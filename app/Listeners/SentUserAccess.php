<?php

namespace App\Listeners;

use App\Events\UserAccessSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentUserAccess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserAccessSent  $event
     * @return void
     */
    public function handle(UserAccessSent $event)
    {
        //
    }
}
