<?php

namespace App\Listeners;

use App\Events\OBPSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentOBP
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
     * @param  OBPSent  $event
     * @return void
     */
    public function handle(OBPSent $event)
    {
        //
    }
}
