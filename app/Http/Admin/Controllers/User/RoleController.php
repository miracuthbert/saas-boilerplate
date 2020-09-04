<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use Carbon\Carbon;
use SAASBoilerplate\Domain\Users\Models\Role;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     * @throws AuthorizationException
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
     * @return Application|Factory|Response|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return view('admin.users.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $parent = Role::where('id', $request->parent_id)->first();

        Role::create($request->only(['name', 'details']), $parent);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', "{$request->name} role created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @throws AuthorizationException
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return Application|Factory|Response|View
     * @throws AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        return view('admin.users.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->fill($request->only(['name', 'details', 'usable', 'parent_id']));

        $role->save();

        return back()->with('success', "{$role->name} role updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return RedirectResponse
     * @throws Exception
     * @throws AuthorizationException
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        if (!$role->users->count()) {
            $role->delete();

            return back()->with('success', "{$role->name} deleted successfully.");
        }

        return back()->withErrors(["{$role->name} cannot be deleted since it has been assigned to users."]);
    }
}
