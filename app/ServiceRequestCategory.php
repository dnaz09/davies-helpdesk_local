<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestCategory extends Model
{
    protected $table = 'service_request_categories';

    protected $fillable = [

    	'category'
    ];
}
