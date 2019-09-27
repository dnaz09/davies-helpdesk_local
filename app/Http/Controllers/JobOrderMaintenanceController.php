<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobOrderLocation;
use App\JobOrderFacility;
use App\JobOrderEquipment;
use App\JobOrderInhouse;
use App\JobOrderSubItemClass;

class JobOrderMaintenanceController extends Controller
{
    public function index()
    {
    	$locations = JobOrderLocation::all();
    	$facilities = JobOrderFacility::all();
        $equipments = JobOrderEquipment::all();
    	$inhouses = JobOrderInhouse::all();
        $iclasses = JobOrderSubItemClass::all();
    	$type1 = 1;
    	$type2 = 2;
    	$type3 = 3;
        $type4 = 4;
        $type5 = 5;
    	return view('job_order_m.index',compact('locations','facilities','equipments','inhouses','iclasses','type1','type2','type3','type4','type5'));
    }

    public function show($type)
    {
    	$type = $type;
    	if($type == 1){
    		return view('job_order_m.createlocation');
    	}
    	if($type == 2){
    		return view('job_order_m.createfacility');
    	}
    	if($type == 3){
    		return view('job_order_m.createequipment');
    	}
        if($type == 4){
            return view('job_order_m.createinhouse');
        }
        if($type == 5){
            $equipments = JobOrderEquipment::all();
            return view('job_order_m.createitemclasses',compact('equipments'));
        }
    }

    public function store(Request $request)
    {
    	$type = $request->type;
    	if($type == 1){
    		$location = new JobOrderLocation();
    		$location->location = $request->new;
    		$location->save();

    		return redirect('job_order_m')->with('is_success','Success');
    	}
    	if($type == 2){
    		$facility = new JobOrderFacility();
    		$facility->facility = $request->new;
    		$facility->save();

    		return redirect('job_order_m')->with('is_success','Success');
    	}
    	if($type == 3){
            $equipment = new JobOrderEquipment();
            $equipment->equipment = $request->new;
            $equipment->save();

            return redirect('job_order_m')->with('is_success','Success');
        }
        if($type == 4){
    		$equipment = new JobOrderInhouse();
    		$equipment->inhouse = $request->new;
    		$equipment->save();

    		return redirect('job_order_m')->with('is_success','Success');
    	}
        if($type == 5){
            $class = new JobOrderSubItemClass();
            $class->equipment_type = $request->equipment_type;
            $class->description = $request->description;
            $class->save();

            return redirect('job_order_m')->with('is_success','Success');
        }

    	return redirect()->back()->with('is_error','Error');
    }
}
