<?php

namespace App\Listeners;

use App\Events\UsersRemoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemovedUsers
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
     * @param  UsersRemoved  $event
     * @return void
     */
    public function handle(UsersRemoved $event)
    {
        //
    }
}
