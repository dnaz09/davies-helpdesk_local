<?php

namespace App\Http\Controllers;

use App\OBP;
use App\OBPDetail;
use App\OBPRemark;
use App\User;
use App\Department;
use App\EmployeeExitPass;
use App\AccessControl;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;
use PDF;
use App;
use App\Events\ManagerOBPSent;
use Illuminate\Http\Request;
use App\Events\OBPSent;
use App\Events\HrDashboardLoader;
use App\Events\OBPReqApproved;
use App\Events\OBPRequestSent;
use App\Events\ExitPassSent;

class OBPController extends Controller
{   
    protected $request;    

    public function __construct(Request $request){

        $this->request = $request;
    }        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $obps = OBP::byCreated(Auth::id());
        $uid = Auth::id();
        return view('obp.index',compact('obps','uid'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $user = Auth::user();

        return view('obp.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postdata = $this->request->all();
        $curr_user = Auth::user();       

        $obp = new OBP();
        $obp->user_id = Auth::id();
        $obp->position = $postdata['position'];
        $obp->department = $postdata['department'];
        $obp->purpose = $postdata['purpose'];
        $obp->date = date('Y-m-d',strtotime($postdata['date']));
        $obp->date2 = date('Y-m-d',strtotime($postdata['date2']));
        $obp->time_left = "";
        $obp->time_arrived = "";     
        $obp->supervisor = $curr_user->superior;
        $obp->manager = $curr_user->superior;
        $obp->manager_action = 0;
        $obp->level = 1;
        $obp->obpno = "";
        $obp->save();

        $strlength = 6;
        $str = substr(str_repeat(0, $strlength).$obp->id,-$strlength);
        $obp->obpno = "HRD-OB-".$str;
        $obp->update();

        $postdata['obp_id'] = $obp->id;
        $obp_det = new OBPDetail();
        
        $obp_det->obp_id = $obp->id;
        $obp_det->destination = $this->request->get('destination');
        $obp_det->person_visited = $this->request->get('visited');
        $obp_det->time_of_arrival = "";
        $obp_det->time_of_departure = "";
        $obp_det->destination2 = $this->request->get('destination2');
        $obp_det->person_visited2 = $this->request->get('visited2');
        $obp_det->time_of_arrival2 = "";
        $obp_det->time_of_departure2 = "";
        $obp_det->destination3 = $this->request->get('destination3');
        $obp_det->person_visited3 = $this->request->get('visited3');
        $obp_det->time_of_arrival3 = "";
        $obp_det->time_of_departure3 = "";
        $obp_det->destination4 = $this->request->get('destination4');
        $obp_det->person_visited4 = $this->request->get('visited4');
        $obp_det->time_of_arrival4 = "";
        $obp_det->time_of_departure4 = "";
        $obp_det->destination5 = $this->request->get('destination5');
        $obp_det->person_visited5 = $this->request->get('visited5');
        $obp_det->time_of_arrival5 = "";
        $obp_det->time_of_departure5 = "";
        $obp_det->save();

        try{
            // hr notif
            // broadcast(new HrDashboardLoader($obp))->toOthers();
            // broadcast(new OBPSent($obp, $curr_user))->toOthers();
            // superior notif
            broadcast(new ManagerOBPSent($obp, $curr_user))->toOthers();
        }catch (\Exception $e){

        }
        $module_id = 5;
        $accesses = AccessControl::findByModule($module_id);
        foreach($accesses as $access){
            $user = User::findUserByidandDeptid($access->user_id, $curr_user->dept_id);
            try{
                // dept manager notif
                broadcast(new OBPRequestSent($obp, $user))->toOthers();
            }catch (\Exception $e){

            }
        }
        return redirect('obp')->with('is_success','Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OBP  $oBP
     * @return \Illuminate\Http\Response
     */
    public function show(OBP $oBP)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OBP  $oBP
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $obp = OBP::findOrFail($id);

        $obp_details = OBPDetail::byObp($obp->id);                
        return view('obp.edit',compact('obp','obp_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OBP  $oBP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $postdata = $request->all();

        $userr = Auth::user();
        $department = Department::findOrFail($userr->dept_id);
        $obp = OBP::findOrFail($id);        
        $obp->user_id = Auth::id();
        $obp->supervisor = 0;
        $obp->position = $userr->position;
        $obp->department = $department->department;
        $obp->purpose = $postdata['purpose'];
        $obp->date = date('Y-m-d',strtotime($postdata['date']));
        $obp->time_left = "";
        $obp->time_arrived = "";     
        $obp->manager = 0;
        $obp->manager_action = 0;
        $obp->level = 1;
        $obp->save();

        $postdata['obp_id'] = $obp->id;

        $obp_det = OBPDetail::byObp($obp->id);        
        $obp_det->destination = $this->request->get('destination');
        $obp_det->person_visited = $this->request->get('visited');
        $obp_det->time_of_arrival = "";
        $obp_det->time_of_departure = "";    
        $obp_det->destination2 = $this->request->get('destination2');
        $obp_det->person_visited2 = $this->request->get('visited2');
        $obp_det->time_of_arrival2 = "";
        $obp_det->time_of_departure2 = "";    
        $obp_det->destination3 = $this->request->get('destination3');
        $obp_det->person_visited3 = $this->request->get('visited3');
        $obp_det->time_of_arrival3 = "";
        $obp_det->time_of_departure3 = "";    
        $obp_det->destination4 = $this->request->get('destination4');
        $obp_det->person_visited4 = $this->request->get('visited4');
        $obp_det->time_of_arrival4 = "";
        $obp_det->time_of_departure4 = "";    
        $obp_det->destination5 = $this->request->get('destination5');
        $obp_det->person_visited5 = $this->request->get('visited5');
        $obp_det->time_of_arrival5 = "";
        $obp_det->time_of_departure5 = "";             
        $obp_det->update();

        return redirect('obp')->with('is_updated','Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OBP  $oBP
     * @return \Illuminate\Http\Response
     */
    public function destroy(OBP $oBP)
    {
        //
    }
    public function details($id){

        $obp = OBP::findOrFail($id);
        $obp_details = OBPDetail::byObp($id);

        $remarks = OBPRemark::byObp($id);

        return view('obp.emp_details',compact('obp','obp_details','remarks'));
    }

    public function remarks(Request $request){
        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            if(!empty($request->details)){
                $remark = new OBPRemark();
                $remark->obp_id = $request->obp_id;
                $remark->details = $request->details;
                $remark->remarks_by = Auth::id();
                $remark->save();

                return redirect()->back()->with('is_success','Success');
            }
            return redirect()->back()->with('no_remarks','No Remarks');
        }

        if($sub == 2){            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->manager_action = 2;
            $obp->approver = Auth::id();
            $obp->update();

            $curr_user = User::findOrFail($obp->user_id);

            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            broadcast(new OBPReqApproved($obp, $curr_user))->toOthers();
            broadcast(new HrDashboardLoader($obp))->toOthers();

        }elseif ($sub == 3) {            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->hr_action = 2;
            $obp->level = 3;
            $obp->hrd = Auth::id();                   
            $obp->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Denied!';
            }
            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();
            
            try{
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return redirect('dashboard')->with('is_denied','Saved!');
            }catch (\Exception $e){
                return redirect('dashboard')->with('is_denied','Saved!');
            }
        }

        if($sub == 4){            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->hr_action = 1;
            $obp->hrd = Auth::id();
            $obp->level = 2;                 
            $obp->update();

            $curr_user = User::findOrFail($obp->user_id);

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            $ext = new EmployeeExitPass();
            $ext->user_id = $obp->user_id;            
            $ext->date = date('Y-m-d',strtotime($obp->date));
            $ext->purpose = nl2br($obp->purpose);
            $ext->time_in = "";
            $ext->time_out = "";
            $ext->appr_obp = 1;            
            $ext->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength).$ext->id,-$strlength);
            $ext->exit_no = "HRD-EP-".$str;
            $ext->obp_id = $obp->id;
            $ext->update();

            try{
                broadcast(new OBPReqApproved($obp, $curr_user))->toOthers();
                broadcast(new ExitPassSent($ext, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return redirect('dashboard')->with('is_success','Saved!');
            }catch (\Exception $e){
                return redirect('dashboard')->with('is_success','Saved!');
            }
        }

        return back()->with('is_sucess','Saved!');
    }

    public function mngr_remarks(Request $request){

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub == 1){            
            if(!empty($request->details)){
                $remark = new OBPRemark();
                $remark->obp_id = $request->obp_id;
                $remark->details = $request->details;
                $remark->remarks_by = Auth::id();
                $remark->save();

                return back()->with('is_sucess','Saved!');
            }
            return back()->with('no_remarks','Needed');
        }

        if($sub == 2){            

            $obp = OBP::where('id',$postdata['obp_id'])->first();

            $curr_user = User::findOrFail($obp->user_id);

            $obp->manager = $curr_user->id;
            $obp->manager_action = 2;            
            $obp->manager = Auth::id();
            $obp->approver = Auth::id();               
            $obp->level = 2;
            $obp->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            $ext = new EmployeeExitPass();
            $ext->user_id = $obp->user_id;            
            $ext->date = date('Y-m-d',strtotime($obp->date));
            $ext->purpose = nl2br($obp->purpose);
            $ext->time_in = "";
            $ext->time_out = "";
            $ext->appr_obp = 1;            
            $ext->save();
            $ext->exit_no = "EXT".$ext->id;
            $ext->obp_id = $obp->id;
            $ext->update();

            try{
                broadcast(new OBPSent($obp, $curr_user))->toOthers();
                broadcast(new ExitPassSent($ext, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return redirect('superior')->with('is_sucess','Saved!');
            }catch (\Exception $e){
                return redirect('superior')->with('is_sucess','Saved!');
            }
        }
        if ($sub == 3) {            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->manager_action = 3;
            $obp->hr_action = 2;
            $obp->level = 3;                     
            $obp->manager = Auth::id();
            $obp->approver = Auth::id(); 
            $obp->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Denied!';
            }
            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();
            
            try{
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return redirect('dashboard')->with('is_denied','Saved!');
            }catch (\Exception $e){
                // 
            }
            return redirect('dashboard')->with('is_denied','Saved!');
        }
        if($sub == 4){           

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->manager_action = 2;
            $obp->approver = Auth::id();                     
            $obp->update();

            $curr_user = User::findOrFail($obp->user_id);

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new OBPReqApproved($obp, $curr_user))->toOthers();
                broadcast(new OBPSent($obp, $curr_user))->toOthers();
                // broadcast(new ExitPassSent($ext, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return redirect('dashboard')->with('is_approved','Saved!');
            }catch (\Exception $e){
                
            }
        }
        if($sub == 5){           
            $obp = OBP::where('id',$request->obp_id)->first();
            $obp->manager_action = 2;
            $obp->approver = Auth::id();                        
            $obp->update();

            $curr_user = User::findOrFail($obp->user_id);

            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = "Approved";
            $remark->remarks_by = Auth::id();
            $remark->save();

            if($obp->date = date('Y-m-d')){
                $ext = new EmployeeExitPass();
                $ext->user_id = $obp->user_id;            
                $ext->date = date('Y-m-d',strtotime($obp->date));
                $ext->purpose = nl2br($obp->purpose);
                $ext->time_in = "";
                $ext->time_out = "";
                $ext->appr_obp = 1;            
                $ext->save();
                $ext->exit_no = "EXT".$ext->id;
                $ext->obp_id = $obp->id;
                $ext->update();    
            }
            try{
                broadcast(new OBPReqApproved($obp, $curr_user))->toOthers();
                broadcast(new ExitPassSent($ext, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return redirect('dashboard')->with('is_exitpass','Saved!');
            }catch (\Exception $e){
                return redirect('dashboard')->with('is_exitpass','Saved!');
            }
        }
        
        return redirect('dashboard')->with('is_sucess','Saved!');
    }

    public function mngr_obp_list(){

        $mngr_id = Auth::user()->dept_id;

        $obps = OBP::byUnder(Auth::id());

        return view('manager.mng_obp_list',['obps'=>$obps]);
    }

    public function mngr_details($id){

        $obp = OBP::findOrFail($id);
        $obp_details = OBPDetail::byObp($id);

        $remarks = OBPRemark::byObp($id);

        return view('manager.mng_obp_details',compact('obp','obp_details','remarks'));
    }


    public function hr_obp_list(){

        $obps = OBP::all();
        // $obps = OBP::byHrd();
        return view('obp.hrd_lists',compact('obps'));
    }

    public function hrd_details($id){

        $obp = OBP::findOrFail($id);
        $obp_details = OBPDetail::byObp($id);

        $remarks = OBPRemark::byObp($id);

        return view('obp.hrd_details',compact('obp','obp_details','remarks'));
    }

    public function download(Request $request){
        $obp = OBP::findOrFail($request->uid);

        $user = User::findOrFail($obp->user_id);
        $obp_details = OBPDetail::byallObp($obp->id);
        if(!empty($obp)){
            
            
                                    
            $employee_name = strtoupper($user->first_name.' '.$user->last_name);
            $position = strtoupper($user->position);
            $department =strtoupper($user->department->department);   
            $company = strtoupper($user->company); 

        $pdf = App::make('dompdf.wrapper');                        
        $view = \View::make('pdf.obp',compact('obp','employee_name','position','department','obp_details', 'company'))->render();                
        $pdf->loadHTML($view);        
        $customPaper = array(0,0,700,1000);
        $pdf->setPaper($customPaper);
        return $pdf->stream();
        // 
        // $pdf = PDF::loadView($view);
        // return $pdf->download('pdf.obp');
        }
        else{
            return view('errors.503');
        }
    }
    
    public function downloadPDF($obpid,$uid){

        $obp = OBP::findOrFail($obpid);
        $user = User::findOrFail($uid);
        $obp_details = OBPDetail::byObp($obp->id);

        if(!empty($obp)){
            
                                    
            $employee_name = strtoupper($user->first_name.' '.$user->last_name);
            $position = strtoupper($user->position);
            $department =strtoupper($user->department->department);
            $company = strtoupper($user->company); 
        

        $pdf = App::make('dompdf.wrapper');        

        $view = \View::make('pdf.obp',compact('obp','employee_name','position','department','obp_details','company'))->render();        
        $pdf->loadHTML($view);
        $customPaper = array(0,0,700,1000);
        $pdf->setPaper($customPaper);
        return $pdf->stream();

        }
        else{
            return view('errors.503');
        }
    }
    public function mng_obp_list()
    {
        $manager_dept_id = Auth::user()->dept_id;

        $obps = OBP::byDeptId($manager_dept_id);

        return view('dept_manager.obp_list',['obps'=>$obps]);
    }

    public function mng_obp_details($id)
    {
        $obp = OBP::findOrFail($id);
        $obp_details = OBPDetail::byObp($id);

        $remarks = OBPRemark::byObp($id);

        return view('dept_manager.obp_details',compact('obp','obp_details','remarks'));
    }

    public function mng_obp_remarks(Request $request)
    {
        $curr_user = Auth::user();

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub == 1){            
            
            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        if($sub == 2){            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->manager = $curr_user->id;
            $obp->manager_action = 2;            
            $obp->manager = Auth::id();                
            $obp->level = 2;
            $obp->update();
            

            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            $ext = new EmployeeExitPass();
            $ext->user_id = $obp->user_id;            
            $ext->date = date('Y-m-d',strtotime($obp->date));
            $ext->purpose = nl2br($obp->purpose);
            $ext->time_in = "";
            $ext->time_out = "";
            $ext->appr_obp = 1;            
            $ext->save();
            $ext->exit_no = "EXT".$ext->id;
            $ext->obp_id = $obp->id;
            $ext->update();

            try{
                broadcast(new OBPSent($obp, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return back()->with('is_sucess','Saved!');
            }catch (\Exception $e){
                return back()->with('is_sucess','Saved!');
            }

        }
        if ($sub == 3) {            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->manager_action = 3;                        
            $obp->manager = Auth::id();
            $obp->update();

            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
            
            try{
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return back()->with('is_denied','Saved!');
            }catch (\Exception $e){
                return back()->with('is_denied','Saved!');
            }
        }
        if($sub == 4){            

            $obp = OBP::where('id',$postdata['obp_id'])->first();
            $obp->manager_action = 2;
            $obp->approver = Auth::id();                        
            $obp->update();

            $curr_user = User::findOrFail($obp->user_id);

            $remark = new OBPRemark();
            $remark->obp_id = $request->obp_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            if($obp->date = date('Y-m-d')){
                $ext = new EmployeeExitPass();
                $ext->user_id = $obp->user_id;            
                $ext->date = date('Y-m-d',strtotime($obp->date));
                $ext->purpose = nl2br($obp->purpose);
                $ext->time_in = "";
                $ext->time_out = "";
                $ext->appr_obp = 1;            
                $ext->save();
                $ext->exit_no = "EXT".$ext->id;
                $ext->obp_id = $obp->id;
                $ext->update();    
            }
            try{
                broadcast(new OBPReqApproved($obp, $curr_user))->toOthers();
                broadcast(new ExitPassSent($ext, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($obp))->toOthers();
                return back()->with('is_exitpass','Saved!');
            }catch (\Exception $e){
                return back()->with('is_exitpass','Saved!');
            }
        }
        return back()->with('is_sucess','Saved!');
    }

    public function cancel(Request $request)
    {
        $obp = OBP::findOrFail($request->id);
        if(!empty($obp)){
            // if($obp->manager_action < 2){
                $obp->manager_action = 5;
                $obp->level = 5;
                $obp->hr_action = 5;
                $obp->save();

                try{
                    broadcast(new HrDashboardLoader($obp))->toOthers();
                }catch(\Exception $e){
                    
                }
                return \Response::json(['type'=>'1']);
            // }
            // return \Response::json(['type'=>'2']);
        }
        return \Response::json(['type'=>'3']);
    }

    public function editDate(Request $request){
        $result = "E";

        $work = OBP::findOrFail($request->id);
        if (!empty($work)) {
            $work->date = date('Y/m/d',strtotime($request->newDate1));
            $work->date2 = date('Y/m/d',strtotime($request->newDate2));
            $work->save();
            $result = "S";
        }
        return response()->json($result);
    }
}
