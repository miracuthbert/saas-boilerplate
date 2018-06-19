<?php

use Illuminate\Database\Seeder;
use SAASBoilerplate\Domain\Users\Models\Permission;
use SAASBoilerplate\Domain\Users\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'children' => [
                    [
                        'name' => 'Root',
                    ],
                ]
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $permissions = [
            [
                'name' => 'manage users'
            ],
            [
                'name' => 'manage roles'
            ],
            [
                'name' => 'assign roles'
            ],
            [
                'name' => 'create users'
            ],
            [
                'name' => 'update users'
            ],
            [
                'name' => 'delete users'
            ],
            [
                'name' => 'browse admin'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
