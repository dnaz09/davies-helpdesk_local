<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExitPassRemark extends Model
{
    protected $table = 'exit_pass_remarks';

    protected $fillable = [
    	'exit_id',
    	'exit_no',
    	'details',    	
    	'remarks_by'

    ];


    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public static function getList($id){

    	$remarks = self::where('exit_no',$id)->orderBy('created_at','DESC')->get();
        
        return $remarks;
    }
}
