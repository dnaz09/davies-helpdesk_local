<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccessRequestSubSubCategory extends Model
{
    protected $table = 'user_access_request_sub_sub_categories';

    protected $fillable = [
    	'sub_categ_id','error'
    ];

    public function subcategory()
    {
    	return $this->hasOne('App\UserAccessRequestSubCategory','id','sub_categ_id');
    }

    public static function getList($id){

    	return self::where('sub_categ_id',$id)->orderBy('error','ASC')->pluck('error','error');
    }
}
