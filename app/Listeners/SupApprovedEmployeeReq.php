<?php

namespace App\Listeners;

use App\Events\EmployeeReqApprovedSup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupApprovedEmployeeReq
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
     * @param  EmployeeReqApprovedSup  $event
     * @return void
     */
    public function handle(EmployeeReqApprovedSup $event)
    {
        //
    }
}
