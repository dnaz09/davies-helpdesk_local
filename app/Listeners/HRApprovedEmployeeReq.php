<?php

namespace App\Listeners;

use App\Events\EmployeeReqApprovedHR;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HRApprovedEmployeeReq
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
     * @param  EmployeeReqApprovedHR  $event
     * @return void
     */
    public function handle(EmployeeReqApprovedHR $event)
    {
        //
    }
}
