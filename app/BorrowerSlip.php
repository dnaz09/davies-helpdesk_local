<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowerSlip extends Model
{
    protected $table = 'borrower_slips';
    protected $fillables = [
        'asset_request_no', 'asset_barcode', 'released', 'returned', 'must_date', 'date_needed', 'return_date', 'borrow_code',
        'item', 'is_asset', 'qty', 'qty_r', 'accs', 'get_by', 'received_by',
    ];

    public function asset()
    {
        return $this->hasOne('App\AssetTracking', 'barcode', 'asset_barcode');
    }

    public function assreq()
    {
        return $this->hasOne('App\AssetRequest', 'req_no', 'asset_request_no');
    }

    public function receiever()
    {
        return $this->hasOne('App\User', 'id', 'received_by');
    }
    public static function findByReqId($reqno)
    {
        $items = self::where('asset_request_no', $reqno)->where('released', 1)->get();

        return $items;
    }
    public static function getMine($id)
    {
        return self::select('borrower_slips.*')->join('asset_requests', 'asset_requests.req_no', '=', 'borrower_slips.asset_request_no')
            ->where('asset_requests.user_id', $id)
            ->where('borrower_slips.is_asset', 0)
            ->where('released', 1)
            ->where('returned', null)
            ->get();
    }

    public static function ByTicket($num)
    {

        $ticks =  self::where('asset_request_no', $num)->get();

        // $ticks->dets = AssetRequestDetail::where('asset_request_id',$ticks->id)->get();

        return $ticks;
    }

    public static function ByTicketReturned($num)
    {

        // $ticks = self::where('asset_request_no',$num)->where('released',1)->where('returned',1)->get();
        $ticks = self::where('asset_request_no', $num)->where('released', 1)->get();
    }

    public static function ByTicket2($num)
    {

        $ticks =  self::where('asset_request_no', $num)->first();

        // $ticks->dets = AssetRequestDetail::where('asset_request_id',$ticks->id)->get();

        return $ticks;
    }

    public static function ByTicketAndName($barcode, $rno)
    {
        return self::where('asset_request_no', $rno)
            ->where('asset_barcode', $barcode)
            ->where('released', 1)
            ->where('returned', null)->first();
    }

    public static function getToRelease()
    {
        return self::where('released', null)->where('borrow_code', '!=', null)->orderBy('id', 'DESC')->limit(3)->get();
    }

    public static function getToReleaseCount()
    {
        return self::where('released', null)->where('borrow_code', '!=', null)->count();
    }

    public static function byReturned()
    {
        return self::where('released', 1)->where('is_asset', 1)->where('returned', 1)->where('return_date', '!=', null)->get();
    }

    public static function NaByReturned()
    {
        return self::where('released', 1)->where('is_asset', 0)->where('returned', 1)->where('return_date', '!=', null)->get();
    }

    public static function byReleased()
    {
        return self::where('released', 1)->where('returned', null)->where('return_date', null)->get();
    }

    public static function getReleasedAssets()
    {
        return self::where('released', 1)->where('returned', null)->where('return_date', null)->where('is_asset', 1)->where('asset_barcode', '!=', null)->get();
    }

    public static function getReleasedNonAssets()
    {
        return self::where('released', 1)->where('returned', null)->where('return_date', null)->where('is_asset', 0)->where('asset_barcode', null)->get();
    }

    public static function getAllNonReturned($req_no)
    {
        return self::where('released', 1)->where('returned', null)->where('asset_request_no', $req_no)->count();
    }

    public static function getAllSlips($req_no)
    {
        return self::where('asset_request_no', $req_no)->count();
    }

    public static function getMyNonAssets($id)
    {
        return self::select('*')->leftJoin('asset_requests', 'asset_requests.req_no', '=', 'borrower_slips.asset_request_no')->where('is_asset', 0)->where('released', 1)->where('returned', null)->where('asset_requests.user_id', $id)->get();
    }

    public static function findByIdFirst($id)
    {
        return self::where('id', $id)->first();
    }
}
