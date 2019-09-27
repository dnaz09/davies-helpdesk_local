<?php

namespace App\Listeners;

use App\Events\NewGatePass;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewGatePassGenerated
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
     * @param  NewGatePass  $event
     * @return void
     */
    public function handle(NewGatePass $event)
    {
        //
    }
}
