<?php

namespace App\Listeners;

use App\Events\JOReqSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentJOReq
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
     * @param  JOReqSent  $event
     * @return void
     */
    public function handle(JOReqSent $event)
    {
        //
    }
}
