<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ITRequestRemarks extends Model
{
    protected $table = 'it_request_remarks';

    protected $fillable = [
    	
    	'request_id',
    	'ticket_no',
    	'details',    	
    	'remarks_by'

    ];


    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public function rdetail(){

        return $this->hasOne('App\ITRequest','id','request_id');
    }

    public static function getList($id){

    	$remarks = self::where('ticket_no',$id)->orderBy('created_at','DESC')->get();

        foreach ($remarks as $key => $value) {
            
            $files = ITRequestRemarksFile::where('request_remarks_id',$value->id)->get();

            $remarks[$key]->files = $files;
        }

        return $remarks;
    }
}
