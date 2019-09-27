<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkAuthorizationRemark extends Model
{
    protected $table = 'work_authorization_remarks';

    protected $fillable = [

    	'work_authorization_id',
    	'details',
    	'remarks_by'    	    
    ];

    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public static function byWork($id){

    	return self::where('work_authorization_id',$id)->get();
    }

}
