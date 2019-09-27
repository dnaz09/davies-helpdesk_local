<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessageFile extends Model
{
    protected $table = 'group_message_files';

    protected $fillable = [
    	'group_message_id', 'filename', 'user_id'
    ];
    public function groupmessage()
    {
    	return $this->belongsTo(GroupMessage::class);
    }
}
