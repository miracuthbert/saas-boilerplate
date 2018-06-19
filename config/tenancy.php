<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 6/19/2018
 * Time: 5:14 PM
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Multi-tenancy Settings
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials required for multi-tenancy.
    | This file provides a sane default location for this type of information,
    | allowing developers to have a conventional place to find
    | various multi-tenant credentials when using `HasTenancy` trait.
    |
    */


    'tenant' => [
        'name' => 'companies',
        'model' => SAASBoilerplate\Domain\Company\Models\Company::class,
    ],

    'owners' => [
        'model' => SAASBoilerplate\Domain\Users\Models\User::class,
        'table' => 'company_users',
        'last_access_column' => 'last_login_at'
    ],
];