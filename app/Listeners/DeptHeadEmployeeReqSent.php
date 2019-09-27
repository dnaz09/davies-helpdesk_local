<?php

namespace App\Listeners;

use App\Events\EmployeeReqSentToDeptHead;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeptHeadEmployeeReqSent
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
     * @param  EmployeeReqSentToDeptHead  $event
     * @return void
     */
    public function handle(EmployeeReqSentToDeptHead $event)
    {
        //
    }
}
