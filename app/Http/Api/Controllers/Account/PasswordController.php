<?php

namespace SAASBoilerplate\Http\Api\Controllers\Account;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\PasswordUpdated;
use SAASBoilerplate\Domain\Account\Requests\PasswordStoreRequest;

class PasswordController extends Controller
{

    /**
     * Store user's new password in storage.
     *
     * @param PasswordStoreRequest|Request $request
     * @return JsonResponse
     */
    public function store(PasswordStoreRequest $request)
    {
        //update user password
        $request->user()->update(['password' => bcrypt($request->password)]);

        //Send email
        Mail::to($request->user())->send(new PasswordUpdated());

        //return with no content
        return response()->json(null, 204);
    }
}
