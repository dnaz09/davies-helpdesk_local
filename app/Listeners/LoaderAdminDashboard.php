<?php

namespace App\Listeners;

use App\Events\AdminDashboardLoader;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoaderAdminDashboard
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
     * @param  AdminDashboardLoader  $event
     * @return void
     */
    public function handle(AdminDashboardLoader $event)
    {
        //
    }
}
