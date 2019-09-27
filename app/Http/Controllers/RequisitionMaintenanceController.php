<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\RequisitionDescription;
use App\RequisitionForm;
use App\RequisitionPurpose;

class RequisitionMaintenanceController extends Controller
{
    public function index()
    {
    	$descs = RequisitionDescription::all();
    	$forms = RequisitionForm::all();
    	$purposes = RequisitionPurpose::all();

    	return view('requisition_maintenance.index',compact('purposes','forms','descs'));
    }
    public function create(Request $request)
    {
    	$type = $type = $request->get('sub');
    	if($type == 1)
    	{
    		$form = new RequisitionForm();
    		$form->form = $request->form;
    		$form->save();
    	}
    	if($type == 2)
    	{
    		$desc = new RequisitionDescription();
    		$desc->description = $request->description;
    		$desc->save();
    	}
    	if($type == 3)
    	{
    		$purpose = new RequisitionPurpose();
    		$purpose->purpose = strtoupper($request->purpose);
    		$purpose->save();
    	}
    	return redirect()->back()->with('is_success', 'Success');
    }
}
