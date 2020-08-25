<?php

namespace SAASBoilerplate\Domain\Users\Policies;

use SAASBoilerplate\Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin-root') ||
            $user->can('manage users') ||
            $user->can('manage roles')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        if ($this->touch($user) || $user->can('create users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($this->touch($user) || $user->can('create users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        if ($this->touch($user) || $user->can('update users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($this->touch($user) || $user->can('delete users')) {
            return true;
        }
    }

    /**
     * Determine whether the user can perform any action on the model.
     *
     * @param  User  $user
     * @return mixed
     */
    public function touch(User $user)
    {
        if ($user->can('assign roles')) {
            return true;
        }
    }
}
