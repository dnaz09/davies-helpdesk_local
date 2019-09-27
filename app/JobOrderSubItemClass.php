<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderSubItemClass extends Model
{
    protected $table = 'job_order_sub_item_classes';

    protected $fillable = [
    	'equipment_type','description'
    ];

    public static function getByEquipment($type)
    {
    	return self::where('equipment_type',$type)->orderBy('description','ASC')->pluck('description','description');
    }
}
