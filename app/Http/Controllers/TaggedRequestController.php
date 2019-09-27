<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkAuthorization;
use App\WorkAuthorizationDetail;
use App\WorkAuthorizationRemark;
use App\WorkAuthorizationRemarkFile;
use Auth;

class TaggedRequestController extends Controller
{
    public function index()
    {
    	$work_auths = WorkAuthorizationDetail::getWorkAuthById(Auth::id());

    	return view('tagged_trans.index',compact('work_auths'));
    }
    public function work_auth_details($id)
    {
    	$work = WorkAuthorization::findOrFail($id);
        $remarks = WorkAuthorizationRemark::byWork($id);
        $emps = WorkAuthorizationDetail::byWork($id);

        return view('tagged_trans.work_auth_details',compact('work','remarks','emps'));
    }
}
