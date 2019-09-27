<?php

namespace App\Listeners;

use App\Events\HrDashboardLoader;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoaderHrDashboard
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
     * @param  HrDashboardLoader  $event
     * @return void
     */
    public function handle(HrDashboardLoader $event)
    {
        //
    }
}
