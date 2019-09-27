<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class AssetReport extends Model
{
    protected $table = 'asset_reports';
    protected $fillable = [
        'req_no', 'user_id', 'solved_by', 'barcode', 'rel_date', 'ret_date'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function admin()
    {
        return $this->hasOne('App\User', 'id', 'solved_by');
    }
    public function req()
    {
        return $this->hasOne('App\AssetRequest', 'req_no', 'req_no');
    }
    public function item()
    {
        return $this->hasOne('App\AssetTracking', 'barcode', 'barcode');
    }
    public function slip()
    {
        return $this->hasOne('App\BorrowerSlip', 'id', 'bslip_id');
    }
    public function byAsset($num)
    {
        return self::where('rel_date', '=', 'ret_date')->where('req_no', $num)->first();
    }
    public static function getAssetReports($date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));
        return self::select('asset_reports.*')->join('asset_requests', 'asset_requests.req_no', '=', 'asset_reports.req_no')
            ->whereDate('asset_requests.created_at', '>=', $from)
            ->whereDate('asset_requests.created_at', '<=', $to)
            ->where('asset_requests.status', 2)
            ->where('solved_by', '!=', 0)->where('ret_date', '!=', null)
            ->orderBy('asset_requests.created_at')->get();
    }
    public static function getOverdueReports($date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));
        $datenow = date('Y-m-d');

        // return DB::select("SELECT `asset_reports`.* FROM `asset_reports` JOIN asset_requests ON asset_requests.req_no = asset_reports.req_no  WHERE 
        //     (`asset_reports`.ret_date > `asset_reports`.must_date OR `asset_reports`.ret_date IS NULL) and 
        //     (`asset_reports`.created_at BETWEEN '".$from."' AND '".$to."')");

        return self::select('asset_reports.*')->join('asset_requests', 'asset_requests.req_no', '=', 'asset_reports.req_no')

            // ->where('asset_reports.solved_by',0)->orWhere( function ($query) {
            //     $query->where('solved_by','!=', 0);})
            // ->where('asset_reports.must_date','<=',$datenow)
            // ->where('asset_reports.ret_date',null)->orWhere( function ($query) {
            //     $query->whereColumn('asset_reports.must_date','<=','asset_reports.ret_date');})

            // ->where('asset_reports.ret_date','')->orWhere( function ($query) {
            //     $query->whereColumn('asset_reports.ret_date','>','asset_reports.must_date');})

            // ->where('asset_reports.ret_date','>','asset_reports.must_date')->orWhere( function ($query) {
            //     $query->where('asset_reports.ret_date','');})

            // ->where(function($query) {
            //      $query->where('asset_reports.solved_by', '!=', '0')
            //          ->orWhere('asset_reports.solved_by','0');
            //      })
            // ->where('asset_reports.must_date','<=',$datenow)
            ->where(function ($query) {
                $query->where(DB::raw('asset_reports.ret_date'), '>', DB::raw('asset_reports.must_date'));
                // ->orWhere('asset_reports.ret_date', NULL);
            })
            ->whereBetween('asset_reports.created_at', [$from, $to])
            // ->whereDate('asset_requests.created_at','<=',$to)
            ->orderBy('asset_reports.created_at', 'desc')->get();

        // return self::where(function ($query) use ($date_from,$date_to,$datenow){
        //     $query->where('created_at',[$date_from,$date_to])
        //     ->where('solved_by',0)->where('must_date','>=',$datenow)
        //     ->where('ret_date',null);
        // })->orWhere(function ($query) use ($date_from,$date_to,$datenow){
        //     $query->where('created_at',[$date_from,$date_to])
        //         ->whereColumn('must_date','<','ret_date');
        // })->get();
    }
    public static function byBarcodeAndReqNo($barcode, $rno, $id)
    {
        return self::where('bslip_id', $id)->where('barcode', $barcode)->where('req_no', $rno)->where('ret_date', null)->first();
    }

    public static function byBarcodeReqno($barcode, $rno)
    {
        return self::where('barcode', $barcode)->where('req_no', $rno)->where('solved_by', 0)->first();
    }

    public static function byBslipId($id)
    {
        return self::where('bslip_id', $id)->first();
    }
}
