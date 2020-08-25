<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Mail\Subscription\SubscriptionResumed;
use Illuminate\View\View;

class SubscriptionResumeController extends Controller
{
    /**
     * Show resume subscription form.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('account.subscription.resume.index');
    }

    /**
     * Resume user's subscription.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->user()->subscription('main')->resume();

        // send mail
        Mail::to($request->user())->send(new SubscriptionResumed());

        return redirect()->route('account.index')
            ->with('success', 'Your subscription has been resumed.');
    }
}
