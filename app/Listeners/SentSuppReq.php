<?php

namespace App\Listeners;

use App\Events\SuppReqSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentSuppReq
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
     * @param  SuppReqSent  $event
     * @return void
     */
    public function handle(SuppReqSent $event)
    {
        //
    }
}
