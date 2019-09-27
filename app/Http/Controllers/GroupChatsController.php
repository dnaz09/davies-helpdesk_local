<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\GroupCreated;
use Response;
use App\Events\GroupMessageSent;
use App\Events\UsersRemoved;
use App\Events\UserAdded;
use App\Events\GroupFileSent;
use App\GroupMessage;
use App\GroupMessageMember;
use App\GroupMessageMessage;
use App\GroupMessageFile;
use App\GroupMessageUnseen;
use Auth;
use App\User;
use Illuminate\Support\Facades\Input;
use DB;

class GroupChatsController extends Controller
{
	public function index()
	{
		return view('groupchats');
	}
	public function groupadd(Request $request)
	{
		// save  group 
		$group = GroupMessage::create([
			'group_name' => $request->input('group_name')
		]);
		// save current user to group members
		$user = Auth::user();
		$auth = GroupMessageMember::create([
			'group_message_id' => $group->id,
			'user_id' => $user->id
		]);
		// save members to group members
		$group_members = $request->input('user_id');
		foreach ($group_members as $group_member) {
			$members = GroupMessageMember::create([
				'group_message_id' => $group->id,
				'user_id' => $group_member
			]);
		}
		$all = [];
		$mems = GroupMessageMember::where('group_message_id', '=', $group->id)->get();
		foreach ($mems as $mem) {
			$all[] = $mem->user_id;
		}
		broadcast(new GroupCreated($user, $group, $all))->toOthers();
		return ['group_id' => $group->id, 'group_name' => $group->group_name];
	}
	public function showgroups()
	{
		$id = Auth::id();
		$groups = GroupMessage::ByAuthUser($id);
		// $groups = GroupMessage::getGroupById($id);

		$unseen = GroupMessageUnseen::where('user_id', $id)->pluck('group_message_id');

		$gunseencount = GroupMessageUnseen::where('user_id', $id)->count();
		
		return ['groups' => $groups, 'unseen' => $unseen, 'gunseencount' => $gunseencount];
	}
	public function seengroupmessage(Request $request)
	{
		$id = Auth::id();
		$group_id = $request->group_id;

		$toseen = GroupMessageUnseen::where('user_id', $id)->where('group_message_id', $group_id)->get();

		foreach ($toseen as $tosee) {
			$tosee->delete();
		}
		return ['status'=>'success'];
	}
	public function getgroupmessage(Request $request)
	{
		$group_id = $request->group_id;
		// return GroupMessageMessage::where('group_message_id', '=', $group_id)
		// 	->with('user')
		// 	->get();

		$gmessages = GroupMessageMessage::where('group_message_id', '=', $group_id)
			->with('user')
			->get();
		$group_name = GroupMessage::where('id', $group_id)->first();

		return ['gmessages'=>$gmessages, 'group_name'=>$group_name];
	}
	public function sendgroupmessage(Request $request)
	{
		$user = Auth::user();
		$group_ids = $request->input('group_id');
		foreach($group_ids as $group_id){
			$groupId = $group_id;
		}
		$gmessage = GroupMessageMessage::create([
			'group_message_id' => $groupId,
			'gmessage' => $request->input('gmessage'),
			'user_id' => $user->id,
		]);

		$groupnow = GroupMessageMember::where('group_message_id', $groupId)->get();
		foreach ($groupnow as $groupno) {
			if($groupno->user_id != $user->id)
			$gmessageunseen = GroupMessageUnseen::create([
				'group_message_id' => $groupId,
				'user_id' => $groupno->user_id
			]);
		}
		$group = GroupMessage::where('id', '=', $groupId)->first();
		$all = [];
		$mems = GroupMessageMember::where('group_message_id', '=', $group->id)->get();
		foreach ($mems as $mem) {
			$all[] = $mem->user_id;
		}

		broadcast(new GroupMessageSent($user, $gmessage, $group, $all))->toOthers();
		return ['status' => 'Chat Sent'];
	}
	public function sendFile(Request $request)
	{
		if($request->hasFile('file')){
            $file = Input::file('file');
            $destinationPath = public_path().'/uploads/groupchats/'.$request->group_id.'/';
            $filename = $file->getClientOriginalName();
            Input::file('file')->move($destinationPath, $filename);

            $group_file = new GroupMessageFile();
            $group_file->group_message_id = $request->group_id;
            $group_file->filename = $filename;
            $group_file->user_id = $request->user;
            $group_file->save();

            $user = User::findOrFail($request->user);
            $group = GroupMessage::findOrFail($request->group_id);
            $mems = GroupMessageMember::where('group_message_id','=',$group->id)->get();
            foreach ($mems as $mem) {
            	$all[] = $mem->user_id;
            }
            broadcast(new GroupFileSent($user, $group, $all))->toOthers();
        }
        return ['group_id'=>$request->group_id];
	}
	public function fetchFiles(Request $request)
	{
		$files = GroupMessageFile::where('group_message_id', $request->group_id)->get();
		$files_count = GroupMessageFile::where('group_message_id', $request->group_id)->count();

		return ['files'=>$files, 'files_count'=>$files_count];
	}
	public function downloadFile($id)
	{
        $id = $id;

        $group_file = GroupMessageFile::findOrFail($id);

        $filename = $group_file->filename;
        $file_download = public_path()."/uploads/groupchats/".$group_file->group_message_id."/$filename";

        return response()->download($file_download, $filename);
	}
	public function fileSearch(Request $request)
	{
		$group_id = $request->group_id[0];
        $files = GroupMessageFile::where('filename', 'LIKE', '%'.Input::get('search').'%')->where('group_message_id', $group_id)->get();
        return ['files'=>$files];
	}
	public function getgroupmembers(Request $request)
	{
		$group_id = $request->group_id;

		$group = GroupMessage::findOrFail($group_id);

		$users = [];
		$members = GroupMessageMember::where('group_message_id', $group_id)->get();
		foreach ($members as $member) {
			$users[] = User::findOrFail($member->user_id);
		}
		return ['group' => $group, 'users' => $users];
	}
	public function getnonmembers(Request $request)
	{
		$group_id = $request->group_id;
		
		$members = GroupMessageMember::where('group_message_id', $group_id)->pluck('user_id');
		$members->all();
		
		$users = User::whereNotIn('id', $members)->get();
		
		return ['users'=>$users];
	}
	public function searchnonmember(Request $request)
	{
		$group_id = $request->group_id;

		$members = GroupMessageMember::where('group_message_id', $group_id)->pluck('user_id');
		$members->all();

		$users = User::whereIn('id', $members)->where('first_name', 'LIKE', '%'.Input::get('search').'%')->orWhere('last_name', 'LIKE', '%'.Input::get('search').'%')->get();

		return ['users'=>$users];
	}
	public function searchmember(Request $request)
	{
		$group_id = $request->group_id;

		$members = GroupMessageMember::where('group_message_id', $group_id)->pluck('user_id');
		$members->all();

		$users = User::whereIn('id', $members)->where('first_name', 'LIKE', '%'.Input::get('search').'%')->orWhere('last_name', 'LIKE', '%'.Input::get('search').'%')->get();

		return ['users'=>$users];
	}
	public function removegroupmember(Request $request)
	{
		$members = $request->members;
		$group_id = $request->group_id;

		foreach($members as $member){
			$fetch_members = GroupMessageMember::where('group_message_id', $group_id)
				->where('user_id', $member)
				->first();
			$fetch_members->delete();
		}
		broadcast(new UsersRemoved($members))->toOthers();
		return ['success'=>'removed user!'];
	}
	public function addgroupmembers(Request $request)
	{
		$members = $request->input('user_id');
		$group_id = $request->input('group_id');
		$group = GroupMessage::findOrFail($group_id);
		if(is_array($members)){
			foreach ($members as $member) {
				$new_mem = new GroupMessageMember();
				$new_mem->group_message_id = $group_id;
				$new_mem->user_id = $member;
				$new_mem->save();
			}
		}else{
			$new_mem = new GroupMessageMember();
			$new_mem->group_message_id = $group_id;
			$new_mem->user_id = $members;
			$new_mem->save();
		}
		broadcast(new UserAdded($members, $group))->toOthers();
		return ['success'=>'user added!'];

	}
	public function groupsearch(Request $request)
	{
		$user = Auth::user()->id;
		$search = Input::get('search');
		$group = GroupMessage::searchGroup($user,$search);
        return $group;
	}
	public function test(Request $request)
	{
		\Log::info('asdasdasd');
	}
}
