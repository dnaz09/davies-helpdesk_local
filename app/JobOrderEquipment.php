<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderEquipment extends Model
{
    protected $table = 'job_order_equipments';

    protected $fillable = [
    	'equipment'
    ];

    public static function getEquipments()
    {
        return self::all();
    }

    public static function getAllEquipments()
    {
    	return self::pluck('equipment','equipment');
    }

    public static function getIdAndName()
    {
    	return self::orderBy('equipment','ASC')->pluck('equipment','equipment');
    }
}
