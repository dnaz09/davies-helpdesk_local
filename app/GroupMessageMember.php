<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class GroupMessageMember extends Model
{
    protected $table = 'group_message_members';
    protected $fillable = ['group_message_id', 'user_id'];

    public function groupmessage()
    {
    	return $this->belongsTo(GroupMessage::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public static function byGroupMessageId()
    {
        return self::where('user_id',Auth::id())->get();
    }

}
