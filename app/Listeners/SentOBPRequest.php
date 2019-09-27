<?php

namespace App\Listeners;

use App\Events\OBPRequestSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentOBPRequest
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
     * @param  OBPRequestSent  $event
     * @return void
     */
    public function handle(OBPRequestSent $event)
    {
        //
    }
}
