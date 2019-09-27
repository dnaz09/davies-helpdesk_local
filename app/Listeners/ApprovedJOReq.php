<?php

namespace App\Listeners;

use App\Events\JOReqApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedJOReq
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
     * @param  JOReqApproved  $event
     * @return void
     */
    public function handle(JOReqApproved $event)
    {
        //
    }
}
