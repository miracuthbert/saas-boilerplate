<?php

use Illuminate\Support\Str;

return [

    /*
     *
     * The tenancy driver to use in the app.
     *
     * Supported drivers: single, multi
     *
     */
    'default' => 'single',

    /*
     *
     * The tenant's model options to use in the app.
     *
     */
    'model' => [

        /*
         *
         * The tenant model.
         *
         */
        'class' => \SAAS\Domain\Teams\Models\Team::class,

        /*
         *
         * The column to query against in the tenant model.
         *
         */
        'key' => 'uuid',

        /*
         *
         * The column to query against in the tenant model when using "DB" store.
         *
         */
        'db_key' => 'id',

        /*
         *
         * The route key used by the model.
         *
         * Used to fetch the tenant's unique identifier directly from the request.
         * eg. 'slug' => $request->slug, 'team' => $request->team
         *
         * Note: When not using the tenant store functionality, make sure this
         * value matches the key option above.
         *
         */
        'route_key' => 'id',
    ],

    /*
     *
     * Configure the User to use for tenant.
     *
     */
    'users' => [

        /*
         *
         * The User model to use.
         *
         */
        'model' => \SAAS\Domain\Users\Models\User::class,

        /*
         *
         * The name of the tenant's user table to use.
         *
         * Leave blank unless you don't follow Laravel's pivot table naming convention.
         *
         */
        'tenant_user' => null,
    ],

    /*
     *
     * The tenant's connection settings.
     *
     */
    'connection' => [

        /*
         *
         * The database connection config.
         *
         */

        'database' => [

            /*
             *
             * The prefix for the tenant's database name.
             *
             * Note: It should not be changed once set to maintain consistency throughout the app.
             *
             */

            'prefix' => Str::slug(env('APP_NAME', 'laravel'), '_'),

            /*
             *
             * The class that should be used to resolve database create statements based on connection.
             *
             * The default class handles: "mysql" and "pgsql".
             *
             */

            'creator_statement' => \Miracuthbert\Multitenancy\Database\DatabaseCreatorStatement::class,
        ],

    ],

    /*
     *
     * The routes options is used to define the tenant routing.
     *
     * Use this option if you are using the controller provided by the package
     * to switch between tenants.
     *
     */
    'routes' => [

        /*
         *
         * Set whether to use sub-domains.
         *
         * Not currently supported.
         *
         */
        'subdomain' => false,

        /*
         *
         * The tenant routes prefix.
         *
         */
        'prefix' => '/',

        /*
         *
         * The prefix to the tenant route names.
         *
         * eg. 'tenant.'
         *
         */
        'as' => 'tenant.',

        /*
         *
         * The namespace for your tenant controllers.
         *
         */
        'namespace' => 'SAAS\Http\Tenant\Controllers',

        /*
         *
         * The middleware to protect the tenant routes.
         *
         */
        'middleware' => [

            /*
             *
             * The middleware to apply before the tenant middleware.
             *
             */
            'before' => [
                'web',
                'auth',
            ],

            /*
             *
             * The options to pass to the tenant middleware.
             *
             */
            'set_tenant' => [

                /*
                 *
                 * Determines whether the current user is authorized to access tenant.
                 *
                 */
                'in_tenant' => false,

                /*
                 *
                 * Determines whether the current tenant should be fetched from the request header.
                 *
                 */
                'in_header' => false,
            ],

            /*
             *
             * The middleware to add to the tenant group middleware.
             *
             */
            'tenant' => [
                
            ],

            /*
             *
             * The middleware to apply after the tenant middleware group.
             *
             */
            'after' => [
                'tenant.config'
                // theme_config
            ],
        ],

        /*
         *
         * The path to the tenant's routes file.
         *
         */
        'file' => base_path('routes/tenant.php'),
    ],

    /*
     *
     * The redirect options used on switching a tenant.
     *
     * Use this option if you are using the controller provided by the package
     * to switch between tenants.
     *
     */
    'redirect' => [

        /*
         *
         * The url to redirect to by default when a tenant is switched.
         *
         */
        'url' => '/dashboard',

        /*
         *
         * Set whether to abort if tenant not found or user is not authorized to
         * access a tenant.
         *
         */
        'abort' => false,

        /*
         *
         * The url to redirect back to if tenant not found.
         *
         */
        'fallback_url' => '/',

        /*
         *
         * The middleware to protect the redirect url.
         *
         */
        'middleware' => [
            'web',
            'auth'
        ],
    ],

    /*
     *
     * This controls the key and driver to use when switching or identifying
     * the tenant to be loaded.
     *
     * Supported drivers: "session", "cache", "cookie"
     *
     */
    'store' => [

        /*
         *
         * The unique key used for storing tenant in cache or session.
         *
         */
        'key' => 'tenant',

        /*
         *
         * Set whether to use Session, Cache or Cookie storing tenant in cache or session.
         *
         */
        'driver' => 'session',
    ],

    /*
     *
     * This controls the console options to be used by tenant.
     *
     */
    'console' => [

        /*
         *
         * The commands related to tenant.
         *
         */
        'commands' => [

            /*
             *
             * The migrator commands used by the tenant.
             *
             * Add commands that handle tenant migration's here.
             *
             * Note: The commands must be implementing the MigrationRepositoryInterface.
             *
             */
            'migrator' => [],

            /*
             *
             * The db commands used by the tenant.
             *
             * Add commands that connect with a tenant's database here.
             *
             * Note: The commands must be implementing the ConnectionResolverInterface.
             *
             */
            'db' => [],

        ],
    ],

    /*
     *
     * Here are all the tenant drivers available for your application.
     *
     * You can use the drivers below as samples to create your own driver.
     *
     */
    'drivers' => [

        'single' => [
            'handler' => Miracuthbert\Multitenancy\Drivers\Single\SingleDatabaseDriver::class,
        ],

        'multi' => [
            'handler' => Miracuthbert\Multitenancy\Drivers\Multi\MultiDatabaseDriver::class,
        ],

    ],

];
