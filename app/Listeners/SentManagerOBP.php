<?php

namespace App\Listeners;

use App\Events\ManagerOBPSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentManagerOBP
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
     * @param  ManagerOBPSent  $event
     * @return void
     */
    public function handle(ManagerOBPSent $event)
    {
        //
    }
}
