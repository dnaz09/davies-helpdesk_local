<?php

namespace App\Listeners;

use App\Events\OBPReqApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedOBPReq
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
     * @param  OBPReqApproved  $event
     * @return void
     */
    public function handle(OBPReqApproved $event)
    {
        //
    }
}
