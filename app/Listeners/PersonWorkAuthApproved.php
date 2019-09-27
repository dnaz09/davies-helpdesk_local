<?php

namespace App\Listeners;

use App\Events\WorkAuthApprovedPerson;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PersonWorkAuthApproved
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
     * @param  WorkAuthApprovedPerson  $event
     * @return void
     */
    public function handle(WorkAuthApprovedPerson $event)
    {
        //
    }
}
