<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSupplyRequestRemark extends Model
{
    protected $table = 'admin_supply_request_remarks';

    protected $fillable = [
    	'admin_supply_request_id','user_id','remarks'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public static function findByAdminRequestId($id)
    {
    	return self::where('admin_supply_request_id',$id)->orderBy('created_at','DESC')->get();
    }
}
