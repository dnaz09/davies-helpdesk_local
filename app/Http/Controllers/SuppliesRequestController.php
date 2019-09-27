<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplyRequest;
use App\Supplies;
use App\SuppliesRequestRemark;
use App\SupplyRequestDetail;
use App\User;
use App\Events\SuppReqSent;
use App\Events\AdminDashboardLoader;
use Response;
use Auth;

class SuppliesRequestController extends Controller
{
    public function index()
    {

        $category = ['DAVIES' => 'DAVIES', 'CHARTER' => 'CHARTER'];

        return view('supplies.sup_req', compact('category'));
    }

    public function store(Request $request)
    {
        $curr_user = Auth::user();
        $dets = explode(',', $request->get('det'));
        $cats = "";
        $supply = "";

        if (!empty($dets)) {
            foreach ($dets as $det) {
                $subs = explode('-', $det);

                $cats = $cats . ',' . $subs[0];
                $supply = $supply . ',' . $subs[1];
            }

            $postdata = $request->all();
            $postdata['user_id'] = Auth::id();
            $postdata['category'] = $cats;
            $postdata['supply'] = $supply;


            $sup_req = new SupplyRequest($postdata);
            $sup_req->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength) . $sup_req->id, -$strlength);
            $asset_req->req_no = "ASD-SP-" . $str;
            $sup_req->update();

            broadcast(new SuppReqSent($sup_req, $curr_user))->toOthers();
            broadcast(new AdminDashboardLoader($sup_req))->toOthers();

            if (!empty($dets)) {

                foreach ($dets as $det) {

                    $subs = explode('-', $det);

                    $sup_det = new SupplyRequestDetail();
                    $sup_det->supply_req_id = $sup_req->id;
                    $sup_det->category = $subs[0];
                    $sup_det->item_name = $subs[1];
                    $sup_det->qty = $subs[2];
                    $sup_det->save();
                }
            }
            return redirect('supplies_request')->with('is_success', 'Saved');
        }
        return redirect('supplies_request')->with('is_error', 'Error');
    }

    public function getSupply(Request $request)
    {

        $supplies = Supplies::byCategory($request->cat);

        return Response::json($supplies);
    }

    public function all_list()
    {

        $supplies = SupplyRequest::orderBy('created_at', 'DESC')->get();

        return view('supplies.all_list', compact('supplies'));
    }

    public function details($reqno)
    {


        $supply = SupplyRequest::byReq($reqno);
        $remarks = SuppliesRequestRemark::byReq($supply->id);
        return view('supplies.alldetails', compact('supply', 'remarks'));
    }

    public function remarks(Request $request)
    {

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;


        $req = SupplyRequest::where('id', $postdata['sup_req_id'])->first();

        $user = User::findOrFail($req->user_id);

        if (\Hash::check($request->password, $user->password)) {
            $req->done_by = Auth::id();
            $req->status = 2;
            $req->update();

            $remark = new SuppliesRequestRemark();
            $remark->sup_req_id = $request->sup_req_id;
            $remark->remarks = $request->remarks;
            $remark->remarks_by = Auth::id();
            $remark->save();

            broadcast(new AdminDashboardLoader($req))->toOthers();
            return back()->with('is_success', 'Saved!');
        } else {

            return back()->with('is_pass', 'Saved!');
        }
    }
}
