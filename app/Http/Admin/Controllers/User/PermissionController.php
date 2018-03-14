<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\Domain\Users\Models\Permission;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::with(['roles', 'roles.users'])->paginate();

        return view('admin.users.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->only(['name', 'usable']));

        return redirect()
            ->route('admin.permissions.index')
            ->withSuccess("{$request->name} permission created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.users.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAASBoilerplate\Domain\Users\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->fill($request->only(['name', 'usable']));

        $permission->save();

        return back()->withSuccess("{$permission->name} permission updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Permission $permission
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        if (!$permission->roles->count()) {
            $permission->delete();

            return back()->withSuccess("{$permission->name} deleted successfully.");
        }

        return back()->withError("{$permission->name} cannot be deleted since it has been linked to role(s).");
    }
}
