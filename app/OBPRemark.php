<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OBPRemark extends Model
{
    protected $table = 'obp_remarks';

    protected $fillable = [

    	'obp_id',    	
    	'details',    	
    	'remarks_by'
    ];

    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public static function byObp($id){

    	return self::where('obp_id',$id)->orderBy('created_at','DESC')->get();
    }
}
