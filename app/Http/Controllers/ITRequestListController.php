<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserAccessRequestCategory;
use App\AccessControl;
use App\ServiceRequestCategory;
use App\ItemRequest;
use App\ITRequestFile;
use App\ITRequest;
use App\ITRequestRemarks;
use App\ITRequestRemarksFile;
use App\User;
use Auth;
use Response;
use App\Events\ItDashboardLoader;
use App\Events\ServiceRequestSent;
use App\Events\MTDashboardLoader;
use App\Events\MamTiffSent;
use Illuminate\Support\Facades\Input;
use Session;
class ITRequestListController extends Controller
{
    protected $request;
    protected $user_access_req;
    protected $it_request;


    public function __construct(Request $request){

    	$this->request = $request;
    }

    public function index(){

    	$user = Auth::user();

        $user_acc_total = ITRequest::getTotal();
        $user_acc_ongoing = ITRequest::getTotalOngoing();
        $user_acc_returned = ITRequest::getTotalReturned();
        $user_acc_closed = ITRequest::getTotalClosed();
    	
        $user_acc_solve = ITRequest::getMySolved($user->id);
        $service_solve = ITRequest::getMySolvedService($user->id);
        $saps_solve = ITRequest::getMySolvedSap($user->id);

        $user_access_reqs = ITRequest::byBatch($user->itlevel);
        $service_reqs = ITRequest::byBatchService($user->itlevel);
        // user access = service type = 1 
        // service = service type = 2 

        $reqs = [];
        foreach ($user_access_reqs as $user_acc) {
            $reqs[] = $user_acc;
        }
        foreach ($service_reqs as $key => $ser_req) {
            $reqs[] = $ser_req;
        }
        arsort($reqs);
        $saps = ITRequest::byApprovedManager();
        

    	return view('it_help_desk.all_list',compact('user_acc_solve','service_solve','user_acc_total','user_acc_ongoing','user_acc_returned','user_acc_closed','saps','saps_solve','reqs'));
    }

    public function details($id){

        $user_acss = ITRequest::byTicket($id);

        if(empty($user_acss)){

            return view('errors.909',compact('id'));
        }

        $user = Auth::user();        

        $files = ITRequestFile::ByTicket($id);


        $remarks = ITRequestRemarks::getList($id);


        return view('it_help_desk.request_details',compact('user_acss','files','remarks','user'));
    }

    public function details_user($id){

        $user_acss = ITRequest::byTicket($id);

        if(empty($user_acss)){

            return view('errors.909',compact('id'));
        }

        $user = Auth::user();        

        $files = ITRequestFile::ByTicket($id);


        $remarks = ITRequestRemarks::getList($id);


        return view('myrequest.request_details',compact('user_acss','files','remarks','user'));
    }

    public function cancel($id){
        $result;
        $req = ITRequest::byTicket($id);

        if(!empty($user_acss)){

           return view('errors.909',compact('id'));
        }else{
            $req->status = 5;
            $req->save();
            $result = 'is_canceled';
            Session::put('is_canceled', 'Canceled');
        }

        // return Response::json($result);
        return Response::json(['is_canceled'=>true,'url'=> route('my_request_list.index')]);
        // return redirect()->route('my_request_list.index')->with('is_canceled','Canceled');
    }

    public function download_files(Request $request){

        $encryptname = $this->request->get('encname');
        $file = ITRequestFile::ByEncryptName($encryptname);
        $type = $this->request->get('service_type');
        if($type == 1){

            $file_down= public_path().'/uploads/ITHelpDesk/service_type/'.$file->ticket_no.'/Remarks/'.$file->filename;       
        }
        elseif($type == 2){

            $file_down= public_path().'/uploads/ITHelpDesk/user_access_request/'.$file->ticket_no.'/Remarks/'.$file->filename;   
        }else{

            $file_down= public_path().'/uploads/ITHelpDesk/item_request/'.$file->ticket_no.'/'.$file->filename;   
        }
        

        return Response::download($file_down);
    }

    public function add_remarks(Request $request){

        $type = $this->request->get('sub');

        if($type == 1){
            $postdata = $this->request->all();
            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;      
            $postdata['details'] = nl2br($this->request->get('remarks'));

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();
            $stype = $this->request->get('service_type');

            if($request->hasFile('attached')){
                
                $files = Input::file('attached');                    
                    
                    if($stype > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }                    

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }        
            return redirect()->back()->with('is_success', 'Saved');
        }

        if($type == 2){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;       
            $postdata['details'] = nl2br($this->request->get('remarks'));

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->status = 1;
            $user_acss->level = 1;
            $user_acss->solved_by = Auth::id();
            $user_acss->update();
            $stype = $this->request->get('service_type');

            if($request->hasFile('attached')){
                    $files = Input::file('attached');
                    if($stype > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         
                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  

                    foreach ($files as $file) {
                        $filename = $file->getClientOriginalName();    
                        $namefile = Date('YmdHis').$filename;
                        // move_uploaded_file($destinationPath, $namefile);
                        $file->move($destinationPath, $namefile);
                        
                        $hashname = \Hash::make($namefile);

                        $enc = str_replace("/","", $hashname);

                        $message_file = new ITRequestRemarksFile();
                        $message_file->request_remarks_id = $remarks->id;
                        $message_file->request_id = $remarks->request_id;
                        $message_file->ticket_no = $remarks->ticket_no;
                        $message_file->filename = $namefile;
                        $message_file->encryptname = $enc;
                        $message_file->uploaded_by = Auth::id();                
                        $message_file->save();
                    }
            }

            $moduleid = 21;
            $acss = AccessControl::findByModule($moduleid);
            foreach ($acss as $acs) {
                $user = User::findOrFail($acs->user_id);
                if(!empty($user)){
                    try{
                        broadcast(new MTDashboardLoader($user_acss, $user))->toOthers();
                    }catch (\Exception $e){
                        // pass broadcasting
                    }
                }
            }
            try{
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_returned','Returned');
            }
            return redirect()->back()->with('is_returned','Returned');
        }

        if($type == 3){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;   
            $postdata['details'] = nl2br($this->request->get('remarks'));

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            if(Auth::id() == 25){
                $user_acss->level = 0;
            }else{
                $user_acss->level = 1;
                $user_acss->solved_by = Auth::id();
            }               
            $user_acss->update();

            $id = $user_acss->created_by;
            $curr_user = User::findOrFail($id);

            if($request->hasFile('attached')){
            
                $files = Input::file('attached');
                       
                    if($type > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {

                    $filename = $file->getClientOriginalName();    

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);
                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            $moduleid = 21;
            $acss = AccessControl::findByModule($moduleid);
            foreach ($acss as $acs) {
                $user = User::findOrFail($acs->user_id);
                try{
                    broadcast(new MTDashboardLoader($user_acss, $user))->toOthers();
                }catch (\Exception $e){
                    // pass broadcasting
                }
            }
            try{
                broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_transfered','Transfered');
            }
            return redirect()->back()->with('is_transfered','Transfered');
        }   
        if($type == 4){
            if(!empty($request->remarks)){
                $postdata = $this->request->all();

                $postdata['remarks_by'] = Auth::id();
                $postdata['request_id'] = $request->request_id; 
                $postdata['details'] = nl2br($this->request->get('remarks'));

                $remarks = new ITRequestRemarks($postdata);
                $remarks->save();

                $stype = $this->request->get('service_type');
                if($request->hasFile('attached')){
                    
                    $files = Input::file('attached');                    
                        
                        
                        if($stype > 1){
                            $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                        }else{
                            $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                        }                    

                           if (!\File::exists($destinationPath))
                        {
                            mkdir($destinationPath, 0755, true); 
                        }  
                    foreach ($files as $file) {
                       

                        $filename = $file->getClientOriginalName();    
                     

                        $namefile = Date('YmdHis').$filename;
                        // move_uploaded_file($destinationPath, $namefile);
                        $file->move($destinationPath, $namefile);

                        
                        $hashname = \Hash::make($namefile);

                        $enc = str_replace("/","", $hashname);

                        $message_file = new ITRequestRemarksFile();
                        $message_file->request_remarks_id = $remarks->id;
                        $message_file->request_id = $remarks->request_id;
                        $message_file->ticket_no = $remarks->ticket_no;
                        $message_file->filename = $namefile;
                        $message_file->encryptname = $enc;
                        $message_file->uploaded_by = Auth::id();                
                        $message_file->save();
                    }
                }    

                return redirect()->back()->with('is_success', 'Saved');
            }
            return redirect()->back()->with('remarks_needed', 'Error');
        }
        if($type == 5){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;      
            if(!empty($request->remarks)){
                $postdata['details'] = nl2br($this->request->get('remarks'));
            }else{
                $postdata['details'] = 'Approved';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->level = 0;              
            $user_acss->update();

            $id = $user_acss->created_by;
            $curr_user = User::findOrFail($id);

            if($request->hasFile('attached')){
            
                $files = Input::file('attached');
                    
                       
                    if($type > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            $moduleid = 21;
            $acss = AccessControl::findByModule($moduleid);
            foreach ($acss as $acs) {
                $user = User::findOrFail($acs->user_id);
                try{
                    broadcast(new MTDashboardLoader($user_acss, $user))->toOthers();
                }catch (\Exception $e){
                    // pass broadcasting
                }
            }
            try{
                broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_transfered','Transfered');
            }
            return redirect()->back()->with('is_transfered','Transfered');
        }
        if($type == 6){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;
            if(!empty($request->remarks)){
                $postdata['details'] = nl2br($this->request->get('remarks'));
            }else{
                $postdata['details'] = 'Approved';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->level = 0;          
            $user_acss->sup_action = 1;          
            $user_acss->update();

            $id = $user_acss->created_by;
            $curr_user = User::findOrFail($id);

            if($request->hasFile('attached')){
            
                $files = Input::file('attached');
                    
                       
                    if($type > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            try{
                broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_transfered','Transfered');
            }
            return redirect()->back()->with('is_transfered','Transfered');
        }
        if($type == 7){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;
            if(!empty($request->remarks)){
                $postdata['details'] = nl2br($this->request->get('remarks'));
            }else{
                $postdata['details'] = 'Approved';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->level = 3;          
            $user_acss->sup_action = 3;
            $user_acss->status = 3;          
            $user_acss->update();

            $id = $user_acss->created_by;
            $curr_user = User::findOrFail($id);

            if($request->hasFile('attached')){
            
                $files = Input::file('attached');
                    
                       
                    if($type > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            try{
                broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_denied','Transfered');
            }
            return redirect()->back()->with('is_denied','Transfered');
        }
    }

    public function remarks_download_files(Request $request){

        $encryptname = $this->request->get('encname');
        $file = ITRequestRemarksFile::ByEncryptName($encryptname);
        $type = $this->request->get('service_type');
        if($type == 2){
            $file_down= public_path().'/uploads/ITHelpDesk/service_request/'.$file->ticket_no.'/Remarks/'.$file->filename;
        }
        elseif($type == 1){

            $file_down= public_path().'/uploads/ITHelpDesk/user_access_request/'.$file->ticket_no.'/Remarks/'.$file->filename;   
        }else{

            $file_down= public_path().'/uploads/ITHelpDesk/item_request/'.$file->ticket_no.'/Remarks/'.$file->filename;   
        }
        

        return Response::download($file_down);
    }
    public function show(){
        $tickets = ITRequest::byManager();

        return view('it_help_desk.manager_list',compact('tickets'));
    }
    public function getMangerList(){

        $tickets = ITRequest::byManager();

        return view('it_help_desk.manager_list',compact('tickets'));
    }

    public function manager_details($id){

        $user_acss = ITRequest::byTicket($id);

        if(empty($user_acss)){

            return view('errors.909',compact('id'));
        }

        $user = Auth::user();        

        $files = ITRequestFile::ByTicket($id);


        $remarks = ITRequestRemarks::getList($id);


        return view('it_help_desk.request_mngdetails',compact('user_acss','files','remarks','user'));
    }

    public function sapmanagerindex()
    {
        $id = Auth::id();
        $tickets = ITRequest::byManagerSAP($id);
        return view('manager.mng_sap_list',compact('tickets'));
    }

    public function sapmanagerdetails($id)
    {
        $user_acss = ITRequest::byTicket($id);

        if(empty($user_acss)){

            return view('errors.909',compact('id'));
        }

        $user = Auth::user();        

        $files = ITRequestFile::ByTicket($id);


        $remarks = ITRequestRemarks::getList($id);


        return view('manager.mng_sap_details',compact('user_acss','files','remarks','user'));
    }

    public function sapmanagerremarks(Request $request)
    {
        $type = $this->request->get('sub');

        if($type == 1){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();      
            $postdata['details'] = nl2br($this->request->get('remarks'));

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();
            $stype = $this->request->get('service_type');
            if($request->hasFile('attached')){
                
                $files = Input::file('attached');                    
                    
                    
                    if($stype > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }                    

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }        

            return redirect()->back()->with('is_success', 'Saved');
        }
        if($type == 2){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();      
            $postdata['details'] = nl2br($this->request->get('remarks'));

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->sup_action = 1;
            if(Auth::id() == 25){
                $user_acss->level = 0;
            }
            $user_acss->update();
            $stype = $this->request->get('service_type');
            if($request->hasFile('attached')){
            
                $files = Input::file('attached');
                    
                       
                    if($stype > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            if($user_acss->level != 0){
                $moduleid = 21;
                $acss = AccessControl::findByModule($moduleid);
                foreach ($acss as $acs) {
                    $user = User::findOrFail($acs->user_id);
                    try{
                        broadcast(new MamTiffSent($user_acss, $user))->toOthers();
                        broadcast(new MTDashboardLoader($user_acss, $user))->toOthers();
                    }catch (\Exception $e)
                    {
                        // pass broadcasting if broadcasting fail
                    }
                }
            }else{
                $curr_user = User::findOrFail($user_acss->created_by);
                try{
                    broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                }catch(\Exception $e){
                    // catch
                }
                
            }

            try{
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                // catch
            }
            return redirect()->back()->with('is_returned','Returned');
        }
        if($type == 7){

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['request_id'] = $request->request_id;
            if(!empty($request->remarks)){
                $postdata['details'] = nl2br($this->request->get('remarks'));
            }else{
                $postdata['details'] = 'Approved';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->level = 3;          
            $user_acss->sup_action = 3;
            $user_acss->status = 3;          
            $user_acss->update();

            $id = $user_acss->created_by;
            $curr_user = User::findOrFail($id);

            if($request->hasFile('attached')){
            
                $files = Input::file('attached');
                    
                       
                    if($type > 1){
                        $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$remarks->ticket_no.'/Remarks/';  
                    }else{
                        $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$remarks->ticket_no.'/Remarks/';  
                    }         

                       if (!\File::exists($destinationPath))
                    {
                        mkdir($destinationPath, 0755, true); 
                    }  
                foreach ($files as $file) {
                   

                    $filename = $file->getClientOriginalName();    
                 

                    $namefile = Date('YmdHis').$filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);

                    
                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/","", $hashname);

                    $message_file = new ITRequestRemarksFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            try{
                broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            }catch (\Exception $e){
                return redirect()->back()->with('is_denied','Transfered');
            }
            return redirect()->back()->with('is_denied','Transfered');
        }
    }

    public function uaindex()
    {
        $its = ITRequest::byDept(Auth::user()->dept_id);
        
        return view('dept_manager.user_access_list',compact('its'));
    }

    public function uadetails($id)
    {
        $user_acss = ITRequest::findOrFail($id);
        if(empty($user_acss)){

            return view('errors.909',compact('id'));
        }

        $user = Auth::user();        

        $files = ITRequestFile::ByTicket($id);

        $remarks = ITRequestRemarks::getList($user_acss->reqit_no);

        return view('dept_manager.user_access_details',compact('user_acss','files','remarks'));
    }

    public function supdetails($id)
    {
        $user_acss = ITRequest::findOrFail($id);
        if(empty($user_acss)){

            return view('errors.909',compact('id'));
        }

        $user = Auth::user();        

        $files = ITRequestFile::ByTicket($id);

        $remarks = ITRequestRemarks::getList($user_acss->reqit_no);

        return view('superior.user_access_details',compact('user_acss','files','remarks'));
    }
}
