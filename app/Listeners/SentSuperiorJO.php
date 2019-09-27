<?php

namespace App\Listeners;

use App\Events\SuperiorJOSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentSuperiorJO
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
     * @param  SuperiorJOSent  $event
     * @return void
     */
    public function handle(SuperiorJOSent $event)
    {
        //
    }
}
