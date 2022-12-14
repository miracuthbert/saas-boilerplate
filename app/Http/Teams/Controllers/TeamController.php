<?php

namespace SAAS\Http\Teams\Controllers;

use Illuminate\Http\Request;
use SAAS\Domain\Teams\Models\Team;
use SAAS\App\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = $request->user()->teams;

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request->merge([
            'domain' => \Cviebrock\EloquentSluggable\Services\SlugService::createSlug(Team::class, 'domain', $request->name)
        ]), [
            'name' => ['required', 'unique:teams,name'],
        ]);

        $team = new Team;

        DB::transaction(function () use ($request, $team) {
            $team->fill($request->only('name'));
            $team->user_id = ($request->user()->id);
            $team->save();

            $request->user()->teams()->syncWithoutDetaching($team->id);
        });

        return redirect()->route('tenant.switch', $team)
            ->withSuccess('Team created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Teams\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Teams\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Teams\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $this->validate($request, [
            'name' => ['required', Rule::unique('teams')->ignore($team->id)],
        ]);

        $team->update($request->only(['name']));

        return back()->withSuccess(__('Team updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Teams\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
