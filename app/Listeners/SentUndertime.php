<?php

namespace App\Listeners;

use App\Events\UndertimeSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentUndertime
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
     * @param  UndertimeSent  $event
     * @return void
     */
    public function handle(UndertimeSent $event)
    {
        //
    }
}
