<?php

namespace App\Listeners;

use App\Events\ItDashboardLoader;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoaderItDashboard
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
     * @param  ItDashboardLoader  $event
     * @return void
     */
    public function handle(ItDashboardLoader $event)
    {
        //
    }
}
