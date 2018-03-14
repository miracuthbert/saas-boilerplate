<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Support\ServiceProvider;
use SAASBoilerplate\Domain\Users\Models\Role;
use SAASBoilerplate\Domain\Users\Observers\RoleObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //model observers
//        Category::observe(CategoryObserver::class);
//        Tag::observe(TagObserver::class);
        Role::observe(RoleObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
