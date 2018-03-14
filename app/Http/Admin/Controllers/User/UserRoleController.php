<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use Carbon\Carbon;
use SAASBoilerplate\Domain\Users\Models\Role;
use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param  \Illuminate\Http\Request $request
     * @param  \SAASBoilerplate\Domain\Users\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('touch', User::class);

        $expires = null;

        $role = Role::where('id', $request->role)->first();

        $assigned = $user->assignRole($role, $request->expires_at);

        if ($assigned) {
            return back()->withSuccess("{$user->name} has been assigned {$role->name} role.");
        }

        return back()->withSuccess("Failed assigning user {$role->name} role.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \SAASBoilerplate\Domain\Users\Models\User $user
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, User $user, Role $role)
    {
        $this->authorize('touch', User::class);

        $updated = $user->updateRole($role, $request->expires_at);

        if ($updated) {
            return back()->withSuccess("{$user->name}'s {$role->name} role updated.");
        }

        return back()->withError("Failed updating user's {$role->name} role.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\User $user
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user, Role $role)
    {
        $this->authorize('delete', User::class);

        $updated = $user->updateRole($role, Carbon::now());

        if ($updated) {
            return back()->withSuccess("{$user->name}'s {$role->name} role revoked.");
        }

        return back()->withError("{$user->name} does not have an active {$role->name} role.");
    }
}
