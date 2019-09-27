<?php

namespace App\Listeners;

use App\Events\GatePassForClosing;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClosingGatePass
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
     * @param  GatePassForClosing  $event
     * @return void
     */
    public function handle(GatePassForClosing $event)
    {
        //
    }
}
