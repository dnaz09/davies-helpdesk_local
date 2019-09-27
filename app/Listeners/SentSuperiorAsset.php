<?php

namespace App\Listeners;

use App\Events\SuperiorAssetSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentSuperiorAsset
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
     * @param  SuperiorAssetSent  $event
     * @return void
     */
    public function handle(SuperiorAssetSent $event)
    {
        //
    }
}
