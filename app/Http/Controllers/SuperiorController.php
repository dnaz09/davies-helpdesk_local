<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\OBP;
use App\Undertime;
use App\Requisition;
use App\WorkAuthorizationDetail;
use App\AssetRequest;
use App\ITRequest;
use App\EmployeeRequisition;
use App\JobOrder;
use App\AdminSupplyRequest;
use App\LeaveRequest;

class SuperiorController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '-1');
        
    	$obps = OBP::byUnder(Auth::id());
    	$undertimes = Undertime::byUnder(Auth::id());
    	$requis = Requisition::byUnder(Auth::id());
    	$works = WorkAuthorizationDetail::bySup(Auth::id());
    	$asset_reqs = AssetRequest::BySuperior(Auth::id());
    	$tickets = ITRequest::byManagerSAP(Auth::id());
        $its = ITRequest::byManagerUserAcc(Auth::id());
        $emps = EmployeeRequisition::findBySuperior(Auth::id());
        $jos = JobOrder::getSupAll(Auth::id());
        $supps = AdminSupplyRequest::findBySuperior(Auth::id());

    	return view('superior.index', compact('obps','undertimes','requis','works','asset_reqs','tickets','its','emps','jos','supps'));
    }
}
