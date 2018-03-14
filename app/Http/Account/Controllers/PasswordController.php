<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\PasswordUpdated;
use SAASBoilerplate\Domain\Account\Requests\PasswordStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    /**
     * Show the change password view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.password.index');
    }

    /**
     * Store user's new password in storage.
     *
     * @param PasswordStoreRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PasswordStoreRequest $request)
    {
        // update user password
        $request->user()->update(['password' => bcrypt($request->password)]);

        // send email
        Mail::to($request->user())->send(new PasswordUpdated());

        // redirect with success
        return redirect()
            ->route('account.index')
            ->withSuccess('Password updated successfully.');
    }
}
