<?php

namespace App\Listeners;

use App\Events\SendToAdminDept;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentToAdminDept
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
     * @param  SendToAdminDept  $event
     * @return void
     */
    public function handle(SendToAdminDept $event)
    {
        //
    }
}
