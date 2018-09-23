<?php

namespace Fully\Http\Controllers;

use Hash;
use View;
use Image;
use File;
use Session;
use Response;
use DB;
use Illuminate\Support\Facades\URL;
use Config;
use Flash;
use Redirect;
use Sentinel;
use Validator;
use Fully\Models\User;
use Fully\Models\Role;
use Fully\Models\Recharge;
use Fully\NganLuong\Lib\NL_Checkout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Fully\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class UserRegisterController extends Controller {

    /**
     * @var
     */
    protected $width;

    /**
     * @var
     */
    protected $height;

    /**
     * @var
     */
    protected $imgDir;

    public function __construct() {
        $config = Config::get('fully');
        $this->width = $config['modules']['user']['image_size']['width'];
        $this->height = $config['modules']['user']['image_size']['height'];
        $this->imgDir = $config['modules']['user']['image_dir'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $formData = array(
            'user_name' => $request->get('user_name'),
            'password' => $request->get('password'),
            'confirm-password' => $request->get('confirm_password'),
            'full_name' => $request->get('full_name'),
            'email' => $request->get('email-register'),
            'mobile' => $request->get('mobile'),
            'roles' => $request->get('user-r'),
        );

        $rules = array(
            'user_name' => 'unique:users,user_name',
            'email' => 'unique:users,email',
        );

        $messages = array(
            'email.unique' => 'Email đã dùng để đăng kí',
            'user_name.unique' => 'Tài khoản truy cập đã tồn tại',
        );

        $validation = Validator::make($formData, $rules, $messages);

        if ($validation->fails()) {
            return Response::json(array('errors' => $validation->errors()->all()));
        }
        $user = Sentinel::registerAndActivate(array(
                    'user_name' => $formData['user_name'],
                    'full_name' => $formData['full_name'],
                    'email' => $formData['email'],
                    'mobile' => $formData['mobile'],
                    'password' => $formData['password'],
                    'activated' => 1,
        ));
        $user->roles()->attach($formData['roles']);

        return Response::json(array('success' => true));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $user = Sentinel::findUserById($id);

        $userRoles = $user->getRoles()->lists('name', 'id')->toArray();
        $roles = Role::lists('name', 'id');

        return view('backend.user.edit', compact('user', 'roles', 'userRoles'))->with('active', 'user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, $id) {
        $formData = array(
            'full_name' => $request->get('full_name'),
            'email' => $request->get('email'),
            'password' => ($request->get('password')) ?: null,
            'confirm-password' => ($request->get('confirm_password')) ?: null,
            'roles' => $request->get('account-role') ?: 0,
        );

        if (!$formData['password'] || !$formData['confirm-password']) {
            unset($formData['password']);
            unset($formData['confirm_password']);
        }

        $rules = array(
            'email' => 'email',
            'password' => 'min:6',
            'confirm-password' => 'same:password',
        );

        $messages = array(
            'email' => trans('fully.val_user_email_format'),
            'password.required' => trans('fully.val_user_pass_req'),
            'confirm-password.required' => trans('fully.val_user_cofirm_pass_req'),
            'same' => trans('fully.val_user_cofirm_pass_valid'),
            'password.min' => trans('fully.val_user_min_pass'),
        );

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $user = Sentinel::findById($id);
        $user->email = $formData['email'];

        Sentinel::update($user, $formData);

        $oldRoles = $user->getRoles()->lists('name', 'id')->toArray();

        foreach ($oldRoles as $id => $role) {
            $roleModel = Sentinel::findRoleByName($role);
            $roleModel->users()->detach($user);
        }

        if (isset($formData['roles'])) {
            $formData['roles'] = $user->roles()->attach($formData['roles']);
        }
        Flash::message(trans('fully.mes_update_succes'));
        return Redirect::action('Admin\UserController@index');
    }

    public function userWallet($id) {
        $user = User::find($id);
        $paymentsInfo = $user->getPayments;
        foreach ($paymentsInfo as $payment) {
            $payment->newsRE = $payment->getNewsRealEstale()->select('id', 'news_title')->first();
        }
        $rechargeInfo = $user->getRecharges;
        return view('backend.user.info-wallet', compact('user', 'paymentsInfo', 'rechargeInfo'))->with('active', 'user');
    }

    public function rechargeNganLuong(Request $request) {
        require_once(app_path() . '\NganLuong\config.php');
        $user_id = $request->get('user_id');
        Session::put('user_id', $user_id);
        // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
        $receiver = RECEIVER;
        //Mã đơn hàng
        $order_code = 'VCCI-' . date_format(Carbon::now(), "dmY");
        //Khai báo url trả về
        $return_url = URL::route('admin.user-payment.wallet');
        // Link nut hủy đơn hàng
        $cancel_url = URL::route('admin.user.wallet', array('id' => $user_id));
        //Giá của cả giỏ hàng
        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $price = (int) str_replace(".", "", $request->get('money'));
        //Thông tin giao dịch
        $transaction_info = "Thong tin giao dich";
        $currency = "vnd";
        $quantity = 1;
        $tax = 0;
        $discount = 0;
        $fee_cal = 0;
        $fee_shipping = 0;
        $order_description = "Thong tin don hang: " . $order_code;
        $buyer_info = $name . "*|*" . $email . "*|*" . $phone;
        $affiliate_code = "";
        //Khai báo đối tượng của lớp NL_Checkout
        $nl = new NL_Checkout();
        $nl->nganluong_url = NGANLUONG_URL;
        $nl->merchant_site_code = MERCHANT_ID;
        $nl->secure_pass = MERCHANT_PASS;
        //Tạo link thanh toán đến nganluong.vn
        $url = $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount, $fee_cal, $fee_shipping, $order_description, $buyer_info, $affiliate_code);
        //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);
        //echo $url; die;
        if ($order_code != "") {
            //một số tham số lưu ý
            //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
            //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
            $url .= '&cancel_url=' . $cancel_url;
            //$url .='&option_payment=bank_online';

            echo '<meta http-equiv="refresh" content="0; url=' . $url . '" >';
            //&lang=en --> Ngôn ngữ hiển thị google translate
        }

//        return view('backend.user.info-wallet', compact('link_checkout'));
    }

    public function userPaymentNganLuong() {
        require_once(app_path() . '\NganLuong\config.php');
        $user_id = Session::get('user_id');

        if (isset($_GET['payment_id'])) {
            // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
            $transaction_info = $_GET['transaction_info'];
            $order_code = $_GET['order_code'];
            $price = $_GET['price'];
            $payment_id = $_GET['payment_id'];
            $payment_type = $_GET['payment_type'];
            $error_text = $_GET['error_text'];
            $secure_code = $_GET['secure_code'];
            //Khai báo đối tượng của lớp NL_Checkout
            $nl = new NL_Checkout();
            $nl->merchant_site_code = MERCHANT_ID;
            $nl->secure_pass = MERCHANT_PASS;
            //Tạo link thanh toán đến nganluong.vn
            $checkpay = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

            if ($checkpay) {
                // bạn viết code vào đây để cung cấp sản phẩm cho người mua
                DB::beginTransaction();
                try {
                    $recharge = new Recharge();
                    $recharge->order_code = $order_code;
                    $recharge->cost = $price;
                    $recharge->payment_id = $payment_id;
                    $recharge->recharge_method = $payment_type;

                    $user = User::find($user_id);
                    $user->wallet_money += $price;
                    $user->save();
                    $user->getRecharges()->save($recharge);
                    DB::commit();
                    Flash::message('Thanh toán thành công. Mời kiểm tra lại số dư trong ví của bạn !');
                    return Redirect::route('admin.user.wallet', array('id' => $user_id));
                } catch (Exception $ex) {
                    DB::rollback();
                    return Redirect::route('admin.user.wallet', array('id' => $user_id))->with('message', 'Có sự cố khi lưu dữ liệu !!!');
                }
            } else {
                return Redirect::route('admin.user.wallet', array('id' => $user_id))->with('message', $error_text);
            }
        }
    }

    public function updatePasswordView() {
        return view('backend.user.change-password');
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:4',
            'confirm-password' => 'required|same:newPassword',
                ], [
            'currentPassword.required' => trans('fully.val_update_pass_present_req'),
            'newPassword.required' => trans('fully.val_update_pass_new_req'),
            'newPassword.min' => trans('fully.val_pass_new_min'),
            'confirm-password.required' => trans('fully.val_confirm_pass_req'),
            'confirm-password.same' => trans('fully.val_confirm_pass_same'),
        ]);

        $currentPassword = $request->currentPassword;
        $newPassword = $request->newPassword;

        if (!Hash::check($currentPassword, Auth::user()->password)) {
            Flash::message(trans('fully.mes_user_log'));
        } else {
            $request->user()->fill(['password' => Hash::make($newPassword)])->save;
            Flash::message(trans('fully.mes_user_update'));
            return Redirect::action('Admin\UserController@index');
        }
    }

}
