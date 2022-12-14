<?php

namespace SAAS\Http\Auth\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //prevent user login if not activated
        if ($user->hasNotActivated()) {

            //log user out
            $this->guard()->logout();

            //redirect with error
            return back()->withInput(['email'])
                ->withError('Your account is not active. Please activate it first.');
        }

        if ($user->twoFactorEnabled()) {
            return $this->startTwoFactorAuthentication($request, $user);
        }
    }

    protected function startTwoFactorAuthentication(Request $request, $user)
    {
        session()->put('twofactor', (object)[
            'user_id' => $user->id,
            'remember' => $request->has('remember')
        ]);

        $this->guard()->logout();

        return redirect()->route('login.twofactor.index');
    }
}
