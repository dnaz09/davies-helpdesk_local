<?php

namespace App\Listeners;

use App\Events\ExpiredAssetSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentExpiredAsset
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
     * @param  ExpiredAssetSent  $event
     * @return void
     */
    public function handle(ExpiredAssetSent $event)
    {
        //
    }
}
