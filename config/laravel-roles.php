<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Laravel Roles Settings
     |--------------------------------------------------------------------------
     |
     | Settings for Laravel Roles package.
     */

    /*
     |--------------------------------------------------------------------------
     | User Settings
     |--------------------------------------------------------------------------
     |
     | Configure the User model to use with roles.
     */
    'users' => [
        'model' => \SAAS\Domain\Users\Models\User::class,
    ],

    /*
     |--------------------------------------------------------------------------
     | Middleware Settings
     |--------------------------------------------------------------------------
     |
     | Configure the middleware.
     */
    'middleware' => [
        'abort_code' => 403,
    ],

    /*
     |--------------------------------------------------------------------------
     | Cache Settings
     |--------------------------------------------------------------------------
     |
     | Configure whether to enable caching of roles and permissions.
     |
     | The default cache driver defined in `config/cache` will be used.
     |
     | Note: The package will handle cache clearing whenever there is a change
     | to permissions and roles.
     */
    'cache' => [

        /*
         |--------------------------------------------------------------------------
         | Enable cache
         |--------------------------------------------------------------------------
         |
         | Set whether to enable caching in package.
         */
        'enabled' => true,

        /*
         |--------------------------------------------------------------------------
         | Expiration time in SECONDS
         |--------------------------------------------------------------------------
         |
         | Set how long the roles and permissions should be stored in cache.
         */
        'expiration_time' => 3600,
    ],

    /*
     |--------------------------------------------------------------------------
     | Permission Settings
     |--------------------------------------------------------------------------
     |
     | Config for the Permission model.
     */
    'permissions' => [
        'types' => [
            'default' => 'admin',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Role Settings
     |--------------------------------------------------------------------------
     |
     | Config for Role model.
     */
    'roles' => [
        'types' => [
            'default' => 'admin',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Permitable Types
     |--------------------------------------------------------------------------
     |
     | Setup a map of the types of Role and Permission.
     | eg. admin for Admin permission or role, team for Team, etc.
     */
    'permitables' => [
        'admin' => 'Admin',
        // 'team' => 'Team',
    ],

    /*
     |--------------------------------------------------------------------------
     | Models
     |--------------------------------------------------------------------------
     |
     | Setup a map of the models relating to types of Role and Permission.
     | eg. team for App\Team, company for App\Company, etc.
     */
    'models' => [
        // 'team' => \App\Team::class,
    ],

];
