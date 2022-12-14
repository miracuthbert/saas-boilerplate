<?php

namespace SAAS\App\Actions\Fortify;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Auth\Events\Registered;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected $defaults = [
        'password' => 'password',
        'confirmation_password' => 'password',
    ];

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @param  array  $except
     * @param  bool   $fireEvent
     * @return \SAAS\Domain\Users\Models\User
     */
    public function create(array $input, $except = [], $fireEvent = false)
    {
        $input = array_merge($input, Arr::only($this->defaults, $except));

        Validator::make($input, Arr::except([
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'username' => 'nullable|string|max:30|unique:users',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'terms' => 'required'
        ], $except))->validate();

        return DB::transaction(function () use ($input, $fireEvent) {
            return tap(User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use($input, $fireEvent) {
                if ($fireEvent) {
                    $this->fireEvent($user, $fireEvent);
                }
                $this->assignRole($user, $input['role_id'] ?? null);
            });
        });
    }

    public function fireEvent(User $user, $fireEvent = false)
    {
        event(new Registered($user));
    }

    public function assignRole(User $user, $roleId)
    {
        if ($roleId && ($role = Role::find($roleId))) {
            $user->assignRole($role);
        }
    }
}
