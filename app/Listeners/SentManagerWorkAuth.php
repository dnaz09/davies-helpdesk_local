<?php

namespace App\Listeners;

use App\Events\ManagerWorkAuthSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentManagerWorkAuth
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
     * @param  ManagerWorkAuthSent  $event
     * @return void
     */
    public function handle(ManagerWorkAuthSent $event)
    {
        //
    }
}
