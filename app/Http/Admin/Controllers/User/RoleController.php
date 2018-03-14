<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use Carbon\Carbon;
use SAASBoilerplate\Domain\Users\Models\Role;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('create', Role::class);

        $roles = Role::with([
            'children',
            'ancestors',
            'users' => function ($query) {
                return $query->whereNull('expires_at')
                    ->orWhereDate('expires_at', '>', Carbon::now());
            },
            'permissions'
        ])->filter($request)->paginate();

        return view('admin.users.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return view('admin.users.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $parent = Role::where('id', $request->parent_id)->first();

        Role::create($request->only(['name', 'details']), $parent);

        return redirect()
            ->route('admin.roles.index')
            ->withSuccess("{$request->name} role created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        return view('admin.users.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->fill($request->only(['name', 'details', 'usable', 'parent_id']));

        $role->save();

        return back()->withSuccess("{$role->name} role updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAASBoilerplate\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        if (!$role->users->count()) {
            $role->delete();

            return back()->withSuccess("{$role->name} deleted successfully.");
        }

        return back()->withError("{$role->name} cannot be deleted since it has been assigned to users.");
    }
}
