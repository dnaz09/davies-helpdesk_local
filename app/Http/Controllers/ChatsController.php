<?php
namespace App\Http\Controllers;

use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Events\UnseenMsgShow;
use App\Events\FileSent;
use Illuminate\Support\Facades\Input;
use DB;
use App\MessageFile;

class ChatsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages(Request $request)
    {
        $other_user = $request->to_id;
        // return Message::where('user_id',\Auth::user()->id)->where('to_user_id', $other_user)
        //     ->orWhere('user_id', $other_user)->orWhere('to_user_id', \Auth::user())
        //     ->with('user')->get();

        // $messages = Message::where('user_id',\Auth::user()->id)->where('to_user_id', $other_user)
        //         ->orWhere('user_id', $other_user)->orWhere('to_user_id', \Auth::user())
        //         ->with('user')->get();

        $messages = Message::where(function ($query) use ($other_user) {
            $query->where('user_id', '=' ,\Auth::user()->id)
                ->where('to_user_id', '=' ,$other_user);
        })->orWhere(function ($query) use ($other_user) {
            $query->where('user_id', '=' ,$other_user)
                ->where('to_user_id', '=' ,\Auth::user()->id);
        })->with('user')->get();

        $to_user = User::where('id', $other_user)->first();

        return ['messages'=>$messages, 'to_user'=>$to_user];
    }

    public function seenClickMessages(Request $request)
    {
        $to_id = $request->to_id;
        $from_id = $request->my_id;
        $messages = Message::where('user_id', $to_id)
            ->where('to_user_id', $from_id)
            ->where('is_seen', 0)
            ->get();
        foreach($messages as $message)
        {
            $message->is_seen = 1;
            $message->save();
        }

    return ['status'=>'success'];
    }

    public function seenMessages(Request $request)
    {
        $user_id = $request->to_id;
        $to_user_id = Auth::user()->id;

        $messages = Message::where('user_id', $user_id)->where('to_user_id', $to_user_id)->get();
        foreach ($messages as $message) {
        	$message->is_seen = 1;
        	$message->update();
        }

        return ['status'=>'success'];
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    
    public function sendMessage(Request $request)
    {
        $to_id = $request->to_id[0];
        $user = Auth::user();
        
        if($to_id != ''){
            $message = $user->messages()->create([
                'message' => $request->input('message'),
                'to_user_id' => $to_id,
            ]);
        }else{
            $message = $user->messages()->create([
                'message' => $request->input('message'),
                'to_user_id' => $request->to_id
            ]);
        }
        broadcast(new MessageSent($user, $message))->toOthers();
        return ['status' => 'Message Sent!'];
    }

    public function getOnlineUsers(){
        $id = Auth::user()->id;
        $users = User::byOnline($id);
        // $users = User::byMessage($id);

        foreach ($users as $user) {
            $user->active = true;
            $messages = Message::where('to_user_id', $id)
            ->where('is_seen', 0)
            ->pluck('user_id');
        }

        $unseencount = Message::where('to_user_id', $id)->where('is_seen', 0)->count();

        if(!empty($messages)){
            return ['users'=>$users, 'messages'=>$messages, 'unseencount'=>$unseencount];
        }else{
            return ['users'=>$users];
        }
    }

    public  function getMySession()
    {
        return Auth::user();
    }

    public function searchuser(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('first_name', 'LIKE', '%'.Input::get('search').'%')->orWhere('last_name', 'LIKE', '%'.Input::get('search').'%')->where('id', '!=', $id)->get();
        return $user;
    }

    public function uploadFile(Request $request)
    {
        if($request->hasFile('file')){
            $file = Input::file('file');
            $destinationPath = public_path().'/uploads/singlechats/';
            $filename = $file->getClientOriginalName();
            Input::file('file')->move($destinationPath, $filename);

            $file = new MessageFile();
            $file->to_user_id = $request->to_id;
            $file->filename = $filename;
            $file->user_id = $request->user;
            $file->save();

            $user = User::findOrFail($request->to_id);
            $user_from = User::findOrFail($request->user);

            broadcast(new FileSent($user,$user_from))->toOthers();
        }
        return ['to_id'=>$request->to_id];
    }

    public function fetchFiles(Request $request)
    {
        $other_user = $request->to_id;

        $files = MessageFile::where(function ($query) use ($other_user) {
            $query->where('user_id', '=' ,\Auth::user()->id)
                ->where('to_user_id', '=' ,$other_user);
        })->orWhere(function ($query) use ($other_user) {
            $query->where('user_id', '=' ,$other_user)
                ->where('to_user_id', '=' ,\Auth::user()->id);
        })->get();

        $files_count = MessageFile::where(function ($query) use ($other_user) {
            $query->where('user_id', '=' ,\Auth::user()->id)
                ->where('to_user_id', '=' ,$other_user);
        })->orWhere(function ($query) use ($other_user) {
            $query->where('user_id', '=' ,$other_user)
                ->where('to_user_id', '=' ,\Auth::user()->id);
        })->count();

        // $files = MessageFile::where('to_user_id', $request->to_id)->where('user_id', $user)
        //     ->orWhere('to_user_id', $user)->orWhere('user_id', $request->to_id)->get();

        // $files_count = MessageFile::where('to_user_id', $request->to_id)->where('user_id', $user)
        //     ->orWhere('to_user_id', $user)->orWhere('user_id', $request->to_id)->count();

        return ['files'=>$files, 'files_count'=>$files_count];
    }

    public function downloadFile($id)
    {
        $id = $id;

        $sfile = MessageFile::findOrFail($id);

        $filename = $sfile->filename;
        $file_download = public_path()."/uploads/singlechats/$filename";

        return response()->download($file_download, $filename);
    }

    public function fileSearch(Request $request)
    {
        $to_user = $request->to_user[0];
        $user = Auth::user()->id;
        $files = MessageFile::where('filename', 'LIKE', '%'.Input::get('search').'%')
            ->where('to_user_id', $to_user)->where('user_id', $user)
            ->orWhere('to_user_id', $user)->orWhere('user_id', $to_user)->get();
        return ['files'=>$files];
    }
}
