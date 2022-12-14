<?php

namespace SAAS\Http\Account\Controllers;

use SAAS\App\Controllers\Controller;
use SAAS\Http\Account\Requests\ProfileStoreRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user profile view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.profile.index');
    }

    /**
     * Store user's profile details in storage.
     *
     * @param ProfileStoreRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileStoreRequest $request)
    {
        //update user
        $request->user()->update($request->only(['first_name', 'last_name', 'username', 'email', 'phone']));

        //redirect with success
        return back()->withSuccess('Profile updated successfully.');
    }
}
