<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderFacility extends Model
{
    protected $table = 'job_order_facilities';

    protected $fillable = [
    	'facility'
    ];

    public static function getFacilities()
    {
    	return self::all();
    }

    public static function getIdAndName()
    {
    	return self::orderBy('facility','ASC')->pluck('facility','facility');
    }
}
