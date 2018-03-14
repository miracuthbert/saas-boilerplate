<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\Subscription\SubscriptionCancelled;

class SubscriptionCancelController extends Controller
{
    /**
     * Show cancel subscription form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.subscription.cancel.index');
    }

    /**
     * Cancel user's active subscription.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->user()->subscription('main')->cancel();

        // send email
        Mail::to($request->user())->send(new SubscriptionCancelled());

        return redirect()->route('account.index')
            ->withSuccess('Your subscription has been cancelled.');
    }
}
