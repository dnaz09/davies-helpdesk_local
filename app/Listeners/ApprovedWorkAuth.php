<?php

namespace App\Listeners;

use App\Events\WorkAuthApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedWorkAuth
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
     * @param  WorkAuthApproved  $event
     * @return void
     */
    public function handle(WorkAuthApproved $event)
    {
        //
    }
}
