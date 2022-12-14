<?php

namespace SAAS\Http\Users\Policies;

use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin-root') || $user->can('manage roles')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        if ($this->touch($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($this->touch($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        if ($this->touch($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @param  \SAAS\Domain\Users\Models\Role $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        if ($this->touch($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can perform any action on the model.
     *
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return mixed
     */
    public function touch(User $user)
    {
        if ($user->can('manage roles')) {
            return true;
        }
    }
}
