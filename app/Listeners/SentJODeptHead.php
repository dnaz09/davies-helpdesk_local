<?php

namespace App\Listeners;

use App\Events\DeptHeadJOSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentJODeptHead
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
     * @param  DeptHeadJOSent  $event
     * @return void
     */
    public function handle(DeptHeadJOSent $event)
    {
        //
    }
}
