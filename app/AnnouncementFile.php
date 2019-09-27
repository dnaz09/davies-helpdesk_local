<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementFile extends Model
{
    protected $table = 'announcement_files';

    protected $fillable = [

    	'ann_id',
    	'filename',
    	'encryptname',
    	'uploaded_by'    	 
    ];
}
