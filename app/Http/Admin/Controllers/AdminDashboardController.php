<?php

namespace SAASBoilerplate\Http\Admin\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard view.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
