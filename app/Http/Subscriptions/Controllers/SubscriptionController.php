<?php

namespace SAAS\Http\Subscriptions\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Subscriptions\Models\Plan;
use SAAS\Http\Subscriptions\Requests\SubscriptionStoreRequest;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $choosenPlan = $plans->where('id', $request->plan)->first();

        $user = $request->user();

        $hasSubscription = $user->hasSubscription();

        $intent = $hasSubscription ? null : $user->createSetupIntent();

        return view('subscriptions.index', compact('intent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionStoreRequest $request)
    {
        try {
            $subscription = ($user = $request->user())->newSubscription('main', $request->plan);

            if($request->has('coupon')) {
                $subscription->withCoupon($request->coupon);
            }

            $subscription->create($request->payment_method, [
                'email' => $user->email,
            ]);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('account.subscriptions.index')]
            );
        }

        return redirect()->route('account.dashboard')->withSuccess(__('Thank you. Your subscription is now active.'));
    }
}
