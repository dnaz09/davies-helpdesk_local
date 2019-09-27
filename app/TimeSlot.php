<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'timeslots';
    protected $fillable = [
    	'time'
    ];
}
