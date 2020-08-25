<?php

namespace SAASBoilerplate\Http\Account\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use PragmaRX\Countries\Package\Countries;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\App\TwoFactor\TwoFactor;
use SAASBoilerplate\Domain\Account\Requests\TwoFactor\TwoFactorStoreRequest;
use SAASBoilerplate\Domain\Account\Requests\TwoFactor\TwoFactorVerifyRequest;

class TwoFactorController extends Controller
{
    /**
     * Show the two factor auth view.
     *
     * @return Factory|Application|Response|View
     */
    public function index()
    {
        return view('account.twofactor.index');
    }

    /**
     * Store resource in storage.
     *
     * @param TwoFactorStoreRequest $request
     * @param TwoFactor $twoFactor
     * @return RedirectResponse
     */
    public function store(TwoFactorStoreRequest $request, TwoFactor $twoFactor)
    {
        $user = $request->user();

        $user->twoFactor()->create([
            'phone' => $request->phone_number,
            'dial_code' => $request->dial_code,
        ]);

        if ($response = $twoFactor->register($user)) {
            $user->twoFactor()->update([
                'identifier' => $response->user->id
            ]);
        }

        return back();
    }

    /**
     * Verify phone number.
     *
     * @param TwoFactorVerifyRequest $request
     * @return RedirectResponse
     */
    public function verify(TwoFactorVerifyRequest $request)
    {
        $request->user()->twoFactor()->update([
            'verified' => true
        ]);

        return back()->with('success','Your phone number has been verified.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param TwoFactor $twoFactor
     * @return RedirectResponse
     */
    public function destroy(Request $request, TwoFactor $twoFactor)
    {
        $user = $request->user();

        if ($twoFactor->delete($user)) {
            $user->twoFactor()->delete();

            return back()->with('success','Two factor authentication has been disabled.');
        }

        return back();
    }
}
