<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessControl extends Model
{
    protected $table = 'access_controls';

    protected $fillable = [

    	'user_id',
    	'module_id'
    ];

    public function module(){

    	return $this->hasOne('App\Module','id','module_id');
    }

    public static function byUser($id){

    	$acc = self::where('user_id',$id)->get();

    	$access = [];

    	foreach ($acc as $ac) {
    		
    		$access[] = $ac->module_id;
    	}

        return $access;
    	// return $acc;

    }

    public function CheckUserModule($id, $module_id)
    {
        return self::where('user_id',$id)->where('module_id',$module_id)->first();
    }

    public static function findByModule($num)
    {
        return self::where('module_id',$num)->get();
    }
}
