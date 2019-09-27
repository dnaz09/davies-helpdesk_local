<?php

namespace App\Listeners;

use App\Events\RequisitionRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestedRequisition
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
     * @param  RequisitionRequested  $event
     * @return void
     */
    public function handle(RequisitionRequested $event)
    {
        //
    }
}
