<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OBP extends Model
{
    protected $table = 'obps';

    protected $fillbable = [

    	'user_id',
    	'supervisor',
    	'manager',
    	'position',
    	'department',
    	'purpose',
        'date',
    	'date2',
    	'time_left',
    	'time_arrived',
    	'manager',
    	'hrd',
    	'level',
    	'manager_action',
    	'hrd_action',
        'obpno',
        'hr_action',
        'hrd'
    ];

    public function user(){

        return $this->hasOne('App\User','id','user_id');
    }

    public function solver(){

        return $this->hasOne('App\User','id','approver');
    }

    public function superv(){

        return $this->hasOne('App\User','id','supervisor');
    }

    public function manage(){

        return $this->hasOne('App\User','id','manager');
    }

    public function hrds(){

        return $this->hasOne('App\User','id','hrd');
    }

    public static function ByNum($num){

        return self::where('obpno',$num)->first();
    }

    public static function byCreated($id){

        return self::where('user_id',$id)->get();
    }

    public static function byId($id){

        return self::where('id',$id)->first();
    }

    public static function byManager(){

        $user = \Auth::user();

        $under_me = User::select('id')->where('id','!=',$user->id)->where('superior',$user->id)->get();
        $u_id = [];

        foreach ($under_me as $under) {
            $u_id[] = $under->id;
        }

        return self::whereIn('user_id',$u_id)->where('level',1)->where('manager_action','<',2)->get();
    }

    public static function byUnder($id)
    {
        return self::where('supervisor', $id)->where('level','!=',5)->orderBy('created_at','DESC')->get();
    }

    public static function byHrd(){

        return self::where('level',2)->orderBy('created_at','DESC')->get();
    }

    public static function getApproved($id){

        $date = date('Y-m-d');
        return self::where('user_id',$id)->where('date',$date)->where('hrd_action',2)->pluck('obpno','id');
    }
    public function apvr(){

        return $this->hasOne('App\User','id','approver');
    }
    // public static function getPendingHR(){

    //     return self::where('level',2)->where('hrd_action','<',2)->count();
    // }

    public static function getPendingHR(){

        return self::where('manager_action', 2)->where('level', 1)->count();
    }

    public static function fetchPendingHR(){

        return self::where('manager_action', 2)->where('level', 1)->orderBy('id','DESC')->limit(3)->get();
    }

    public static function byDeptId($id)
    {
        return self::select('obps.*')
        ->leftJoin('users', 'users.id', '=', 'obps.user_id')
        ->where('users.dept_id','=',$id)
        ->orderBy('obps.created_at', 'DESC')
        ->get();
    }

    public static function getReports($date_from, $date_to)
    {
        set_time_limit(0);  
        ini_set('memory_limit',-1); 
        
        return self::where('hr_action',1)
            ->whereDate('created_at','>=',$date_from)
            ->whereDate('created_at','<=',$date_to)
            ->get();
    }
    public static function getMine($id)
    {
        return self::where('user_id',$id)->where('level','<',2)->orderBy('created_at', 'DESC')->limit(2)->get();
    }

    public static function getMineCount($id)
    {
        return self::where('user_id',$id)->where('level','<',2)->count();
    }
}
