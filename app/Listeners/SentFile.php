<?php

namespace App\Listeners;

use App\Events\FileSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentFile
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
     * @param  FileSent  $event
     * @return void
     */
    public function handle(FileSent $event)
    {
        //
    }
}
