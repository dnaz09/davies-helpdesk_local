<?php

namespace App\Listeners;

use App\Events\SendRoomRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoomRequestSent
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
     * @param  SendRoomRequest  $event
     * @return void
     */
    public function handle(SendRoomRequest $event)
    {
        //
    }
}
