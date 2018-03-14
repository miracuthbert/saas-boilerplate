<?php

namespace SAASBoilerplate\Http\Admin\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

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
