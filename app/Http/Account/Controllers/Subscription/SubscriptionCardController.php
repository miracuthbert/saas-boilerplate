<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\Subscription\CardUpdated;
use Illuminate\View\View;

class SubscriptionCardController extends Controller
{
    /**
     * Show update card form.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
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
            ->with('success', 'Your card has been updated.');
    }
}
