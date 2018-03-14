<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //user is subscribed
        Blade::if ('impersonating', function () {
            return session()->has('impersonate');
        });

        //user is subscribed
        Blade::if ('subscribed', function () {
            return auth()->user()->hasSubscription();
        });

        //user does not have subscription
        Blade::if ('notsubscribed', function () {
            return !auth()->check() || auth()->user()->doesNotHaveSubscription();
        });

        //user has cancelled subscription
        Blade::if ('subscriptioncancelled', function () {
            return auth()->user()->hasCancelled();
        });

        //user has not cancelled subscription
        Blade::if ('subscriptionnotcancelled', function () {
            return !auth()->check() || auth()->user()->hasNotCancelled();
        });

        //user has a team subscription
        Blade::if ('teamsubscription', function () {
            return auth()->user()->hasTeamSubscription();
        });

        //user does not have a piggyback subscription
        Blade::if ('notpiggybacksubscription', function () {
            return !auth()->user()->hasPiggybackSubscription();
        });
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
