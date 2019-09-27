<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\OBP;
use App\OBPDetail;
use App\OBPRemark;
use App\Undertime;
use App\UndertimeRemark;
use App\UndertimeRemarkFile;
use App\Requisition;
use App\RequisitionRemark;
use App\WorkAuthorization;
use App\WorkAuthorizationRemark;
use App\WorkAuthorizationRemarkFile;
use App\Events\UndertimeSent;
use Auth;

class ManagerController extends Controller
{
    public function obp_index()
    {
    	$manager_dept_id = Auth::user()->dept_id;

        // $obps = OBP::byDeptId($manager_dept_id);
    	$obps = OBP::byUnder(Auth::id());

    	return view('manager.mng_obp_list',['obps'=>$obps]);
    }
    public function obp_details($id)
    {
    	$obp = OBP::find($id);
    	$obp_details = OBPDetail::byObp($id);
    	$remarks = OBPRemark::byObp($id);

    	return view('manager.mng_obp_details',['obp'=>$obp,'obp_details'=>$obp_details,'remarks'=>$remarks]);
    }
    public function undertime_index()
    {
        $manager_dept_id = Auth::user()->dept_id;

        $undertimes = Undertime::byDeptId($manager_dept_id);

        return view('manager.mng_undertime_list',['undertimes'=>$undertimes]);
    }
    public function undertime_detail($id)
    {
        $undertime = Undertime::findOrFail($id);
        $remarks = UndertimeRemark::byUndertime($id);

        return view('manager.mng_undertime_details',['undertime'=>$undertime,'remarks'=>$remarks]);
    }
    public function undertime_remarks(Request $request){

        $curr_user = Auth::user();

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            
            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $request->details;
            $remark->save();
        }

        if($sub == 2){            

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->status = 2;            
            $undertime->approve_by = Auth::id();  
            $undertime->manager = Auth::id();
            $undertime->manager_action = 2;              
            $undertime->update();


        }if($sub == 4){            

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->status = 2;            
            $undertime->approve_by = Auth::id(); 
            $undertime->generated = 1;               
            $undertime->update();

            $remark = new UndertimeRemark();
            $remark->remarks_by = Auth::id();
            $remark->undertime_id = $request->undertime_id;
            $remark->details = $request->details;
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

            return back()->with('is_exitpass','Saved!');

        }elseif ($sub == 3) {            

            $undertime = Undertime::where('id',$postdata['undertime_id'])->first();
            $undertime->status = 3;            
            $undertime->approve_by = Auth::id();                
            $undertime->update();

        }       

        return back()->with('is_success','Saved!');
    }
    public function requisition_index()
    {
        $manager_dept_id = Auth::user()->dept_id;

        $requis = Requisition::byDeptId($manager_dept_id);

        return view('manager.mng_requisition_list',['requis'=>$requis]);
    }
    public function requisition_details($id)
    {
        $req = Requisition::find($id);
        $remarks = RequisitionRemark::byWork($id);

        return view('manager.mng_requisition_detail',['req'=>$req,'remarks'=>$remarks]);
    }
    public function reqremarks(Request $request)
    {
        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){            
            
            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        if($sub == 2){            

            $req = Requisition::where('id',$postdata['req_id'])->first();
            $req->sup_action = 2;            
            $req->supervisor_id = Auth::id();  
            $req->status = 2;
            $req->level = 2;
            $req->update();

            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
            return back()->with('is_closed','Saved!');


        }elseif ($sub == 3) {            

            $req = Requisition::where('id',$postdata['req_id'])->first();
            $req->hrd_action = 3;            
            $req->hrd = Auth::id();  
            $req->status = 3;
            $req->update();

            $remark = new RequisitionRemark();
            $remark->requisition_id = $request->req_id;
            $remark->remarks = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
            return back()->with('is_denied','Saved!');
        }   

        return back()->with('is_success','Saved!');
    }
    public function workauth_index()
    {
        $manager_dept_id = Auth::user()->dept_id;

        $works = WorkAuthorization::byDeptId($manager_dept_id);

        return view('manager.mng_workauth_list',['works'=>$works]);
    }

    public function workauth_details($id)
    {
        $work = WorkAuthorization::find($id);
        $remarks = WorkAuthorizationRemark::byWork($id);

        $files = WorkAuthorizationRemarkFile::byWork($id);

        return view('manager.mng_workauth_details',['work'=>$work,'remarks'=>$remarks]);
    }
    public function workremarks(Request $request)
    {
        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if($sub < 2){                           
            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        if($sub == 2){            

            $work = WorkAuthorization::where('id',$postdata['work_id'])->first();
            
            $work->superior_action = 2;            
            $work->superior = Auth::id();       
            $work->level = 2;            
            $work->update();

            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            return back()->with('is_closed','Close');

        }elseif ($sub == 3) {            

            $work = WorkAuthorization::where('id',$postdata['work_id'])->first();
            if($work->superior_action < 2){
                $work->superior_action = 3;            
                $work->superior = Auth::id();       
                $work->level = 1;
            }else{
                $work->hrd_action = 3;            
                $work->hrd = Auth::id();       
            }                    
            $work->update();
        }        

        return back()->with('is_sucess','Saved!');
    }
}
