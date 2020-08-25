<?php

namespace SAASBoilerplate\Http\Account\Controllers\Subscription;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SAASBoilerplate\App\Controllers\Controller;
use SAASBoilerplate\Domain\Account\Requests\SubscriptionTeamMemberStoreRequest;
use SAASBoilerplate\Domain\Teams\Mail\TeamMemberAdded;
use SAASBoilerplate\Domain\Teams\Mail\TeamMemberDeleted;
use SAASBoilerplate\Domain\Users\Models\User;

class SubscriptionTeamMemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param SubscriptionTeamMemberStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SubscriptionTeamMemberStoreRequest $request)
    {
        if ($request->user()->teamLimitReached()) {
            return back()->withErrors(['You have reached the team limit for your plan.']);
        }

        // team
        $team = $request->user()->team;

        // new member
        $member = User::where('email', $request->email)->first();

        $team->users()->syncWithoutDetaching([
            $member->id
        ]);

        // send email to member
        Mail::to($member)->send(new TeamMemberAdded($member, $team));

        return back()->with('success', 'Team member added.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(Request $request, User $user)
    {
        // team
        $team = $request->user()->team;

        // detach user
        $team->users()->detach($user->id);

        // send mail to removed user
        Mail::to($user)->send(new TeamMemberDeleted($user, $team));

        return back()->with('success', 'Member has been removed.');
    }
}
