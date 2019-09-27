<?php

namespace App\Listeners;

use App\Events\SAPSentToSuperior;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuperiorSAPSent
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
     * @param  SAPSentToSuperior  $event
     * @return void
     */
    public function handle(SAPSentToSuperior $event)
    {
        //
    }
}
