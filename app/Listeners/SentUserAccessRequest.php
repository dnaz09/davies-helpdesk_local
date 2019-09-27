<?php

namespace App\Listeners;

use App\Events\UserAccessRequestSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentUserAccessRequest
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
     * @param  UserAccessRequestSent  $event
     * @return void
     */
    public function handle(UserAccessRequestSent $event)
    {
        //
    }
}
