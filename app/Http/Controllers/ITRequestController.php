<?php

namespace App\Http\Controllers;

use App\ITRequest;
use Illuminate\Http\Request;
use App\UserAccessRequestCategory;
use App\UserAccessRequestSubCategory;
use App\ServiceRequestCategory;
use App\ServiceRequestSubCategory;
use App\ServiceRequestSubSubCategory;
use App\UserAccessRequestSubSubCategory;
use App\ITRequestFile;
use App\AccessControl;
use Response;
use Auth;
use App\User;
use App\Events\ServiceRequestSent;
use App\Events\ItDashboardLoader;
use App\Events\MTDashboardLoader;
use App\Events\UserAccessRequestSent;
use App\Events\MamTiffSent;
use App\Events\SAPSentToSuperior;
use App\Events\UserAccessSent;
use App\Events\UserAccessSentSup;
use Illuminate\Support\Facades\Input;
use App\AssetTracking;

class ITRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_access_request_index(){

        $u_acess = UserAccessRequestCategory::orderBy('category','ASC')->pluck('category','id');

        return view('it_help_desk.index',compact('u_acess'));

    }

    public function user_access_request_store(Request $request){

        $curr_user = Auth::user();
        if($request->category != null){
            $category = UserAccessRequestCategory::findorFail($request->get('category'));

            $year = date('y');
            $postdata = $request->all();
            $datenow = date('Y-m-d');
            $var_date = explode('-',$datenow);
            $postdata['details'] = nl2br($request->get('error'));
            $postdata['level'] = 2;
            $postdata['created_by'] = Auth::id();
            $postdata['status'] = 0;
            $postdata['solved_by'] = 0;
            $postdata['service_type'] = 1;
            $postdata['category'] = $category->category;
            $postdata['sub_category'] = $request->get('sub_category');
            $postdata['reqit_no'] = "IT";
            $postdata['old'] = $request->old;
            $ticket = new ITRequest($postdata);
            $ticket->superior = Auth::user()->superior;
            $ticket->sup_action = 0;
            $ticket->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength).$ticket->id,-$strlength);
            $ticket->reqit_no = 'IT-'.$year.'-'.$str;
            $ticket->update();

            // if($ticket->service_type == 1 AND $ticket->sub_category == 'SAP'){
            //     $ticket->sup_action = 0;
            //     $ticket->update();
            // }else{
            //     $ticket->sup_action = 1;
            //     $ticket->update();
            // }

            if($request->hasFile('attached')){
                
                $files = Input::file('attached');
                    
                       
                    $destinationPath = public_path().'/uploads/ITHelpDesk/user_access_request/'.$ticket->reqit_no.'/';  

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

                    $message_file = new ITRequestFile();
                    $message_file->request_id = $ticket->id;
                    $message_file->ticket_no = $ticket->reqit_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();                
                    $message_file->save();
                }
            }
            if(Auth::user()->superior != 0){
                $superior = User::findorFail(Auth::user()->superior);
            }else{
                $ticket->sup_action = 1;
                $ticket->update();
            }
            // if SAP REQUEST
            if($ticket->sub_category == 'SAP'){
                // notif to mam tiff if manager nag request
                if($ticket->sup_action == 1){
                    $moduleid = 21;
                    $acss = AccessControl::findByModule($moduleid);
                    foreach ($acss as $acs) {
                        $user = User::findOrFail($acs->user_id);
                        try{
                            broadcast(new MamTiffSent($ticket, $user))->toOthers();
                            broadcast(new MTDashboardLoader($ticket, $user))->toOthers();
                        }catch (\Exception $e)
                        {
                            // pass broadcasting if broadcasting fail
                        }
                    }
                }else{
                    // notif to manager if hindi manager nag request
                    try{
                        broadcast(new SAPSentToSuperior($ticket, $superior))->toOthers();
                        broadcast(new ItDashboardLoader($ticket))->toOthers();
                    }catch (\Exception $e){
                        // catch
                    }
                }
            }else{
            //  if NON SAP REQUEST
                $module_id = 56;
                $accesses = AccessControl::findByModule($module_id);
                foreach($accesses as $access){
                    $user = User::findOrFail($access->user_id);
                    try{
                        broadcast(new UserAccessSent($ticket, $user))->toOthers();
                        broadcast(new ItDashboardLoader($ticket))->toOthers();
                    }catch (\Exception $e){
                        // catch
                    }
                }
                $module_id_2 = 55;
                $acs = AccessControl::findByModule($module_id_2);
                foreach ($acs as $ac) {
                    $user = User::findOrFail($ac->user_id);
                    try{
                        broadcast(new UserAccessSentSup($ticket, $user))->toOthers();
                    }catch (\Exception $e){
                        // catch
                    }
                }
            }      
            return back()->with('is_success', 'ticket was successfully submit');
        }else{
            return back()->with('is_error', 'ticket error submit');
        }
    }

    public function service_request_index(){

        $user = Auth::user();
        $s_acess = ServiceRequestCategory::orderBy('category','ASC')->pluck('category','id');
        $assets = AssetTracking::where('holder',$user->id)->get();

        return view('it_help_desk.service_index',compact('s_acess','assets'));

    }

    public function service_request_store(Request $request){

        $curr_user = Auth::user();
        $category = ServiceRequestCategory::findorFail($request->get('category'));

        $postdata = $request->all();

        $year = date('y');
        $datenow = date('Y-m-d');
        $var_date = explode('-',$datenow);
        $postdata['details'] = nl2br($request->get('error'));
        $postdata['level'] = 0;
        $postdata['created_by'] = Auth::id();
        $postdata['status'] = 0;
        $postdata['solved_by'] = 0;
        $postdata['service_type'] = 2;
        $postdata['reqit_no'] = "IT";
        $postdata['category'] = $category->category;
        $postdata['sub_category'] = $request->get('sub_category');
        $postdata['old'] = 0;
        if(!empty($request->asset_no)){
            $postdata['asset_no'] = $request->asset_no;
        }else{
            $postdata['asset_no'] = '';
        }

        $ticket = new ITRequest($postdata);
        $ticket->save();

        $strlength = 6;
        $str = substr(str_repeat(0, $strlength).$ticket->id,-$strlength);
        $ticket->reqit_no = 'IT-'.$year.'-'.$str;
        $ticket->update();

        if($request->hasFile('attached')){
            
            $files = Input::file('attached');
                
                   
                $destinationPath = public_path().'/uploads/ITHelpDesk/service_request/'.$ticket->reqit_no.'/';  

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

                $message_file = new ITRequestFile();
                $message_file->request_id = $ticket->id;
                $message_file->ticket_no = $ticket->reqit_no;
                $message_file->filename = $namefile;
                $message_file->encryptname = $enc;
                $message_file->uploaded_by = Auth::id();                
                $message_file->save();
            }
        }
        try{
            broadcast(new ServiceRequestSent($ticket, $curr_user))->toOthers();
            broadcast(new ItDashboardLoader($ticket))->toOthers();
        }catch (\Exception $e) {
            return back()->with('is_success', 'ticket was successfully submitted');
        }
        return back()->with('is_success', 'ticket was successfully submitted');

    }

    public function u_access_sub_category(Request $request){

        $sub_category = UserAccessRequestSubCategory::getList($request->get('category_id'));

        return Response::json($sub_category);
    }

    public function u_access_error_category(Request $request){

        $sub_category_id = UserAccessRequestSubCategory::where('sub_category',$request->sub_category)->pluck('id');
        $subs = UserAccessRequestSubSubCategory::getList($sub_category_id);

        return Response::json($subs);
    }

    public function service_request_sub_category(Request $request){

        $sub_category = ServiceRequestSubCategory::getList($request->get('category_id'));

        return Response::json($sub_category);
    }

    public function service_request_error_category(Request $request){

        $sub_category_id = ServiceRequestSubCategory::where('sub_category',$request->sub_category)->pluck('id');
        $subs = ServiceRequestSubSubCategory::getList($sub_category_id);

        return Response::json($subs);
    }
}
