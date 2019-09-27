<?php

namespace App\Listeners;

use App\Events\GatePassApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedGatePass
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
     * @param  GatePassApproved  $event
     * @return void
     */
    public function handle(GatePassApproved $event)
    {
        //
    }
}
