<?php

namespace App\Listeners;

use App\Events\UserSubscribe;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateSubscriberTables
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
    public function handle(UserSubscribe $event): void
    {
        DB::insert('insert into subscribers (email) values (?)', [$event->user->email]);
    }
}
