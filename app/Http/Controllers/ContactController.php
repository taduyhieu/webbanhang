<?php

namespace Fully\Http\Controllers;

use DB;

/**
 * Class ContactController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class ContactController extends Controller {

    /**
     * @param ContactInterface $contact
     */
    public function __construct() {
        
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $contactInfo = DB::table('contact')->first();
        return view('frontend.contact.index', compact('contactInfo'));
    }
    
}
