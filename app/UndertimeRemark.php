<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndertimeRemark extends Model
{
    protected $table = 'undertime_remarks';

    protected $fillable = [

    	'undertime_id',
    	'details',
    	'remarks_by'
    ];

    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public static function byUndertime($id){

    	return self::where('undertime_id',$id)->orderBy('created_at','DESC')->get();
    }    
}
