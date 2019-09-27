<?php

namespace App\Listeners;

use App\Events\ApprovedByMamVicky;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MamVickyApproved
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
     * @param  ApprovedByMamVicky  $event
     * @return void
     */
    public function handle(ApprovedByMamVicky $event)
    {
        //
    }
}
