<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplyMaintenance extends Model
{
    protected $table = 'supply_maintenances';

    protected $fillable = [
        'material_code', 'description', 'category'
    ];

    public static function getAll()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);

        return self::orderBy('created_at', 'DESC')->get();;
    }

    public static function getCategories()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);

        return self::groupBy('category')->pluck('category', 'category');
    }

    public static function getByCategory($category)
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);

        return self::where('category', $category)->pluck('material_code', 'description');
    }
}
