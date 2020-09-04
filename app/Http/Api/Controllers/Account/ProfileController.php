<?php

namespace SAASBoilerplate\Http\Api\Controllers\Account;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Requests\ProfileStoreRequest;
use SAASBoilerplate\Domain\Users\Resources\UserResource;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     *
     * @param Request $request
     * @return UserResource
     */
    public function index(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Store user's profile details in storage.
     *
     * @param ProfileStoreRequest|Request $request
     * @return JsonResponse
     */
    public function store(ProfileStoreRequest $request)
    {
        //update user
        $request->user()->update($request->only(['first_name', 'last_name', 'username', 'email', 'phone']));

        //return with no content
        return response()->json(null, 204);
    }
}
