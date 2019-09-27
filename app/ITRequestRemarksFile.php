<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ITRequestRemarksFile extends Model
{
    protected $table = 'it_request_remarks_files';

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

    public function request()
    {
        return $this->hasOne('App\ITRequest','id','request_id');
    }
}
