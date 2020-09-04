<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use Carbon\Carbon;
use SAASBoilerplate\Domain\Users\Models\Role;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  User  $user
     * @return Application|Factory|Response|View
     * @throws AuthorizationException
     */
    public function index(User $user)
    {
        $this->authorize('touch', User::class);

        $roles = $user->roles()
            ->orderByPivot('created_at')
            ->orderByPivot('expires_at')
            ->get();

        return view('admin.users.user.roles.index', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('touch', User::class);

        $expires = null;

        $role = Role::where('id', $request->role)->first();

        $assigned = $user->assignRole($role, $request->expires_at);

        if ($assigned) {
            return back()->with('success', "{$user->name} has been assigned {$role->name} role.");
        }

        return back()->with('success', "Failed assigning user {$role->name} role.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @param  Role  $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user, Role $role)
    {
        $this->authorize('touch', User::class);

        $updated = $user->updateRole($role, $request->expires_at);

        if ($updated) {
            return back()->with('success', "{$user->name}'s {$role->name} role updated.");
        }

        return back()->withErrors(["Failed updating user's {$role->name} role."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user, Role $role)
    {
        $this->authorize('delete', User::class);

        $updated = $user->updateRole($role, Carbon::now());

        if ($updated) {
            return back()->with('success', "{$user->name}'s {$role->name} role revoked.");
        }

        return back()->withErrors(["{$user->name} does not have an active {$role->name} role."]);
    }
}
