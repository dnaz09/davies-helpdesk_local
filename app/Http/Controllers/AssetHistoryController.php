<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\AssetTracking;
use App\AssetRequest;
use App\AssetRouting;
use App\AssetCategory;
use App\AssetReport;
use App\BorrowerSlip;
use App\User;

class AssetHistoryController extends Controller
{
    public function index()
    {
    	$histories = AssetRequest::myrequest(Auth::id());

    	foreach ($histories as $key => $value) {

    		$histories[$key]->items = BorrowerSlip::where('asset_request_no',$value->req_no)->where('released',1)->get();

    	}
    	return view('asset_histories.index',compact('histories'));
    }
}
