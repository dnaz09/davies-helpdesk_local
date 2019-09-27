<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_orders';
    protected $fillable = [
    	'job_orders',
		'jo_no',
		'date_submitted',
		'user_id',
		'status',
		'dept_id',
		'role_id',
        'section',
		'req_work',
        'description',
		'approved_by',
		'repair',
		'project',
		'work_done',
		'served_by',
		'verified_by',
        'item_class'
    ];

    public function user()
    {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function supname()
    {
        return $this->hasOne('App\User', 'id', 'superior');
    }

    public function approved()
    {
        return $this->hasOne('App\User', 'id', 'approved_by');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'dept_id');
    }

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public static function ByDeptId($id)
    {
        return self::where('dept_id',$id)->orderBy('jo_no','DESC')->get();
    }

    public static function ByUser($id)
    {
    	return self::where('user_id', $id)->get();
    }

    public static function byId($id)
    {
        return self::where('id',$id)->first();
    }
    // USER
    public static function getAllTotal($id)
    {
    	return self::where('user_id', $id)->count();
    }

    public static function getAllPending($id)
    {
    	return self::where('user_id', $id)->where('status', 1)->count();
    }

    public static function getAllApproved($id)
    {
    	return self::where('user_id', $id)->where('status', 2)->count();
    }
    //ADMIN
    public static function getAdminAllTotal()
    {
        return self::where('status', 2)->where('jo_status',1)->count();
    }

    public static function getAdminAllPending()
    {
        return self::where('status', 2)->where('jo_status',1)->count();
    }

    public static function getAdminAllApproved()
    {
        return self::where('status', 2)->where('superior', 1)->count();
    }

    public static function getAllSupApproved()
    {
        return self::where('sup_action', 1)->get();
    }
    //SUPERIOR
    public static function getSupAll($id)
    {
        return self::where('superior', $id)->where('status','!=',5)->orderBy('created_at','DESC')->get();
    }

    public static function getSupAllTotal($id)
    {
        return self::where('superior', $id)->count();
    }

    public static function getSupPending($id)
    {
        return self::where('superior', $id)->where('sup_action',0)->count();
    }

    public static function getSupApproved($id)
    {
        return self::where('superior',$id)->where('sup_action',1)->count();
    }

    public static function getApproved()
    {
        return self::where('status',2)->orderBy('id','DESC')->get();
    }

    public static function getReports($from,$to)
    {
        $date_from = date('Y-m-d',strtotime($from));
        $date_to = date('Y-m-d',strtotime($to));
        return self::whereDate('date_submitted','>=',$date_from)
            ->whereDate('date_submitted','<=',$date_to)
            ->orderBy('created_at','ASC')
            ->get();
    }
}
