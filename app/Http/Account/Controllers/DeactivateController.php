<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Requests\DeactivateAccountRequest;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DeactivateController extends Controller
{
    /**
     * Display a view to show deactivate the account.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('account.deactivate.index');
    }

    /**
     * Handle account deactivation.
     *
     * @param DeactivateAccountRequest $request
     * @return RedirectResponse
     */
    public function store(DeactivateAccountRequest $request)
    {
        $user = $request->user();

        if ($user->subscribed('main')) {
            $user->subscription('main')->cancel();
        }

        $user->delete();

        return redirect()->route('home')
            ->with('success', 'Your account has been deactivated.');
    }
}
