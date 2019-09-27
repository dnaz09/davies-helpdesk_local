<?php

namespace App\Listeners;

use App\Events\SupplyRequestSendtoHead;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SenttoHeadSupplyRequest
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
     * @param  SupplyRequestSendtoHead  $event
     * @return void
     */
    public function handle(SupplyRequestSendtoHead $event)
    {
        //
    }
}
