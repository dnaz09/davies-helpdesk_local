<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionRemark extends Model
{
    protected $table = 'requisition_remarks';

    protected $fillable = [

    	'requisition_id',
    	'details',
    	'remarks_by'    	    
    ];

    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public static function byWork($id){

    	return self::where('requisition_id',$id)->orderBy('created_at','DESC')->get();
    }
}
