<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSupplyRequest extends Model
{
    protected $table = 'admin_supply_requests';

    protected $fillable = [
    	'req_no','user_id','details','manager_action','manager','admin_action','admin','status','superior','received_by'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public function approver()
    {
    	return $this->hasOne('App\User','id','manager');
    }

    public function admapprover()
    {
    	return $this->hasOne('App\User','id','admin');
    }

    public static function findByUserId($id)
    {
        return self::where('user_id',$id)->get();
    }

    public static function findOrFailWithDetails($id)
    {
        $req = self::where('id',$id)->first();

        return $req;
    }

    public static function findBySuperior($id)
    {
        return self::where('superior',$id)->where('status','!=',5)->orderBy('created_at','DESC')->get();
    }

    public static function getAllForAdmin()
    {
        return self::where('manager_action',1)->orderBy('id','DESC')->get();
    }

    public static function getAllForSuperior(){
        return self::where('manager_action',0)->orderBy('id','DESC')->get();
    }

    public static function getMyDepartment($id)
    {
        return self::select('admin_supply_requests.*')->join('users','users.id','=','admin_supply_requests.user_id')
            ->where('users.dept_id',$id)->orderBy('admin_supply_requests.created_at','DESC')->get();
    }

        public static function findByReqNo($reqno)
    {
        return self::where('req_no',$reqno)->first();
    }
}
