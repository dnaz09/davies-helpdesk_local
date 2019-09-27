<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeExitPass extends Model
{
    protected $table = 'employee_exit_passes';

    protected $fillble = [

    	'exit_no',
        'obp_id',
        'undertime_id',
    	'supervisor',
    	'user_id',
    	'purpose',
    	'date',
    	'time_in',
    	'time_out',
        'arrival_time',
        'departure_time',
    	'appr_obp',
    	'appr_leave',
    	'others',
    	'dep_manager_approver',
    	'dep_manager_action',
    	'dep_remarks',
    	'hrd_approver',
    	'hrd_action',
    	'hrd_remarks',
    	'vp_hr_approval_approver',
    	'vp_hr_approval_action',
    	'vp_hr_approval_remarks',
    	'vp_division_approver',    	
    	'vp_division_action',
    	'vp_division_remarks',
    	'security_guard',
        'status',
        'level',
        'others_details',
        'guard_remarks',
        'agency'
    ];

    public function user(){

    	return $this->hasOne('App\User','id','user_id');
    }
    public function hrds(){

        return $this->hasOne('App\User','id','hrd_approver');
    }
    public static function byUser($id){

    	return self::where('user_id',$id)->orderBy('created_at','DESC')->get();
    }

    public static function byNo($ext){

        return self::where('id',$ext)->first();
    }

    public static function ByNum($num){

        return self::where('exit_no',$num)->first();
    }

    public static function guardByday(){

        $date = date('Y-m-d',strtotime('-3 days'));
        $date2 = date('Y-m-d');

        return self::whereDate('date','>=',$date)
            ->whereDate('date','<=',$date2)
            ->orderBy('updated_at','DESC')
            ->get();

    }

    public static function getMySolved($id){


        return self::where('solved_by',$id)->where('service_type',1)->count();
    }

    public static function getMySolvedService($id){


        return self::where('solved_by',$id)->where('service_type',2)->count();
    }

    public static function getMySolvedItem($id){


        return self::where('solved_by',$id)->where('service_type',3)->count();
    }

    public static function getTotal(){

        return self::count();
    }

    public static function getTotalOngoing(){

        return self::where('status',0)->count();
    }

    public static function getTotalClosed(){

        return self::where('status',1)->count();
    }

    // public static function getPendingHR(){

    //     return self::where('hrd_action','<','2')->count();
    // }

    public static function getPendingHRCount(){

        // return self::where('hrd_action',null)->count();
        $date = date('Y-m-d');

        return self::where('level',1)->where('date',$date)->count();
    }

    public static function getPendingHR(){

        // return self::where('hrd_action',null)->orderBy('created_at','DESC')->limit(3)->get();
        $date = date('Y-m-d');

        return self::where('level',1)->where('date',$date)->orderBy('created_at','DESC')->limit(3)->get();
    }

    public static function dailyPending(){

        $date = date('Y-m-d',strtotime('-3 days'));
        $date2 = date('Y-m-d');

        return self::where('level',1)
            ->whereDate('date','>=',$date)
            ->whereDate('date','<=',$date2)
            ->orderBy('updated_at','DESC')
            ->count();
    }

    public static function dailyReleased(){

        $date = date('Y-m-d');
        return self::where('level',2)->where('date',$date)->count();
    }

    public static function getByDateRange($from, $to){

        return self::whereBetween('date',[$from,$to])->where('level',2)->get();
    }

}
