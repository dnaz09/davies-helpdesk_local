<?php

namespace App\Listeners;

use App\Events\WorkAuthSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentWorkAuth
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
     * @param  WorkAuthSent  $event
     * @return void
     */
    public function handle(WorkAuthSent $event)
    {
        //
    }
}
