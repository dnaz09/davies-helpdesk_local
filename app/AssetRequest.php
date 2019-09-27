<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\BorrowerSlip;

class AssetRequest extends Model
{
    protected $table = 'asset_requests';

    protected $fillable = [

    	'user_id',
    	'details',
    	'solve_by',
    	'status',
    	'req_no',
        'borrower_name'
    ];

    public static function findByReqNo($reqno)
    {
        return self::where('req_no',$reqno)->first();
    }

    public function user(){

    	return $this->hasOne('App\User','id','user_id');
    }

    public function details(){

        return $this->hasOne('App\AssetRequestDetail', 'asset_request_id', 'id');
    }

    public function slip(){

        return $this->hasOne('App\BorrowerSlip','asset_request_no','req_no');
    }
    public function solve(){

    	return $this->hasOne('App\User','id','solve_by');
    }
    public function solver(){

        return $this->hasOne('App\User','id','solve_by');
    }

    public static function ByTicket($num){

    	$ticks =  self::where('req_no',$num)->first();
            
        $ticks->dets = AssetRequestDetail::where('asset_request_id',$ticks->id)->get();
                
        return $ticks;
    }

    public static function byReqNo($num)
    {
        return self::where('req_no',$num)->first();
    }

    public static function BySuperior($id){
        return self::where('superior', $id)->where('status','!=',5)->orderBy('created_at','DESC')->get();
    }

    public static function ByTicketSolve($num){

        $ticks =  self::where('req_no',$num)->first();
            
        // $ticks->dets = AssetRequestDetail::where('asset_request_id',$ticks->id)->get();
                
        return $ticks;
    }

    public static function getPending()
    {
        return self::where('sup_action',2)->where('status',1)->orderBy('id', 'DESC')->limit(3)->get();
    }

    public static function myrequest($id){

        return self::where('user_id',$id)->get();
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

        return self::where('sup_action',2)->count();
    }

    public static function getTotalOngoing(){

        return self::where('sup_action',2)->where('status',1)->count();
    }

    public static function getTotalClosed(){

        return self::where('status',2)->count();
    }

    public static function byDeptId($id)
    {
        return self::select('asset_requests.*')
        ->leftJoin('users', 'users.id', '=', 'asset_requests.user_id')
        ->where('users.dept_id','=',$id)
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

    public static function getMyHistory($id)
    {
        $reqs = self::where('user_id',$id)->get();

        return $reqs;
    }
}
