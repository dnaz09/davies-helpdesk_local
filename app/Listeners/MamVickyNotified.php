<?php

namespace App\Listeners;

use App\Events\SentToMamVicky;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MamVickyNotified
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
     * @param  SentToMamVicky  $event
     * @return void
     */
    public function handle(SentToMamVicky $event)
    {
        //
    }
}
