<?php

namespace SAAS\Http\Subscriptions\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Subscriptions\Models\Plan;

class PlanTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::active()->forTeams()->get();

        return view('subscriptions.plans.teams.index', compact('plans'));
    }
}
