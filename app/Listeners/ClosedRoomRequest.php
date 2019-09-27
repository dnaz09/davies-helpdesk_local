<?php

namespace App\Listeners;

use App\Events\RoomRequestClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClosedRoomRequest
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
     * @param  RoomRequestClosed  $event
     * @return void
     */
    public function handle(RoomRequestClosed $event)
    {
        //
    }
}
