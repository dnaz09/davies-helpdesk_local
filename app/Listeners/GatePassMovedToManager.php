<?php

namespace App\Listeners;

use App\Events\GatePassMoveToManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GatePassMovedToManager
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
     * @param  GatePassMoveToManager  $event
     * @return void
     */
    public function handle(GatePassMoveToManager $event)
    {
        //
    }
}
