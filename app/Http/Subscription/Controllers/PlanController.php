<?php

namespace SAASBoilerplate\Http\Subscription\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Subscriptions\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::active()->forUsers()->get();

        return view('subscriptions.plans.index', compact('plans'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Subscriptions\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return view('subscriptions.plans.show', compact('plan'));
    }
}
