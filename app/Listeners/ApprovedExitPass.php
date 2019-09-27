<?php

namespace App\Listeners;

use App\Events\ExitPassApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedExitPass
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
     * @param  ExitPassApproved  $event
     * @return void
     */
    public function handle(ExitPassApproved $event)
    {
        //
    }
}
