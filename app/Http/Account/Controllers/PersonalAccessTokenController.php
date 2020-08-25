<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PersonalAccessTokenController extends Controller
{
    /**
     * Display list of user's API tokens.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('account.tokens.index');
    }
}
