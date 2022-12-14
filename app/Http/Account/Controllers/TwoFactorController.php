<?php

namespace SAAS\Http\Account\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use SAAS\App\Controllers\Controller;
use SAAS\App\TwoFactor\TwoFactor;
use SAAS\Http\Account\Requests\TwoFactor\TwoFactorStoreRequest;
use SAAS\Http\Account\Requests\TwoFactor\TwoFactorVerifyRequest;

class TwoFactorController extends Controller
{
    /**
     * Show the two factor auth view.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function verify(TwoFactorVerifyRequest $request)
    {
        $request->user()->twoFactor()->update([
            'verified' => true
        ]);

        return back()->withSuccess('Your phone number has been verified.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param TwoFactor $twoFactor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TwoFactor $twoFactor)
    {
        $user = $request->user();

        if ($twoFactor->delete($user)) {
            $user->twoFactor()->delete();

            return back()->withSuccess('Two factor authentication has been disabled.');
        }

        return back();
    }
}
