<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\Domain\Users\Models\Permission;
use SAASBoilerplate\Domain\Users\Models\Role;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param  \Illuminate\Http\Request $request
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $permission = $request->permission_id;

        if (!$role->permissions->contains($permission)) {

            $role->permissions()->attach($permission);

            return back()->withSuccess("{$role->name} assigned permission.");
        }

        return back()->withInput()->withError("{$role->name} has permission already.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @param  \SAASBoilerplate\Domain\Users\Models\Permission $permission
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Role $role, Permission $permission)
    {
        $this->authorize('delete', $role);

        if ($role->permissions->contains($permission)) {

            $role->permissions()->detach($permission->id);

            return back()->withSuccess("{$permission->name} removed from role.");
        }

        return back()->withError("Role does not have {$permission->name} permission.");
    }
}
