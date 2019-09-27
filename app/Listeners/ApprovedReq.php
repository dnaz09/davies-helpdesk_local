<?php

namespace App\Listeners;

use App\Events\ReqApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedReq
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
     * @param  ReqApproved  $event
     * @return void
     */
    public function handle(ReqApproved $event)
    {
        //
    }
}
