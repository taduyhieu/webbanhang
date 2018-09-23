<?php

namespace Fully\Http\Controllers\Admin;

use Mail;
use Config;
use Sentinel;
use Reminder;
use Redirect;
use Validator;
use Exception;
use Flash;
use Fully\User;
use Fully\Services\Mailer;
use Illuminate\Http\Request;
use Fully\Http\Controllers\Controller;

/**
 * Class AuthController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class AuthController extends Controller {
    
    /**
     * Create a new authentication controller instance.
     */
    public function __construct() {
        
    }

    /**
     * Display the login page.
     *
     * @return View
     */
    public function getLogin() {
        if (!Sentinel::check()) {
            return view('backend/auth/login');
        }

        return Redirect::route('admin.dashboard');
    }

    /**
     * Login action.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request) {
        $credentials = array(
            'user_name' => $request->get('user_name'),
            'password' => $request->get('password'),
        );

        $rememberMe = $request->get('rememberMe');

        try {
            if (!empty($rememberMe)) {
                $result = Sentinel::authenticateAndRemember($credentials);
            } else {
                $result = Sentinel::authenticate($credentials);
            }

            if ($result) {
                return Redirect::route('admin.dashboard');
            }
        } catch (Exception $e) {
            Sentinel::disableCheckpoints();
            Flash::message(trans('fully.mes_auth_warning'));
            return Redirect::route('admin.dashboard')->withInput();
        }

        flash()->error(trans('fully.mes_auth_invalid'));

        return Redirect::back()->withInput();
    }

    /**
     * Logout action.
     *
     * @return Redirect
     */
    public function getLogout() {
        Sentinel::logout(Sentinel::getUser());

        return Redirect::route('admin.login');
    }

    public function getForgotPassword() {
        if (!Sentinel::check()) {
            return view('backend/auth/forgot-password');
        }

        return Redirect::route('admin.dashboard');
    }

    public function postForgotPassword(Request $request) {
        $credentials = array(
            'email' => $request->get('email'),
        );

        $rules = array(
            'email' => 'required|email',
        );

        $validation = Validator::make($credentials, $rules);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        // Find the user using the user email address
        $this->user = Sentinel::findByCredentials($credentials);

        if (!$this->user) {
            flash()->error(trans('fully.mes_auth_email'));

            return Redirect::route('admin.forgot.password');
        }

        $reminderData = Reminder::create($this->user);

        // Get the password reset code
        $resetCode = $reminderData->code;

        $formData = array('id' => $this->user->id, 'code' => $resetCode);
        try {
            Mail::send('backend.auth.reset-password', $formData, function ($message) use ($request) {
                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
                $message->to($request->get('email'))->subject('Reset password');
            });

            return Redirect::route('admin.login');
        } catch (Exception $ex) {
            return Redirect::route('admin.forgot.password')->withErrors(array('forgot-password' => 'Password reset failed'));
        }
        /* $mailer = new Mailer;
          $mailer->send('emails.auth.reset-password', 'user@fully.com', 'Reset Password', $formData); */
    }

    public function getResetPassword($id, $code) {
        try {

            $this->user = Sentinel::findById($id);
            if ($reminder = Reminder::exists($this->user, $code)) {
                flash()->success(trans('fully.mes_auth_new_pass'));
                return view('backend/auth/reset-password', compact('id', 'code'));
            }
        } catch (Exception $ex) {
            return view('errors.error_resetpass');
        }
    }

    public function postResetPassword(Request $request) {
        $formData = array(
            'id' => $request->get('id'),
            'code' => $request->get('code'),
            'password' => $request->get('password'),
            'confirm-password' => $request->get('confirm_password'),
        );

        $rules = array(
            'id' => 'required',
            'code' => 'required',
            'password' => 'required|min:4',
            'confirm-password' => 'required|same:password',
        );

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        // Find the user using the user id
        $this->user = Sentinel::findById($formData['id']);

        if ($reminder = Reminder::complete($this->user, $formData['code'], $formData['password'])) {
            // Password reset passed
            return Redirect::route('admin.login');
        } else {
            return view('errors.error_resetpass');
            // Password reset failed
//            return Redirect::route('admin.reset.password')->withErrors(array('forgot-password' => 'Password reset failed'));
        }
    }
    
}
