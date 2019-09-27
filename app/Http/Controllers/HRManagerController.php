<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkAuthorization;
use App\WorkAuthorizationDetail;
use App\OBP;
use App\Requisition;
use App\Undertime;
use Excel;
use Auth;

class HRManagerController extends Controller
{
	public function work_auth_reports()
	{
		$date_from = date('m/d/Y');
		$date_to = date('m/d/Y');
		$work_auths = WorkAuthorization::getReports($date_from, $date_to);
		return view('hrd_reports.work_auth_reports', ['date_from' => $date_from, 'date_to' => $date_to, 'work_auths' => $work_auths]);
	}
	public function work_auth_generate(Request $request, WorkAuthorizationDetail $workAuthorization)
	{
		set_time_limit(0);
		ini_set('memory_limit', -1);

		$date_from = date('Y-m-d', strtotime($request->date_from));

		$date_to = date('Y-m-d', strtotime($request->date_to));

		$date_now = date('m/d/Y');

		// $work_auths = WorkAuthorization::getReports($date_from, $date_to);
		// $work_auths = WorkAuthorizationDetail::getReports($date_from, $date_to);
		$work_auths = $workAuthorization->getReports($date_from, $date_to);
		try {
			// $submit_type = $request->get('submit');
			if (count($work_auths)) {
				$data = [];
				foreach ($work_auths as $key => $work_auth) {
					if (!empty($work_auth->user)) {
						$data[$key] = [
							'Date' => date('m/d/Y', strtotime($work_auth->work->date_needed)),
							'WAS #' => $work_auth->work->work_no,
							'Name' => $work_auth->user->last_name . ', ' . $work_auth->user->first_name,
							'Department' => $work_auth->user->department->department,
							'From' => date('h:i a', strtotime($work_auth->work->ot_from)),
							'To' => date('h:i a', strtotime($work_auth->work->ot_to)),
							'Check Out' => ''
						];
					}
				}

				Excel::create('Work Authorization Report(' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
					$excel->setTitle('Work Authorization Slip ' . $date_from . ' to ' . $date_to . '');
					$excel->sheet('Sheet1', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
						$sheet->setAllBorders('thin');
						$sheet->setOrientation('portrait');
						$sheet->setPageMargin(array(
							0.54, 0.54, 0.54, 1.00
						));
						$sheet->mergeCells('A1:G1');
						$sheet->row(1, array('Work Authorization Slip'));
						$sheet->row(1, function ($row) {
							$row->setFontWeight('bold');
							$row->setBackground('#D9D1D1');
							$row->setAlignment('center');
						});
						$from = date('m/d/Y', strtotime($date_from));
						$to = date('m/d/Y', strtotime($date_to));
						$sheet->mergeCells('A2:G2');
						$sheet->row(2, array($from . ' - ' . $to));
						$sheet->row(2, function ($row) {
							$row->setFontWeight('bold');
							$row->setBackground('#D9D1D1');
							$row->setAlignment('center');
						});
						$sheet->mergeCells('A3:G3');
						$sheet->row(3, function ($row) {
							$row->setFontWeight('bold');
							$row->setBackground('#D9D1D1');
							$row->setAlignment('center');
						});
						$sheet->row(4, function ($row) {
							$row->setFontWeight('bold');
							$row->setAlignment('center');
						});
						$sheet->cells('A', function ($cells) {
							$cells->setBackground('#F8F6F6');
						});
						// $sheet->fromArray($data, null, 'A4', true);

						$sheet->row(4, array('Date', 'WAS #', 'Name', 'Department', 'From', 'To', 'Check Out'));

						$row = 5;

						$flag = true;

						foreach ($data as $key => $value) {

							if (($value['Department'] === 'OUTBOUND LOGISTICS'
								|| $value['Department'] === 'LOGISTICS'
								|| $value['Department'] === 'LOGISTICS & WAREHOUSE'
								|| $value['Department'] === 'WAREHOUSE'
								|| $value['Department'] === 'SALES'
								|| $value['Department'] === 'CUSTOMER SERVICES'
								|| $value['Department'] === 'BASES & COLORANTS') && $flag) {
								$flag = false;
								$merge = 'A' . $row . ":G" . $row;
								$sheet->mergeCells($merge);
								$sheet->row($row, array('Gate 4 Entrance'));
								$sheet->row($row, function ($row) {
									$row->setFontWeight('bold');
									$row->setBackground('#D9D1D1');
									$row->setAlignment('center');
								});
								$row++;
							}

							$sheet->row($row, array($value['Date'], $value['WAS #'], $value['Name'], $value['Department'], $value['From'], $value['To'], $value['Check Out']));
							$row++;
						}
						$sheet->setAutoFilter();
					});
				})->export('xls');
			} else {
				return redirect()->back()->with('is_null', 'Null Data');
			}
		} catch (Exception $e) {
			dd($e);
		}
	}
	public function obp_request_reports()
	{
		$date_from = date('m/d/Y');
		$date_to = date('m/d/Y');
		return view('hrd_reports.obp_request_reports', ['date_from' => $date_from, 'date_to' => $date_to]);
	}
	public function obp_request_generate(Request $request)
	{
		set_time_limit(0);
		ini_set('memory_limit', -1);

		$date_from = date('Y-m-d', strtotime($request->date_from));

		$date_to = date('Y-m-d', strtotime($request->date_to));

		$date_now = date('m/d/Y');

		$obps = OBP::getReports($date_from, $date_to);
		// $submit_type = $request->get('submit');
		if ($obps->count()) {
			$data = [];
			foreach ($obps as $key => $obp) {
				if (!empty($obp->date2)) {
					$date2 = date('m/d/Y', strtotime($obp->date2));
				} else {
					$date2 = date('m/d/Y', strtotime($obp->date));
				}
				$data[$key] = [
					'OB #' => $obp->obpno,
					'Name' => $obp->user->last_name . ' ' . $obp->user->first_name,
					'Username' => $obp->user->username,
					'Department' => $obp->user->department->department,
					'Date Needed' => date('m/d/Y', strtotime($obp->date)) . ' - ' . $date2,
					'Date and Time Left' => $obp->time_left,
					'Date and Time Arrived' => $obp->time_arrived,
				];
			}
			Excel::create('OBP Request Report(' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->setTitle('OBP Request Report ' . $date_from . ' to ' . $date_to . '');
				$excel->sheet('Sheet1', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAllBorders('thin');
					$sheet->setOrientation('portrait');
					$sheet->setPageMargin(array(
						0.54, 0.54, 0.54, 1.00
					));
					$sheet->mergeCells('A1:G1');
					$sheet->mergeCells('A1:F1');
					$sheet->row(1, array('OBP Request'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$from = date('m/d/Y', strtotime($date_from));
					$to = date('m/d/Y', strtotime($date_to));
					$sheet->mergeCells('A2:G2');
					$sheet->row(2, array($from . ' - ' . $to));
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:G3');
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->cells('A', function ($cells) {
						$cells->setBackground('#F8F6F6');
					});
					$sheet->fromArray($data, null, 'A4', true);
					// $sheet->fromArray($hr_manager, null, '', true);
					// $sheet->fromArray($position, null, '', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with('is_null', 'Null Data');
		}
	}
	public function requisition_reports()
	{
		$date_from = date('m/d/Y');
		$date_to = date('m/d/Y');
		return view('hrd_reports.requisition_reports', ['date_from' => $date_from, 'date_to' => $date_to]);
	}
	public function requisition_generate(Request $request)
	{
		set_time_limit(0);
		ini_set('memory_limit', -1);

		$date_from = date('Y-m-d', strtotime($request->date_from));

		$date_to = date('Y-m-d', strtotime($request->date_to));

		$date_now = date('m/d/Y');

		$reqs = Requisition::getReports($date_from, $date_to);
		// $submit_type = $request->get('submit');
		if ($reqs->count()) {
			$data = [];
			foreach ($reqs as $key => $req) {
				if ($req->item2 != null && $req->item3 != null) {
					$data[$key] = [
						'Req# ' => $req->rno,
						'Date Needed' => date('m-d-Y', strtotime($req->date_needed)),
						'Name' => $req->user->last_name . ' ' . $req->user->first_name,
						'Department' => $req->user->department->department,
						'Items' => $req->item1 . ' - ' . $req->qty1 . ' - ' . $req->purpose1 . ', ' . $req->item2 . ' - ' . $req->qty2 . ' - ' . $req->purpose2 . ', ' . $req->item3 . ' - ' . $req->qty3 . ' - ' . $req->purpose3
					];
				}
				if ($req->item2 != null && $req->item3 == null) {
					$data[$key] = [
						'Req# ' => $req->rno,
						'Date Needed' => date('m-d-Y', strtotime($req->date_needed)),
						'Name' => $req->user->last_name . ' ' . $req->user->first_name,
						'Department' => $req->user->department->department,
						'Items' => $req->item1 . ' - ' . $req->qty1 . ' - ' . $req->purpose1 . ', ' . $req->item2 . ' - ' . $req->qty2 . ' - ' . $req->purpose2
					];
				}
				if ($req->item2 == null && $req->item3 != null) {
					$data[$key] = [
						'Req# ' => $req->rno,
						'Date Needed' => date('m-d-Y', strtotime($req->date_needed)),
						'Name' => $req->user->last_name . ' ' . $req->user->first_name,
						'Department' => $req->user->department->department,
						'Items' => $req->item1 . ' - ' . $req->qty1 . ' - ' . $req->purpose1 . ', ' . $req->item3 . ' - ' . $req->qty3 . ' - ' . $req->purpose3
					];
				}
				if ($req->item2 == null && $req->item3 == null) {
					$data[$key] = [
						'Req# ' => $req->rno,
						'Date Needed' => date('m-d-Y', strtotime($req->date_needed)),
						'Name' => $req->user->last_name . ' ' . $req->user->first_name,
						'Department' => $req->user->department->department,
						'Items' => $req->item1 . ' - ' . $req->qty1 . ' - ' . $req->purpose1
					];
				}
			}
			Excel::create('Requisition Report(' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->setTitle('Requisition Report' . $date_from . ' to ' . $date_to . '');
				$excel->sheet('Sheet1', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAllBorders('thin');
					$sheet->setOrientation('portrait');
					$sheet->setPageMargin(array(
						0.54, 0.54, 0.54, 1.00
					));
					$sheet->mergeCells('A1:E1');
					$sheet->mergeCells('A1:E1');
					$sheet->row(1, array('Requisition Report'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$from = date('m/d/Y', strtotime($date_from));
					$to = date('m/d/Y', strtotime($date_to));
					$sheet->mergeCells('A2:E2');
					$sheet->row(2, array($from . ' - ' . $to));
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:E3');
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->cells('B', function ($cells) {
						$cells->setBackground('#F8F6F6');
					});
					$sheet->fromArray($data, null, 'A4', true);
					// $sheet->fromArray($hr_manager, null, '', true);
					// $sheet->fromArray($position, null, '', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with('is_null', 'Null Data');
		}
	}
	public function undertime_reports()
	{
		$date_from = date('m/d/Y');
		$date_to = date('m/d/Y');
		return view('hrd_reports.undertime_reports', ['date_from' => $date_from, 'date_to' => $date_to]);
	}
	public function undertime_generate(Request $request)
	{
		set_time_limit(0);
		ini_set('memory_limit', -1);

		$date_from = date('Y-m-d', strtotime($request->date_from));

		$date_to = date('Y-m-d', strtotime($request->date_to));

		$date_now = date('m/d/Y');

		$undertimes = Undertime::getReports($date_from, $date_to);
		// $submit_type = $request->get('submit');
		if ($undertimes->count()) {
			$data = [];
			foreach ($undertimes as $key => $undertime) {
				if ($undertime->type == 1) {
					$type = 'HALF DAY';
					$sched = '11:30';
				} elseif ($undertime->type == 2) {
					$type = 'UNDERTIME';
					$sched = $undertime->sched;
				} else {
					$type = '';
					$sched = $undertime->sched;
				}
				$data[$key] = [
					'Leave #' => $undertime->und_no,
					'Name' => $undertime->user->last_name . ' ' . $undertime->user->first_name,
					'Department' => $undertime->user->department->department,
					'Date' => date('m/d/Y', strtotime($undertime->date)),
					'Schedule' => $sched,
					'Type' => $type,
					'Check Out' => '',
				];
			}
			Excel::create('Leave Report(' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->setTitle('Leave Report' . $date_from . ' to ' . $date_to . '');
				$excel->sheet('Sheet1', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAllBorders('thin');
					$sheet->setOrientation('portrait');
					$sheet->setPageMargin(array(
						0.54, 0.54, 0.54, 1.00
					));
					$sheet->mergeCells('A1:G1');
					$sheet->mergeCells('A1:G1');
					$sheet->row(1, array('Leave Report'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$from = date('m/d/Y', strtotime($date_from));
					$to = date('m/d/Y', strtotime($date_to));
					$sheet->mergeCells('A2:G2');
					$sheet->row(2, array($from . ' - ' . $to));
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:G3');
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->cells('A', function ($cells) {
						$cells->setBackground('#F8F6F6');
					});
					$sheet->fromArray($data, null, 'A4', true);
					// $sheet->fromArray($hr_manager, null, '', true);
					// $sheet->fromArray($position, null, '', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with('is_null', 'Null Data');
		}
	}

	public function hrd_reports_index()
	{
		$date_from = date('m/d/Y');
		$date_to = date('m/d/Y');
		return view('hrd_reports.index', compact('date_from', 'date_to'));
	}
}
