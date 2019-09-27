<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndertimeRemarkFile extends Model
{
    protected $table = 'undertime_remarks';

    protected $fillable = [

    	'undertime_id',
    	'filename',
    	'encryptname',
    	'uploaded_by'
    ];
}
