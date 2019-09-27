<?php

namespace App\Listeners;

use App\Events\SupplyRequestSend;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentSupplyRequest
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
     * @param  SupplyRequestSend  $event
     * @return void
     */
    public function handle(SupplyRequestSend $event)
    {
        //
    }
}
