<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestSubCategory extends Model
{
    protected $table = 'service_request_sub_categories';

    protected $fillable = [

    	'category_id',
    	'sub_category'

    ];

    public function category(){
    	 
    	return $this->hasOne('App\ServiceRequestCategory','id','category_id');
    }

    public static function getList($id){

    	return self::where('category_id',$id)->orderBy('sub_category','ASC')->pluck('sub_category','sub_category');
    }
}
