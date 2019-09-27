<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessageMessage extends Model
{
    protected $table = 'group_message_messages';
    protected $fillable = ['group_message_id', 'user_id', 'gmessage'];

    public function groupmessage()
    {
    	return $this->belongsTo(GroupMessage::class);
    }
    public function groupmessagemember()
    {
    	return $this->belongsTo(GroupMessageMember::class);
    }
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
