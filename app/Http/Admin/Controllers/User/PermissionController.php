<?php

namespace SAAS\Http\Admin\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Models\Permission;

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
        return view('admin.users.permissions.create', [
            'types' => config('laravel-roles.permitables'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required', 'string', 'max:60',
                Rule::unique('permissions', 'name'),
            ],
            'type' => [
                'required',
                'string',
                'in:'. implode(",", array_keys(config('laravel-roles.permitables')))
            ],
            'usable' => ['nullable', 'boolean'],
        ], [
            'name.unique' => __('Permission with :attribute already exists.')
        ]);

        Permission::create($request->only(['name', 'usable', 'type']));

        return redirect()
            ->route('admin.permissions.index')
            ->withSuccess("{$request->name} permission created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\Permission  $permission
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
     * @param  \SAAS\Domain\Users\Models\Permission  $permission
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
     * @param  \SAAS\Domain\Users\Models\Permission $permission
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
