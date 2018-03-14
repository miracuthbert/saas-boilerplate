<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Show the account index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.index');
    }
}
