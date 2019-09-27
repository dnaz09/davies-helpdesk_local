<?php

namespace App\Listeners;

use App\Events\UndertimeApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedUndertime
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
     * @param  UndertimeApproved  $event
     * @return void
     */
    public function handle(UndertimeApproved $event)
    {
        //
    }
}
