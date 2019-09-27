<?php

namespace App\Listeners;

use App\Events\AssetRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestedAsset
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
     * @param  AssetRequested  $event
     * @return void
     */
    public function handle(AssetRequested $event)
    {
        //
    }
}
