<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadableFile extends Model
{
    protected $table = 'downloadable_files';
    protected $fillable = [
    	'filename'
    ];

    public static function byName($name)
    {
    	return self::where('filename',$name)->first();
    }
}
