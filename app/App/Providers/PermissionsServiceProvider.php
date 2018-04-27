<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Support\Facades\Schema;
use SAASBoilerplate\Domain\Users\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable(Permission::query()->getModel()->getTable())) {
            Permission::where('usable', true)->get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
