<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AdminSupplyRequest;
use App\AdminSupplyRequestRemark;
use App\AdminSupplyRequestDetail;
use App\AccessControl;
use App\SupplyMaintenance;
use App\User;
use App\Events\SupplyRequestSend;
use App\Events\SupplyRequestSendtoHead;
use App\Events\SendToAdminDept;
use App\Events\ApproveByAdminDept;
use Auth;
use Illuminate\Support\Facades\Input;
use App;

class AdminSupplyRequestController extends Controller
{
    public function index()
    {
        $supps = AdminSupplyRequest::findByUserId(Auth::id());
        $categs = SupplyMaintenance::getCategories();

        return view('supply_req.index', compact('supps', 'categs'));
    }

    public function store(Request $request)
    {
        if (!empty($request->supplies)) {
            $supp = new AdminSupplyRequest();
            $supp->user_id = Auth::id();
            $supp->details = $request->details;
            $supp->superior = Auth::user()->superior;
            $supp->via = $request->via;
            $supp->deliver = $request->deliver;
            $supp->value = $request->value;
            $supp->received_by = strtoupper($request->received_by);
            $supp->status = 1;
            $supp->req_no = "ASD-SUP";
            $supp->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength) . $supp->id, -$strlength);
            $supp->req_no = "ASD-SUP-" . $str;
            $supp->update();

            $dets = explode(',', $request->get('supplies'));

            foreach ($dets as $item) {
                $supply = explode('|', $item);
                if (!empty($supply[0])) {
                    $details = new AdminSupplyRequestDetail();
                    $details->admin_supply_request_id = $supp->id;
                    $details->item = strtoupper($supply[0]);
                    $details->measurement = strtoupper($supply[2]);
                    $details->qty = $supply[1];
                    $details->status = 1;
                    $details->save();
                }
            }
            try {
                broadcast(new SupplyRequestSend($supp, Auth::user()))->toOthers();
            } catch (\Exception $e) {
                // catch
            }
            $module_id = 65;
            $accesses = AccessControl::findByModule($module_id);
            foreach ($accesses as $access) {
                $user = User::findUserByidandDeptid($access->user_id, Auth::user()->dept_id);
                try {
                    // dept manager notif
                    broadcast(new SupplyRequestSendtoHead($supp, $user))->toOthers();
                } catch (\Exception $e) { }
            }
            return redirect()->back()->with('is_success', 'Success');
        }
    }
    public function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    public function view($id)
    {
        $supp = AdminSupplyRequest::findOrFailWithDetails($id);

        $items = AdminSupplyRequestDetail::findByAdminRequestId($supp->id);

        $routings = AdminSupplyRequestRemark::findByAdminRequestId($supp->id);

        $categs = SupplyMaintenance::getCategories();
        return view('supply_req.details', compact('supp', 'items', 'routings', 'categs'));
    }

    public function remarks(Request $request)
    {
        $sub = $request->sub;

        if ($sub == 1) {
            if (!empty($request->details)) {
                $remark = new AdminSupplyRequestRemark();
                $remark->admin_supply_request_id = $request->id;
                $remark->user_id = Auth::id();
                $remark->remarks = $request->details;
                $remark->save();

                return redirect()->back()->with('is_success', ' Success');
            }
            return redirect()->back()->with('no_remarks', 'Error');
        }
        if ($sub == 2) {
            if (!empty($request->details)) {
                $details = $request->details;
            } else {
                $details = 'Approved!';
            }
            $remark = new AdminSupplyRequestRemark();
            $remark->admin_supply_request_id = $request->id;
            $remark->user_id = Auth::id();
            $remark->remarks = $details;
            $remark->save();

            $supp = AdminSupplyRequest::findOrFail($request->id);
            $supp->manager_action = 1;
            $supp->manager = Auth::id();
            $supp->save();

            $user = User::findOrFail($supp->user_id);

            $items = AdminSupplyRequestDetail::findByAdminRequestId($request->id);

            if (!empty($items)) {
                foreach ($items as $item) {
                    $item->qty_a = $item->qty_a === null ? $item->qty : $item->qty_a;
                    $item->save();
                }
            }

            try {
                broadcast(new SendToAdminDept($supp, $user))->toOthers();
            } catch (\Exception $e) {
                // catch
            }

            return redirect()->back()->with('is_success', 'Approved');

            // if($supp->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_success','Approved');
            // }else{
            //     return redirect()->back()->with('is_success','Approved');
            // }
        }
        if ($sub == 3) {
            if (!empty($request->details)) {
                $details = $request->details;
            } else {
                $details = 'Denied!';
            }
            $remark = new AdminSupplyRequestRemark();
            $remark->admin_supply_request_id = $request->id;
            $remark->user_id = Auth::id();
            $remark->remarks = $details;
            $remark->save();

            $supp = AdminSupplyRequest::findOrFail($request->id);
            $supp->manager_action = 2;
            $supp->admin_action = 2;
            $supp->status = 3;
            $supp->save();

            $user = User::findOrFail($supp->user_id);

            try {
                broadcast(new SendToAdminDept($supp, $user))->toOthers();
            } catch (\Exception $e) {
                // catch
            }
            // if($supp->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_deny','Denied');
            // }else{
            return redirect()->back()->with('is_deny', 'Denied');
            // }
        }
        if ($sub == 4) {
            if (!empty($request->details)) {
                $details = $request->details;
            } else {
                $details = 'Approved!';
            }
            $remark = new AdminSupplyRequestRemark();
            $remark->admin_supply_request_id = $request->id;
            $remark->user_id = Auth::id();
            $remark->remarks = $details;
            $remark->save();

            $supp = AdminSupplyRequest::findOrFail($request->id);
            $supp->admin_action = 1;
            $supp->admin = Auth::id();
            $supp->status = 2;
            $supp->save();

            $user = User::findOrFail($supp->user_id);

            try {
                broadcast(new ApproveByAdminDept($supp, $user))->toOthers();
            } catch (\Exception $e) {
                // catch
            }
        }

        return redirect()->back()->with('is_success', 'Remarks Added');
    }

    public function managerindex()
    {
        $supps = AdminSupplyRequest::findBySuperior(Auth::id());

        return view('supply_req.supindex', compact('supps'));
    }

    public function headindex()
    {
        // $supps = AdminSupplyRequest::findBySuperior(Auth::id());
        $supps = AdminSupplyRequest::getMyDepartment(Auth::user()->dept_id);
        // dd($supps);
        return view('supply_req.supindex', compact('supps'));
    }

    public function managerview($id)
    {
        $supp = AdminSupplyRequest::findOrFailWithDetails($id);

        $items = AdminSupplyRequestDetail::findByAdminRequestId($supp->id);

        $routings = AdminSupplyRequestRemark::findByAdminRequestId($supp->id);

        $categs = SupplyMaintenance::getCategories();
        return view('supply_req.manager_details', compact('supp', 'items', 'routings', 'categs'));
    }

    public function headview($id)
    {
        $supp = AdminSupplyRequest::findOrFailWithDetails($id);

        $items = AdminSupplyRequestDetail::findByAdminRequestId($supp->id);

        $routings = AdminSupplyRequestRemark::findByAdminRequestId($supp->id);

        $categs = SupplyMaintenance::getCategories();

        return view('supply_req.manager_details', compact('supp', 'items', 'routings', 'categs'));
    }

    public function cancel(Request $request)
    {
        $supp = AdminSupplyRequest::findOrFail($request->id);
        if (!empty($supp)) {
            if ($supp->manager_action == 0) {
                $supp->status = 5;
                $supp->manager_action = 5;
                $supp->admin_action = 5;
                $supp->save();

                return \Response::json(['type' => '1']);
            } else {
                return \Response::json(['type' => '2']);
            }
        }
        return \Response::json(['type' => '3']);
    }

    public function adminindex()
    {
        $supps = AdminSupplyRequest::getAllForAdmin();
        $forsuperiors = AdminSupplyRequest::getAllForSuperior();
        return view('supply_req.adminindex', compact('supps', 'forsuperiors'));
    }

    public function adminview($id)
    {
        $supp = AdminSupplyRequest::findOrFailWithDetails($id);

        $items = AdminSupplyRequestDetail::findByAdminRequestId($supp->id);

        $routings = AdminSupplyRequestRemark::findByAdminRequestId($supp->id);

        $categs = SupplyMaintenance::getCategories();
        return view('supply_req.admin_details', compact('supp', 'items', 'routings', 'categs'));
    }

    public function adminreleasing($id)
    {
        $item = AdminSupplyRequestDetail::findOrFail($id);
        $req = AdminSupplyRequest::findOrFail($item->admin_supply_request_id);
        if (!empty($req)) {
            $user = User::findOrFail($req->user_id);
        } else {
            $user = '';
        }
        $num = $item->qty;
        $count = 0;
        while ($num != $count) {
            $count++;
            $qtys[] = $count;
        }

        return view('supply_req.admin_releasing', compact('item', 'qtys', 'user'));
    }

    public function release(Request $request)
    {
        $item = AdminSupplyRequestDetail::findOrFail($request->id);
        if (!empty($item)) {
            $item->qty_r = $request->qty_r;
            $item->status = 2;
            $item->save();

            $others = AdminSupplyRequestDetail::getPendings($item->admin_supply_request_id);
            if (empty($others)) {
                $req = AdminSupplyRequest::findOrFail($item->admin_supply_request_id);
                if (!empty($req)) {
                    $req->admin_action = 1;
                    $req->admin = Auth::id();
                    $req->status = 2;
                    $req->save();
                }
                return redirect('supplies_request_admin/' . $item->admin_supply_request_id . '/details')->with('is_success', 'Released');
            }
        }
        return redirect('supplies_request_admin/' . $item->admin_supply_request_id . '/details')->with('is_success', 'Released');
    }

    public function release_all($id)
    {
        $result = "E";
        $qty = Input::get("qty");
        $main_id = Input::get("id");

        $item = AdminSupplyRequestDetail::findOrFail($main_id);
        if (!empty($item)) {
            $item->qty_r = $qty;
            $item->status = 2;
            $item->save();

            $result = "S";

            $others = AdminSupplyRequestDetail::getPendings($item->admin_supply_request_id);
            if (empty($others)) {
                $req = AdminSupplyRequest::findOrFail($item->admin_supply_request_id);
                if (!empty($req)) {

                    $req->admin_action = 1;
                    $req->admin = Auth::id();
                    $req->status = 2;
                    $req->save();

                    $result = "S";
                } else {
                    $result = "E";
                }
                return response()->json($result);
            }
        }

        return response()->json($result);
    }

    public function release_all_items($id)
    {
        $result = "E";
        $request_id = Input::get('id');

        $items = AdminSupplyRequestDetail::findByAdminRequestId($request_id);

        if (!empty($items)) {
            foreach ($items as $item) {

                $qty = $item->qty_a;
                if (!$item->qty_r) {
                    $item->qty_r = $item->status !== 3 ? $qty : 0;
                }
                $item->status = $item->status !== 3 ? 2 : 3;
                $item->save();
            }

            $others = AdminSupplyRequestDetail::getPendings($request_id);
            if ($others->isEmpty()) {
                $req = AdminSupplyRequest::where("id", $request_id)->firstOrFail();
                if (!empty($req)) {
                    $req->admin_action = 1;
                    $req->admin = Auth::id();
                    $req->status = 2;
                    $req->save();

                    $result = "S";
                } else {
                    $result = "E";
                }
                return response()->json($result);
            }
        }

        return response()->json($result);
    }


    public function reject(Request $request)
    {
        $item = AdminSupplyRequestDetail::findOrFail($request->id);
        if (!empty($item)) {
            $item->status = 3;
            $item->save();

            $others = AdminSupplyRequestDetail::getPendings($item->admin_supply_request_id);
            if ($others->isEmpty()) {
                $req = AdminSupplyRequest::findOrFail($item->admin_supply_request_id);
                if (!empty($req)) {
                    $req->manager_action = 2;
                    $req->admin = Auth::id();
                    $req->status = 3;
                    $req->save();

                    return \Response::json(['type' => '1']);
                }
            }
        }
        return \Response::json(['type' => '3']);
    }

    public function other_details(Request $request)
    {
        $req = AdminSupplyRequest::findOrFail($request->id);
        if (!empty($req)) {
            $req->via = $request->via;
            $req->deliver = $request->deliver;
            $req->value = $request->value;
            $req->received_by = strtoupper($request->received_by);
            $req->save();

            return redirect()->back()->with('other_save', 'Saved');
        }
        return redirect()->back()->with('other_save_not', 'Error');
    }

    public function edit_item_quantity($id)
    {
        $result = "E";
        $type = Input::get("type");
        $newqty = Input::get("newqty");
        $main_id = Input::get("id");
        $item = AdminSupplyRequestDetail::findByIdFirst($main_id);

        if (!empty($item)) {
            if ($type === '1') {
                $item->qty = $newqty;
            } else {
                $item->qty_a = $newqty;
            }
            $item->save();
            $result = "S";
        }

        return response()->json($result);
    }

    public function downloadPDF($reqno, $uid)
    {
        $supp = AdminSupplyRequest::findByReqNo($reqno);
        if (!empty($supp)) {

            $details = AdminSupplyRequestDetail::findByReqId($supp->id);
            $user = User::findOrFail($uid);

            $employee_name = strtoupper($user->first_name . ' ' . $user->last_name);
            $position = strtoupper($user->position);
            $department = strtoupper($user->department->department);
            $company = strtoupper($user->company);


            $pdf = App::make('dompdf.wrapper');

            $view = \View::make('pdf.supply', compact('supp', 'details',  'employee_name',  'position',  'department',  'company'))->render();
            $pdf->loadHTML($view);
            $customPaper = array(0, 0, 700, 1000);
            $pdf->setPaper($customPaper);
            return @$pdf->stream();
            // return view( 'pd f .suppl y', compact( 'sup p',  'detail s',  'employee_nam e',  'positio n',  'departmen t',  'compan y'));
        } else {
            return view('errors.503');
        }
    }

    public function addNewItem(Request $request, AdminSupplyRequestDetail $adminSupplyRequestDetail)
    {
        $data = $this->validate($request, [
            "supply_request_id" => "required",
            "qty" => "required|numeric",
            "item_measure" => "required",
            "item" => "required",
        ]);

        if (!$data) {
            $adminSupplyRequestDetail->admin_supply_request_id = $request->supply_request_id;
            $adminSupplyRequestDetail->qty = $request->qty;
            $adminSupplyRequestDetail->measurement = $request->item_measure;
            $adminSupplyRequestDetail->item = $request->item;
            $adminSupplyRequestDetail->status =  ' 1';
            $adminSupplyRequestDetail->save();
            return back()->with('is_succes s',  'Item Successfully Ad ded!');
        }
    }

    public function remove_item()
    {

        $result = "E";
        $main_id = Input::get("id");
        $item = AdminSupplyRequestDetail::findByIdFirst($main_id);
        if (!empty($item)) {
            $item->delete();
            $result = "S";
        }

        return response()->json($result);
    }
}
