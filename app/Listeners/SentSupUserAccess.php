<?php

namespace App\Listeners;

use App\Events\UserAccessSentSup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentSupUserAccess
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
     * @param  UserAccessSentSup  $event
     * @return void
     */
    public function handle(UserAccessSentSup $event)
    {
        //
    }
}
