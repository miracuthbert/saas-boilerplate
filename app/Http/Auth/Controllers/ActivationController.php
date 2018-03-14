<?php

namespace SAASBoilerplate\Http\Auth\Controllers;

use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Users\Models\ConfirmationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    protected $redirectTo = '/account/dashboard';

    /**
     * ActivationController constructor.
     */
    public function __construct()
    {
        $this->middleware(['confirmation_token.expired:/']);
    }

    /**
     * @param Request $request
     * @param ConfirmationToken $token
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function activate(Request $request, ConfirmationToken $token)
    {
        //activate user of given token
        $token->user->update([
            'activated' => true,
        ]);

        //delete token
        $token->delete();

        //login user by id
        Auth::loginUsingId($token->user->id);

        //redirect user to intended route
        return redirect()->intended($this->redirectPath())
            ->withSuccess('You are now signed in.');
    }

    /**
     * Where redirect user on successful activation.
     *
     * @return string
     */
    protected function redirectPath()
    {
        return $this->redirectTo;
    }
}
