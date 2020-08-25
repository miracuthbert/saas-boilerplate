<?php

namespace SAASBoilerplate\Http\Tenant\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Projects\Models\Project;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the tenant's application dashboard.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $projects = Project::limit(3)->get();

        return view('tenant.dashboard.index', compact('projects'));
    }
}
