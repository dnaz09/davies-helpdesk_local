<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ITRequestFile extends Model
{
    protected $table = 'it_request_files';

    protected $fillable = [


    	'request_id',
    	'ticket_no',
    	'filename',
    	'encryptname',
    	'uploaded_by'
    ];

    public static function ByTicket($id){


    	return self::where('ticket_no',$id)->get();
    }

    public static function ByEncryptName($name){

        return self::where('encryptname',$name)->first();
    }
}
