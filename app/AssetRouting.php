<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetRouting extends Model
{
    protected $table = 'asset_routings';

    protected $fillable = [

    	'asset_id',
        'barcode',
    	'holder',
    	'remarks',
    	'remarks2',
        'must_date',
        'returned_date',
        'return_status'
    ];

    public function user(){

    	return $this->hasOne('App\User','id','holder');
    }
    public static function byAsset($id){

    	return self::where('asset_id',$id)->orderBy('created_at','DESC')->get();
    }
}
