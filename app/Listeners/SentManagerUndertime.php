<?php

namespace App\Listeners;

use App\Events\ManagerUndertimeSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentManagerUndertime
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
     * @param  ManagerUndertimeSent  $event
     * @return void
     */
    public function handle(ManagerUndertimeSent $event)
    {
        //
    }
}
