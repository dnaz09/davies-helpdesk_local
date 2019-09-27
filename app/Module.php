<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = [

    	'module',
    	'description',
    	'routeUri',
    	'icon',
    	'default_url',
    	'deparment'
    ];

    public static function getAll()
    {
    	return self::where('id','!=',0)->get();
    }
}
