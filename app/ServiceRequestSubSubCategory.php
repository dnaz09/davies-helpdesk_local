<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestSubSubCategory extends Model
{
    protected $table = 'service_request_sub_sub_categories';

    protected $fillable = [
    	'sub_categ_id','sub_sub_category'
    ];

    public function subcategory()
    {
    	return $this->hasOne('App\ServiceRequestSubCategory','id','sub_categ_id');
    }

    public static function getList($id){

    	return self::where('sub_categ_id',$id)->orderBy('sub_sub_category','ASC')->pluck('sub_sub_category','sub_sub_category');
    }
}
