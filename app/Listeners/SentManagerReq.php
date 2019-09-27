<?php

namespace App\Listeners;

use App\Events\ManagerReqSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentManagerReq
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
     * @param  ManagerReqSent  $event
     * @return void
     */
    public function handle(ManagerReqSent $event)
    {
        //
    }
}
