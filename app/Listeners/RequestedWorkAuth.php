<?php

namespace App\Listeners;

use App\Events\WorkAuthRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestedWorkAuth
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
     * @param  WorkAuthRequested  $event
     * @return void
     */
    public function handle(WorkAuthRequested $event)
    {
        //
    }
}
