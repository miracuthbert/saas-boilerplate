<?php

namespace SAAS\Http\Users\Policies;

use SAAS\Domain\Users\Models\User;
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
     * @param  \SAAS\Domain\Users\Models\User $user
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
     * @param  \SAAS\Domain\Users\Models\User $user
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
     * @param  \SAAS\Domain\Users\Models\User $user
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
     * @param  \SAAS\Domain\Users\Models\User $user
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
     * @param  \SAAS\Domain\Users\Models\User $user
     * @return mixed
     */
    public function touch(User $user)
    {
        if ($user->can('assign roles')) {
            return true;
        }
    }
}
