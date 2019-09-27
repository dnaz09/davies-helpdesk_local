<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\AnnouncementFile;
use App\AnnouncementMember;
use App\Department;
use App\Events\AnnouncementPosted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;


class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depts = Department::all();
        return view('announcement.index',compact('depts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function depts($id)
    {
        $memo = Announcement::findOrFail($id);
        if(!empty($memo)){
            // $depts = AnnouncementMember::findAllByAnnouncementId($id);
            $depts = Department::all();
            $members = AnnouncementMember::findAllByAnnouncementIdmembers($id);
            $string = str_replace('<br />', '&#13;&#10;', $memo->message);
            
            return view('announcement.deptsview',compact('memo','depts','members','string'));
        }else{
            return redirect()->back()->with('is_error','Error');
        }
    }

    public function deptsave(Request $request)
    {
        $memo = Announcement::findOrFail($request->id);
        if(!empty($memo)){
            $depts = AnnouncementMember::where('ann_id',$memo->id)->get();
            if(!empty($depts)){
                foreach ($depts as $dept) {
                    $dept->delete();
                }
            }
            if(!empty($request->dept_id)){
                foreach ($request->dept_id as $dep) {
                    $new_dept = new AnnouncementMember();
                    $new_dept->ann_id = $memo->id;
                    $new_dept->dept_id = $dep;
                    $new_dept->save();
                }
            }
            return redirect('announcements/list')->with('is_success','Success');
        }else{
            return redirect()->back()->with('is_error','Error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        set_time_limit(0);  
        ini_set('memory_limit',-1); 
        if(!empty($request->dept_id)){
            $ann = new Announcement();
            $ann->subject = $request->get('subject');
            $ann->message = nl2br($request->get('message'));
            $ann->dept_id = 1;
            $ann->uploaded_by = Auth::id();
            $ann->save();

            if($request->hasFile('attached')){
                $files = Input::file('attached');

                $dPath = public_path().'/uploads/Announcement/'.$ann->id.'/';

                if (!\File::exists($dPath))
                {
                    mkdir($dPath, 0755, true); 
                }
                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();

                    $nameOfFile = $filename;

                    $hashname = \Hash::make($nameOfFile);

                    $enc = str_replace("/","", $hashname);

                    // move_uploaded_file($dPath, $nameOfFile);
                    $file->move($dPath,$nameOfFile);

                    $message_file = new AnnouncementFile();
                    $message_file->ann_id = $ann->id;
                    $message_file->filename = $nameOfFile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            $ids = $request->dept_id;
            foreach ($ids as $dept) {
                $depts = new AnnouncementMember();
                $depts->ann_id = $ann->id;
                $depts->dept_id = $dept;
                $depts->save();

                try{
                    broadcast(new AnnouncementPosted($ann, $dept))->toOthers(); 
                }catch(\Exception $e){
                    // 
                }
            }
            return back()->with('is_success','Saved!');
        }else{
            return back()->with('empty_id', 'Error');
        }
    }

    public function getDetails(Request $request){

        $memo = Announcement::getlatest($request->memoid);

        return Response::json($memo);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        //
    }

    public function memo_details($id){

     $memo = Announcement::getlatest($id);


     return view('announcement.details',compact('memo'));
    }

    public function download_file(Request $request){

        $encryptname = $request->get('encname');
        $file = AnnouncementFile::where('encryptname',$encryptname)->first();
        
        

        $file_down= public_path().'/uploads/Announcement/'.$file->ann_id.'/'.$file->filename;               
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if(finfo_file($finfo, $file_down) === 'application/pdf') {
            return response()->file($file_down);
        }
        else{
            return Response::download($file_down);
        }
        finfo_close($finfo);
    }

    public function hrlist()
    {
        $anncs = Announcement::getAll();

        return view('announcement.show',compact('anncs'));
    }

    public function deleted(Request $request)
    {
        $anc = Announcement::findOrFail($request->id);

        if(!empty($anc)){
            $depts = AnnouncementMember::where('ann_id',$anc->id)->get();
            if(!empty($depts)){
                foreach ($depts as $dept) {
                    $dept->delete();
                }
            }
            $anc->delete();
        }

        return redirect()->back()->with('is_success','Success');
    }

    public function editsave(Request $request)
    {
        $ann = Announcement::findOrFail($request->ann_id);
        if(!empty($ann)){
            $ann->message = nl2br($request->message);
            $ann->subject = $request->subj;
            $ann->update();

            return redirect('announcements/list')->with('is_edit_success','Success');
        }
        return redirect()->back()->with('is_error','Error');
    }
}
