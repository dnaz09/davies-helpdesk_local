<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeExitPass;
use App\WorkAuthorization;
use App\WorkAuthorizationDetail;
use App\OBP;
use App\Undertime;
use Response;
use Auth;

class GuardController extends Controller
{

    public function index(){

    	$exit_pass = EmployeeExitPass::guardByday();
        $exit_pending = EmployeeExitPass::dailyPending();
        $exit_released = EmployeeExitPass::dailyReleased();
        $today = 0;
        $tom = 0;
        foreach ($exit_pass as $epass) {
            if($epass->date == date('Y-m-d')){
                $today++;
            }
            if($epass->date == date('Y-m-d',strtotime('+1 day'))){
                $tom++;
            }
        }
        
    	return view('guards.index',compact('exit_pass','today','tom','exit_pending','exit_released'));    	

    }

    public function passDetails(Request $request){

    	$pass = EmployeeExitPass::findOrFail($request->pass);

    	return Response::json($pass);
    }

    public function store(Request $request){

    	$emp = EmployeeExitPass::findOrFail($request->pass_id);
    	$emp->security_guard = $request->secguard;
        $emp->guard_remarks = nl2br($request->guard_remarks);
    	$emp->level = 2;
        $emp->time_in = $request->time_in;
        $emp->time_out = $request->time_out;
        $emp->agency = strtoupper(Auth::user()->first_name);
    	$emp->update();

    	return back();
    }

    public function store_obp(Request $request){

        $emp = EmployeeExitPass::findOrFail($request->pass_id);
        $emp->security_guard = $request->secguard;
        $emp->guard_remarks = nl2br($request->guard_remarks);
        $emp->agency = strtoupper(Auth::user()->first_name);
        
        if($emp->departure_time){

            $emp->arrival_time = $request->arrival_time;    
            $emp->level = 2;    

            $obp = OBP::findOrFail($emp->obp_id);            
            $obp->time_arrived = $request->arrival_time;
            $obp->update();
        }else{

            $emp->departure_time = $request->departure_time;
            $emp->level = 1;

            $obp = OBP::findOrFail($emp->obp_id);            
            $obp->time_left = $request->departure_time;
            $obp->update();
        }
            
        $emp->update();

        return back()->with('is_released','Released');   
    }

    public function guardrepindex()
    {
        $date_from = date('m/d/Y');
        $date_to = date('m/d/Y');

        return view('guards.reports',compact('date_from','date_to'));
    }

    public function guardgetreports(Request $request)
    {
        set_time_limit(0);
        $from = date('Y-m-d',strtotime($request->date_from));
        $to = date('Y-m-d',strtotime($request->date_to));
        $date_now = date('Y-m-d');
        $date_from = date('m/d/Y',strtotime($request->date_from));
        $date_to = date('m/d/Y',strtotime($request->date_to));
        $submit_type = $request->sub;
        if($submit_type == 1){
            $exits = EmployeeExitPass::getByDateRange($from,$to);
            if(!empty($exits)){
                $data = [];
                foreach ($exits as $key => $exit) {
                    if($exit->obp_id > 0){
                        $type = 'OBP';
                        $in = $exit->departure_time;
                        $out = $exit->arrival_time;
                    }else{
                        $type = $exit->others_details;
                        $in = '';
                        $out = $exit->time_out;
                    }
                    $data[$key] = [
                        'Exit Pass No' => $exit->exit_no,
                        'Category' => $type,
                        'User' => $exit->user->first_name.' '.$exit->user->last_name,
                        'Purpose' => $exit->purpose,
                        'In' => $in,
                        'Out' => $out,
                        'Date' => $exit->date,
                        'Authorized By' => $exit->security_guard,
                        'Agency' => $exit->agency
                    ];
                }
                \Excel::create('Exit_Pass_Report ('.$date_from.'-'.$date_to.')', function($excel) use($data, $date_from, $date_to, $date_now){
                    $excel->sheet('Exits', function($sheet) use($data, $date_from, $date_to, $date_now) {
                        $sheet->setAutoSize(true);
                        $sheet->mergeCells('A1:I1');
                        $sheet->row(1, array('EXIT PASS REPORTS'));
                        $sheet->row(1, function($row){
                            $row->setFontWeight('bold');
                            $row->setBackground('#D9D1D1');
                            $row->setAlignment('center');
                        });
                        $sheet->mergeCells('A2:I2');
                        $sheet->row(2, function($row){
                            $row->setFontWeight('bold');
                            $row->setBackground('#D9D1D1');
                            $row->setAlignment('center');
                        });
                        $sheet->mergeCells('A3:I3');
                        $sheet->row(3, array(''.$date_from.' to '.$date_to.''));
                        $sheet->row(3, function($row){
                            $row->setFontWeight('bold');
                            $row->setBackground('#D9D1D1');
                            $row->setAlignment('center');
                        });
                        $sheet->row(4, function($row){
                            $row->setBackground('#68A6FB');
                            $row->setFontWeight('bold');
                            $row->setAlignment('center');
                        });
                        $sheet->fromArray($data, null, 'A4', true);
                    });
                })->export('xls');
            }
        }
        if($submit_type == 2){
            // $works = WorkAuthorization::findByDateRange($from,$to);
            $works = WorkAuthorizationDetail::findByDateRange($from,$to);
            if(!empty($works)){
                $data = [];
                foreach ($works as $key => $det) {
                    if(!empty($det->exit_time)){
                        $exit_time = $det->exit_time;
                    }else{
                        $exit_time = '';
                    }
                    if(!empty($det->superior) || $det->superior > 0){
                        if(!empty($det->manager)){
                            $sup = $det->manager->first_name.' '.$det->manager->last_name;
                        }else{
                            $sup = '';
                        }
                    }else{
                        $sup = '';
                    }
                    $data[$key] = [
                        'Work Authorization No' => $det->work->work_no,
                        'Employee' => $det->user->first_name.' '.$det->user->last_name,
                        'Department' => $det->user->department->department,
                        'Manager' => $sup,
                        'Exit Time' => $exit_time,
                        'Reason' => $det->work->reason
                    ];
                }
                \Excel::create('Work_Auth_Report ('.$date_from.'-'.$date_to.')', function($excel) use($data, $date_from, $date_to, $date_now){
                    $excel->sheet('Works', function($sheet) use($data, $date_from, $date_to, $date_now) {
                        $sheet->setAutoSize(true);
                        $sheet->mergeCells('A1:F1');
                        $sheet->row(1, array('WAS REPORT'));
                        $sheet->row(1, function($row){
                            $row->setFontWeight('bold');
                            $row->setBackground('#D9D1D1');
                            $row->setAlignment('center');
                        });
                        $sheet->mergeCells('A2:F2');
                        $sheet->row(2, function($row){
                            $row->setFontWeight('bold');
                            $row->setBackground('#D9D1D1');
                            $row->setAlignment('center');
                        });
                        $sheet->mergeCells('A3:F3');
                        $sheet->row(3, array(''.$date_from.' to '.$date_to.''));
                        $sheet->row(3, function($row){
                            $row->setFontWeight('bold');
                            $row->setBackground('#D9D1D1');
                            $row->setAlignment('center');
                        });
                        $sheet->row(4, function($row){
                            $row->setFontWeight('bold');
                            $row->setAlignment('center');
                            $row->setBackground('#68A6FB');
                        });
                        $sheet->fromArray($data, null, 'A4', true);
                    });
                })->export('xls');
            }
        }
    }
}
