<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;
use App\GatePass;
use App\GatePassDetail;
use App\GatePassFile;
use App\GatePassRemark;
use App\AssetTracking;
use App\BorrowerSlip;
use App\AccessControl;
use App\Events\NewGatePass;
use App\Events\GatePassMoveToManager;
use App\Events\GatePassMoveToGuard;
use App\Events\GatePassApproved;
use App\Events\GatePassForClosing;
use App\User;
use Auth;
use Session;
use App;

class GatePassController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $assets = AssetTracking::getAllMine($user->id);
        $non_assets = BorrowerSlip::getMine($user->id);
        $gates = [
            'GATE 1',
            'GATE 2',
            'GATE 3',
            'GATE 4'
        ];
        $gps = GatePass::getMine($user->id);

        if (date('H:i') > date('H:i', strtotime('15:59'))) {
            return view('gatepass.index', compact('user', 'non_assets', 'gps', 'gates'))->with('is_overtime', 'Overtime');
        } else {
            return view('gatepass.index', compact('user', 'non_assets', 'gps', 'gates'));
        }
    }

    public function addNewItem(Request $request, GatePassDetail $gatePassDetail)
    {
        $data = $this->validate($request, [
            "gate_pass_id" => "required",
            "item_no" => "required",
            "item_qty" => "required|numeric",
            "item_measure" => "required",
            "description" => "required",
            "description2" => "required",
            "remarks" => "required",
        ]);

        if (!$data) {
            $gatePassDetail->gate_pass_id = $request->gate_pass_id;
            $gatePassDetail->item_no = $request->item_no;
            $gatePassDetail->item_qty = $request->item_qty;
            $gatePassDetail->item_measure = $request->item_measure;
            $gatePassDetail->description = $request->description;
            $gatePassDetail->description2 = $request->description2;
            $gatePassDetail->remarks = $request->remarks;
            $gatePassDetail->save();
            return back()->with('is_success', 'Item Successfully Added!');
        }
    }

    public function store(Request $request)
    {
        $gpass = new GatePass();
        $gpass->req_no = "ASD-GP-";
        $gpass->user_id = Auth::user()->id;
        $gpass->company = strtoupper(Auth::user()->company);
        $gpass->department = strtoupper(Auth::user()->department->department);
        $gpass->ref_no = strtoupper($request->ref_no);
        $gpass->purpose = $request->purpose;
        $gpass->date = date('Y-m-d');
        $gpass->exit_gate_no = strtoupper($request->exit_gate_no);
        $gpass->requested_by = strtoupper($request->requested_by);
        $gpass->control_no = 0;
        $gpass->save();

        $nstrlength = 6;
        $nstr = substr(str_repeat(0, $nstrlength) . $gpass->id, -$nstrlength);
        $gpass->control_no = $nstr;
        $gpass->update();

        if ($request->hasFile('attached')) {
            $files = Input::file('attached');
            $dPath = public_path() . '/uploads/gatepass/files/' . $gpass->id . '/';
            if (!\File::exists($dPath)) {
                mkdir($dPath, 0755, true);
            }
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();

                $nameOfFile = $filename;

                $hashname = \Hash::make($nameOfFile);

                $enc = str_replace("/", "", $hashname);

                // move_uploaded_file($dPath, $nameOfFile);
                $file->move($dPath, $nameOfFile);

                $gfile = new GatePassFile();
                $gfile->gate_pass_id = $gpass->id;
                $gfile->filename = $nameOfFile;
                $gfile->user_id = Auth::id();
                $gfile->save();
            }
        }

        if (!empty($request->det)) {
            $dets = explode(',', $request->get('det'));
            foreach ($dets as $det) {
                $subs = explode('|', $det);
                $detail = new GatePassDetail();
                $detail->gate_pass_id = $gpass->id;
                $detail->item_no = $subs[0];
                $detail->item_qty = $subs[1];
                $detail->item_measure = $subs[2];
                $detail->description = $subs[3];
                $detail->description2 = $subs[4];
                $detail->remarks = $subs[5];
                $detail->save();
            }
        }
        if (!empty($request->nadet)) {
            $na_dets = explode(',', $request->get('nadet'));
            foreach ($na_dets as $na_det) {
                $subs = explode('|', $na_det);
                $detail = new GatePassDetail();
                $detail->gate_pass_id = $gpass->id;
                $detail->item_no = $subs[0];
                $detail->item_qty = $subs[1];
                $detail->item_measure = $subs[2];
                $detail->description = $subs[3];
                $detail->description2 = $subs[4];
                $detail->remarks = $subs[5];
                $detail->save();
            }
        }

        $strlength = 6;
        $str = substr(str_repeat(0, $strlength) . $gpass->id, -$strlength);
        $gpass->req_no = "ASD-GP-" . $str;
        $gpass->update();

        $module = 73;
        $acss = AccessControl::findByModule($module);
        foreach ($acss as $acs) {
            $user = User::findOrFail($acs->user_id);
            try {
                // broadcast(new GatePassMoveToManager($gpass, $user))->toOthers();
                broadcast(new NewGatePass($gpass, $user))->toOthers();
            } catch (\Exception $e) { }
        }
        return back()->with('is_success', 'Saved!');
    }

    public function show($id)
    {
        $gatepass = GatePass::findOrFail($id);
        if (!empty($gatepass)) {
            $details = GatePassDetail::getByGatePassId($gatepass->id);
            $routings = GatePassRemark::getByGatePassId($gatepass->id);
            $files = GatePassFile::getByGatePassId($gatepass->id);

            switch ($gatepass->exit_gate_no) {
                case '0':
                    $gatepass->exit_gate_no = 'GATE 1';
                    break;

                case '1':
                    $gatepass->exit_gate_no = 'GATE 2';
                    break;

                case '2':
                    $gatepass->exit_gate_no = 'GATE 3';
                    break;
                case '3':
                    $gatepass->exit_gate_no = 'GATE 4';
                    break;

                default:

                    break;
            }

            return view('gatepass.details', compact('gatepass', 'details', 'routings', 'files'));
        } else {
            return back()->with('is_error', 'Error');
        }
    }
    public function edit_gatepass_item_quantity($id)
    {
        $result = "E";
        $newqty = Input::get("newqty");
        $main_id = Input::get("id");
        $item = GatePassDetail::findByIdFirst($main_id);

        if (!empty($item)) {
            $item->item_qty = $newqty;
            $item->save();
            $result = "S";
        }

        return response()->json($result);
    }

    public function remarks(Request $request)
    {
        $gatepass = GatePass::findOrFail($request->id);
        $sub = $request->sub;
        if (!empty($gatepass)) {
            if ($sub < 2) {
                if (!empty($request->remarks)) {
                    $remark = new GatePassRemark();
                    $remark->user_id = Auth::id();
                    $remark->gate_pass_id = $gatepass->id;
                    $remark->remark = nl2br($request->remarks);
                    $remark->save();

                    return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
                }
                return redirect()->back()->with('is_null_remark', 'Error');
            }
            if ($sub == 2) {
                if (!empty($request->remarks)) {
                    $remark = new GatePassRemark();
                    $remark->user_id = Auth::id();
                    $remark->gate_pass_id = $gatepass->id;
                    $remark->remark = nl2br($request->remarks);
                    $remark->save();
                }

                $gatepass->issue_by = Auth::user()->id;
                $gatepass->save();

                // try {
                //     broadcast(new GatePassApproved($gatepass))->toOthers();
                // } catch (Exception $e) {

                // }

                // $module = 74;
                // $acss = AccessControl::findByModule($module);
                // foreach ($acss as $acs) {
                //     $user = User::findOrFail($acs->user_id);
                //     try{
                //         broadcast(new GatePassMoveToManager($gatepass, $user))->toOthers();
                //     }catch(\Exception $e){

                //     }
                // }

                return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
            }

            if ($sub == 3) {
                if (!empty($request->remarks)) {
                    $remark = new GatePassRemark();
                    $remark->user_id = Auth::id();
                    $remark->gate_pass_id = $gatepass->id;
                    $remark->remark = nl2br($request->remarks);
                    $remark->save();
                }

                $gatepass->issue_by = Auth::user()->id;
                $gatepass->approval = 3;
                $gatepass->status = 3;
                $gatepass->save();

                // try {
                //     broadcast(new GatePassApproved($gatepass))->toOthers();
                // } catch (Exception $e) {

                // }

                return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
            }

            if ($sub == 4) {
                if (!empty($request->remarks)) {
                    $remark = new GatePassRemark();
                    $remark->user_id = Auth::id();
                    $remark->gate_pass_id = $gatepass->id;
                    $remark->remark = nl2br($request->remarks);
                    $remark->save();
                }

                $gatepass->approval = 1;
                // $gatepass->issue_by = Auth::user()->id;
                $gatepass->approve_for_release = Auth::id();
                $gatepass->save();

                try {
                    broadcast(new GatePassApproved($gatepass))->toOthers();
                } catch (Exception $e) { }

                $module = 74;
                $acss = AccessControl::findByModule($module);
                foreach ($acss as $acs) {
                    $user = User::findOrFail($acs->user_id);
                    try {
                        broadcast(new GatePassMoveToManager($gatepass, $user))->toOthers();
                    } catch (\Exception $e) { }
                }

                return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
            }

            if ($sub == 5) {
                if (!empty($request->checked_by)) {
                    $gatepass->checked_by = strtoupper($request->checked_by);
                    $gatepass->received_by = $gatepass->user_id;
                    $gatepass->save();

                    try {
                        broadcast(new GatePassApproved($gatepass))->toOthers();
                    } catch (Exception $e) { }

                    // $module = 73;
                    // $acss = AccessControl::findByModule($module);
                    // foreach ($acss as $acs) {
                    //     $user = User::findOrFail($acs->user_id);
                    //     try{
                    //         broadcast(new GatePassForClosing($gatepass, $user))->toOthers();
                    //     }catch(\Exception $e){

                    //     }
                    // }
                    return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
                }
                return back()->with('name_is_error', 'Error');
            }

            if ($sub == 6) {
                // $gatepass->status = 2;
                $gatepass->issue_by = Auth::id();
                $gatepass->save();

                try {
                    broadcast(new GatePassApproved($gatepass))->toOthers();
                } catch (Exception $e) { }

                $module = 74;
                $acss = AccessControl::findByModule($module);
                foreach ($acss as $acs) {
                    $user = User::findOrFail($acs->user_id);
                    try {
                        broadcast(new GatePassForClosing($gatepass, $user))->toOthers();
                    } catch (\Exception $e) {
                        dd($e);
                        die;
                    }
                }

                return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
            }

            if ($sub == 7) {
                $gatepass->status = 2;
                // $gatepass->issue_by = Auth::id();
                $gatepass->save();

                try {
                    broadcast(new GatePassApproved($gatepass))->toOthers();
                } catch (Exception $e) { }
                return redirect()->back()->with('is_saved', 'Remarks Succesfully Added!');
            }
        }
    }

    public function admin_list()
    {
        $gps = GatePass::getForIssuing();
        $cgps = GatePass::getForClosing();

        return view('gatepass.admin_list', compact('gps', 'cgps'));
    }

    public function admin_details($id)
    {
        $gatepass = GatePass::findOrFail($id);
        if (!empty($gatepass)) {
            $details = GatePassDetail::getByGatePassId($gatepass->id);
            $routings = GatePassRemark::getByGatePassId($gatepass->id);
            $files = GatePassFile::getByGatePassId($gatepass->id);

            switch ($gatepass->exit_gate_no) {
                case '0':
                    $gatepass->exit_gate_no = 'GATE 1';
                    break;

                case '1':
                    $gatepass->exit_gate_no = 'GATE 2';
                    break;

                case '2':
                    $gatepass->exit_gate_no = 'GATE 3';
                    break;
                case '3':
                    $gatepass->exit_gate_no = 'GATE 4';
                    break;

                default:

                    break;
            }

            return view('gatepass.admin_details', compact('gatepass', 'details', 'routings', 'files'));
        } else {
            return back()->with('is_error', 'Error');
        }
    }

    public function admin_manager_list()
    {
        $gps = GatePass::getForApproval();

        return view('gatepass.admin_manager_list', compact('gps'));
    }

    public function admin_manager_details($id)
    {
        $gatepass = GatePass::findOrFail($id);

        if (!empty($gatepass)) {
            $details = GatePassDetail::getByGatePassId($gatepass->id);
            $routings = GatePassRemark::getByGatePassId($gatepass->id);
            $files = GatePassFile::getByGatePassId($gatepass->id);

            switch ($gatepass->exit_gate_no) {
                case '0':
                    $gatepass->exit_gate_no = 'GATE 1';
                    break;

                case '1':
                    $gatepass->exit_gate_no = 'GATE 2';
                    break;

                case '2':
                    $gatepass->exit_gate_no = 'GATE 3';
                    break;
                case '3':
                    $gatepass->exit_gate_no = 'GATE 4';
                    break;

                default:

                    break;
            }

            return view('gatepass.admin_manager_details', compact('gatepass', 'details', 'routings', 'files'));
        } else {
            return back()->with('is_error', 'Error');
        }
    }

    public function guard_admin_list()
    {
        $gps = GatePass::getForGuard();

        return view('gatepass.guard_list', compact('gps'));
    }

    public function guard_details($id)
    {
        $gatepass = GatePass::findOrFail($id);
        if (!empty($gatepass)) {
            $details = GatePassDetail::getByGatePassId($gatepass->id);
            $routings = GatePassRemark::getByGatePassId($gatepass->id);
            $files = GatePassFile::getByGatePassId($gatepass->id);
            return view('gatepass.guard_details', compact('gatepass', 'details', 'routings', 'files'));
        } else {
            return back()->with('is_error', 'Error');
        }
    }

    public function download(Request $request)
    {
        $filename = $request->filename;
        $file = GatePassFile::where('gate_pass_id', $request->id)->where('filename', $filename)->first();

        if (!empty($file)) {
            $file_down = public_path() . '/uploads/gatepass/files/' . $request->id . '/' . $file->filename;

            return Response::download($file_down);
        } else {
            return back()->with('is_error', 'Error');
        }
    }

    public function cancel($id)
    {
        $result;
        $type = Input::get("type");

        $gpass = GatePass::findOrFail($id);

        if (!empty($user_acss)) {
            return view('errors.909', compact('id'));
        } else {
            $gpass->status = 5;
            $gpass->save();
            $result = 'is_canceled';
            Session::put('is_canceled', 'Canceled');
        }

        if ($type == "0") {
            return Response::json(['is_canceled' => true, 'url' => route('gatepass.index')]);
        } else {
            return Response::json(['is_canceled' => true, 'url' => route('gatepass.m_admin_list')]);
        }
    }

    public function downloadPDF($gpid, $uid)
    {
        $gatepass = GatePass::findOrFail($gpid);
        $user = User::findOrFail($uid);
        $details = GatePassDetail::getByGatePassId($gatepass->id);

        if (!empty($gatepass)) {
            $employee_name = strtoupper($user->first_name . ' ' . $user->last_name);
            $position = strtoupper($user->position);
            $department = strtoupper($user->department->department);
            $company = strtoupper($user->company);


            $pdf = App::make('dompdf.wrapper');

            $view = \View::make('pdf.gatepass', compact('gatepass', 'employee_name', 'position', 'department', 'details', 'company'))->render();
            $pdf->loadHTML($view);
            $customPaper = array(0, 0, 700, 1000);
            $pdf->setPaper($customPaper);
            return @$pdf->stream();
        } else {
            return view('errors.503');
        }
    }
}
