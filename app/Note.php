<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = [


    	'user_id',
    	'title',
    	'notes'
    ];

    public static function byUser($id){

    	return self::where('user_id',$id)->orderBy('created_at','DESC')->get();
    }
}
