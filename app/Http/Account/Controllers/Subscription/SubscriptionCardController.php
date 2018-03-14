<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\Subscription\CardUpdated;

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
        return view('account.subscription.card.index');
    }

    public function store(Request $request)
    {
        $request->user()->updateCard($request->token);

        // send email
        Mail::to($request->user())->send(new CardUpdated());

        return redirect()->route('account.index')
            ->withSuccess('Your card has been updated.');
    }
}
