<?php

namespace SAAS\Http\Admin\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
