<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ITRequest extends Model
{
    protected $table = 'i_t_requests';

    protected $fillable = [

		'created_by',
		'reqit_no',
		'level',
		'details',
		'status',
		'solved_by',
		'category',
		'sub_category',
		'service_type',
        'old',
        'asset_no'
    ];

    public function user(){

        return $this->hasOne('App\User','id','created_by');
    }

    public function solve(){

        return $this->hasOne('App\User','id','solved_by');
    }

    public static function byBatch($level){
        // return self::where('service_type',1)->where('level','!=',2)->orderBy('id','DESC')->get();
    	return self::where('service_type',1)->where('sub_category','!=','SAP')->where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status','!=',5)->get();
    }

    public static function getMySolvedSap($id)
    {
        return self::where('service_type',1)->where('solved_by',$id)->where('sub_category','SAP')->count();
    }

    public static function byApprovedManager()
    {
        return self::where('service_type',1)->where('sub_category','SAP')->where('status','!=',5)->where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->orderBy('status','ASC')->get();
    }

    public static function byManagerSAP($id)
    {
        return self::where('service_type',1)->where('sub_category','SAP')->where('status','!=',5)->where('superior',$id)->orderBy('created_at','DESC')->get();
    }

    public static function byBatchService($level){


        return self::where('service_type',2)->where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status','!=',5)->get();
    }

    public static function byBatchItem($level){


        return self::where('service_type',3)->orderBy('id','DESC')->paginate(10);
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

    	// return self::count();
        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->count();
    }

    public static function getTotalOngoing(){

    	// return self::where('status',0)->where('level',0)->count();
        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status',0)->where('solved_by',0)->count();
        // return self::where('sub_category','!=','SAP')->where('status',0)->count();
    }

    public static function getTotalMamTifOngoing(){

        // return self::where('level', 2)->count();
        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')
            ->where('service_type',1)->where('level',2)->where('sup_action',1)
            ->where('category','PROGRAM')->where('sub_category','SAP')
            ->where('solved_by',0)->count();
    }

    public static function getTotalReturned(){

        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status',1)->count();
    }

    public static function getTotalClosed(){

    	return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status',2)->count();
    }

    public static function byTicket($id){

        return self::where('reqit_no',$id)->first();
    }

    public static function myRequest($id){

        return self::where('created_by',$id)->get();
    }
    //service
    public static function getTotalService(){

        return self::where('service_type',2)->count();
    }

    public static function serviceOngoing(){

        return self::where('service_type',2)->where('status',0)->count();
    }

    public static function serviceReturned(){

        return self::where('service_type',2)->where('status',1)->count();
    }

    public static function serviceSolved(){

        return self::where('service_type',2)->where('status',2)->count();
    }
    //user access
    public static function getAccessTotal(){

        return self::where('service_type',1)->count();
    }

    public static function accessOngoing(){

        return self::where('service_type',1)->where('level',0)->where('status',0)->count();
        // return self::where('service_type',1)->where('level',1)->where('status',0)->count();
    }

    public static function accessReturned(){

        return self::where('service_type',1)->where('level',1)->where('status',1)->count();
    }

    public static function accessSolved(){

        return self::where('service_type',1)->where('level',1)->where('status',2)->count();
    }

    public static function solvedService($id){

        return self::where('service_type',2)->where('status',2)->where('solved_by',$id)->count();
    }

    public static function solvedAccess($id){

        return self::where('service_type',1)->where('status',2)->where('solved_by',$id)->count();
    }

    public static function getByDate($start, $end){

        $from = date("Y-m-d",strtotime($start));
        $to = date("Y-m-d",strtotime($end));
        
        $reports =  self::select(DB::raw('users.first_name, users.last_name'),'i_t_requests.details as issues','category','sub_category','service_type',
            'i_t_requests.created_at','i_t_requests.updated_at','reqit_no','created_by')
            ->join('users','users.id','=','i_t_requests.solved_by')            
            ->where('status',2)            
            ->whereDate('i_t_requests.updated_at','>=',$from)
            ->whereDate('i_t_requests.updated_at','<=',$to)
            ->orderBy('i_t_requests.updated_at')
            ->get();

        if(!empty($reports)){

            foreach ($reports as $key => $value) {
                
                if($value->service_type > 1){

                    $reports[$key]->service = "SERVICE REQUEST";
                }else{
                    $reports[$key]->service = "USER ACCESS REQUEST";
                }


            }
        }

        return $reports;
    }

    public static function byManager(){

        return self::where('service_type',1)->where('category','PROGRAM')->where('sub_category','SAP')->orderBy('id','DESC')->where('sup_action',1)->get();
    }

    public static function ManagerPendingCount()
    {
        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('service_type',1)->where('solved_by',0)->where('level',2)->where('category','PROGRAM')->where('sub_category','SAP')->where('sup_action',1)->limit(3)->orderBy('id','DESC')->get();
    }

    public static function getAllPending()
    {
        // return self::where('sub_category','!=','SAP')->where('status',0)->limit(3)->orderBy('id','DESC')->get();
        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status',0)->where('solved_by',0)->limit(3)->orderBy('id','DESC')->get();
    }
    public static function getAllPendingCount()
    {
        // return self::where('sub_category','!=','SAP')->where('status',0)->count();
        return self::where('reqit_no','NOT LIKE','%IT-UR%')->where('reqit_no','NOT LIKE','%IT-SR%')->where('status',0)->where('solved_by',0)->count();
    }
    public static function getMine($id)
    {
        return self::where('created_by',$id)->where('status','!=',1)->where('status','!=',5)->where('level','!=',1)->orderBy('created_at', 'DESC')->limit(2)->get();
    }

    public static function getMineCount($id)
    {
        return self::where('created_by',$id)->where('status','!=',1)->where('status','!=',5)->where('level','!=',1)->count();
    }

    public static function byDept($id)
    {
        $all = []; 
        $reqs = self::where('service_type',1)->where('sub_category', '!=', 'SAP')->get();
        foreach ($reqs as $req) {
            if($req->user->department->id == $id){
                $all[] = $req;
            }
        }
        return $all;
    }

    public static function byManagerUserAcc($id)
    {
        return self::where('superior',$id)->where('service_type',1)->where('status','!=',5)->where('sub_category','!=','SAP')->orderBy('created_at','DESC')->get();
    }
}
