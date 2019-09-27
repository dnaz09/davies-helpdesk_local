<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class GroupMessage extends Model
{
	protected $table = 'group_messages';
    protected $fillable = ['group_name'];

    public static function ByAuthUser($id)
    {
    	return self::select('group_messages.*')
    	->leftJoin('group_message_members', 'group_message_members.group_message_id', '=', 'group_messages.id')
    	->where('group_message_members.user_id', '=', $id)
        ->orderBy('created_at', 'DESC')
    	->get();
    }
    public static function searchGroup($user, $search)
    {
        return self::select('group_messages.*')
        ->leftJoin('group_message_members', 'group_message_members.group_message_id', '=', 'group_messages.id')
        ->where('group_message_members.user_id', '=', $user)
        ->where('group_name', 'LIKE', '%'.$search.'%')
        ->get();
    }

    public static function getGroupById($id)
    {
        return self::select('group_messages.*','group_message_messages.*', 'group_message_members.*', 'group_message_unseens.*')
            ->leftJoin('group_message_messages', 'group_message_messages.group_message_id', '=', 'group_messages.id')
            ->leftJoin('group_message_members', 'group_message_members.group_message_id', '=', 'group_messages.id')
            ->leftJoin('group_message_unseens', 'group_message_unseens.group_message_id', '=', 'group_messages.id')
            ->where('group_message_members.user_id', '=', $id)
            ->orderBy('group_message_unseens.created_at', 'DESC')
            ->get();
    }

    public function member()
    {
    	return $this->hasOne('App\GroupMessageMember', 'id', 'group_message_id');
    }

    public static function getAll()
    { 
        
        $member = GroupMessageMember::byGroupMessageId();

        $groupid = [];

        foreach($member as $mem){

            $groupid[] = $mem->group_message_id;
        }

        $groups = self::whereIn('id',$groupid)->get();

        return $groups;
    }

}

// public static function getAll(){        
        
//         $groups = self::all();
                
//         foreach ($groups as $key => $value) {
//             $value->active = true;
//             $users = [];
//             $member = GroupMessageMember::byGroupMessageId($value->id);
        
//             // $users[] = $member->toArray();
//             // $groups[$key]->uid = $users;
//         }        
//         return $groups;
//     }