<?php

namespace SAAS\Http\Auth\Controllers;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Auth\Events\UserRequestedActivationEmail;
use SAAS\Http\Auth\Requests\ActivateResendRequest;
use SAAS\Domain\Users\Models\User;
use Illuminate\Http\Request;

class ActivationResendController extends Controller
{
    /**
     * Show the activation resend form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.activation.resend.index');
    }

    /**
     * Resend activation link.
     *
     * @param ActivateResendRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivateResendRequest $request)
    {
        //find user
        $user = User::where('email', $request->email)->first();

        //send activation email
        event(new UserRequestedActivationEmail($user));

        return redirect()->route('login')->withSuccess('An activation email has been sent.');
    }
}
