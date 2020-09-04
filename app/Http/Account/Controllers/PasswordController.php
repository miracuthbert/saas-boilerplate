<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\PasswordUpdated;
use SAASBoilerplate\Domain\Account\Requests\PasswordStoreRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Show the change password view.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('account.password.index');
    }

    /**
     * Store user's new password in storage.
     *
     * @param PasswordStoreRequest|Request $request
     * @return RedirectResponse
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
            ->with('success', 'Password updated successfully.');
    }
}
