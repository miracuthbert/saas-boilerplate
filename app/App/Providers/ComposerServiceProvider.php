<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SAASBoilerplate\App\ViewComposers\CountriesComposer;
use SAASBoilerplate\App\ViewComposers\PermissionsComposer;
use SAASBoilerplate\App\ViewComposers\PlansComposer;
use SAASBoilerplate\App\ViewComposers\RolesComposer;
use SAASBoilerplate\App\ViewComposers\UserFiltersComposer;

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
//
//        //blog filters mappings
//        View::composer([
//            'blog.layouts.partials._navigation',
//            'admin.posts.partials._filters'
//        ], PostFiltersComposer::class);

        //user filters mappings
        View::composer([
            'admin.users.partials._filters'
        ], UserFiltersComposer::class);

        //roles list
        View::composer([
            'admin.users.roles.partials.forms._roles',
            'admin.users.user.roles.index'
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
        //
    }
}
