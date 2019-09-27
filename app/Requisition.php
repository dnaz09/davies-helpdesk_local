<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Requisition extends Model
{
    protected $table = 'requisitions';

    protected $fillable = [

        'rno',
    	'user_id',
    	'supervisor_id',
        'recomm',
    	'coe',
    	'itr2316',
    	'philhealth',
    	'others',
    	'others_details',
    	'date_needed',    	
    	'item_no1',
    	'desc1',
    	'qty1',
    	'unit1',
    	'purpose1',
    	'item_no2',
    	'desc2',
    	'qty2',
    	'unit2',
    	'purpose2',
    	'item_no3',
    	'desc3',
    	'qty3',
    	'unit3',
    	'purpose3',
    	'item_no4',
    	'desc4',
    	'qty4',
    	'unit4',
    	'purpose4',
    	'item_no5',
    	'desc5',
    	'qty5',
    	'unit5',
    	'purpose5',
        'hrd',
        'hrd_action',
        'status',
        'sup_action',
        'level',
        'hrd_remarks'      
    ];

    public function user(){

        return $this->hasOne('App\User','id','user_id');
    }

    public static function byUnder($id)
    {
        return self::where('supervisor_id', $id)->where('level','!=',5)->orderBy('created_at','DESC')->get();
    }

    public function hr(){

        return $this->hasOne('App\User','id','hrd');
    }

    public function mngr(){

        return $this->hasOne('App\User','id','supervisor_id');
    }

    public static function byCreated($id){

        return self::where('user_id',$id)->orderBy('created_at','DESC')->get();
    }

    public static function byNo($reqno){

        return self::where('rno',$reqno)->first();
    }

    public static function byHrd(){

        return self::where('status','<','2')->where('level', '<', '2')->where('sup_action',2)->orderBy('created_at','DESC')->get();
    }

    public static function getForHrd(){

        return self::where('status','!=',3)->orderBy('created_at','DESC')->get();
    }

    public static function getPendingHR(){

        return self::where('status','<','2')->where('level', '<', '2')->where('sup_action',2)->count();
    }

    public static function getPending(){

        return self::where('status','<','2')->where('level', '<', '2')->where('sup_action',2)->orderBy('id','DESC')->limit(3)->get();
    }

    public static function byManager(){

        $user = Auth::user();

        $under_me = User::select('id')->where('id','!=',$user->id)->where('superior',$user->id)->get();
        $u_id = [];

        foreach ($under_me as $under) {
            $u_id[] = $under->id;
        }

        return self::whereIn('user_id',$u_id)->where('level',1)->where('sup_action','<',2)->get();

    }

    public static function byDeptId($id)
    {
        return self::select('requisitions.*')
        ->leftJoin('users', 'users.id', '=', 'requisitions.user_id')
        ->where('users.dept_id','=',$id)
        ->get();
    }

    public static function getReports($date_from, $date_to)
    {
        set_time_limit(0);  
        ini_set('memory_limit',-1); 
        
        return self::where('status',2)
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
