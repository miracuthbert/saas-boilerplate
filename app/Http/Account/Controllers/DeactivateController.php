<?php

namespace SAAS\Http\Account\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Http\Account\Requests\DeactivateAccountRequest;

class DeactivateController extends Controller
{
    /**
     * Display a view to show deactivate the account.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.deactivate.index');
    }

    /**
     * Handle account deactivation.
     *
     * @param DeactivateAccountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeactivateAccountRequest $request)
    {
        $user = $request->user();

        if ($user->subscribed('main')) {
            $user->subscription('main')->cancel();
        }

        $user->delete();

        return redirect()->route('home')
            ->withSuccess('Your account has been deactivated.');
    }
}
