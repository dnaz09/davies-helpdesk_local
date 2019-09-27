<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequisition extends Model
{
    protected $table = 'employee_requisitions';
    protected $fillable = [
    	'ereq_no',
		'job_title',
        'company',
        'dept_id',
        'work_site',
        'no_needed',
		'req_type',
        'req_nature',
		'gender',
		'age',
		'details',
		'user_id',
		'manager',
        'superior',
        'sup_action',
        'hr_action',
        'hrd',
        'approver_action'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }
    public function supervisor()
    {
        return $this->hasOne('App\User','id','superior');
    }
    public function mgr()
    {
    	return $this->hasOne('App\User','id','manager');
    }
    public function hr()
    {
        return $this->hasOne('App\User','id','hrd');
    }
    public static function byUser($id)
    {
        return self::where('user_id',$id)->orderBy('created_at','DESC')->get();
    }
    public static function findByEReqNo($id)
    {
        return self::where('ereq_no',$id)->first();
    }
    public static function findBySuperior($id)
    {
        return self::where('superior',$id)->where('sup_action','!=',5)->orderBy('created_at','DESC')->get();
    }
    public static function allApprovedBySup()
    {
        return self::where('sup_action', 1)->get();
    }
    public static function findByDepartment($id)
    {
        return self::where('dept_id',$id)->orderBy('ereq_no','DESC')->get();
    }
    public static function countPending()
    {
        return self::where('sup_action',1)->where('hr_action','<',1)->where('approver_action','<',1)->count();
    }
    public static function Pending()
    {
        return self::where('sup_action',1)->where('hr_action','<',1)->where('approver_action','<',1)->orderBy('ereq_no','DESC')->limit(3)->get();
    }
    public static function approvedByHr()
    {
        return self::where('sup_action',1)->where('hr_action',1)->get();
    }
}
