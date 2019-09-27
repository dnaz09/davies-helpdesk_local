<?php

namespace App\Http\Controllers;

use App\EmployeeExitPass;
use App\OBP;
use App\ExitPassRemark;
use App\User;
use App\Events\ExitPassApproved;
use App\Events\HrDashboardLoader;
use Illuminate\Http\Request;
use Auth;

class EmployeeExitPassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $exit_pass = EmployeeExitPass::byUser($user->id);
        // $obps = OBP::getApproved($user->id);        

        return view('exit_pass.create',compact('user','exit_pass'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $ext = new EmployeeExitPass();
        $ext->user_id = Auth::id();
        $ext->date = date('Y-m-d',strtotime($request->date));
        $ext->purpose = nl2br($request->purpose);
        $ext->time_in = $request->time_in;
        $ext->time_out = $request->time_out;
        if(!empty($request->appr_obp)){
            $ext->appr_obp = 1;
        }
        if(!empty($request->appr_leave)){
            $ext->appr_leave = 1;
        }
        if(!empty($request->others)){
            $ext->others = 1;
        }
        $ext->save();
        $ext->exit_no = "EXT".$ext->id;
        $ext->update();
        
        return back()->with('is_success','Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeExitPass  $employeeExitPass
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeExitPass $employeeExitPass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeExitPass  $employeeExitPass
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeExitPass $employeeExitPass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeExitPass  $employeeExitPass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeExitPass $employeeExitPass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeExitPass  $employeeExitPass
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeExitPass $employeeExitPass)
    {
        //
    }
    public function emp_details($id){

        $exit_pass = EmployeeExitPass::byNo($id);
        
        $remarks = ExitPassRemark::getList($exit_pass->exit_no);

        return view('exit_pass.emp_details',compact('exit_pass','remarks'));
    }
    public function hrd_list(){

        $user_acc_total = EmployeeExitPass::getTotal();
        $user_acc_ongoing = EmployeeExitPass::getTotalOngoing();
        $user_acc_closed = EmployeeExitPass::getTotalClosed();
        $exit_pass = EmployeeExitPass::all();
        $exit_pass_count = EmployeeExitPass::getPendingHRCount();

        return view('exit_pass.hrd_list',compact('exit_pass', 'user_acc_total', 'user_acc_ongoing', 'user_acc_closed','exit_pass_count'));
    }

    public function hrd_details($id){

        $exit_pass = EmployeeExitPass::byNo($id);
        
        $remarks = ExitPassRemark::getList($exit_pass->exit_no);

        return view('exit_pass.hrd_details',compact('exit_pass','remarks'));
    }

    public function remarks(Request $request){

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        $ext = EmployeeExitPass::findOrFail($request->exit_id);

        $curr_user = User::findOrFail($ext->user_id);

        if($sub < 2){            
            
            $ext = EmployeeExitPass::where('id',$postdata['exit_id'])->first();
            $ext->hrd_action = 1;   
            $ext->status = 0;   
            $ext->hrd_approver = Auth::id();                
            $ext->update();

            $remark = new ExitPassRemark();
            $remark->exit_id = $request->exit_id;
            $remark->exit_no = $ext->exit_no;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        elseif($sub == 2){            

            $ext = EmployeeExitPass::where('id',$postdata['exit_id'])->first();
            $ext->hrd_action = 2;   
            $ext->status = 1;   
            $ext->hrd_approver = Auth::id();                
            $ext->update();

            $remark = new ExitPassRemark();
            $remark->exit_id = $request->exit_id;
            $remark->exit_no = $ext->exit_no;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new ExitPassApproved($ext, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($ext))->toOthers();
                return back()->with('is_approved','approved');
            }catch (\Exception $e){
                return back()->with('is_approved','approved');
            }
            return back()->with('is_approved','approved');

        }elseif ($sub == 3) {            

            $ext = EmployeeExitPass::where('id',$postdata['exit_id'])->first();
            $ext->hrd_action = 3; 
            $ext->status = 1;                        
            $ext->hrd_approver = Auth::id();
            $ext->update();

            $remark = new ExitPassRemark();
            $remark->exit_id = $request->exit_id;
            $remark->exit_no = $ext->exit_no;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new HrDashboardLoader($ext))->toOthers();
                return back()->with('is_denied','denied');
            }catch (\Exception $e){
                return back()->with('is_denied','denied');
            }
            return back()->with('is_denied','denied');
        }

        return back()->with('is_success','Saved!');
    }
}
