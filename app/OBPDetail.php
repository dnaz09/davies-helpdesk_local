<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OBPDetail extends Model
{
    protected $table = 'obp_details';

    protected $fillable = [

    	'obp_id',
    	'destination',
    	'person_visited',
    	'time_of_arrival',
    	'time_of_daparture',
        'destination2',
        'person_visited2',
        'time_of_arrival2',
        'time_of_daparture2',
        'destination3',
        'person_visited3',
        'time_of_arrival3',
        'time_of_daparture3',
        'destination4',
        'person_visited4',
        'time_of_arrival4',
        'time_of_daparture4',
        'destination5',
        'person_visited5',
        'time_of_arrival5',
        'time_of_daparture5'
    ];

    public static function byObp($id){

    	return self::where('obp_id',$id)->first();
    }

    public static function byallObp($id){

        return self::where('obp_id',$id)->get();
    }
}
