<?php

namespace App\Listeners;

use App\Events\UserLogged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogged1
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
     * @param  UserLogged  $event
     * @return void
     */
    public function handle(UserLogged $event)
    {
        //
    }
}
