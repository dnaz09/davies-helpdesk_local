<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\ITRequest;
use App\ITRequestRemarks;
use App\ITRequestRemarksFile;
use App\AssetRequest;
use App\AssetRequestRemark;
use App\AssetRequestRemarkFile;
use App\OBP;
use App\OBPRemark;
use App\OBPDetail;
use App\EmployeeExitPass;
use App\ExitPassRemark;
use App\Undertime;
use App\UndertimeRemark;
use App\Requisition;
use App\RequisitionRemark;
use App\WorkAuthorization;
use App\WorkAuthorizationRemark;
use App\BorrowerSlip;
use App\JobOrder;
use App\AssetRequestDetail;
use App\Events\ItDashboardLoader;
use App\Events\ServiceRequestSent;
use App\Events\AdminDashboardLoader;
use App\GatePass;
use App\AdminSupplyRequest;
use Illuminate\Support\Facades\Input;
use Auth;


class MyRequestController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }
    public function index()
    {

        $reqs = ITRequest::myRequest(Auth::id());
        $assets = AssetRequest::myRequest(Auth::id());
        $obp_reqs = OBP::byCreated(Auth::id());
        $exit_pass_reqs = EmployeeExitPass::ByUser(Auth::id());
        $undertimes = Undertime::byCreated(Auth::id());
        $work_reqs = Requisition::byCreated(Auth::id());
        $work_auths = WorkAuthorization::byCreated(Auth::id());
        $jos = JobOrder::ByUser(Auth::id());
        $exits = EmployeeExitPass::byUser(Auth::id());
        $gps = GatePass::getMine(Auth::id());
        $supps = AdminSupplyRequest::findByUserId(Auth::id());

        return view('myrequest.index', compact('reqs', 'assets', 'obp_reqs', 'exit_pass_reqs', 'undertimes', 'work_reqs', 'work_auths', 'jos', 'exits', 'gps', 'supps'));
    }

    public function add_remarks(Request $request)
    {
        $curr_user = Auth::user();
        $type = $this->request->get('sub');

        if ($type == 1) {

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            if ($request->remarks != null) {
                $postdata['details'] = nl2br($this->request->get('remarks'));
            } else {
                $postdata['details'] = 'Remark';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');

                $destinationPath = public_path() . '/uploads/ITHelpDesk/user_access_request/' . $remarks->ticket_no . '/Remarks/';

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

            return redirect()->action('ITRequestListController@details_user', ['id' => $this->request->get('ticket_no')])->with('is_success', 'Saved');
        }
        if ($type == 2) {

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            if ($request->remarks != null) {
                $postdata['details'] = nl2br($this->request->get('remarks'));
            } else {
                $postdata['details'] = 'Return To Pending';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->status = 0;
            $user_acss->solved_by = 0;
            $user_acss->update();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');


                $destinationPath = public_path() . '/uploads/ITHelpDesk/service_request/' . $remarks->ticket_no . '/Remarks/';

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
            try {
                broadcast(new ServiceRequestSent($user_acss, $curr_user))->toOthers();
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            } catch (\Exception $e) {
                return back()->with('is_pending', 'Pending');
            }
            return back()->with('is_pending', 'Pending');
        }

        if ($type == 3) {

            $postdata = $this->request->all();

            $postdata['remarks_by'] = Auth::id();
            if ($request->remarks != null) {
                $postdata['details'] = nl2br($this->request->get('remarks'));
            } else {
                $postdata['details'] = 'Closed';
            }

            $remarks = new ITRequestRemarks($postdata);
            $remarks->save();

            $user_acss = ITRequest::byTicket($remarks->ticket_no);
            $user_acss->status = 2;
            $user_acss->update();

            if ($request->hasFile('attached')) {

                $files = Input::file('attached');


                $destinationPath = public_path() . '/uploads/ITHelpDesk/item_request/' . $remarks->ticket_no . '/Remarks/';

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
            try {
                broadcast(new ItDashboardLoader($user_acss))->toOthers();
            } catch (\Exception $e) {
                return back()->with('is_closed', 'Closed');
            }
            return back()->with('is_closed', 'Closed');
        }
    }

    public function davies_asset_request_details($id)
    {

        $user_acss = AssetRequest::ByTicket($id);

        if (empty($user_acss)) {

            return view('errors.909', compact('id'));
        }

        $asset_reqs = AssetRequest::ByTicket($id);
        $remarks = AssetRequestRemark::getList($id);
        $slips = BorrowerSlip::ByTicket2($id);
        $dets = BorrowerSlip::ByTicket($id);
        return view('myrequest.asset_details', compact('asset_reqs', 'remarks', 'slips', 'dets'));
    }

    public function delete_item()
    {
        $result = "E";
        $id = Input::get("id");
        $item = BorrowerSlip::findByIdFirst($id);

        if (!empty($item)) {
            $item->delete();
            $result = "S";
        }

        return response()->json($result);
    }
    public function edit_quantity()
    {
        $result = "E";
        $newqty = Input::get("newqty");
        $main_id = Input::get("id");
        $item = BorrowerSlip::findByIdFirst($main_id);
        if (!empty($item)) {
            $item->qty = $newqty;
            $item->save();
            $result = "S";
        }

        return response()->json($result);
    }
    public function cancel_asset($id)
    {
        $asset = AssetRequest::ByTicketSolve($id);
        if (empty($asset)) {
            return view('errors.909', compact('id'));
        } else {
            $bslips = BorrowerSlip::byTicket($asset->req_no);
            if (!empty($bslips)) {
                foreach ($bslips as $bslip) {
                    if ($bslip->released != 1) {
                        $bslip->delete();
                    } else {
                        return redirect()->back()->with('error_cancel', 'Cancel Error');
                    }
                }
            }
            $details = AssetRequestDetail::byRequestId($asset->id);
            if (!empty($details)) {
                foreach ($details as $detail) {
                    $detail->status = 5;
                    $detail->save();
                }
            }
            $asset->status = 5;
            $asset->save();
            try {
                broadcast(new AdminDashboardLoader($asset_req))->toOthers();
            } catch (\Exception $e) { }
        }
        return redirect()->back()->with('is_cancel', 'Canceled');
    }

    public function davies_asset_remarks(Request $request)
    {


        $type = $this->request->get('sub');

        $postdata = $this->request->all();

        $postdata['remarks_by'] = Auth::id();
        $postdata['details'] = nl2br($this->request->get('remarks'));

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

        return redirect()->action('MyRequestController@davies_asset_request_details', ['id' => $this->request->get('ticket_no')])->with('is_success', 'Saved');
    }

    public function davies_obp_request_details($id)
    {

        $obp = OBP::ByNum($id);

        if (empty($obp)) {

            return view('errors.909', compact('id'));
        }
        $obp_details = OBPDetail::byObp($id);

        $remarks = OBPRemark::byObp($id);

        return view('obp.emp_details', compact('obp', 'remarks', 'obp_details'));
    }

    public function davies_obp_request_remarks(Request $request)
    {

        $type = $this->request->get('sub');

        $postdata = $this->request->all();

        $postdata['remarks_by'] = Auth::id();
        $postdata['details'] = nl2br($this->request->get('remarks'));

        $remarks = new OBPRemark($postdata);
        $remarks->obp_id = $request->ticket_no;
        $remarks->save();

        return back()->with('is_success', 'Saved');
    }

    public function davies_exit_pass_request_details($id)
    {

        $user_acss = EmployeeExitPass::ByNum($id);

        if (empty($user_acss)) {

            return view('errors.909', compact('id'));
        }

        $exit_pass_reqs = EmployeeExitPass::ByNum($id);
        $remarks = ExitPassRemark::getList($id);

        return view('myrequest.exit_pass_details', compact('exit_pass_reqs', 'remarks'));
    }

    public function davies_exit_pass_request_remarks(Request $request)
    {

        $type = $this->request->get('sub');

        $postdata = $this->request->all();

        $postdata['remarks_by'] = Auth::id();
        $postdata['details'] = nl2br($this->request->get('remarks'));

        $remarks = new ExitPassRemark($postdata);
        $remarks->exit_id = $request->request_id;
        $remarks->exit_no = $request->ticket_no;
        $remarks->save();

        return back()->with('is_success', 'Saved');
    }

    public function davies_undertime_request_details($id)
    {

        $undertime = Undertime::findOrFail($id);

        if (empty($undertime)) {

            return view('errors.909', compact('id'));
        }
        $remarks = UndertimeRemark::byUndertime($id);

        return view('undertime.emp_details', compact('undertime', 'remarks'));
    }

    public function davies_undertime_request_remarks(Request $request)
    {

        $type = $this->request->get('sub');

        $postdata = $this->request->all();

        $postdata['remarks_by'] = Auth::id();
        $postdata['details'] = nl2br($this->request->get('remarks'));

        $remarks = new UndertimeRemark($postdata);
        $remarks->undertime_id = $request->request_id;
        $remarks->save();

        return back()->with('is_success', 'Saved');
    }
}
