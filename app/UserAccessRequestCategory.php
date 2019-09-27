<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccessRequestCategory extends Model
{
    protected $table = 'user_access_request_categories';

    protected $fillable = [

    	'category'
    ];
}
