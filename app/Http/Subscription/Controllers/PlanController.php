<?php

namespace SAASBoilerplate\Http\Subscription\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Subscriptions\Models\Plan;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $plans = Plan::active()->forUsers()->get();

        return view('subscriptions.plans.index', compact('plans'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Plan  $plan
     * @return Application|Factory|Response|View
     */
    public function show(Plan $plan)
    {
        return view('subscriptions.plans.show', compact('plan'));
    }
}
