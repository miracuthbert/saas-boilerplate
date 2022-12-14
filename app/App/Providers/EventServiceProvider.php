<?php

namespace SAAS\App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use SAAS\Domain\Auth\Events\UserSignedUp;
use SAAS\Domain\Auth\Listeners\CreateDefaultTeam;
use SAAS\Domain\Auth\Listeners\SendActivationEmail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use SAAS\Domain\Auth\Events\UserRequestedActivationEmail;
use SAAS\Domain\Company\Listeners\CompanyUserEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateDefaultTeam::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        CompanyUserEventSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
