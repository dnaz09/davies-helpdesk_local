<?php

namespace App\Listeners;

use App\Events\AssetReqApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovedAssetReq
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
     * @param  AssetReqApproved  $event
     * @return void
     */
    public function handle(AssetReqApproved $event)
    {
        //
    }
}
