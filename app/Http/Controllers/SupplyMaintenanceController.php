<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupplyMaintenance;
use Illuminate\Support\Facades\Input;
use Excel;
use Response;

class SupplyMaintenanceController extends Controller
{
    public function index()
    {
    	set_time_limit(0);
        ini_set('memory_limit', -1); 
    	$supplies = SupplyMaintenance::getAll();
    	
    	return view('supply_m.index',compact('supplies'));
    }

    public function import(Request $request)
    {
    	set_time_limit(0);
        ini_set('memory_limit', -1);                

        if($request->file('supplyfile')){ 
            
            $path = $request->file('supplyfile')->getRealPath();
            \Excel::load(Input::file('supplyfile'), function ($reader) {
                foreach($reader->toArray() as $row) {
                    $check = SupplyMaintenance::where('material_code',$row['material_code'])->count();
                    if($check < 1){
                    	$new = new SupplyMaintenance();
                    	$new->material_code = strtoupper($row['material_code']);
                    	$new->description = strtoupper($row['material_description']);
                    	$new->category = strtoupper($row['category']);
                    	$new->save();
                    }
                } 
            });
            return redirect('supply_m')
                ->with('class', 'alert-success')
                ->with('supply', 'Supply list successfully updated');
        }
    }

    public function getsupplycategory(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);  
        $items['selection'] = SupplyMaintenance::getByCategory($request->category);

        return Response::json($items,200);
    }
}
