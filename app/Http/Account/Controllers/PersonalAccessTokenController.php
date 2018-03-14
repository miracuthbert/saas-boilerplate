<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class PersonalAccessTokenController extends Controller
{
    /**
     * Display list of user's API tokens.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.tokens.index');
    }
}
