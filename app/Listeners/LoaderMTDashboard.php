<?php

namespace App\Listeners;

use App\Events\MTDashboardLoader;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoaderMTDashboard
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
     * @param  MTDashboardLoader  $event
     * @return void
     */
    public function handle(MTDashboardLoader $event)
    {
        //
    }
}
