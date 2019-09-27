<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderLocation extends Model
{
    protected $table = 'job_order_locations';

    protected $fillable = [
    	'location'
    ];

    public static function getLocations()
    {
    	return self::all();
    }
}
