<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/27/2018
 * Time: 7:03 PM
 */

namespace SAAS\App\Tenant\Traits;

use Illuminate\Database\Eloquent\Builder;
use SAAS\App\Tenant\Manager;
use SAAS\App\Tenant\Observers\TenantObserver;
use SAAS\App\Tenant\Scopes\TenantScope;

trait ForTenants
{
    public static function boot()
    {
        parent::boot();

        $manager = app(Manager::class);

        if (null !== ($manager->getTenant())) {
            static::addGlobalScope(
                new TenantScope($manager->getTenant())
            );

            static::observe(
                app(TenantObserver::class)
            );
        }
    }

    /**
     * Scope a query to exclude 'tenant' scope.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWithoutForTenants(Builder $builder)
    {
        return $builder->withoutGlobalScope(TenantScope::class);
    }
}