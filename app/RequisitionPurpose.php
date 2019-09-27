<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionPurpose extends Model
{
    protected $table = 'requisition_purposes';
    protected $fillable = [
    	'purpose'
    ];
}
