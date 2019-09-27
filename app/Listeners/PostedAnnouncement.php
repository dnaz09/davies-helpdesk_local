<?php

namespace App\Listeners;

use App\Events\AnnouncementPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostedAnnouncement
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
     * @param  AnnouncementPosted  $event
     * @return void
     */
    public function handle(AnnouncementPosted $event)
    {
        //
    }
}
