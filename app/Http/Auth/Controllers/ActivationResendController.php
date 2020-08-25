<?php

namespace SAASBoilerplate\Http\Auth\Controllers;

use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Auth\Events\UserRequestedActivationEmail;
use SAASBoilerplate\Domain\Auth\Requests\ActivateResendRequest;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ActivationResendController extends Controller
{
    /**
     * Show the activation resend form.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('auth.activation.resend.index');
    }

    /**
     * Resend activation link.
     *
     * @param ActivateResendRequest|Request $request
     * @return RedirectResponse
     */
    public function store(ActivateResendRequest $request)
    {
        //find user
        $user = User::where('email', $request->email)->first();

        //send activation email
        event(new UserRequestedActivationEmail($user));

        return redirect()->route('login')->with('success', 'An activation email has been sent.');
    }
}
