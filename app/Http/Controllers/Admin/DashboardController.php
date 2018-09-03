<?php

namespace Fully\Http\Controllers\Admin;

use Fully\Http\Controllers\Controller;

/**
 * Class DashboardController.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class DashboardController extends Controller
{
    public function index()
    {
        return view('backend/layout/dashboard', compact('chartData'))->with('active', 'home');
    }
}
