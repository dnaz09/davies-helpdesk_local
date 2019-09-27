<?php

namespace App\Listeners;

use App\Events\MamTiffSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentMamTiff
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
     * @param  MamTiffSent  $event
     * @return void
     */
    public function handle(MamTiffSent $event)
    {
        //
    }
}
