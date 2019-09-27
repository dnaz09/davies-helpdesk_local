<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionDescription extends Model
{
    protected $table = 'requisition_descriptions';
    protected $fillable = [
    	'description'
    ];
}
