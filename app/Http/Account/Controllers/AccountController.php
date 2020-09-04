<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Show the account index.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('account.index');
    }
}
