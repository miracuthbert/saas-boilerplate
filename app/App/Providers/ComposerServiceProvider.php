<?php

namespace SAAS\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SAAS\App\ViewComposers\CountriesComposer;
use SAAS\App\ViewComposers\PermissionsComposer;
use SAAS\App\ViewComposers\PlansComposer;
use SAAS\App\ViewComposers\RolesComposer;
use SAAS\App\ViewComposers\UserCompaniesComposer;
use SAAS\App\ViewComposers\UserFiltersComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //plans
        View::composer([
            'subscriptions.index'
        ], PlansComposer::class);

        //countries
        View::composer([
            'account.twofactor.index'
        ], CountriesComposer::class);

//        //categories
//        View::composer([
//            'layouts.blog.partials._navigation',
//            'blog.partials._categories_filters_list'
//        ], CategoriesComposer::class);

        //user companies
        View::composer('*', UserCompaniesComposer::class);

        //user filters mappings
        View::composer([
            'admin.users.partials._filters'
        ], UserFiltersComposer::class);

        //roles list
        View::composer([
            'admin.users.roles.partials.forms._roles',
            'admin.users.user.roles.index',
            'admin.users.create',
        ], RolesComposer::class);

        //permissions list
        View::composer([
            'admin.users.roles.partials.forms._permissions',
        ], PermissionsComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserCompaniesComposer::class);
    }
}
