<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetRequestDetail extends Model
{
    protected $table = 'asset_request_details';

    protected $fillable = [

    	'asset_req_id',
    	'item_name',
    	'qty',
    	'status'
    ];

    public static function byRequestId($id)
    {
    	return self::where('asset_request_id',$id)->get();
    }
}
