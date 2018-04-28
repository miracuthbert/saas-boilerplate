<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/27/2018
 * Time: 7:03 PM
 */

namespace SAASBoilerplate\App\Tenant\Traits;

use SAASBoilerplate\App\Tenant\Manager;
use SAASBoilerplate\App\Tenant\Observers\TenantObserver;
use SAASBoilerplate\App\Tenant\Scopes\TenantScope;

trait ForTenants
{
    public static function boot()
    {
        parent::boot();

        $manager = app(Manager::class);

        static::addGlobalScope(
            new TenantScope($manager->getTenant())
        );

        static::observe(
            app(TenantObserver::class)
        );
    }
}