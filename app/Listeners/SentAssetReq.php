<?php

namespace App\Listeners;

use App\Events\AssetReqSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentAssetReq
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
     * @param  AssetReqSent  $event
     * @return void
     */
    public function handle(AssetReqSent $event)
    {
        //
    }
}
