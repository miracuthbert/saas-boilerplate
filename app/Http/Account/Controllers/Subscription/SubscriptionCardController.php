<?php

namespace SAAS\Http\Account\Controllers\Subscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Account\Mail\Subscription\CardUpdated;

class SubscriptionCardController extends Controller
{
    /**
     * Show update card form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $intent = null;

        try {
            $intent = $request->user()->createSetupIntent();
        } catch (\Exception $e) {
            logger($e->getMessage(), $e->getTrace());
        }

        return view('account.subscription.card.index', compact('intent'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => ['required']
        ]);

        $request->user()->updateDefaultPaymentMethod($request->payment_method);

        $request->user()->updateDefaultPaymentMethodFromStripe();

        // send email
        Mail::to($request->user())->send(new CardUpdated());

        return redirect()->route('account.index')
            ->withSuccess('Your card has been updated.');
    }
}
