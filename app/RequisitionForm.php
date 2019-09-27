<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitionForm extends Model
{
    protected $table = 'requisition_forms';
    protected $fillable = [
    	'form'
    ];
}
