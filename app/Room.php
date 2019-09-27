<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
    	'room_name','vacancy'
    ];

    public static function getAllVacant()
    {
      return self::orderBy('id','DESC')->get();
    }

    public static function getAllExceptPantry()
    {
      $room = 'BLDG. 102 - PANTRY (4:30PM onwards only)';
      
    	return self::where('room_name','!=',$room)->orderBy('id','DESC')->get();
    }

    public static function findByName($name)
   	{
   		return self::where('room_name',$name)->first();
   	}
}
