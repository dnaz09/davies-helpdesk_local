<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    protected $table = 'gate_passes';

    protected $fillable = [
        'req_no', 'user_id', 'company', 'department', 'ref_no', 'purpose', 'control_no', 'date', 'exit_gate_no', 'requested_by', 'issue_by', 'approve_for_release', 'checked_by', 'received_by'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function issue()
    {
        return $this->hasOne('App\User', 'id', 'issue_by');
    }

    public function approver()
    {
        return $this->hasOne('App\User', 'id', 'approve_for_release');
    }

    public static function getMine($id)
    {
        return self::where('user_id', $id)->orderBy('created_at', 'DESC')->get();
    }

    public static function getForIssuing()
    {
        return self::where('approval', '<', 1)->orderBy('created_at', 'DESC')->get();
    }

    public static function getForClosing()
    {
        return self::where('approval', 1)->orderBy('created_at', 'DESC')->get();
    }

    public static function getForApproval()
    {
        return self::orderBy('created_at', 'DESC')->get();
    }

    public static function getForGuard()
    {
        return self::where('approval', 1)->where('status', 1)->orderBy('created_at', 'DESC')->get();
    }

    public static function getReports($from, $to)
    {
        $date_from = date('Y-m-d', strtotime($from));
        $date_to = date('Y-m-d', strtotime($to));

        return self::where('status', 2)->whereDate('date', '>=', $date_from)->whereDate('date', '<=', $date_to)->orderBy('created_at', 'DESC')->get();
    }
}
