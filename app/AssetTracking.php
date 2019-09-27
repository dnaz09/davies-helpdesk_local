<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTracking extends Model
{
    protected $table = 'asset_trackings';

    protected $fillable = [

    	'barcode',
    	'item_name',
    	'io',
    	'remarks',
    	'holder',
        'must_date',
        'returned_date',
        'category',
        'brand',
        'active'

    ];

    public function user(){

    	return $this->hasOne('App\User','id','holder');
    }

    public function slip()
    {
        return $this->hasOne('App\BorrowerSlip','asset_barcode','barcode');
    }

    public static function getAllMine($id)
    {
        return self::where('holder',$id)->orderBy('item_name','ASC')->get();
    }

    public static function ByItemName($name)
    {
        return self::where('item_name', '=', $name)->where('io',1)->first();
    }

    public static function getItemByItem($name)
    {
        return self::where('item_name', $name)->where('io',1)->get();
    }

    public static function getItemByCategory($name)
    {
        return self::where('category', $name)->where('active',1)->where('io',1)->get();
    }

    public static function byBarcode($barcode){

    	return self::where('barcode',$barcode)->first();
    }

    public static function byCreated($id){

        return self::where('user_id',$id)->get();
    }

    public static function getList(){

        return AssetTracking::orderBy('category','ASC')->pluck('category','category');
    }
    // public static function byExpDate($date)
    // {
    //     return self::where('must_date',$date)->get();
    // }
    public static function byUserId($id)
    {
        return self::where('holder', $id)->where('io', 0)->get();
        // return self::select('asset_trackings.*','borrower_slips.*')
        // ->join('borrower_slips','borrower_slips.asset_barcode','=','asset_trackings.barcode')
        // ->where('io',0)->where('borrower_slips.returned',null)->where('holder',$id)->get();
    }

    public static function byReleased()
    {
        // return self::where('io',0)->where('holder', '!=',0)->get();
        // return self::select('asset_trackings.*','borrower_slips.*')
        // ->join('borrower_slips','borrower_slips.asset_barcode','=','asset_trackings.barcode')
        // ->where('io',0)->where('borrower_slips.returned',null)->get();
        
        return self::select('asset_trackings.*','borrower_slips.asset_barcode','borrower_slips.must_date')
                    ->join('borrower_slips','borrower_slips.asset_barcode','=','asset_trackings.barcode')
                    ->where('io',0)
                    ->where('borrower_slips.returned',null)                  
                    ->get();
    }

    public static function byReturned()
    {
        return self::where('io',1)->where('holder',0)->get();
    }

    public static function getCategories()
    {
        return self::orderBy('category','ASC')->pluck('category','category');
    }

    public static function findByBarcode($barcode)
    {
        return self::where('barcode',$barcode)->first();
    }
}
