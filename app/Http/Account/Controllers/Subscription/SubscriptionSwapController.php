<?php

namespace SAAS\Http\Account\Controllers\Subscription;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Account\Mail\Subscription\SubscriptionSwapped;
use SAAS\Http\Account\Requests\SubscriptionSwapStoreRequest;
use SAAS\Domain\Subscriptions\Models\Plan;
use SAAS\Domain\Users\Models\User;

class SubscriptionSwapController extends Controller
{
    /**
     * Show swap subscription form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plans = Plan::except($request->user()->plan->id)->active()->get();

        return view('account.subscription.swap.index', compact('plans'));
    }

    /**
     * Store new subscription in storage.
     *
     * @param SubscriptionSwapStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionSwapStoreRequest $request)
    {
        $user = $request->user();

        $plan = Plan::where('gateway_id', $request->plan)->first();

        if ($this->downgradesFromTeamPlan($user, $plan)) {
            // todo: uncomment lines below and create event to email each user on the team

            // $user->team->users()->each(function() {
                // fire event to mail users here
                // remember to queue them
            // });

            $user->team->users()->detach();
        }

        $user->subscription('main')->swap([$user->plan->gateway_id, $plan->gateway_id]);

        // send mail to user
        Mail::to($user)->send(new SubscriptionSwapped());

        return back()->withSuccess('Your subscription has been changed.');
    }

    /**
     * Check if user is downgrading from a team plan.
     *
     * @param User $user
     * @param Plan $plan
     * @return bool
     */
    public function downgradesFromTeamPlan(User $user, Plan $plan)
    {
        if ($user->plan->isForTeams() && $plan->isNotForTeams()) {
            return true;
        }

        return false;
    }
}
