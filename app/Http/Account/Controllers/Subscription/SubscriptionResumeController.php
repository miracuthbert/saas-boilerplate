<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\Subscription\SubscriptionResumed;

class SubscriptionResumeController extends Controller
{
    /**
     * Show resume subscription form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.subscription.resume.index');
    }

    /**
     * Resume user's subscription.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->subscription('main')->resume();

        // send mail
        Mail::to($request->user())->send(new SubscriptionResumed());

        return redirect()->route('account.index')
            ->withSuccess('Your subscription has been resumed.');
    }
}
