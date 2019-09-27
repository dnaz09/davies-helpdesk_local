<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetBorrowHistory extends Model
{
    protected $table = 'asset_borrow_histories';

    protected $fillable = [
    	'user_id','req_no','barcode','remarks'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public static function byBarcode($barcode)
    {
    	return self::where('barcode',$barcode)->orderBy('created_at','DESC')->get();
    }
}
