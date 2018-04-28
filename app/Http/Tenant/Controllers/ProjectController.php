<?php

namespace SAASBoilerplate\Http\Tenant\Controllers;

use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Projects\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('tenant.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project();
        $project->fill($request->only('name'));
        $project->save();

        return redirect()->route('tenant.projects.index')
            ->withSuccess('Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('tenant.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \SAASBoilerplate\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->fill($request->only('name'));
        $project->save();

        return back()->withSuccess('Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAASBoilerplate\Domain\Projects\Models\Project $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return back()->withSuccess("{$project->name} project deleted successfully.");
    }
}
