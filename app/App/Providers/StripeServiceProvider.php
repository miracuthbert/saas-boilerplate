<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        Cashier::useCurrency(config('settings.cashier.currency'), config('settings.cashier.symbol'));
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
