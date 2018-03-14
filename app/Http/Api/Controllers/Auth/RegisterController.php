<?php

namespace SAASBoilerplate\Http\Api\Controllers\Auth;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Auth\Events\UserSignedUp;
use SAASBoilerplate\Domain\Auth\Requests\UserSignUpRequest;
use SAASBoilerplate\Domain\Users\Models\User;

class RegisterController extends Controller
{
    /**
     * Handles the registration request and stores user in storage.
     *
     * @param UserSignUpRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserSignUpRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activated' => false,
        ]);

        //send user an activation email
        event(new UserSignedUp($user));

        return response()->json(null, 204);
    }
}
