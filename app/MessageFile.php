<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageFile extends Model
{
    protected $table = 'message_files';

    protected $fillable = [
    	'user_id', 'to_user_id', 'filename'
    ];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
