<?php

namespace App\Http\Controllers;

use App\AssetRequest;
use App\AssetRequestRemark;
use App\AssetRequestRemarkFile;
use Illuminate\Support\Facades\Input;
use Response;
use Auth;
use App\AssetTracking;
use Illuminate\Http\Request;
use App\AssetRequestDetail;
use App\BorrowerSlip;
use App\User;
use App\AssetReport;
use App\AccessControl;
use App\AssetBorrowHistory;
use App\Events\AssetReqSent;
use App\Events\AdminDashboardLoader;
use App\Events\SuperiorAssetSent;
use App\Events\AssetReqApproved;
use App\Events\AssetRequested;
use App;

class AssetRequestController extends Controller
{
    public function index()
    {

        $assets = AssetTracking::getList();
        // $ass_reqs = AssetRequest::myRequest(Auth::id());
        $user = Auth::user();
        return view('assets.request', compact('assets', 'user'));
    }

    public function store(Request $request)
    {
        $curr_user = Auth::user();
        if (!empty($request->det) || !empty($request->nadet)) {
            if ($curr_user->superior != 0) {
                if (!empty($request->borrower_name)) {
                    $borrower = strtoupper($request->borrower_name);
                } else {
                    $borrower = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                }
                $asset_req = new AssetRequest();
                $asset_req->user_id = Auth::id();
                $asset_req->details = $request->details;
                $asset_req->borrower_name = $borrower;
                $asset_req->solve_by = 0;
                $asset_req->req_no = "ASD-BS-";
                $asset_req->status = 1;
                $asset_req->sup_action = 1;
                $asset_req->superior = Auth::user()->superior;
                $asset_req->save();

                $strlength = 6;
                $str = substr(str_repeat(0, $strlength) . $asset_req->id, -$strlength);
                $asset_req->req_no = "ASD-BS-" . $str;
                $asset_req->update();

                $randomchars = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

                if ($request->det != '') {
                    $dets = explode(',', $request->get('det'));
                    if (!empty($dets)) {

                        foreach ($dets as $det) {

                            $subs = explode('-', $det);
                            if (!empty($subs[0]) and !empty($subs[1])) {
                                $assetDet = new AssetRequestDetail();
                                $assetDet->asset_request_id = $asset_req->id;
                                $assetDet->item_name = $subs[0];
                                $assetDet->qty = $subs[1];
                                $assetDet->save();

                                for ($i = 0; $i < $subs[1]; $i++) {
                                    $bSlip = new BorrowerSlip();
                                    $bSlip->asset_request_no = $asset_req->req_no;
                                    $bSlip->must_date = date('Y-m-d', strtotime($request->must_date));
                                    $bSlip->date_needed = date('Y-m-d', strtotime($request->date_needed));
                                    $bSlip->item = $subs[0];
                                    $bSlip->borrow_code = $randomchars;
                                    $bSlip->is_asset = 1;
                                    $bSlip->qty = 1;
                                    $bSlip->get_by = $request->get_by;
                                    $bSlip->save();
                                }
                            } else {
                                $details = AssetRequestDetail::where('asset_request_id', $asset_req->id)->get();
                                if (!empty($details)) {
                                    foreach ($details as $detail) {
                                        $detail->status = 5;
                                        $detail->update();
                                    }
                                }
                                $slips = BorrowerSlip::where('asset_request_no', $asset_req->req_no)->get();
                                if (!empty($slips)) {
                                    foreach ($slips as $sp) {
                                        $sp->delete();
                                    }
                                }
                                $asset_req->status = 5;
                                $asset_req->update();
                                return redirect()->back()->with('is_error', 'Error in requesting');
                            }
                        }
                    }
                }
                if ($request->nadet != '') {
                    $nadets = explode(',', $request->get('nadet'));
                    if (!empty($nadets)) {
                        foreach ($nadets as $nadet) {

                            $subs = explode('-', $nadet);
                            if (!empty($subs[0]) and !empty($subs[1])) {
                                $assetDet = new AssetRequestDetail();
                                $assetDet->asset_request_id = $asset_req->id;
                                $assetDet->item_name = strtoupper($subs[0]);
                                $assetDet->qty = $subs[1];
                                $assetDet->save();

                                $bSlip = new BorrowerSlip();
                                $bSlip->asset_request_no = $asset_req->req_no;
                                $bSlip->must_date = date('Y-m-d', strtotime($request->must_date));
                                $bSlip->date_needed = date('Y-m-d', strtotime($request->date_needed));
                                $bSlip->item = strtoupper($subs[0]);
                                $bSlip->borrow_code = $randomchars;
                                $bSlip->is_asset = 0;
                                $bSlip->qty = $subs[1];
                                $bSlip->get_by = $request->get_by;
                                $bSlip->save();
                            } else {
                                $details = AssetRequestDetail::where('asset_request_id', $asset_req->id)->get();
                                if (!empty($details)) {
                                    foreach ($details as $detail) {
                                        $detail->status = 5;
                                        $detail->update();
                                    }
                                }
                                $slips = BorrowerSlip::where('asset_request_no', $asset_req->req_no)->get();
                                if (!empty($slips)) {
                                    foreach ($slips as $sp) {
                                        $sp->delete();
                                    }
                                }
                                $asset_req->status = 5;
                                $asset_req->update();
                                return redirect()->back()->with('is_error', 'Error in requesting');
                            }
                        }
                    }
                }
                try {
                    broadcast(new SuperiorAssetSent($asset_req, $curr_user))->toOthers();
                    broadcast(new AdminDashboardLoader($asset_req))->toOthers();
                    $id = 54;
                    $acss = AccessControl::findByModule($id);
                    foreach ($acss as $acs) {
                        $user = User::findUserByidandDeptid($acs->user_id, $curr_user->dept_id);
                        try {
                            broadcast(new AssetRequested($asset_req, $user))->toOthers();
                        } catch (\Exception $e) { }
                    }
                } catch (\Exception $e) { }
                return back()->with('is_success', 'Saved!');
            } else {
                if (!empty($request->borrower_name)) {
                    $borrower = strtoupper($request->borrower_name);
                } else {
                    $borrower = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                }
                $asset_req = new AssetRequest();
                $asset_req->user_id = Auth::id();
                $asset_req->details = $request->details;
                $asset_req->borrower_name = $borrower;
                $asset_req->solve_by = 0;
                $asset_req->req_no = "ASD-BS-";
                $asset_req->status = 1;
                $asset_req->sup_action = 2;
                $asset_req->superior = Auth::user()->id;
                $asset_req->save();

                $strlength = 6;
                $str = substr(str_repeat(0, $strlength) . $asset_req->id, -$strlength);
                $asset_req->req_no = "ASD-BS-" . $str;
                $asset_req->update();

                $randomchars = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

                if ($request->det != '') {
                    $dets = explode(',', $request->get('det'));
                    if (!empty($dets)) {

                        foreach ($dets as $det) {

                            $subs = explode('-', $det);

                            if (!empty($subs[0]) and !empty($subs[1])) {
                                $assetDet = new AssetRequestDetail();
                                $assetDet->asset_request_id = $asset_req->id;
                                $assetDet->item_name = $subs[0];
                                $assetDet->qty = $subs[1];
                                $assetDet->save();

                                for ($i = 0; $i < $subs[1]; $i++) {
                                    $bSlip = new BorrowerSlip();
                                    $bSlip->asset_request_no = $asset_req->req_no;
                                    $bSlip->must_date = date('Y-m-d', strtotime($request->must_date));
                                    $bSlip->date_needed = date('Y-m-d', strtotime($request->date_needed));
                                    $bSlip->item = $subs[0];
                                    $bSlip->borrow_code = $randomchars;
                                    $bSlip->is_asset = 1;
                                    $bSlip->qty = 1;
                                    $bSlip->get_by = strtoupper($request->get_by);
                                    $bSlip->save();
                                }
                            } else {
                                $details = AssetRequestDetail::where('asset_request_id', $asset_req->id)->get();
                                if (!empty($details)) {
                                    foreach ($details as $detail) {
                                        $detail->status = 5;
                                        $detail->update();
                                    }
                                }
                                $slips = BorrowerSlip::where('asset_request_no', $asset_req->req_no)->get();
                                if (!empty($slips)) {
                                    foreach ($slips as $sp) {
                                        $sp->delete();
                                    }
                                }
                                $asset_req->status = 5;
                                $asset_req->update();
                                return redirect()->back()->with('is_error', 'Error in requesting');
                            }
                        }
                    }
                }
                if ($request->nadet != '') {
                    $nadets = explode(',', $request->get('nadet'));
                    if (!empty($nadets)) {
                        foreach ($nadets as $nadet) {
                            $subs = explode('-', $nadet);
                            if (!empty($subs[0]) and !empty($subs[1])) {
                                $assetDet = new AssetRequestDetail();
                                $assetDet->asset_request_id = $asset_req->id;
                                $assetDet->item_name = strtoupper($subs[0]);
                                $assetDet->qty = $subs[1];
                                $assetDet->save();

                                $bSlip = new BorrowerSlip();
                                $bSlip->asset_request_no = $asset_req->req_no;
                                $bSlip->must_date = date('Y-m-d', strtotime($request->must_date));
                                $bSlip->date_needed = date('Y-m-d', strtotime($request->date_needed));
                                $bSlip->item = strtoupper($subs[0]);
                                $bSlip->borrow_code = $randomchars;
                                $bSlip->is_asset = 0;
                                $bSlip->qty = $subs[1];
                                $bSlip->get_by = $request->get_by;
                                $bSlip->save();
                            } else {
                                $details = AssetRequestDetail::where('asset_request_id', $asset_req->id)->get();
                                if (!empty($details)) {
                                    foreach ($details as $detail) {
                                        $detail->status = 5;
                                        $detail->update();
                                    }
                                }
                                $slips = BorrowerSlip::where('asset_request_no', $asset_req->req_no)->get();
                                if (!empty($slips)) {
                                    foreach ($slips as $sp) {
                                        $sp->delete();
                                    }
                                }
                                $asset_req->status = 5;
                                $asset_req->update();
                                return redirect()->back()->with('is_error', 'Error in requesting');
                            }
                        }
                    }
                }
                try {
                    broadcast(new AssetReqSent($asset_req, $curr_user))->toOthers();
                    broadcast(new AdminDashboardLoader($asset_req))->toOthers();
                } catch (\Exception $e) {
                    return back()->with('is_success', 'Saved!');
                }
                return back()->with('is_success', 'Saved!');
            }
        }
        return back()->with('is_error', 'Error!');
    }

    public function asset_req_list()
    {

        $user_acc_total = AssetRequest::getTotal();
        $user_acc_ongoing = AssetRequest::getTotalOngoing();
        $user_acc_closed = AssetRequest::getTotalClosed();

        $asset_reqs = AssetRequest::where('sup_action', 2)->where('status', '<', 2)->orderBy('created_at', 'DESC')->get();
        return view('assets.asset_reqs_list', compact('asset_reqs', 'user_acc_total', 'user_acc_ongoing', 'user_acc_closed'));
    }

    public function downloadPDF($reqno, $uid)
    {
        ini_set('memory_limit', -1);
        $req = AssetRequest::findByReqNo($reqno);
        $slips = BorrowerSlip::findByReqId($reqno);
        $user = User::findOrFail($uid);

        if (!empty($req)) {


            $employee_name = strtoupper($user->first_name . ' ' . $user->last_name);
            $position = strtoupper($user->position);
            $department = strtoupper($user->department->department);
            $company = strtoupper($user->company);
            $bcode = strtoupper($req->slip->borrow_code);

            $pdf = App::make('dompdf.wrapper');

            $view = \View::make('pdf.borrower', compact('req', 'slips', 'employee_name', 'position', 'department', 'company', 'bcode'))->render();
            $pdf->loadHTML($view);
            $customPaper = array(0, 0, 700, 1000);
            $pdf->setPaper($customPaper);
            return @$pdf->stream();
        } else {
            return view('errors.503');
        }
    }

    public function details($id)
    {

        $asset_reqs = AssetRequest::ByTicket($id);
        $remarks = AssetRequestRemark::getList($id);

        return view('assets.request_details', compact('asset_reqs', 'remarks'));
    }

    public function remarks(Request $request)
    {


        $type = $request->get('sub');

        if ($type == 1) {

            $postdata = $request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['details'] = nl2br($request->get('remarks'));

            $remarks = new AssetRequestRemark($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/AdminHelpDesk/asset_request/' . $remarks->ticket_no . '/Remarks/';

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

                    $message_file = new AssetRequestRemarkFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }

            return redirect()->action('AssetRequestController@details', ['id' => $request->get('ticket_no')])->with('is_success', 'Saved');
        }
        if ($type == 2) {

            $postdata = $request->all();

            $postdata['remarks_by'] = Auth::id();
            $postdata['details'] = nl2br($request->get('remarks'));

            $remarks = new AssetRequestRemark($postdata);
            $remarks->save();

            $user_acss = AssetRequest::ByTicketSolve($remarks->ticket_no);
            $user_acss->status = 2;
            $user_acss->solve_by = Auth::id();
            $user_acss->update();

            $curr_user = User::findOrFail($user_acss->user_id);

            // $randomchars = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

            // $bSlip = BorrowerSlip::ByTicket($remarks->ticket_no);
            // foreach ($bSlip as $slip) {
            //     $slip->borrow_code = $randomchars;
            //     $slip->update();
            // }

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');


                $destinationPath = public_path() . '/uploads/AdminHelpDesk/asset_request/' . $remarks->ticket_no . '/Remarks/';

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

                    $message_file = new AssetRequestRemarkFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }
            try {
                broadcast(new AssetReqApproved($user_acss, $curr_user))->toOthers();
                broadcast(new AdminDashboardLoader($user_acss))->toOthers();
            } catch (\Exception $e) {
                return redirect()->action('AssetRequestController@details', ['id' => $request->get('ticket_no')])->with('is_closed', 'Saved');
            }
            return redirect()->action('AssetRequestController@details', ['id' => $request->get('ticket_no')])->with('is_closed', 'Saved');
        }
    }

    public function show()
    { }

    public function showrelease($id)
    {

        $bSlips = BorrowerSlip::ByTicket($id);
        $asset_reqs = AssetRequest::ByTicket($id);
        $remarks = AssetRequestRemark::getList($id);
        $returns = BorrowerSlip::ByTicketReturned($id);

        return view('assets.asset_reqs_release', ['bSlips' => $bSlips, 'asset_reqs' => $asset_reqs, 'remarks' => $remarks, 'returns' => $returns]);
    }

    public function itemrelease($id)
    {
        $bSlip = BorrowerSlip::where('id', $id)->first();
        $assets = AssetTracking::getItemByCategory($bSlip->item);
        $asset_reqs = AssetRequest::ByTicket($bSlip->asset_request_no);

        return view('assets.asset_reqs_releaseitem', compact('bSlip', 'assets', 'asset_reqs'));
    }

    public function release(Request $request)
    {
        $bSlip = BorrowerSlip::findOrFail($request->id);
        if ($request->code == $bSlip->borrow_code) {
            $asset = AssetTracking::findOrFail($request->rel_asset);
            $bSlip->asset_barcode = $asset->barcode;
            $bSlip->released = 1;
            $bSlip->qty_r = $bSlip->qty;
            $bSlip->accs = $request->accs;
            $bSlip->save();

            $asset->io = 0;
            $asset->holder = $request->user_id;
            $asset->save();

            $ass = AssetRequest::byReqNo($bSlip->asset_request_no);

            if (!empty($request->accs)) {
                $accessories = 'Released from Admin Dept. with ' . $request->accs;
            } else {
                $accessories = 'Released from Admin Dept.';
            }
            $history = new AssetBorrowHistory();
            $history->user_id = $asset->holder;
            $history->req_no = $bSlip->asset_request_no;
            $history->barcode = $bSlip->asset_barcode;
            $history->remarks = $accessories;
            $history->save();

            $reps = new AssetReport();
            $reps->req_no = $ass->req_no;
            $reps->user_id = $ass->user_id;
            $reps->solved_by = 0;
            $reps->bslip_id = $bSlip->id;
            $reps->barcode = $bSlip->asset_barcode;
            $reps->must_date = $bSlip->must_date;
            $reps->rel_date = date('Y-m-d');
            $reps->save();

            try {
                broadcast(new AdminDashboardLoader($asset))->toOthers();
            } catch (\Exception $e) {
                return redirect()->action('AssetRequestController@showrelease', ['id' => $bSlip->asset_request_no])->with('is_success', 'Released');
            }
            return redirect()->action('AssetRequestController@showrelease', ['id' => $bSlip->asset_request_no])->with('is_success', 'Released');
        } else {
            return redirect()->back()->with('is_wrong', 'error');
        }
    }

    public function reject(Request $request)
    {
        $bSlip = BorrowerSlip::findOrFail($request->id);
        if (!empty($bSlip)) {
            $bSlip->released = 2;
            $bSlip->update();

            return \Response::json(['type' => '1']);
        }
        return \Response::json(['type' => '3']);
    }

    public function return(Request $request)
    {
        $rep = AssetReport::byBarcodeAndReqNo($request->barcode, $request->rno, $request->id);
        if (!empty($rep)) {
            $rep->ret_date = date('Y-m-d');
            $rep->solved_by = Auth::id();
            $rep->save();
        }

        $bSlips1 = BorrowerSlip::findOrFail($request->id);
        if (!empty($bSlips1)) {
            $bSlips1->return_date = date('Y-m-d');
            $bSlips1->returned = 1;
            $bSlips1->received_by = Auth::id();
            $bSlips1->save();
        }

        $item = AssetTracking::where('barcode', $bSlips1->asset_barcode)->first();
        $item->io = 1;
        $item->holder = 27;
        $item->returned_date = date('Y-m-d');
        $item->save();

        if (!empty($request->missing)) {
            if ($request->missing != '') {
                $historyremarks = 'Returned to Admin Dept. with ' . $request->missing;
            } else {
                $historyremarks = 'Returned to Admin Dept.';
            }
        } else {
            $historyremarks = 'Returned to Admin Dept.';
        }
        $history = new AssetBorrowHistory();
        $history->user_id = $item->holder;
        $history->req_no = $bSlips1->asset_request_no;
        $history->barcode = $bSlips1->asset_barcode;
        $history->remarks = $historyremarks;
        $history->save();

        if (!empty($request->missing) || $request->missing == '') {
            $remark = new AssetRequestRemark();
            $remark->details = 'Missing:' . $item->barcode . '(' . $item->item_name . ')' . $request->missing;
            $remark->request_id = $request->id;
            $remark->ticket_no = $request->rno;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        $slips = BorrowerSlip::getAllNonReturned($bSlips1->asset_request_no);

        if ($slips == 0) {
            $ass = AssetRequest::byReqNo($bSlips1->asset_request_no);
            $ass->status = 2;
            $ass->solve_by = Auth::id();
            $ass->save();
        }

        return redirect()->back()->with('is_returned', 'Returned');
    }

    public function return_na(Request $request)
    {
        $id = $request->id;
        $bSlip = BorrowerSlip::findOrFail($id);
        if (!empty($bSlip)) {
            $bSlip->return_date = date('Y-m-d');
            $bSlip->returned = 1;
            $bSlip->received_by = Auth::id();
            $bSlip->save();
        }
        $rep = AssetReport::byBslipId($request->id);
        if (!empty($rep)) {
            $rep->ret_date = date('Y-m-d');
            $rep->solved_by = Auth::id();
            $rep->save();
        }
        $slips = BorrowerSlip::getAllNonReturned($bSlip->asset_request_no);
        if ($slips == 0) {
            $ass = AssetRequest::byReqNo($bSlip->asset_request_no);
            $ass->status = 2;
            $ass->solve_by = Auth::id();
            $ass->save();
        }

        return redirect()->back()->with('is_returned', 'Returned');
    }

    public function download_files(Request $request)
    {

        $encryptname = $request->get('encname');
        $file = AssetRequestRemarkFile::ByEncryptName($encryptname);

        $file_down = public_path() . '/uploads/AdminHelpDesk/asset_request/' . $file->ticket_no . '/Remarks/' . $file->filename;



        return Response::download($file_down);
    }

    public function mngrsup_asset_request_list()
    {
        $id = Auth::id();

        $user_acc_total = AssetRequest::getTotal();
        $user_acc_ongoing = AssetRequest::getTotalOngoing();
        $user_acc_closed = AssetRequest::getTotalClosed();
        $asset_reqs = AssetRequest::BySuperior($id);

        return view('assets.mngr_asset_list', compact('asset_reqs', 'user_acc_total', 'user_acc_ongoing', 'user_acc_closed'));
    }

    public function dept_mng_asset_request_list()
    {
        $id = Auth::user()->dept_id;

        $asset_reqs = AssetRequest::byDeptId($id);

        return view('dept_manager.asset_req_list', compact('asset_reqs'));
    }

    public function mngr_details($id)
    {
        $asset_reqs = AssetRequest::ByTicket($id);
        $remarks = AssetRequestRemark::getList($id);

        return view('assets.mngr_asset_details', compact('asset_reqs', 'remarks'));
    }

    public function dept_mng_details($id)
    {
        $asset_reqs = AssetRequest::ByTicket($id);
        $remarks = AssetRequestRemark::getList($id);

        return view('dept_manager.asset_req_details', compact('asset_reqs', 'remarks'));
    }

    public function mngr_remarks(Request $request)
    {
        $type = $request->get('sub');

        if ($type == 1) {
            if (!empty($request->remarks)) {
                $postdata = $request->all();

                $postdata['remarks_by'] = Auth::id();
                $postdata['details'] = nl2br($request->get('remarks'));

                $remarks = new AssetRequestRemark($postdata);
                $remarks->save();

                if ($request->hasFile('attached')) {

                    $files = Input::file('attached');

                    $destinationPath = public_path() . '/uploads/AdminHelpDesk/asset_request/' . $remarks->ticket_no . '/Remarks/';

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

                        $message_file = new AssetRequestRemarkFile();
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
            return redirect()->back()->with('no_remarks', 'Error');
        }
        if ($type == 2) {

            $postdata = $request->all();

            $postdata['remarks_by'] = Auth::id();
            if (!empty($request->remarks)) {
                $postdata['details'] = nl2br($request->get('remarks'));
            } else {
                $postdata['details'] = 'Approved';
            }

            $remarks = new AssetRequestRemark($postdata);
            $remarks->save();

            $user_acss = AssetRequest::ByTicketSolve($remarks->ticket_no);
            $user_acss->sup_action = 2;
            $user_acss->update();

            $curr_user = User::findOrFail($user_acss->user_id);

            $randomchars = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

            $bSlip = BorrowerSlip::ByTicket($remarks->ticket_no);
            foreach ($bSlip as $slip) {
                $slip->borrow_code = $randomchars;
                $slip->update();
            }

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');


                $destinationPath = public_path() . '/uploads/AdminHelpDesk/asset_request/' . $remarks->ticket_no . '/Remarks/';

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

                    $message_file = new AssetRequestRemarkFile();
                    $message_file->request_remarks_id = $remarks->id;
                    $message_file->request_id = $remarks->request_id;
                    $message_file->ticket_no = $remarks->ticket_no;
                    $message_file->filename = $namefile;
                    $message_file->encryptname = $enc;
                    $message_file->uploaded_by = Auth::id();
                    $message_file->save();
                }
            }
            try {
                broadcast(new AssetReqSent($user_acss, $curr_user))->toOthers();
                broadcast(new AdminDashboardLoader($user_acss))->toOthers();
            } catch (\Exception $e) { }
            // if($user_acss->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_success','Success');
            // }else{
            return redirect()->back()->with('is_closed', 'Saved');
            // }
        }
        if ($type == 3) {

            $postdata = $request->all();

            $postdata['remarks_by'] = Auth::id();
            if (!empty($request->remarks)) {
                $postdata['details'] = nl2br($request->get('remarks'));
            } else {
                $postdata['details'] = 'Denied';
            }

            $remarks = new AssetRequestRemark($postdata);
            $remarks->save();

            $user_acss = AssetRequest::ByTicketSolve($remarks->ticket_no);
            $user_acss->sup_action = 3;
            $user_acss->status = 3;
            $user_acss->update();

            // if($user_acss->user->superior == Auth::user()->id){
            //     return redirect('superior')->with('is_deny','Denied');
            // }else{
            return redirect()->back()->with('is_closed', 'Saved');
            // }
        }
    }

    public function nonassetrelease($id)
    {
        $bSlip = BorrowerSlip::where('id', $id)->first();
        $num = $bSlip->qty;
        $count = 0;
        while ($num != $count) {
            $count++;
            $qtys[] = $count;
        }
        $assets = AssetTracking::getItemByCategory($bSlip->item);
        $asset_reqs = AssetRequest::ByTicket($bSlip->asset_request_no);

        return view('assets.nonasset_reqs_release', compact('bSlip', 'assets', 'asset_reqs', 'qtys'));
    }

    public function nonassetreleasing(Request $request)
    {
        $bSlip = BorrowerSlip::findOrFail($request->id);
        if ($request->code == $bSlip->borrow_code) {
            $bSlip->released = 1;
            $bSlip->qty_r = $request->qty_r;
            if (!empty($request->accs)) {
                $bSlip->accs = $request->accs;
            }
            $bSlip->save();

            $ass = AssetRequest::byReqNo($bSlip->asset_request_no);

            $reps = new AssetReport();
            $reps->req_no = $ass->req_no;
            $reps->user_id = $ass->user_id;
            $reps->solved_by = 0;
            $reps->barcode = '-';
            $reps->bslip_id = $bSlip->id;
            $reps->must_date = $bSlip->must_date;
            $reps->rel_date = date('Y-m-d');
            $reps->save();

            try {
                broadcast(new AdminDashboardLoader($ass))->toOthers();
            } catch (\Exception $e) {
                return redirect()->action('AssetRequestController@showrelease', ['id' => $bSlip->asset_request_no])->with('is_success', 'Released');
            }
            return redirect()->action('AssetRequestController@showrelease', ['id' => $bSlip->asset_request_no])->with('is_success', 'Released');
        } else {
            return redirect()->back()->with('is_wrong', 'error');
        }
    }

    public function removeItem($id)
    {

        $req = AssetRequestDetail::where('id', $id)->first();
        if (!empty($req)) {
            AssetRequestDetail::where('id', $id)->delete();

            return Response::json('S');
            // }else{
            //     return Response::json(['type'=>'2']);
            // }
        } else {
            return Response::json('E');
        }
    }

    public function editquantity()
    {

        $result = "E";
        $newqty = Input::get("newqty");
        $main_id = Input::get("id");
        $item = AssetRequestDetail::where('id', $main_id)->first();

        if (!empty($item)) {
            $item->qty = $newqty;
            $item->save();
            $result = "S";
        }

        return response()->json($result);
    }
}
