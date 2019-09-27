<?php

namespace App\Listeners;

use App\Events\JobOrderStatusToggler;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TogglerJobOrder
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
     * @param  JobOrderStatusToggler  $event
     * @return void
     */
    public function handle(JobOrderStatusToggler $event)
    {
        //
    }
}
