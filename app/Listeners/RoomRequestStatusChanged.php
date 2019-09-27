<?php

namespace App\Listeners;

use App\Events\ChangeStatusRoomRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoomRequestStatusChanged
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
     * @param  ChangeStatusRoomRequest  $event
     * @return void
     */
    public function handle(ChangeStatusRoomRequest $event)
    {
        //
    }
}
