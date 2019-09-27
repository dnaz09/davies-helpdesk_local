<?php

namespace App\Http\Controllers;

use App\Requisition;
use App\RequisitionRemark;
use App\RequisitionForm;
use App\RequisitionPurpose;
use App\RequisitionDescription;
use App\AccessControl;
use Illuminate\Http\Request;
use Auth;
use App\Events\ManagerReqSent;
use App\Events\ReqSent;
use App\Events\HrDashboardLoader;
use App\Events\ReqApproved;
use App\Events\RequisitionRequested;
use App\User;
class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $requisitions = Requisition::byCreated(Auth::id());
        $user = Auth::user();
        $forms = RequisitionForm::all();
        $purposes = RequisitionPurpose::all();
        $descs = RequisitionDescription::all();
        $date = date('m/d/Y');
        return view('requisition.index',compact('requisitions','user','forms','purposes','descs','date'));
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
        if($request->date_needed != null){
            $curr_user = Auth::user();
            
            $req = new Requisition();
            $req->user_id = Auth::id();
            if(Auth::user()->superior != 0){
                $req->supervisor_id = Auth::user()->superior;
            }else{
                $req->supervisor_id = Auth::id();
                $req->sup_action = 2;
            }
            $req->recomm = "";      
            $req->date_needed = date('Y-m-d',strtotime($request->date_needed));
            if($request->item1 != null){
                $req->purpose1 = $request->purpose1;
                $req->item_no1 = 1;
                $req->item1 = $request->item1;
                $req->qty1 = $request->qty1;
            }else{
                return redirect()->back()->with('is_error', 'Error');
            }
            if($request->item2 != ''){
                $req->purpose2 = $request->purpose2;
                $req->item_no2 = 2;
                $req->item2 = $request->item2;
                $req->qty2 = $request->qty2;
            }else{
                $req->purpose2 = $request->purpose2;
                $req->item_no2 = '';
                $req->item2 = $request->item2;
                $req->qty2 = $request->qty2;
            }
            if($request->item3 != ''){
                $req->purpose3 = $request->purpose3;
                $req->item_no3 = 3;
                $req->item3 = $request->item3;
                $req->qty3 = $request->qty3;   
            }else{
                $req->purpose3 = $request->purpose3;
                $req->item_no3 = '';
                $req->item3 = $request->item3;
                $req->qty3 = $request->qty3;
            }
            if($request->item4 != ''){
                $req->purpose4 = $request->purpose4;
                $req->item_no4 = 4;
                $req->item4 = $request->item4;
                $req->qty4 = $request->qty4;   
            }else{
                $req->purpose4 = $request->purpose4;
                $req->item_no4 = '';
                $req->item4 = $request->item4;
                $req->qty4 = $request->qty4;
            }
            if($request->item5 != ''){
                $req->purpose5 = $request->purpose5;
                $req->item_no5 = 5;
                $req->item5 = $request->item5;
                $req->qty5 = $request->qty5;
            }else{
                $req->purpose5 = $request->purpose5;
                $req->item_no5 = '';
                $req->item5 = $request->item5;
                $req->qty5 = $request->qty5;
            }
            $req->rno = "";
            $req->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength).$req->id,-$strlength);

            $req->rno = "HRD-REQ-".$str;
            $req->update();

            $remark = new RequisitionRemark();
            $remark->requisition_id = $req->id;
            $remark->remarks = $request->remarks;
            $remark->remarks_by = Auth::id();
            $remark->save();
            
            if($req->sup_action == 2){
                try{
                    broadcast(new ReqSent($req, $curr_user))->toOthers();
                    broadcast(new HrDashboardLoader($req))->toOthers();
                    return redirect()->back()->with('is_success', 'Success');
                }catch (\Exception $e){
                    // Pass broadcast
                }
            }else{
                try{
                    broadcast(new HrDashboardLoader($req))->toOthers();
                    broadcast(new ManagerReqSent($req, $curr_user))->toOthers();
                    $module_id = 53;
                    $acss = AccessControl::findByModule($module_id);
                    foreach ($acss as $acs) {
                        $user = User::findUserByidandDeptid($acs->user_id, $curr_user->dept_id);
                        try{
                            broadcast(new RequisitionRequested($req, $user))->toOthers();
                        }catch(\Exception $e){

                        }
                    }
                }catch (\Exception $e){
                    // Pass broadcast
                }
            }
            return redirect()->back()->with('is_success', 'Success');
        }else{
            return redirect()->back()->with('is_error', 'Error');
        }
    }

    public function details($rno){

        $req = Requisition::byNo($rno);
        $remarks = RequisitionRemark::byWork($req->id);

        return view('requisition.details',compact('req','remarks'));
    }

    public function cancel($id){

        $req = Requisition::byNo($id);
        $req->level = 5;
        $req->hrd_action = 5;
        $req->sup_action = 5;
        $req->status = 5;
        $req->save();

        try{
            broadcast(new HrDashboardLoader($req))->toOthers();
        }catch(\Exception $e){

        }

        return back()->with('is_cancel','Canceled');
    }

    public function remarks(Request $request){

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            if(!empty($request->details)){
                $remark = new RequisitionRemark();
                $remark->requisition_id = $request->req_id;
                $remark->remarks = $request->details;
                $remark->remarks_by = Auth::id();
                $remark->save();

                return redirect()->back()->with('is_success','Success');
            }
            return redirect()->back()->with('no_remarks','Remarks Needed');
        }

        if($sub == 2){            

            $req = Requisition::where('id',$postdata['req_id'])->first();
            $curr_user = User::findOrFail($req->user_id);
            $req->hrd_action = 2;            
            $req->hrd = Auth::id();  
            $req->status = 2;
            $req->level = 2;
            $req->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new ReqApproved($req, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($req))->toOthers();
                return redirect()->back()->with('is_closed','Saved!');
            }catch (\Exception $e){
                return redirect()->back()->with('is_closed','Saved!');
            }

        }elseif ($sub == 3) {            

            $req = Requisition::where('id',$postdata['req_id'])->first();
            $req->hrd_action = 3;            
            $req->hrd = Auth::id();  
            $req->status = 3;
            $req->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Denied!';
            }
            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new HrDashboardLoader($req))->toOthers();
                return redirect()->back()->with('is_denied','Saved!');
            }catch (\Exception $e){
                return redirect()->back()->with('is_denied','Saved!');
            }
        }   

        return back()->with('is_success','Saved!');

    }

    public function mngr_requisition_list(){

        $mngr_id = Auth::user()->dept_id;

        // $requis = Requisition::byDeptId($mngr_id);

        $requis = Requisition::byUnder(Auth::id());

        return view('manager.mng_requisition_list',['requis'=>$requis]);
    }

    public function mng_requisition_list(){

        $id = Auth::user()->dept_id;

        // $requis = Requisition::byDeptId($mngr_id);

        $requis = Requisition::byDeptId($id);

        return view('dept_manager.requisition_list',['requis'=>$requis]);
    }

    public function mng_requisition_details($id){

        $req = Requisition::find($id);
        $remarks = RequisitionRemark::byWork($id);

        return view('dept_manager.requisition_details',compact('req','remarks'));
    }

    public function mngr_details($id){

        $req = Requisition::find($id);
        $remarks = RequisitionRemark::byWork($id);

        return view('requisition.mngr_details',compact('req','remarks'));
    }

    public function mngr_remarks(Request $request){
        $curr_user = Auth::user();

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            if(!empty($request->details)){
                $remark = new RequisitionRemark();
                $remark->requisition_id = $request->req_id;
                $remark->remarks = $request->details;
                $remark->remarks_by = Auth::id();
                $remark->save();

                return redirect()->back()->with('is_success','Success');
            }
            return redirect()->back()->with('no_remarks','Remarks needed');
        }

        if($sub == 2){            

            $req = Requisition::where('id',$postdata['req_id'])->first();
            $curr_user = User::findOrFail($req->user_id);
            $req->sup_action = 2;            
            $req->supervisor_id = Auth::id();  
            $req->status = 1;
            $req->level = 1;
            $req->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Approved!';
            }
            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new ReqSent($req, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($req))->toOthers();
            }catch (\Exception $e){    
                
            }
            // if($req->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_success','Approved');
            // }else{
                return back()->with('is_success','Saved!');
            // }

        }elseif ($sub == 3) {            

            $req = Requisition::where('id',$postdata['req_id'])->first();
            $req->sup_action = 3;            
            $req->supervisor_id = Auth::id();  
            $req->status = 3;
            $req->update();

            if(!empty($request->details)){
                $details = $request->details;
            }else{
                $details = 'Denied!';
            }
            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try{
                broadcast(new ReqSent($req, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($req))->toOthers();
            }catch (\Exception $e){
                
            }
            // if($req->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_deny','Denied');
            // }else{
                return back()->with('is_success','Denied!');
            // }
        }   

        return back()->with('is_success','Saved!');
    }

    public function hr_requisition_list(){

        $requis = Requisition::getForHrd();

        return view('requisition.hrd_list',compact('requis'));

    }

    public function hrd_details($rno){

        $req = Requisition::byNo($rno);
        $remarks = RequisitionRemark::byWork($req->id);

        return view('requisition.hrd_details',compact('req','remarks'));
    }

    public function manager_approve(Request $request)
    {
        $id = $request->id;
        $req = Requisition::where('id',$id)->first();
        if(!empty($req)){
            $curr_user = User::findOrFail($req->user_id);
            $req->sup_action = 2;            
            $req->supervisor_id = $curr_user->superior;  
            $req->status = 1;
            $req->level = 1;
            $req->hrd_remarks = $request->hrd_remarks;
            $req->update();

            try{
                broadcast(new ReqSent($req, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($req))->toOthers();
            }catch (\Exception $e){    
                
            }
            return back()->with('is_success','Saved!');
        }
        return back()->with('is_error','Error!');
    }
}
