<?php

namespace App\Listeners;

use App\Events\WorkAuthUserOk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OkWorkAuthUser
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
     * @param  WorkAuthUserOk  $event
     * @return void
     */
    public function handle(WorkAuthUserOk $event)
    {
        //
    }
}
