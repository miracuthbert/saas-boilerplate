<?php

namespace SAASBoilerplate\App\Providers;

use SAASBoilerplate\Domain\Users\Models\User;
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
            /** @var User $user */
            $user = auth()->user();
            return $user->hasSubscription();
        });

        //user does not have subscription
        Blade::if ('notsubscribed', function () {
            /** @var User $user */
            $user = auth()->user();
            return !auth()->check() || $user->doesNotHaveSubscription();
        });

        //user has cancelled subscription
        Blade::if ('subscriptioncancelled', function () {
            /** @var User $user */
            $user = auth()->user();
            return $user->hasCancelled();
        });

        //user has not cancelled subscription
        Blade::if ('subscriptionnotcancelled', function () {
            /** @var User $user */
            $user = auth()->user();
            return !auth()->check() || $user->hasNotCancelled();
        });

        //user has a team subscription
        Blade::if ('teamsubscription', function () {
            /** @var User $user */
            $user = auth()->user();
            return $user->hasTeamSubscription();
        });

        //user does not have a piggyback subscription
        Blade::if ('notpiggybacksubscription', function () {
            /** @var User $user */
            $user = auth()->user();
            return !$user->hasPiggybackSubscription();
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
