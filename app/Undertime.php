<?php

namespace App;
use App\User;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Undertime extends Model
{
    protected $table = 'undertimes';

    protected $fillable = [

    	'user_id',
        'und_no',
    	'sched',
    	'reason',
    	'date',
    	'approve_by',
        'approver_action',
    	'status',
        'manager',
        'manager_action',
        'level',
        'generated',
        'type',
        'remark'
    ];

    public function user(){

        return $this->hasOne('App\User','id','user_id');
    }

    public static function byUnder($id) {

        return self::where('manager', $id)->where('level','!=',5)->orderBy('created_at','DESC')->get();
    }

    public function approver(){

        return $this->hasOne('App\User','id','approve_by');
    }

    public function mngrs(){

        return $this->hasOne('App\User','id','manager');
    }

    public static function byCreated($id){

        return self::where('user_id',$id)->get();
    }

    public static function byManager(){

        $user = Auth::user();

        $under_me = User::select('id')->where('id','!=',$user->id)->where('superior',$user->id)->get();
        $u_id = [];

        foreach ($under_me as $under) {
            $u_id[] = $under->id;
        }

        return self::whereIn('user_id',$u_id)->where('level',1)->where('manager_action','<',2)->get();

    }

    public static function byHrd(){

        return self::where('level','!=',5)->orderBy('created_at','DESC')->get();
    }

    public static function getPendingHR(){

        return self::where('level',2)->where('status','<',2)->count();
    }

    public static function getPendingCount()
    {
        return self::where('level',2)->where('status','<',2)->count();
    }

    public static function getPending()
    {
        return self::where('status','<',2)->where('status','<',2)->orderBy('id','DESC')->limit(3)->get();
    }

    public static function ById($id){

        return self::where('id',$id)->first();
    }

    public static function byDeptId($id)
    {
        return self::select('undertimes.*')
        ->leftJoin('users', 'users.id', '=', 'undertimes.user_id')
        ->where('users.dept_id','=',$id)
        ->get();
    }

    public static function getReports($date_from, $date_to)
    {
        set_time_limit(0);  
        ini_set('memory_limit',-1); 
        
        return self::where('status', '=', 2)
            ->whereDate('created_at','>=',$date_from)
            ->whereDate('created_at','<=',$date_to)
            ->get();
    }
    public static function getMine($id)
    {
        return self::where('user_id',$id)->where('status','<',2)->orderBy('created_at', 'DESC')->limit(2)->get();
    }

    public static function getMineCount($id)
    {
        return self::where('user_id',$id)->where('status','<',2)->count();
    }
}
