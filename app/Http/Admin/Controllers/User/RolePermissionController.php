<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\Domain\Users\Models\Permission;
use SAASBoilerplate\Domain\Users\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Role  $role
     * @return Application|Factory|Response|View
     * @throws AuthorizationException
     */
    public function index(Role $role)
    {
        $this->authorize('update', $role);

        $permissions = $role->permissions()->latestFirst()->get();

        return view('admin.users.roles.permissions.index', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $permission = $request->permission_id;

        if (!$role->permissions->contains($permission)) {

            $role->permissions()->attach($permission);

            return back()->with('success', "{$role->name} assigned permission.");
        }

        return back()->withInput()->withErrors(["{$role->name} has permission already."]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @param  Permission  $permission
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Role $role, Permission $permission)
    {
        $this->authorize('delete', $role);

        if ($role->permissions->contains($permission)) {

            $role->permissions()->detach($permission->id);

            return back()->with('success', "{$permission->name} removed from role.");
        }

        return back()->withErrors(["Role does not have {$permission->name} permission."]);
    }
}
