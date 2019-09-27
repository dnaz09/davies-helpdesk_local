<?php

namespace App\Listeners;

use App\Events\UndertimeRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestedUndertime
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
     * @param  UndertimeRequested  $event
     * @return void
     */
    public function handle(UndertimeRequested $event)
    {
        //
    }
}
