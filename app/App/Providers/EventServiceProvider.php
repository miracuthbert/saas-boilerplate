<?php

namespace SAASBoilerplate\App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SAASBoilerplate\Domain\Auth\Events\UserRequestedActivationEmail;
use SAASBoilerplate\Domain\Auth\Events\UserSignedUp;
use SAASBoilerplate\Domain\Auth\Listeners\CreateDefaultTeam;
use SAASBoilerplate\Domain\Auth\Listeners\SendActivationEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserSignedUp::class => [
            CreateDefaultTeam::class,
            SendActivationEmail::class,
        ],
        UserRequestedActivationEmail::class => [
            SendActivationEmail::class,
        ],
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
