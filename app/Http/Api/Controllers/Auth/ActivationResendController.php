<?php

namespace SAASBoilerplate\Http\Api\Controllers\Auth;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Auth\Events\UserRequestedActivationEmail;
use SAASBoilerplate\Domain\Auth\Requests\ActivateResendRequest;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;

class ActivationResendController extends Controller
{

    /**
     * Resend activation link.
     *
     * @param ActivateResendRequest|Request $request
     * @return JsonResponse
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
