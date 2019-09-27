<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessageUnseen extends Model
{
    protected $table = 'group_message_unseens';
    protected $fillable = [
    	'group_message_id', 'user_id'
    ];
}
