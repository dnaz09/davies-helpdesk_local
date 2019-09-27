<?php

namespace App\Listeners;

use App\Events\GroupFileSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentGroupFile
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
     * @param  GroupFileSent  $event
     * @return void
     */
    public function handle(GroupFileSent $event)
    {
        //
    }
}
