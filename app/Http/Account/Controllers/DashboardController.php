<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the user's application dashboard.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('account.dashboard.index');
    }
}
