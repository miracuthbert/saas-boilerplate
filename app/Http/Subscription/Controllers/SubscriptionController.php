<?php

namespace SAASBoilerplate\Http\Subscription\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Subscriptions\Models\Plan;
use SAASBoilerplate\Domain\Subscriptions\Requests\SubscriptionStoreRequest;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subscriptions.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request)
    {
        $subscription = $request->user()->newSubscription('main', $request->plan);

        if($request->has('coupon')) {
            $subscription->withCoupon($request->coupon);
        }

        $subscription->create($request->token);

        return redirect()->route('account.dashboard')->withSuccess('Thanks for becoming a subscriber.');
    }
}
