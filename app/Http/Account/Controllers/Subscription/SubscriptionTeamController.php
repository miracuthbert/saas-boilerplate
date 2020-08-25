<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use SAASBoilerplate\Domain\Account\Requests\SubscriptionTeamUpdateRequest;
use SAASBoilerplate\Domain\Teams\Models\Team;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SubscriptionTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function index(Request $request)
    {
        $team = $request->user()->team;

        return view('account.subscription.team.index', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubscriptionTeamUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(SubscriptionTeamUpdateRequest $request)
    {
        $request->user()->team->update($request->only(['name']));

        //TODO: Send users an email that their team details have been changed.

        return redirect()->back()
            ->with('success', 'Team name updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Team  $team
     * @return void
     */
    public function destroy(Team $team)
    {
        //
    }
}
