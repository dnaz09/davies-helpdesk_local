<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\JobOrder;
use App\JobOrderRemark;
use App\JobOrderRemarkFile;
use App\JobOrderLocation;
use App\JobOrderFacility;
use App\JobOrderEquipment;
use App\JobOrderInhouse;
use App\JobOrderSubItemClass;
use App\AccessControl;
use App\Events\SuperiorJOSent;
use App\Events\JOReqSent;
use App\Events\AdminDashboardLoader;
use App\Events\JOReqApproved;
use App\Events\DeptHeadJOSent;
use App\Events\JobOrderStatusToggler;
use App\AssetTracking;
use Response;
use Illuminate\Support\Facades\Input;
use Auth;
use App;

class JobOrderRequestController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $jos = JobOrder::ByUser($user);
        $jos_total = JobOrder::getAllTotal($user);
        $jos_pending = JobOrder::getAllPending($user);
        $jos_approved = JobOrder::getAllApproved($user);

        return view('job_order.index', compact('jos', 'jos_total', 'jos_pending', 'jos_approved'));
    }
    public function create()
    {
        $locations = JobOrderLocation::getLocations();
        $facilities = JobOrderFacility::getFacilities();
        $equipments = JobOrderEquipment::getEquipments();
        // $equipments = JobOrderEquipment::getAllEquipments();
        return view('job_order.create', compact('locations', 'facilities', 'equipments'));
    }
    public function store(Request $request)
    {
        if ($request->work_for == 'Facilities/Building') {
            if ($request->facility == '-') {
                return redirect()->back()->with('is_error_facility', 'Error');
            }
        } elseif ($request->work_for == 'Equipment') {
            if ($request->equipment == '-') {
                return redirect()->back()->with('is_error_equipment', 'Error');
            }
        }
        $jos = new JobOrder();
        $jos->date_submitted = date('Y-m-d');
        $jos->user_id = Auth::id();
        $jos->dept_id = Auth::user()->dept_id;
        $jos->role_id = Auth::user()->role_id;
        $jos->section = $request->section;
        $jos->req_work = $request->req_work;
        $jos->work_for = 'Equipment';
        $jos->facility = $request->facility;
        $jos->other_info = $request->equipment;
        $jos->item_class = $request->item_class;
        $jos->asset_no = $request->asset_no;
        $jos->description = $request->description;
        if (Auth::user()->superior != 0) {
            $jos->superior = Auth::user()->superior;
        } else {
            $jos->superior = Auth::id();
        }
        // $jos->item_class = $request->item_class;
        $jos->repair = 1;
        $jos->project = 1;
        $jos->save();

        $strlength = 6;
        $str = substr(str_repeat(0, $strlength) . $jos->id, -$strlength);
        $jos->jo_no = 'ASD-JO-' . $str;
        $jos->update();

        $user = Auth::user();

        try {
            broadcast(new SuperiorJOSent($jos, $user))->toOthers();
        } catch (\Exception $e) { }
        $module_id = 59;
        $accesses = AccessControl::findByModule($module_id);
        foreach ($accesses as $access) {
            $user = User::findUserByidandDeptid($access->user_id, Auth::user()->dept_id);
            try {
                // dept manager notif
                broadcast(new DeptHeadJOSent($jos, $user))->toOthers();
            } catch (\Exception $e) { }
        }

        return redirect('job_order')->with('is_success', 'Saved');
    }
    public function show()
    {
        // 
    }
    public function list()
    {
        $jos = JobOrder::getAllSupApproved();
        $jos_total = JobOrder::getAdminAllTotal();
        $jos_pending = JobOrder::getAdminAllPending();
        $jos_approved = JobOrder::getAdminAllApproved();

        return view('job_order.list', compact('jos', 'jos_total', 'jos_pending', 'jos_approved'));
    }
    public function details($id)
    {
        // $jo = JobOrder::where('id', $id)->first();
        $jo = JobOrder::byId($id);
        $remarks = JobOrderRemark::getList($id);

        return view('job_order.details', compact('jo', 'remarks'));
    }
    public function user_details($id)
    {
        // $jo = JobOrder::where('id', $id)->first();
        $jo = JobOrder::byId($id);
        $remarks = JobOrderRemark::getList($id);
        return view('job_order.user_details', compact('jo', 'remarks'));
    }
    public function cancel($id)
    {
        $jo = JobOrder::byId($id);
        if (!empty($jo)) {
            $jo->status = 5;
            $jo->jo_status = 5;
            $jo->save();
        }
        return redirect()->back()->with('is_cancel', 'Canceled');
    }
    public function remarks(Request $request)
    {
        $type = $request->get('sub');

        if ($type == 1) {

            $postdata = $request->all();

            $postdata['user_id'] = Auth::id();
            $postdata['remark'] = nl2br($request->get('remarks'));

            $remarks = new JobOrderRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/job_order/' . $remarks->id . '/Remarks/';

                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                foreach ($files as $file) {


                    $filename = $file->getClientOriginalName();


                    $namefile = Date('YmdHis') . $filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);


                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/", "", $hashname);

                    $message_file = new JobOrderRemarkFile();
                    $message_file->jo_remark_id = $remarks->id;
                    $message_file->jo_id = $request->jo_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }

            return redirect()->back()->with('is_success', 'Saved');
        }
    }
    public function download(Request $request)
    {
        $encryptname = $request->get('encname');
        $file = JobOrderRemarkFile::ByEncryptName($encryptname);

        $file_down = public_path() . '/uploads/AdminHelpDesk/job_order/' . $file->jo_remark_id . '/Remarks/' . $file->filename;
        return Response::download($file_down);
    }
    public function admin_remarks(Request $request)
    {
        $type = $request->get('sub');

        if ($type == 1) {

            $postdata = $request->all();

            $postdata['user_id'] = Auth::id();
            $postdata['remark'] = nl2br($request->get('remarks'));

            $remarks = new JobOrderRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/job_order/' . $remarks->id . '/Remarks/';

                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                foreach ($files as $file) {


                    $filename = $file->getClientOriginalName();


                    $namefile = Date('YmdHis') . $filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);


                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/", "", $hashname);

                    $message_file = new JobOrderRemarkFile();
                    $message_file->jo_remark_id = $remarks->id;
                    $message_file->jo_id = $request->jo_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }

            return redirect()->back()->with('is_success', 'Saved');
        }
        if ($type == 2) {

            $jo = JobOrder::byId($request->jo_id);
            $jo->status = 2;
            $jo->approved_by = Auth::user()->id;
            $jo->save();

            $curr_user = User::findOrFail($jo->user_id);

            $postdata = $request->all();

            $postdata['user_id'] = Auth::id();
            $postdata['remark'] = nl2br($request->get('remarks'));

            $remarks = new JobOrderRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/job_order/' . $remarks->id . '/Remarks/';

                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                foreach ($files as $file) {


                    $filename = $file->getClientOriginalName();


                    $namefile = Date('YmdHis') . $filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);


                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/", "", $hashname);

                    $message_file = new JobOrderRemarkFile();
                    $message_file->jo_remark_id = $remarks->id;
                    $message_file->jo_id = $request->jo_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }

            broadcast(new JOReqApproved($jo, $curr_user))->toOthers();
            broadcast(new AdminDashboardLoader($jo))->toOthers();

            return redirect()->action('JobOrderRequestController@details', ['id' => $request->get('jo_id')])->with('is_success', 'Saved');
        }
    }

    public function add_details(Request $request)
    {
        $jo = JobOrder::byId($request->jo_id);
        if ($jo != null) {
            $jo->work_done = $request->work_done;
            $jo->served_by = $request->served_by;
            $jo->verified_by = $request->verified_by;
            $jo->save();

            return redirect()->action('JobOrderRequestController@details', ['id' => $request->get('jo_id')])->with('is_good', 'Added');
        }
    }

    public function mng_list()
    {
        $id = Auth::id();
        $jos = JobOrder::getSupAll($id);
        $jos_total = JobOrder::getSupAllTotal($id);
        $jos_pending = JobOrder::getSupPending($id);
        $jos_approved = JobOrder::getSupApproved($id);

        return view('job_order.mng_list', compact('jos', 'jos_total', 'jos_pending', 'jos_approved'));
    }

    public function mng_details($id)
    {
        $jo = JobOrder::byId($id);
        $remarks = JobOrderRemark::getList($id);

        return view('job_order.mng_detail', compact('jo', 'remarks'));
    }

    public function mng_remarks(Request $request)
    {
        $type = $request->get('sub');

        if ($type == 1) {
            if (empty($request->remarks)) {
                return redirect()->back()->with('no_remarks', 'Error');
            }
            $postdata = $request->all();

            $postdata['user_id'] = Auth::id();
            $postdata['remark'] = nl2br($request->get('remarks'));

            $remarks = new JobOrderRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/job_order/' . $remarks->id . '/Remarks/';

                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                foreach ($files as $file) {


                    $filename = $file->getClientOriginalName();


                    $namefile = Date('YmdHis') . $filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);


                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/", "", $hashname);

                    $message_file = new JobOrderRemarkFile();
                    $message_file->jo_remark_id = $remarks->id;
                    $message_file->jo_id = $request->jo_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }

            return redirect()->back()->with('is_success', 'Saved');
        }
        if ($type == 2) {

            $jo = JobOrder::byId($request->jo_id);
            $jo->sup_action = 1;
            $jo->approved_by = Auth::id();
            $jo->status = 2;
            $jo->save();

            $postdata = $request->all();
            if (!empty($request->remarks)) {
                $details = $request->remarks;
            } else {
                $details = 'Approved!';
            }

            $postdata['user_id'] = Auth::id();
            $postdata['remark'] = nl2br($details);

            $remarks = new JobOrderRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/job_order/' . $remarks->id . '/Remarks/';

                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                foreach ($files as $file) {


                    $filename = $file->getClientOriginalName();


                    $namefile = Date('YmdHis') . $filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);


                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/", "", $hashname);

                    $message_file = new JobOrderRemarkFile();
                    $message_file->jo_remark_id = $remarks->id;
                    $message_file->jo_id = $request->jo_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }
            $curr_user = User::findOrFail($jo->user_id);
            try {
                broadcast(new JOReqSent($jo, $curr_user))->toOthers();
                // broadcast(new AdminDashboardLoader($jo))->toOthers();
            } catch (\Exception $e) { }
            // if($jo->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_success','Approved');
            // }else{
            return redirect()->back()->with('is_success', 'Approved');
            // }
        }
        if ($type == 3) {

            $jo = JobOrder::byId($request->jo_id);
            $jo->sup_action = 3;
            $jo->approved_by = Auth::id();
            $jo->status = 3;
            $jo->save();

            $postdata = $request->all();
            if (!empty($request->remarks)) {
                $details = $request->remarks;
            } else {
                $details = 'Denied!';
            }

            $postdata['user_id'] = Auth::id();
            $postdata['remark'] = nl2br($details);

            $remarks = new JobOrderRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/job_order/' . $remarks->id . '/Remarks/';

                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                foreach ($files as $file) {


                    $filename = $file->getClientOriginalName();


                    $namefile = Date('YmdHis') . $filename;
                    // move_uploaded_file($destinationPath, $namefile);
                    $file->move($destinationPath, $namefile);


                    $hashname = \Hash::make($namefile);

                    $enc = str_replace("/", "", $hashname);

                    $message_file = new JobOrderRemarkFile();
                    $message_file->jo_remark_id = $remarks->id;
                    $message_file->jo_id = $request->jo_id;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }
            $curr_user = User::findOrFail($jo->user_id);
            try {
                broadcast(new JOReqSent($jo, $curr_user))->toOthers();
                // broadcast(new AdminDashboardLoader($jo))->toOthers();
            } catch (\Exception $e) { }

            // if($jo->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_deny','Denied');
            // }else{
            return redirect()->back()->with('is_success', 'Denied');
            // }
        }
    }

    public function mnglist()
    {
        $id = Auth::user()->dept_id;
        $jos = JobOrder::ByDeptId($id);

        return view('job_order.jo_dhead_list', compact('jos'));
    }

    public function mngdetails($id)
    {
        $jo = JobOrder::byId($id);
        $remarks = JobOrderRemark::getList($id);

        return view('job_order.mng_detail', compact('jo', 'remarks'));
    }

    public function admin_list()
    {
        $jos = JobOrder::getApproved();
        $jos_total = JobOrder::getAdminAllTotal();
        $jos_pending = JobOrder::getAdminAllPending();

        return view('job_order.admin_list', compact('jos', 'jos_total', 'jos_pending'));
    }

    public function admin_details($id)
    {
        $jo = JobOrder::byId($id);
        $inhouses = JobOrderInhouse::all();
        if ($jo->status != 2) {
            return redirect()->back()->with('no_jo', 'Error');
        }

        return view('job_order.admin_details', compact('jo', 'inhouses'));
    }

    public function editprovider($id)
    {
        $result = "E";
        $jo = JobOrder::byid($id);

        if (!empty($jo)) {
            $jo->jo_status = 1;
            $jo->save();

            $result = "S";
        }
        return Response::json($result);
    }


    public function add_info(Request $request)
    {
        $jo = JobOrder::byId($request->jo_id);
        if (!empty($jo)) {
            $curr_user = User::findOrFail($jo->user_id);
            if ($request->service_by == 'Other Contractors') {
                $server = $request->service_by . ' - ' . $request->contractor;
            } elseif ($request->service_by == 'In-house Contractors') {
                $server = $request->service_by . ' - ' . $request->inhouse;
            } else {
                $server = $request->service_by;
            }
            if (!empty($request->total_cost)) {
                $cost = number_format(0.00 + $request->total_cost, 2);
            } else {
                $cost = 0.00;
            }
            if ($request->sub == 1) {
                $jo->served_by = $server;
                $jo->jo_status = 4;
                $jo->save();

                try {
                    broadcast(new JobOrderStatusToggler($jo, $curr_user))->toOthers();
                } catch (Exception $e) { }
                return redirect('job_order_admin')->with('is_succes', 'Success');
            } elseif ($request->sub == 2) {
                $jo->work_done = $request->work_done;
                $jo->reco = $request->reco;
                $jo->date_started = $request->date_started;
                $jo->date_finished = $request->date_finished;
                $jo->total_cost = $cost;
                $jo->jo_status = 2;
                $jo->save();

                try {
                    broadcast(new JobOrderStatusToggler($jo, $curr_user))->toOthers();
                } catch (Exception $e) { }
                return redirect('job_order_admin')->with('is_succes', 'Success');
            }

            return redirect('job_order_admin')->with('is_succes', 'Success');
        }
    }

    public function add_dets(Request $request)
    {
        $jo = JobOrder::byId($request->jo_id);
        if (!empty($jo)) {
            $curr_user = User::findOrFail($jo->user_id);
            if ($request->sub == 1) {
                $jo->jo_status = 4;
                $jo->save();

                try {
                    broadcast(new JobOrderStatusToggler($jo, $curr_user))->toOthers();
                } catch (Exception $e) { }
            }
            if ($request->sub == 2) {
                $jo->jo_status = 0;
                $jo->save();
            }
            return redirect()->back()->with('is_success', 'Success');
        }
        return redirect()->back()->with('is_error', 'Error');
    }

    public function getJoItemClasses(Request $request)
    {
        $items['selection'] = JobOrderSubItemClass::getByEquipment($request->type);

        return \Response::json($items);
    }

    public function downloadPDF($joID, $uid)
    {

        $jo = JobOrder::findOrFail($joID);
        $user = User::findOrFail($uid);

        if (!empty($jo)) {


            $employee_name = strtoupper($user->first_name . ' ' . $user->last_name);
            $position = strtoupper($user->position);
            $department = strtoupper($user->department->department);
            $company = strtoupper($user->company);


            $pdf = App::make('dompdf.wrapper');

            $view = \View::make('pdf.jo', compact('jo', 'employee_name', 'position', 'department', 'company'))->render();
            $pdf->loadHTML($view);
            $customPaper = array(0, 0, 700, 1000);
            $pdf->setPaper($customPaper);
            return @$pdf->stream();
        } else {
            return view('errors.503');
        }
    }
}
