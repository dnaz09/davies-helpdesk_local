<?php

namespace App\Listeners;

use App\Events\ApproveByAdminDept;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedByAdminDept
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
     * @param  ApproveByAdminDept  $event
     * @return void
     */
    public function handle(ApproveByAdminDept $event)
    {
        //
    }
}
