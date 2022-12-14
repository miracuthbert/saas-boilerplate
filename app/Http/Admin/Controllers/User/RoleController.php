<?php

namespace SAAS\Http\Admin\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SAAS\Domain\Users\Models\Role;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Users\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:browse-roles');
        $this->middleware('permission:create-role')->only('create');
        $this->middleware('permission:update-role')->only(['edit', 'update']);
        $this->middleware('permission:delete-role')->only(['delete']);
    }

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

        $roles = Role::withDepth()-> defaultOrder()->with([
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
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return view('admin.users.roles.create', [
            'roles' => Role::doesntHave('users')->get()->toFlatTree(),
            'permissions' => Permission::get()->groupBy('type'),
        ]);
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

        $this->validate($request, [
            'name' => [
                'required', 'string', 'max:60',
                Rule::unique('roles', 'name'),
            ],
            'type' => [
                'required',
                'string',
                'in:'. implode(",", array_keys(config('laravel-roles.permitables')))
            ],
            'description' => ['nullable', 'string', 'max:160'],
            'order' => ['nullable', 'required_with:node', 'string', 'in:child,before,after'],
            'node' => ['nullable', 'required_with:order', 'string', 'exists:roles,id'],
            'permissions.*' => ['nullable', 'integer', 'exists:permissions,id'],
            'usable' => ['nullable', 'boolean'],
        ]);

        $role = (new Role);
        
        DB::transaction(function () use($role, $request) {
            $role->fill($request->only(['name', 'description', 'type']));
            $role->setRoleOrder($request->order, $request->node);
            $role->save();

            if (is_array($request->permissions) && count($request->permissions)) {
                $role->addPermissions($request->permissions);
            }
        });

        if (!$role->id) {
            return back()->withInput();
        }

        return redirect()
            ->route('admin.roles.index')
            ->withSuccess("{$request->name} role created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $role->loadMissing(['permissions']);

        $flat_roles = Role::defaultOrder()->doesntHave('users')->doesntHave('permissions')->get()->toFlatTree();
        $permissions = Permission::get()->groupBy('type');

        return view('admin.users.roles.edit', compact('role', 'flat_roles' ,'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->fill($request->only(['name', 'description', 'usable']));
        $role->setRoleOrder($request->order, $request->node);

        $role->save();

        if (is_array($request->permissions) && count($request->permissions)) {    
            $role->syncPermissions($request->permissions);
        }

        return back()->withSuccess("{$role->name} role updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \SAAS\Domain\Users\Models\Role $role
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
