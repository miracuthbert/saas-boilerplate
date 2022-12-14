<?php

namespace SAAS\Http\Api\Controllers\Auth;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Auth\Events\UserRequestedActivationEmail;
use SAAS\Http\Auth\Requests\ActivateResendRequest;
use SAAS\Domain\Users\Models\User;

class ActivationResendController extends Controller
{

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

        return response()->json(null, 204);
    }
}
