<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\Subscription\SubscriptionCancelled;
use Illuminate\View\View;

class SubscriptionCancelController extends Controller
{
    /**
     * Show cancel subscription form.
     *
     * @return Application|Factory|Response|View
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
            ->with('success', 'Your subscription has been cancelled.');
    }
}
