<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ITRequest;
use Excel;

class ReportController extends Controller
{
    public function index(){


    }

    public function itdept(){

    	$start = date("m/d/Y");
    	$end = date("m/d/Y");

    	return view('reports.itdept',compact('start','end'));
    }

    public function store(Request $request){

    	$start = $request->start;
    	$end = $request->end;

    	$reports = ITRequest::getByDate($start,$end);

    	Excel::create('REPORTS FROM '.$start.' TO '.$end, function($excel) use($reports,$start,$end) {


        	$excel->sheet('RESOLVED REPORTS', function($sheet) use($reports,$start,$end) {
            	$sheet->setAutoSize(true);
            	$sheet->mergeCells('A2:K2');
            	$sheet->cell('A2:K2', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setFontSize(22);
            
                });        

            	$sheet->row(2, array("IT DEPARTMENT REPORT")); 
            	$sheet->mergeCells('A4:K4');
            	$sheet->cell('A4:K4', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setFontSize(12);
            
                });

            	$sheet->row(4, array("TOTAL RESOLVED FROM ".$start." TO ".$end.": ".count($reports))); 

                $sheet->cell('A7:K7', function($cell) {                	
                    $cell->setAlignment('center');
                    $cell->setBackground('#3498db');
            
                 });                            

                $sheet->row(7,array("NAME","DEPARTMENT","COMPANY","TICKET #","CATEGORY","SUB CATEGORY","SERVICE TYPE","ISSUES","DATE CREATED","DATE SOLVED","RESOLVED BY"));

                if(!empty($reports)){
                    $cnt = 8;
                    $total_g = 0;       
                    foreach ($reports as $report) {                                                                    
                        if(!empty($report)){
                           
                            $sheet->row($cnt,array(
                                    
                                strtoupper($report->user->first_name.' '.$report->user->last_name),
                                strtoupper($report->user->department->department),
                                strtoupper($report->user->company),
                                $report->reqit_no,
                                $report->category,
                                $report->sub_category,
                                strtoupper($report->service),
                                strtoupper($report->issues),                                
                                date('m-d-Y',strtotime($report->created_at)),
                                date('m-d-Y',strtotime($report->updated_at)),
                                strtoupper($report->first_name.' '.$report->last_name)

                            ));

                            $cnt++;
                        }            
                        
                    }    
                }
            });           
        })->export('xlsx');   
    }
}
