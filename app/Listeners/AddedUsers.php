<?php

namespace App\Listeners;

use App\Events\UserAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddedUsers
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
     * @param  UserAdded  $event
     * @return void
     */
    public function handle(UserAdded $event)
    {
        //
    }
}
