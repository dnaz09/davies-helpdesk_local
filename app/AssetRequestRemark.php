<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetRequestRemark extends Model
{
    protected $table = 'asset_request_remarks';

    protected $fillable = [

    	'request_id',
    	'ticket_no',
    	'details',    	
    	'remarks_by'
    ];

    public function user(){

    	return $this->hasOne('App\User','id','remarks_by');
    }

    public static function getList($id){

    	$remarks = self::where('ticket_no',$id)->orderBy('created_at','DESC')->get();

        foreach ($remarks as $key => $value) {
            
            $files = AssetRequestRemarkFile::where('request_remarks_id',$value->id)->get();

            $remarks[$key]->files = $files;
        }

        return $remarks;
    }

    public static function getByReqNoandItem($id,$item)
    {
        return self::where('ticket_no',$id)->where('details','LIKE', '%Missing:'.$item.'%')->first();
    }
}
