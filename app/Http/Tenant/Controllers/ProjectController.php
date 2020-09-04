<?php

namespace SAASBoilerplate\Http\Tenant\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Projects\Models\Project;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $projects = Project::all();

        return view('tenant.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('tenant.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $project = new Project();
        $project->fill($request->only('name'));
        $project->save();

        return redirect()->route('tenant.projects.index')
            ->with('success','Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return void
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project  $project
     * @return Application|Factory|Response|View
     */
    public function edit(Project $project)
    {
        return view('tenant.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Project  $project
     * @return RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $project->fill($request->only('name'));
        $project->save();

        return back()->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', "{$project->name} project deleted successfully.");
    }
}
