<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\Domain\Users\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;

class RoleStatusController extends Controller
{
    /**
     * Update the specified resource status in storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function toggleStatus(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $role->fill([
            'usable' => $role->usable == true ? false : true
        ]);

        $role->save();

        return back()->with('success', "{$role->name} status updated successfully.");
    }
}
