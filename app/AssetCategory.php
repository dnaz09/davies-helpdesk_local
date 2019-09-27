<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $table = 'asset_categories';
    protected $fillable = ['category_name'];

    public static function getName()
    {
    	return self::pluck('category_name');
    }
    public static function getCategs($name)
    {
    	return self::where('category_name', '!=', $name)->get();
    }
}
