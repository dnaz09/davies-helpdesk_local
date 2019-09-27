<?php

namespace App\Listeners;

use App\Events\EmployeeReqSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentEmployeeReq
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
     * @param  EmployeeReqSent  $event
     * @return void
     */
    public function handle(EmployeeReqSent $event)
    {
        //
    }
}
