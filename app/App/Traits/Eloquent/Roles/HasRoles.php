<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 1/8/2018
 * Time: 10:12 AM
 */

namespace SAAS\App\Traits\Eloquent\Roles;

use Carbon\Carbon;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\UserRole;

trait HasRoles
{
    /**
     * Assign user a role by id.
     *
     * @param $roleId
     * @param null $expiresAt
     */
    public function assignRoleById($roleId, $expiresAt = null)
    {
        $role = Role::where('id', $roleId)->first();

        $this->assignRole($role, $expiresAt);
    }

    /**
     * Assign user a role.
     * Returns true if role added.
     *
     * @param Role $role
     * @param null $expiresAt
     * @return bool
     */
    public function assignRole(Role $role, $expiresAt = null)
    {
        if (!($this->hasRole($role->slug))) {

            if (isset($expiresAt)) {
                $expiresAt = Carbon::parse($expiresAt)->toDateTimeString();
            }

            $this->roles()->attach($role->id, ['expires_at' => $expiresAt]);

            return true;
        }

        return false;
    }

    /**
     * Update user's role by id.
     *
     * @param $roleId
     * @param null $expiresAt
     */
    public function updateRoleById($roleId, $expiresAt = null)
    {
        $role = Role::where('id', $roleId)->first();

        $this->updateRole($role, $expiresAt);
    }

    /**
     * Update user's role.
     *
     * @param Role $role
     * @param null $expiresAt
     * @return bool
     */
    public function updateRole(Role $role, $expiresAt = null)
    {
        if ($this->hasRole($role->slug)) {
            if (isset($expiresAt)) {
                $expiresAt = Carbon::parse($expiresAt)->toDateTimeString();
            }

            $this->roles()->updateExistingPivot($role->id, ['expires_at' => $expiresAt]);

            return true;
        }

        return false;
    }

    /**
     * Check if given model has role.
     *
     * if they do not have given role or its child
     * then return false
     *
     * @param $roles
     * @return bool
     */
    public function hasRole(...$roles)
    {
        $roles = Role::with('children')->whereIn('slug', $roles)->get();

        foreach ($roles as $role) {

            //fetch role's children
            $children = $role->children->pluck('slug')->push($role->slug);

            if (!($this->roles()->WhereNull('expires_at')
                ->orWhereDate('expires_at', '>', Carbon::now())
                ->whereIn('slug', $children)->count())) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Get the roles that belong to the model.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->using(UserRole::class)
            ->as('roleable')
            ->withTimestamps()
            ->withPivot(['expires_at']);
    }
}