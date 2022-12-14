<?php

namespace SAAS\App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;
use Laravel\Cashier\Cashier;
use SAAS\Domain\Users\Models\User;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCustomerModel(User::class);
        Stripe::setApiKey(config('services.stripe.secret'));
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
