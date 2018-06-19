<?php

namespace SAASBoilerplate\Domain\Company\Listeners;

use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SAASBoilerplate\Domain\Company\Events\CompanyUserLogin;

class CompanyUserEventSubscriber
{
    /**
     * Handle user login events.
     * @param \Illuminate\Events\Dispatcher $event
     */
    public function onUserLogin($event)
    {
        $user = $event->user;
        $company = $event->company;

        $user->companies()->updateExistingPivot($company->id, [
            'last_login_at' => Carbon::now()
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            CompanyUserLogin::class,
            CompanyUserEventSubscriber::class . '@onUserLogin'
        );
    }
}
