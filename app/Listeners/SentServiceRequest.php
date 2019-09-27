<?php

namespace App\Listeners;

use App\Events\ServiceRequestSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentServiceRequest
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
     * @param  ServiceRequestSent  $event
     * @return void
     */
    public function handle(ServiceRequestSent $event)
    {
        //
    }
}
