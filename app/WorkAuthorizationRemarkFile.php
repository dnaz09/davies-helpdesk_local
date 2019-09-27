<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkAuthorizationRemarkFile extends Model
{
    protected $table = 'work_authorization_remark_files';

    protected $fillable = [

    	'work_authorization_remark_id',
    	'filename',
    	'encryptname',
    	'uploaded_by'
    ];

    public static function byWork($id){

    	return self::where('work_authorization',$id)->get();
    }
}
