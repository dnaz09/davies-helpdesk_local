<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use DataTime;
use App\WorkAuthorizationDetail;
use DB;

class WorkAuthorization extends Model
{
    protected $table = 'work_authorizations';

    protected $fillable = [

        'work_no',
        'user_id',
        'ot_from',
        'ot_to',
        'date_needed',
        'not_exceed_to',
        'reason',
        'requested_by',
        'security',
        'time_out',
        'level'
    ];

    public static function searchByWord($key)
    {
        $data = DB::select("SELECT work_authorizations.*, users.first_name, users.last_name FROM work_authorizations JOIN users on work_authorizations.user_id = users.id WHERE  
        (user_id in (SELECT id FROM users WHERE concat_ws(' ',first_name,last_name) LIKE '%" . $key . "%' )) OR 
        (user_id in (SELECT id FROM users WHERE concat_ws(' ',last_name,first_name) LIKE '%" . $key . "%' )) OR 
        (work_authorizations.created_at LIKE '%" . date('Y-m-d H:i:s', strtotime($key)) . "%') OR
        (work_authorizations.date_needed LIKE '%" . date('Y/m/d', strtotime($key)) . "%') OR
        (work_no LIKE '%" . $key . "%')");
        return $data;
    }
    public function user()
    {

        return $this->hasOne('App\User', 'id', 'user_id');
    }

    // public static function byUnder($id)
    // {
    //     // return self::where('superior', $id)->get();
    //     return self::where('superior', $id)->get();
    // }

    // public function sup(){

    // 	return $this->hasOne('App\User','id','superior');
    // }
    public function detail()
    {
        return $this->hasMany('App\WorkAuthorizationDetail', 'work_auth_id', 'id');
    }

    public function getReportsHrModule($date_from, $date_to)
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $from = date('Y/m/d', strtotime($date_from));
        $to = date('Y/m/d', strtotime($date_to));
        $work_auth = $this->whereBetween('date_needed', [$from, $to])->first()->detail();
        dd($work_auth);
        $report = array();
        foreach ($work_auth as $key => $value) {
            $detail = $value->detail()->get();
            foreach ($detail as $key_detail => $detail_value) {
                $data = [
                    'Date' => date('m/d/Y', strtotime($value->date_needed)),
                    'WAS #' => $value->work_no,
                    'Name' => $detail_value->user->last_name . ', ' . $detail_value->user->first_name,
                    'Department' => $detail_value->user->department->department,
                    'From' => date('h:i a', strtotime($value->ot_from)),
                    'To' => date('h:i a', strtotime($value->ot_to)),
                    'Check Out' => ''
                ];
                array_push($report, $data);
            }
        }
        dd($report);
    }
    public function hr()
    {

        return $this->hasOne('App\User', 'id', 'hrd');
    }

    public static function byCreated($id)
    {

        return self::where('user_id', $id)->orderBy('created_at', 'DESC')->get();
    }


    public static function bySup()
    {

        $user = Auth::user();

        $under_me = User::select('id')->where('id', '!=', $user->id)->get();
        $u_id = [];

        foreach ($under_me as $under) {
            $u_id[] = $under->id;
        }

        return self::whereIn('user_id', $u_id)->where('level', 1)->get();
    }

    public static function byHrd()
    {

        return self::orderBy('created_at', 'DESC')->get();
    }

    public static function getPendingHR()
    {

        return self::count();
    }

    public static function byDeptId($id)
    {
        return self::select('work_authorizations.*', 'users.*', 'work_authorizations.id')
            ->leftJoin('users', 'users.id', '=', 'work_authorizations.user_id')
            ->where('users.dept_id', '=', $id)
            ->get();
    }

    public static function getReports($date_from, $date_to)
    {
        $date_to_ = new \DateTime($date_to);
        $date_to_->add(new \DateInterval('P1D'));
        return self::whereBetween('created_at', [$date_from, $date_to_])
            ->get();

        // return self::select('work_authorization_details.*','work_authorizations.*')
        // ->leftJoin('work_authorization_details', 'work_authorization_details.work_auth_id', '=', 'work_authorizations.id')
        // ->whereBetween('work_authorizations.created_at', [$date_from, $date_to_])
        // ->get();
    }

    public static function findByDateRange($date_from, $date_to)
    {
        $from = date('Y/m/d', strtotime($date_from));
        $to = date('Y/m/d', strtotime($date_to));
        $works = self::whereBetween('date_needed', [$from, $to])->get();

        return $works;
    }

    public static function getAllWorkAuths()
    {
        $date = date('Y/m/d', strtotime('-14 days'));

        $works = self::whereDate('date_needed', '>=', $date)->where('level', '<', 2)->get();

        return $works;
    }
}
