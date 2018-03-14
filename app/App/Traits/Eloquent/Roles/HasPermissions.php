<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 1/28/2018
 * Time: 10:14 PM
 */

namespace SAASBoilerplate\App\Traits\Eloquent\Roles;


use SAASBoilerplate\Domain\Users\Models\Permission;

trait HasPermissions
{
    /**
     * Check if given model has given permission.
     *
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Check if given model has permission through role.
     *
     * @param $permission
     * @return bool
     */
    protected function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            $children = $role->children->pluck('slug')->push($role->slug);

            if ($this->roles->where('roleable.expires_at', null)->whereIn('slug', $children)->count()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if given permission exists and has not expired.
     *
     * @param $permission
     * @return bool
     */
    protected function hasPermission($permission)
    {
        return (bool)$this->permissions
            ->where('name', $permission->name)
            ->where('permitable.expires_at', null)->count();
    }

    /**
     * Get the permission that belong to the model.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
            ->as('permitable')
            ->withTimestamps()
            ->withPivot(['expires_at']);
    }
}