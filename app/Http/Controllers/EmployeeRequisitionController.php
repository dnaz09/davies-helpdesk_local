<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\EmployeeRequisition;
use App\EmployeeRequisitionFile;
use App\EmployeeRequisitionRemark;
use App\EmployeeRequisitionRemarkFile;
use App\EmployeeRequisitionDetail;
use App\User;
use App\AccessControl;
use App\Events\EmployeeReqSent;
use App\Events\EmployeeReqApprovedSup;
use App\Events\EmployeeReqApprovedHR;
use App\Events\EmployeeReqSentToDeptHead;
use App\Events\SentToMamVicky;
use App\Events\ApprovedByMamVicky;
use Auth;
use Response;

class EmployeeRequisitionController extends Controller
{
	public function index()
	{
		$id = Auth::id();
		$reqs = EmployeeRequisition::byUser($id);
		$supers = User::getAllSuperiors(Auth::user()->dept_id);
		return view('employee_req.index',compact('reqs','supers'));
	}
    public function list()
    {
    	$reqs = EmployeeRequisition::allApprovedBySup();
    	return view('employee_req.hr_list',compact('reqs'));
    }
    public function hrlist()
    {
        $reqs = EmployeeRequisition::all();
        return view('employee_req.hr_view_list',compact('reqs'));
    }
    public function hrdetails($id)
    {
    	$req = EmployeeRequisition::findByEReqNo($id);
        $files = EmployeeRequisitionFile::findByEReqNo($id);
        $remarks = EmployeeRequisitionRemark::findByEReqNo($id);
        $req_d = EmployeeRequisitionDetail::findByEReqNo($id);

        return view('employee_req.hr_details',compact('req','files','remarks','req_d'));
    }
    public function hrview($id)
    {
        $req = EmployeeRequisition::findByEReqNo($id);
        $files = EmployeeRequisitionFile::findByEReqNo($id);
        $remarks = EmployeeRequisitionRemark::findByEReqNo($id);
        $req_d = EmployeeRequisitionDetail::findByEReqNo($id);

        return view('employee_req.hr_view',compact('req','files','remarks','req_d'));
    }
    public function store(Request $request)
    {
    	$ereq = new EmployeeRequisition();
    	$ereq->job_title = $request->job_title;
    	$ereq->company = Auth::user()->company;
    	$ereq->dept_id = Auth::user()->dept_id;
    	$ereq->work_site = $request->work_site;
    	$ereq->no_needed = $request->no_needed;
        if($request->job_title == 'staff')
        {
            $date_needed = date('Y-m-d', strtotime('+30 days'));
        }elseif($request->job_title == 'supervisor')
        {
            $date_needed = date('Y-m-d', strtotime('+45 days'));
        }elseif($request->job_title == 'managerial')
        {
            $date_needed = date('Y-m-d', strtotime('+60 days'));
        }
    	$ereq->date_needed = $date_needed;
        $ereq->req_type = $request->type;
    	$ereq->req_nature = $request->nature;
    	$ereq->gender = $request->gender;
    	$ereq->age = $request->age;
    	$ereq->details = $request->details;
    	$ereq->user_id = Auth::id();
        $ereq->superior = Auth::id();
        $ereq->sup_action = 1;
    	$ereq->manager = $request->manager;
        $ereq->hr_action = 0;
        $ereq->approver_action = 0;
    	$ereq->save();

    	$req = EmployeeRequisition::findOrFail($ereq->id);
        $strlength = 6;
        $str = substr(str_repeat(0, $strlength).$req->id,-$strlength);
    	$req->ereq_no = 'HRD-ER-'.$str;
    	$req->update();

    	if($request->hasFile('attached')){

    		$files = Input::file('attached');     
            $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
			if (!\File::exists($destinationPath))
            {
                mkdir($destinationPath, 0755, true); 
            }  
            foreach ($files as $file) 
            {
                $filename = $file->getClientOriginalName();    
                $namefile = Date('YmdHis').$filename;
                // move_uploaded_file($destinationPath, $namefile);
                $file->move($destinationPath, $namefile);
                $hashname = \Hash::make($namefile);

                $enc = str_replace("/","", $hashname);

                $message_file = new EmployeeRequisitionFile();
                $message_file->ereq_no = $req->ereq_no;
                $message_file->filename = $namefile;
                $message_file->uploaded_by = Auth::id();                
                $message_file->save();
            }
    	}
        if($ereq->sup_action == 1){
            $id = 49;
            $acss = AccessControl::findByModule($id);
            foreach ($acss as $acs) {
                // $user = User::findUserByidandDeptid($acs->user_id, $curr_user->dept_id);
                $user = User::findOrFail($acs->user_id);
                try{
                    broadcast(new EmployeeReqApprovedSup($req, $user))->toOthers();
                }catch(\Exception $e){

                }
            }
        }
        $id = 58;
        $acss = AccessControl::findByModule($id);
        foreach ($acss as $acs) {
            $user = User::findUserByidandDeptid($acs->user_id, Auth::user()->dept_id);
            try{
                broadcast(new EmployeeReqSentToDeptHead($req, $user))->toOthers();
            }catch(\Exception $e){

            }
        }
        $curr_user = Auth::user();
        try{
            broadcast(new EmployeeReqSent($ereq, $curr_user))->toOthers();
        }catch (\Exception $e){

        }
    	return redirect()->back()->with('is_saved','Success');
    }

    public function details($id)
    {
        $req = EmployeeRequisition::findByEReqNo($id);
        $files = EmployeeRequisitionFile::findByEReqNo($id);
        $remarks = EmployeeRequisitionRemark::findByEReqNo($id);

        return view('employee_req.emp_details',compact('req','files','remarks'));
    }

    public function cancel_hr($id){
        $req = EmployeeRequisition::findOrFail($id);
        if(empty($req)){
            return \Response::json(['type'=>'3']);
        }
        else{
            $req->sup_action = 5;
            $req->hr_action = 5;
            $req->approver_action = 5;
            $req->save();

            return \Response::json(['type'=>'1']);
        }
            return \Response::json(['type'=>'2']);
    }
    public function cancel($id)
    {
        $req = EmployeeRequisition::findByEReqNo($id);
        $req->sup_action = 5;
        $req->hr_action = 5;
        $req->approver_action = 5;
        $req->save();

        try{

        }catch(\Exception $e){
            broadcast(new HrDashboardLoader($req))->toOthers();
        }

        return back()->with('is_cancel','Canceled');
    }

    public function sup_list()
    {
        $reqs = EmployeeRequisition::findBySuperior(Auth::id());

        return view('employee_req.sup_list',compact('reqs'));
    }

    public function mnglist()
    {
        $user = Auth::user(); 
        $reqs = EmployeeRequisition::findByDepartment($user->dept_id);

        return view('employee_req.dept_head_list',compact('reqs'));
    }

    public function editDate(Request $request){
        $result = "E";

        $und = EmployeeRequisition::findOrFail($request->id);
        if (!empty($und)) {
            $und->date_needed = date('Y/m/d',strtotime($request->newDate));
            $und->save();
            $result = "S";
        }
        return response()->json($result);
    }

    public function mngdetails($id)
    {
        $req = EmployeeRequisition::findByEReqNo($id);
        $files = EmployeeRequisitionFile::findByEReqNo($id);
        $remarks = EmployeeRequisitionRemark::findByEReqNo($id);

        return view('employee_req.dept_head_details',compact('req','files','remarks'));
    }

    public function sup_details($id)
    {
        $req = EmployeeRequisition::findByEReqNo($id);
        $files = EmployeeRequisitionFile::findByEReqNo($id);
        $remarks = EmployeeRequisitionRemark::findByEReqNo($id);

        return view('employee_req.sup_details',compact('req','files','remarks'));
    }
    public function remarks(Request $request)
    {
        $sub = $request->sub;
        if($sub == 1){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();

            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            return redirect()->back()->with('is_success','Success');
        }
        if($sub == 2){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $req->sup_action = 1;
            $req->update();
            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();
            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            $id = 49;
            $acss = AccessControl::findByModule($id);
            foreach ($acss as $acs) {
                // $user = User::findUserByidandDeptid($acs->user_id, $curr_user->dept_id);
                $user = User::findOrFail($acs->user_id);
                try{
                    broadcast(new EmployeeReqApprovedSup($req, $user))->toOthers();
                }catch(\Exception $e){

                }
            }
            return redirect()->back()->with('is_success','Success');
        }
        if($sub == 3){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $req->hrd = Auth::id();
            $req->hr_action = 1;
            $req->update();
            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();
            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            $req_d = new EmployeeRequisitionDetail();
            $req_d->ereq_no = $req->ereq_no;
            $req_d->hr_receiver = Auth::id();
            $req_d->hr_manager_action = 0;
            $req_d->hr_manager = 0;
            $req_d->reco_approval = 1;
            $req_d->reco_approver = Auth::id();
            $req_d->save();

            $user = User::findOrFail($req->user_id);
            broadcast(new EmployeeReqApprovedHR($req, $user))->toOthers();

            $id = 60;
            $acs = AccessControl::findByModule($id);
            foreach ($acs as $ac) {
                $user = User::findOrFail($ac->user_id);
                try{
                    broadcast(new SentToMamVicky($req, $user))->toOthers();
                }catch(\Exception $e){

                }
            }

            return redirect()->back()->with('is_success','Success');
        }
        if($sub == 4){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $req->sup_action = 2;
            $req->hr_action = 2;
            $req->update();
            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();
            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }

            return redirect()->back()->with('is_denied','Success');
        }
    }

    public function download(Request $request)
    {
        $file = EmployeeRequisitionFile::findOrFail($request->id);
        $filename = $file->filename;
        $file_download = public_path()."/uploads/HRD/EmployeeRequisition/".$file->ereq_no."/$filename";

        return response()->download($file_download, $filename);
    }

    public function approver_index()
    {
        $reqs = EmployeeRequisition::approvedByHr();

        return view('employee_req.approver_index',compact('reqs'));
    }

    public function approver_details($id)
    {
        $req = EmployeeRequisition::findByEReqNo($id);
        $files = EmployeeRequisitionFile::findByEReqNo($id);
        $remarks = EmployeeRequisitionRemark::findByEReqNo($id);

        return view('employee_req.approver_details',compact('req','files','remarks'));
    }

    public function approver_remarks(Request $request)
    {
        $sub = $request->sub;
        if($sub == 1){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();

            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            return redirect()->back()->with('is_success','Success');
        }
        if($sub == 2){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $req->approver_action = 1;
            $req->update();
            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();
            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            try{
                $user = User::findOrFail($req->user_id);
                broadcast(new ApprovedByMamVicky($req, $user))->toOthers();
            }catch(\Exception $e){

            }
            
            return redirect()->back()->with('is_success','Success');
        }
        if($sub == 4){
            $curr_user = Auth::user();
            $req = EmployeeRequisition::findByEReqNo($request->ereq_no);
            $req->sup_action = 2;
            $req->hr_action = 2;
            $req->approver_action = 2;
            $req->update();

            $remark = new EmployeeRequisitionRemark();
            $remark->ereq_no = $request->ereq_no;
            $remark->remark = $request->details;
            $remark->user_id = Auth::id();
            $remark->save();
            if($request->hasFile('attached')){
                $files = Input::file('attached');     
                $destinationPath = public_path().'/uploads/HRD/EmployeeRequisition/'.$req->ereq_no.'/';  
                if (!\File::exists($destinationPath))
                {
                    mkdir($destinationPath, 0755, true); 
                }  
                foreach ($files as $file) 
                {
                    $filename = $file->getClientOriginalName();    
                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new EmployeeRequisitionRemarkFile();
                    $message_file->ereq_no = $req->ereq_no;
                    $message_file->e_remark_id = $remark->id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }

            return redirect()->back()->with('is_denied','Success');
        }
    }

    public function download_remark(Request $request)
    {
        $encryptname = $request->encname;
        $file = EmployeeRequisitionRemarkFile::ByEncryptName($encryptname);
        $file_down= public_path().'/uploads/HRD/EmployeeRequisition/'.$file->ereq_no.'/'.$file->filename;       
        
        return Response::download($file_down);
    }
}
