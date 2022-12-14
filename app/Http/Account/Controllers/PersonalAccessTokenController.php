<?php

namespace SAAS\Http\Account\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

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
