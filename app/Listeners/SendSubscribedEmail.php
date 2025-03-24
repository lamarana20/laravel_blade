<?php

namespace App\Listeners;

use App\Events\UserSubscribe;
use Illuminate\Queue\Listener;
use Illuminate\Support\Facades\Mail;

class SendSubscribedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle( UserSubscribe  $event): void
    {
        Mail::raw('Thank you to our new letter', function ($message) use ($event) {
            $message->to($event->user->email);
            $message->subject('Thank you for subscribing');
        });
    }
}
