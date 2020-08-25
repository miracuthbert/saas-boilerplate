<?php

namespace SAASBoilerplate\Http\Subscription\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Subscriptions\Models\Plan;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PlanTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $plans = Plan::active()->forTeams()->get();

        return view('subscriptions.plans.teams.index', compact('plans'));
    }
}
