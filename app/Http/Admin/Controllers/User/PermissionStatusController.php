<?php

namespace SAASBoilerplate\Http\Admin\Controllers\User;

use SAASBoilerplate\Domain\Users\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SAASBoilerplate\App\Controllers\Controller;
use Illuminate\Http\Response;

class PermissionStatusController extends Controller
{
    /**
     * Update the specified resource status in storage.
     *
     * @param  Request  $request
     * @param  Permission  $permission
     * @return RedirectResponse
     */
    public function toggleStatus(Request $request, Permission $permission)
    {
        $permission->fill([
            'usable' => $permission->usable == true ? false : true
        ]);

        $permission->save();

        return back()->with('success', "{$permission->name} status updated successfully.");
    }
}
