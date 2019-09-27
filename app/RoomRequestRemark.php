<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRequestRemark extends Model
{
    protected $table = 'room_request_remarks';

    protected $fillable = [
    	'user_id','remarks','room_req_id'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public static function findByReqId($id)
    {
    	return self::where('room_req_id',$id)->orderBy('created_at','DESC')->get();
    }
}
