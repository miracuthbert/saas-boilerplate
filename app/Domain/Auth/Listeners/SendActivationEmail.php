<?php

namespace SAAS\Domain\Auth\Listeners;

use SAAS\Domain\Auth\Mail\ActivationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        //create token and send email
        Mail::to($event->user)->send(new ActivationEmail($event->user->generateConfirmationToken()));
    }
}
