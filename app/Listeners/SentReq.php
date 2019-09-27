<?php

namespace App\Listeners;

use App\Events\ReqSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentReq
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
     * @param  ReqSent  $event
     * @return void
     */
    public function handle(ReqSent $event)
    {
        //
    }
}
