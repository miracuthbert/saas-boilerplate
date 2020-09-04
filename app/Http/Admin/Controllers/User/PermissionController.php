<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\Domain\Users\Models\Permission;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $permissions = Permission::with(['roles', 'roles.users'])->paginate();

        return view('admin.users.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.users.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        Permission::create($request->only(['name', 'usable']));

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', "{$request->name} permission created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission  $permission
     * @return void
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $permission
     * @return Application|Factory|Response|View
     */
    public function edit(Permission $permission)
    {
        return view('admin.users.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Permission  $permission
     * @return RedirectResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->fill($request->only(['name', 'usable']));

        $permission->save();

        return back()->with('success', "{$permission->name} permission updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission  $permission
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Permission $permission)
    {
        if (!$permission->roles->count()) {
            $permission->delete();

            return back()->with('success', "{$permission->name} deleted successfully.");
        }

        return back()->withErrors(["{$permission->name} cannot be deleted since it has been linked to role(s)."]);
    }
}
