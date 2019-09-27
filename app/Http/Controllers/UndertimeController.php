<?php

namespace App\Http\Controllers;

use App\Undertime;
use App\UndertimeRemark;
use App\UndertimeRemarkFile;
use App\TimeSlot;
use Auth;
use App\EmployeeExitPass;
use App\User;
use App\AccessControl;
use Illuminate\Http\Request;
use App;
use PDF;
use App\Events\ManagerUndertimeSent;
use App\Events\UndertimeSent;
use App\Events\HrDashboardLoader;
use App\Events\UndertimeApproved;
use App\Events\ExitPassSent;
use App\Events\UndertimeRequested;

class UndertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $undertimes = Undertime::byCreated(Auth::id());
        $uid = Auth::id();
        return view('undertime.index',compact('undertimes','uid'));
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(date('H:i') > date('H:i',strtotime('15:00'))){
            return redirect()->back()->with('is_past','Sorry');
        }
        $user = Auth::user();

        $timeslots = TimeSlot::orderBy('time')->get();
        $date_now = date('Y-m-d');
        return view('undertime.create',compact('user','timeslots','date_now'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if($request->type == 1){
            $time = '-';
        }elseif($request->type == 2){
            $time = $request->sched;
        }
        $curr_user = Auth::user();
        $postdata = $request->all();
        $postdata['user_id'] = Auth::id();
        $postdata['date'] = date('Y-m-d',strtotime($request->date));
        $postdata['sched'] = $time;
        $postdata['manager'] = Auth::user()->superior;
        $postdata['manager_action'] = 0;        
        $postdata['approve_by'] = 0;
        $postdata['status'] = 0;
        $postdata['level'] = 1;
        $postdata['generated'] = 0;
        $postdata['type'] = $request->type;
        
        $undertime = new Undertime($postdata);
        $undertime->save();

        $strlength = 6;
        $str = substr(str_repeat(0, $strlength).$undertime->id,-$strlength);
        $undertime->und_no = 'HRD-UT-'.$str;
        $undertime->update();

        try{
            broadcast(new ManagerUndertimeSent($undertime, $curr_user))->toOthers();
            // broadcast(new UndertimeSent($undertime, $curr_user))->toOthers();
            // broadcast(new HrDashboardLoader($undertime))->toOthers();
            $module_id = 52;
            $acss = AccessControl::findByModule($module_id);
            foreach ($acss as $acs) {
                $user = User::findUserByidandDeptid($acs->user_id, $curr_user->dept_id);
                try{
                    broadcast(new UndertimeRequested($undertime, $user))->toOthers();
                }catch(Exception $e){

                }
            }
        }catch(\Exception $e){

        }
        return redirect('undertime')->with('is_success','Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Undertime  $undertime
     * @return \Illuminate\Http\Response
     */
    public function show(Undertime $undertime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Undertime  $undertime
     * @return \Illuminate\Http\Response
     */
    public function edit(Undertime $undertime)
    {   
        $user = Auth::user();
        return view('undertime.edit',compact('undertime','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Undertime  $undertime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Undertime $undertime)
    {
        $undertime->reason = $request->reason;
        $undertime->sched = $request->sched;
        $undertime->update();

        return redirect('undertime')->with('is_updated','Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Undertime  $undertime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Undertime $undertime)
    {
        //
    }

    public function details($id){

        $undertime = Undertime::findOrFail($id);
        if(empty($undertime)){

            return view('errors.909',compact('id'));
        }
        $remarks = UndertimeRemark::byUndertime($id);

        return view('undertime.emp_details',compact('undertime','remarks'));
    }

    public function cancel(Request $request)
    {
        $und = Undertime::findOrFail($request->id);
        if(empty($und)){
            return \Response::json(['type'=>'3']);
        }else{
            if($und->manager_action < 2){
                $und->status = 5;
                $und->manager_action = 5;
                $und->level = 5;
                $und->save();

                try{
                    broadcast(new HrDashboardLoader($und))->toOthers();
                }catch(\Exception $e){
                    
                }
                return \Response::json(['type'=>'1']);
            }
             return \Response::json(['type'=>'2']);
        }
    }
    
    public function editDate(Request $request){
        $result = "E";

        $und = Undertime::findOrFail($request->id);
        if (!empty($und)) {
            $und->date = date('Y/m/d',strtotime($request->newDate));
            $und->save();
            $result = "S";
        }
        return response()->json($result);
    }

    public function remarks(Request $request){

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            if(!empty($request->details)){
                $remark = new UndertimeRemark();
                $remark->remarks_by = Auth::id();
                $remark->undertime_id = $request->undertime_id;
                $remark->details = $request->details;
                $remark->save();

                return redirect()->back()->with('is_success','Success');
            }
            return redirect()->back()->with('no_remarks','Error');
        }

        if($sub == 2){            

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $curr_user = User::findOrFail($undertime->user_id);
            $undertime->status = 2;            
            $undertime->approve_by = Auth::id();                
            $undertime->update();

            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $request->details;
            $remark->save();

            try{
                broadcast(new UndertimeApproved($undertime, Auth::user()))->toOthers();
                broadcast(new HrDashboardLoader($undertime))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_success', 'Success');
            }

        }
        if($sub == 4){          

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->status = 2;
            $undertime->approver_action = 1;            
            $undertime->approve_by = Auth::id(); 
            $undertime->generated = 1;               
            $undertime->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $details;
            $remark->save();

            if($undertime->type == 1){
                $type = 'HALF-DAY';
            }else{
                $type = 'UNDERTIME';
            }
            
            $ext = new EmployeeExitPass();
            $ext->user_id = $undertime->user_id;
            $ext->date = date('Y-m-d',strtotime($undertime->date));
            $ext->purpose = nl2br($undertime->reason);
            $ext->time_in = "";
            $ext->time_out = "";
            $ext->hrd_action = 2;
            $ext->hrd_approver = Auth::id();
            $ext->others = 1;
            $ext->others_details = 'LEAVE '.$type;
            $ext->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength).$ext->id,-$strlength);
            $ext->exit_no = "HRD-EP-".$str;
            $ext->undertime_id = $undertime->id;
            $ext->update();

            try{
                broadcast(new HrDashboardLoader($undertime))->toOthers();
                broadcast(new UndertimeApproved($undertime, Auth::user()))->toOthers();
                broadcast(new ExitPassSent($ext, Auth::user()))->toOthers();
                return redirect()->back()->with('is_exitpass','Saved!');    
            }catch (\Exception $e){
                return redirect()->back()->with('is_exitpass','Saved!');    
            }
            

        }elseif ($sub == 3) {            

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->status = 3;
            $undertime->level = 3;
            $undertime->approver_action = 2;          
            $undertime->approve_by = Auth::id();                
            $undertime->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Denied!';
            }
            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $details;
            $remark->save();

            try{
                broadcast(new HrDashboardLoader($undertime))->toOthers();
                return redirect()->back()->with('is_deny', 'Denied');
            }catch (\Exception $e){
                return redirect()->back()->with('is_deny', 'Denied');
            }
        }
        if($sub == 6){
            $undertime = Undertime::where('id',$request->undertime_id)->first();

            $curr_user = User::findOrFail($undertime->user_id);
            $undertime->manager_action = 1;
            $undertime->level = 2;
            $undertime->remark = $request->remarks;         
            $undertime->update();

            try{
                broadcast(new UndertimeSent($undertime, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($undertime))->toOthers();
                broadcast(new UndertimeApproved($undertime, Auth::user()))->toOthers();
                return redirect()->back()->with('is_success','Saved!');    
            }catch (\Exception $e){
                return redirect()->back()->with('is_success','Saved!');    
            }

        }    
        return back()->with('is_success','Saved!');
    }

    public function mngr_undertime_list(){

        $id = Auth::user()->dept_id;

        // $undertimes = Undertime::byDeptId($id);

        $undertimes = Undertime::byUnder(Auth::id());

        return view('manager.mng_undertime_list',['undertimes'=>$undertimes]);
    }
    
    public function mngr_details($id){

        $undertime = Undertime::findOrFail($id);
        $remarks = UndertimeRemark::byUndertime($id);

        return view('manager.mng_undertime_details',['undertime'=>$undertime,'remarks'=>$remarks]);
    }

    public function dept_mngr_list(){
        $id = Auth::user()->dept_id;

        $undertimes = Undertime::byDeptId($id);

        return view('dept_manager.undertime_list',['undertimes'=>$undertimes]);
    }
    public function dept_mngr_details($id){
        $undertime = Undertime::findOrFail($id);
        $remarks = UndertimeRemark::byUndertime($id);

        return view('dept_manager.undertime_details',['undertime'=>$undertime,'remarks'=>$remarks]);
    }

    public function mngr_remarks(Request $request){

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            if(!empty($request->details)){
                $remark = new UndertimeRemark();
                $remark->remarks_by = Auth::id();
                $remark->undertime_id = $request->undertime_id;
                $remark->details = $request->details;
                $remark->save();

                return redirect()->back()->with('is_success','Success');
            }
            return redirect()->back()->with('no_remarks','Error');
        }

        if($sub == 2){

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $curr_user = User::findOrFail($undertime->user_id);
            $undertime->manager_action = 1;
            $undertime->level = 2;            
            $undertime->update();

            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $details;
            $remark->save();

            try{
                broadcast(new UndertimeSent($undertime, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($undertime))->toOthers();
                broadcast(new UndertimeApproved($undertime, Auth::user()))->toOthers();
                
                // if($undertime->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_success','Saved!');
                // }else{
                    return redirect()->back()->with('is_success','Saved!');
                // }  
            }catch (\Exception $e){
                // if($undertime->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_success','Saved!');
                // }else{
                    return redirect()->back()->with('is_success','Saved!');
                // }    
            }

        }elseif ($sub == 3) {            

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->manager_action = 2;
            $undertime->level = 3;
            $undertime->status = 3;
            $undertime->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Denied!';
            }
            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $details;
            $remark->save();

            try{
                broadcast(new HrDashboardLoader($undertime))->toOthers();
                return back()->with('is_deny','Denied');
            }catch (\Exception $e){
                return back()->with('is_deny','Denied');
            }

        }
        if($sub == 4){          

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->status = 2;            
            $undertime->approve_by = Auth::id(); 
            $undertime->generated = 1;               
            $undertime->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $details;
            $remark->save();

            $ext = new EmployeeExitPass();
            $ext->user_id = $undertime->user_id;
            $ext->date = date('Y-m-d',strtotime($undertime->date));
            $ext->purpose = nl2br($undertime->reason);
            $ext->time_in = "";
            $ext->time_out = "";
            $ext->hrd_action = 2;
            $ext->hrd_approver = Auth::id();
            $ext->others = 1;
            $ext->others_details = "UNDERTIME";
            $ext->save();
            $ext->exit_no = "EXT".$ext->id;
            $ext->undertime_id = $undertime->id;
            $ext->update();

            try{
                broadcast(new HrDashboardLoader($undertime))->toOthers();
                broadcast(new UndertimeApproved($undertime, Auth::user()))->toOthers();
                broadcast(new ExitPassSent($ext, Auth::user()))->toOthers();

                // if($undertime->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_success','Saved!');
                // }else{
                    return redirect()->back()->with('is_success','Saved!');
                // } 
            }catch (\Exception $e){
                // if($undertime->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_success','Saved!');
                // }else{
                    return redirect()->back()->with('is_success','Saved!');
                // }     
            }
        }      

        return redirect()->back()->with('is_success','Saved!');
    }

    public function hr_undertime_list(){

        $undertimes = Undertime::byHrd();
        // $undertimes = Undertime::all();

        return view('undertime.hrd_lists',compact('undertimes'));
    }

    public function hrd_details($id){

        $undertime = Undertime::findOrFail($id);
        $remarks = UndertimeRemark::byUndertime($id);

        return view('undertime.hrd_details',compact('undertime','remarks'));
    }

    public function download(Request $request){

        $undertime = Undertime::findOrFail($request->undertime_id);
        $user = User::findOrFail($undertime->user_id);        

        if(!empty($undertime)){
            
            
                                    
            $employee_name = strtoupper($user->first_name.' '.$user->last_name);
            $position = strtoupper($user->position);
            $department =strtoupper($user->department->department);            
        

            $pdf = App::make('dompdf.wrapper');        

            $view = \View::make('pdf.undertime',compact('undertime','employee_name','position','department'))->render();        
            $pdf->loadHTML($view);
            $customPaper = array(0,0,700,1000);
            $pdf->setPaper($customPaper);
            return $pdf->stream();

        }
        else{
            return view('errors.503');
        }
    }

    public function downloadPDF($underID, $uid){

        $undertime = Undertime::findOrFail($underID);
        $user = User::findOrFail($uid);        

        if(!empty($undertime)){
            if($undertime->approver_action == 1){
                $employee_name = strtoupper($user->first_name.' '.$user->last_name);
                $position = strtoupper($user->position);
                $department =strtoupper($user->department->department);            
                $company = strtoupper($user->company);

                $pdf = App::make('dompdf.wrapper');        

                $view = \View::make('pdf.undertime',compact('undertime','employee_name','position','department','company'))->render();        
                $pdf->loadHTML($view);
                $customPaper = array(0,0,700,1000);
                $pdf->setPaper($customPaper);
                return $pdf->stream();
            }else{
                return view('errors.503');
            }
        }
        else{
            return view('errors.503');
        }
    }
}
