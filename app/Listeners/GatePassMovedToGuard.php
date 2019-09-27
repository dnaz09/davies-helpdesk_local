<?php

namespace App\Listeners;

use App\Events\GatePassMoveToGuard;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GatePassMovedToGuard
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
     * @param  GatePassMoveToGuard  $event
     * @return void
     */
    public function handle(GatePassMoveToGuard $event)
    {
        //
    }
}
