<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetRequestRemarkFile extends Model
{
    protected $table = 'asset_request_remark_files';

    protected $fillable = [

    	'request_remarks_id',
    	'request_id',
    	'ticket_no',
    	'filename',
    	'encryptname',
    	'uploaded_by'
    ];

    public static function ByEncryptName($name){

        return self::where('encryptname',$name)->first();
    }
}
