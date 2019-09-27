<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderInhouse extends Model
{
    protected $table = 'job_order_inhouses';

    protected $fillable = [
    	'inhouse'
    ];
}
