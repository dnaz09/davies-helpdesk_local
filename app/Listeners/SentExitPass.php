<?php

namespace App\Listeners;

use App\Events\ExitPassSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentExitPass
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
     * @param  ExitPassSent  $event
     * @return void
     */
    public function handle(ExitPassSent $event)
    {
        //
    }
}
