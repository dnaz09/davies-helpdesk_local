<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Department;

class WorkAuthorizationDetail extends Model
{
    protected $table = 'work_authorization_details';
    protected $fillable = [
        'user_id', 'work_auth_id', 'superior', 'superior_action', 'exit_time'
    ];

    public function work()
    {
        return $this->hasOne('App\WorkAuthorization', 'id', 'work_auth_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function manager()
    {
        return $this->hasOne('App\User', 'id', 'superior');
    }

    public static function byWork($id)
    {
        return self::where('work_auth_id', $id)->get();
    }

    public static function byWorkUnapproved($id)
    {
        return self::where('work_auth_id', $id)->where('superior_action', 0)->get();
    }

    public static function pendingByWork($id)
    {
        return self::where('work_auth_id', $id)->where('superior_action', 0)->get();
    }
    public static function getApproved($id)
    {
        return self::where('work_auth_id', $id)->where('superior_action', 1)->get();
    }
    public static function pendingByWorkGetUserId($id)
    {
        $data = [];
        $users = self::where('work_auth_id', $id)->where('superior_action', 0)->get();
        foreach ($users as $user) {
            $data[] = $user->user_id;
        }
        return $data;
    }

    public static function pendingByWorkGetUserIdApproved($id)
    {
        $data = [];
        $users = self::where('work_auth_id', $id)->where('superior_action', '!=', 0)->get();
        foreach ($users as $user) {
            $data[] = $user->user_id;
        }
        return $data;
    }

    public static function byWorkAndUser($work, $user)
    {
        return self::where('work_auth_id', $work)->where('user_id', $user)->first();
    }

    public static function getWorkAuthById($id)
    {
        return self::where('user_id', $id)->get();
    }

    public static function bySup($id)
    {
        return self::where('superior', $id)->where('superior_action', '!=', 5)->orderBy('created_at', 'DESC')->get();
    }

    public static function byHrd()
    {
        return self::orderBy('created_at', 'DESC')->get();
    }

    public static function countPending()
    {
        return self::where('superior_action', 0)->count();
    }

    public static function Pending()
    {
        $works = self::select('work_authorization_details.*', 'work_authorizations.work_no')
            ->join('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')
            ->where('superior_action', 0)->orderBy('work_authorization_details.id', 'DESC')->limit(3)->get();

        return $works;
    }

    public function getReports($date_from, $date_to)
    {

        $from = date('Y/m/d', strtotime($date_from));
        $to = date('Y/m/d', strtotime($date_to));

        return self::select('work_authorization_details.*')
            ->join('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')
            ->join('users', 'users.id', '=', 'work_authorizations.user_id')
            ->join('departments', 'departments.id', '=', 'users.dept_id')
            ->where('work_authorization_details.superior_action', 1)
            ->whereDate('work_authorizations.date_needed', '>=', $from)
            ->whereDate('work_authorizations.date_needed', '<=', $to)
            ->orderByRaw('FIELD(departments.department, 
            "HUMAN RESOURCES",
            "DISBURSEMENT",
            "FINANCIAL ACCOUNTING & AUDIT",
            "GENERAL ACCOUNTING",
            "CREDIT & COLLECTION",
            "CREATIVE SERVICES",
            "SAFETY",
            "PURCHASING",
            "ADMINISTRATIVE SERVICES",
            "INFORMATION TECHNOLOGY",
            "MODERN RETAIL",
            "EXPORT",
            "MODERN RETAIL & INTL SALES",
            "SUPPORT GROUP",
            "MARKETING OFFICE",
            "MARKETING COMMUNICATION",
            "RESEARCH & DEVELOPMENT",
            "PLANNING",
            "Inbound  Logistics",
            "PRODUCTION",
            "PRODUCTION OFFICE",
            "PRODUCTION - CHARTER CAVITE",
            "PRODUCTION-ZENKEM",
            "PRODUCTION - 2K3",
            "QUALITY CONTROL",
            "OUTBOUND LOGISTICS",
            "LOGISTICS",
            "LOGISTICS & WAREHOUSE",
            "WAREHOUSE",
            "SALES",
            "CUSTOMER SERVICES",
            "BASES & COLORANTS"
            )')
            ->get();
    }

    public static function getMine($id)
    {
        return self::select('work_authorization_details.*')->join('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')->where('work_authorization_details.user_id', $id)->where('work_authorizations.level', '<', 2)->where('work_authorization_details.superior_action', '<', 1)->orderBy('created_at', 'DESC')->limit(2)->get();
    }

    public static function getMineCount($id)
    {
        return self::select('work_authorization_details.*')->join('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')->where('work_authorization_details.user_id', $id)->where('work_authorizations.level', '<', 2)->where('work_authorization_details.superior_action', '<', 1)->count();
    }

    public static function byDept($id)
    {
        return self::select('work_authorization_details.*')
            ->leftJoin('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')
            ->leftJoin('users', 'users.id', '=', 'work_authorization_details.user_id')
            ->where('users.dept_id', '=', $id)
            ->get();
    }

    public static function getAllForToday()
    {
        $date_from = date('Y/m/d', strtotime('-3 days'));
        $date_to = date('Y/m/d');

        return self::select('work_authorization_details.*')
            ->leftJoin('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')
            ->where('work_authorization_details.superior_action', '=', 1)
            ->whereDate('work_authorizations.date_needed', '>=', $date_from)
            ->whereDate('work_authorizations.date_needed', '<=', $date_to)
            ->get();
    }

    public static function findByDateRange($date_from, $date_to)
    {
        $from = date('Y/m/d', strtotime($date_from));
        $to = date('Y/m/d', strtotime($date_to));

        $works = self::select('work_authorization_details.*')->join('work_authorizations', 'work_authorizations.id', '=', 'work_authorization_details.work_auth_id')
            ->whereDate('work_authorizations.date_needed', '>=', $from)
            ->whereDate('work_authorizations.date_needed', '<=', $to)
            ->where('superior_action', 1)
            ->get();

        // foreach ($works as $key => $value) {
        //     $works[$key]->first_name = User::where('id',$value->user_id)->pluck('first_name');
        //     $works[$key]->last_name = User::where('id',$value->user_id)->pluck('last_name');
        // }

        return $works;
    }
}
