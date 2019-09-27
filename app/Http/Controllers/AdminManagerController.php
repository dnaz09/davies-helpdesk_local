<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\AssetReport;
use App\AssetRequestRemark;
use App\AdminSupplyRequestDetail;
use App\GatePass;
use App\JobOrder;
use Excel;
use DB;

class AdminManagerController extends Controller
{
	public function index()
	{
		$date_from = date('m/d/Y');
		$date_to = date('m/d/Y');
		return view('reports.admindept', compact('date_from', 'date_to'));
	}

	public function bgenerate(Request $request)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);

		$date_from = date($request->date_from);

		$date_to = date($request->date_to);

		$date_now = date('m/d/Y');
		$bs = AssetReport::getAssetReports($date_from, $date_to);
		// $submit_type = $request->get('submit');
		if ($bs->count()) {
			$data = [];
			foreach ($bs as $key => $b) {
				if ($b->solved_by != 0) {
					if ($b->slip->is_asset == 1) {
						$missings = AssetRequestRemark::getByReqNoandItem($b->req_no, $b->item->barcode);
						if (!empty($missings)) {
							$missing = explode(')', $missings->details);
							$miss_item = $missing[1];
						} else {
							$miss_item = 'none';
						}
						if (!empty($b->slip->receiever)) {
							$rec = $b->slip->receiever->first_name . ' ' . $b->slip->receiever->last_name;
						} else {
							$rec = '-';
						}
						$data[$key] = [
							'Request No.' => $b->req_no,
							'Filed By' => $b->user->first_name . ' ' . $b->user->last_name,
							'Name of Borrower' => $b->req->borrower_name,
							'Company' => $b->user->company,
							'Department' => $b->user->department->department,
							'Approved By' => $b->admin->first_name . ' ' . $b->admin->last_name,
							'Item' => $b->item->item_name ?? $b->item->item ?? $b->item->remarks,
							'Category' => 'Asset',
							'Item Code' => $b->item->barcode,
							'Accessories' => $b->item->slip->accs,
							'Borrower Code' => $b->slip->borrow_code,
							'Qty Requested' => $b->slip->qty,
							'Qty Released' => $b->slip->qty_r,
							'Purpose' => $b->req->details,
							'Released Date' => date('m/d/Y', strtotime($b->rel_date)),
							'Returned Date' => date('m/d/Y', strtotime($b->ret_date)),
							'Received By' => $b->slip->get_by,
							'Missing Accessories' => $miss_item,
							'Received by (Admin)' => $rec
						];
					} elseif ($b->slip->is_asset == 0) {
						if (!empty($b->slip->receiever)) {
							$rec = $b->slip->receiever->first_name . ' ' . $b->slip->receiever->last_name;
						} else {
							$rec = '-';
						}
						$data[$key] = [
							'Request No.' => $b->req_no,
							'Filed By' => $b->user->first_name . ' ' . $b->user->last_name,
							'Name of Borrower' => $b->req->borrower_name,
							'Company' => $b->user->company,
							'Department' => $b->user->department->department,
							'Approved By' => $b->admin->first_name . ' ' . $b->admin->last_name,
							'Item' => $b->slip->item,
							'Category' => 'Non Asset',
							'Item Code' => '-',
							'Accessories' => strtoupper($b->slip->accs),
							'Borrower Code' => $b->slip->borrow_code,
							'Qty Requested' => $b->slip->qty,
							'Qty Released' => $b->slip->qty_r,
							'Purpose' => $b->req->details,
							'Released Date' => date('m/d/Y', strtotime($b->rel_date)),
							'Returned Date' => date('m/d/Y', strtotime($b->ret_date)),
							'Received By' => $b->slip->get_by,
							'Missing Accessories' => '-',
							'Received by (Admin)' => $rec
						];
					}
				}
			}
			Excel::create('Item Tracking - Released (' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->sheet('ITEMS', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAutoSize(true);
					$sheet->mergeCells('A1:S1');
					$sheet->row(1, array('Item Tracking - Borrowed Items'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A2:S2');
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:S3');
					$sheet->row(3, array('' . $date_from . ' to ' . $date_to . ''));
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setFontWeight('bold');
						$row->setAlignment('center');
						$row->setBackground('#68A6FB');
					});
					$sheet->fromArray($data, null, 'A4', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with(['date_from' => $date_from, 'date_to' => $date_to])->with('is_null', 'Null Data');
		}
	}

	public function ogenerate(Request $request)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		$date_from = date($request->date_from);

		$date_to = date($request->date_to);

		$date_now = date('m/d/Y');
		$bs = AssetReport::getOverdueReports($date_from, $date_to);
		// $submit_type = $request->get('submit');
		// dd($bs); die;
		if ($bs->count()) {
			$data = [];
			foreach ($bs as $key => $b) {
				if (!empty($b->slip->receiever)) {
					$rec = $b->slip->receiever->first_name . ' ' . $b->slip->receiever->last_name;
				} else {
					$rec = '-';
				}
				if ($b->solved_by != 0) {
					if (!is_null($b->ret_date)) {
						$ret_date = date('m/d/Y', strtotime($b->ret_date));
					} else {
						$ret_date = '-';
					}
					if ($b->slip->is_asset == 1) {
						if (!empty($b->item)) {
							$missings = AssetRequestRemark::getByReqNoandItem($b->req_no, $b->item->barcode);
							if (!empty($missings)) {
								$missing = explode(')', $missings->details);
								$miss_item = $missing[1];
							} else {
								$miss_item = 'none';
							}
							$data[$key] = [
								'Request No.' => $b->req_no,
								'Filed By' => $b->user->first_name . ' ' . $b->user->last_name,
								'Name of Borrower' => $b->req->borrower_name,
								'Company' => $b->user->company,
								'Department' => $b->user->department->department,
								'Approved By' => $b->admin->first_name . ' ' . $b->admin->last_name,
								'Item' => $b->item->remarks,
								'Category' => 'Asset',
								'Item Code' => $b->item->barcode,
								'Accessories' => $b->slip->accs,
								'Borrower Code' => $b->slip->borrow_code,
								'Qty Requested' => $b->slip->qty,
								'Qty Released' => $b->slip->qty_r,
								'Purpose' => $b->req->details,
								'Released Date' => date('m/d/Y', strtotime($b->rel_date)),
								'Return Date Indicated' => date('m/d/Y', strtotime($b->req->slip->must_date)),
								'Item Returned Date' => $ret_date,
								'Received By' => $b->slip->get_by,
								'Missing Accessories' => $miss_item,
								'Received by (Admin)' => $rec
							];
						}
					} else {
						$data[$key] = [
							'Request No.' => $b->req_no,
							'Filed By' => $b->user->first_name . ' ' . $b->user->last_name,
							'Name of Borrower' => $b->req->borrower_name,
							'Company' => $b->user->company,
							'Department' => $b->user->department->department,
							'Approved By' => $b->admin->first_name . ' ' . $b->admin->last_name,
							'Item' => $b->slip->item,
							'Category' => 'Non Asset',
							'Item Code' => '-',
							'Accessories' => strtoupper($b->slip->accs),
							'Borrower Code' => $b->slip->borrow_code,
							'Qty Requested' => $b->slip->qty,
							'Qty Released' => $b->slip->qty_r,
							'Purpose' => $b->req->details,
							'Released Date' => date('m/d/Y', strtotime($b->rel_date)),
							'Return Date Indicated' => date('m/d/Y', strtotime($b->req->slip->must_date)),
							'Item Returned Date' => $ret_date,
							'Received By' => $b->slip->get_by,
							'Missing Accessories' => '-',
							'Received by (Admin)' => $rec
						];
					}
				} else {
					if (!is_null($b->ret_date)) {
						$ret_date = date('m/d/Y', strtotime($b->ret_date));
					} else {
						$ret_date = '-';
					}
					if ($b->slip->is_asset == 1) {
						$missings = AssetRequestRemark::getByReqNoandItem($b->req_no, $b->item->barcode);
						if (!empty($missings)) {
							$missing = explode(')', $missings->details);
							$miss_item = $missing[1];
						} else {
							$miss_item = 'none';
						}
						$data[$key] = [
							'Request No.' => $b->req_no,
							'Filed By' => $b->user->first_name . ' ' . $b->user->last_name,
							'Name of Borrower' => $b->req->borrower_name,
							'Company' => $b->user->company,
							'Department' => $b->user->department->department,
							'Approved By' => '-',
							'Item' => $b->item->remarks,
							'Category' => 'Asset',
							'Item Code' => $b->item->barcode,
							'Accessories' => $b->slip->accs,
							'Borrower Code' => $b->slip->borrow_code,
							'Qty Requested' => $b->slip->qty,
							'Qty Released' => $b->slip->qty_r,
							'Purpose' => $b->req->details,
							'Released Date' => date('m/d/Y', strtotime($b->rel_date)),
							'Return Date Indicated' => date('m/d/Y', strtotime($b->req->slip->must_date)),
							'Item Returned Date' => $ret_date,
							'Received By' => $b->slip->get_by,
							'Missing Accessories' => '-',
							'Received by (Admin)' => '-'
						];
					} else {
						$data[$key] = [
							'Request No.' => $b->req_no,
							'Filed By' => $b->user->first_name . ' ' . $b->user->last_name,
							'Name of Borrower' => $b->req->borrower_name,
							'Company' => $b->user->company,
							'Department' => $b->user->department->department,
							'Approved By' => '-',
							'Item' => $b->slip->item,
							'Category' => 'Non-Asset',
							'Item Code' => '-',
							'Accessories' => strtoupper($b->slip->accs),
							'Borrower Code' => $b->slip->borrow_code,
							'Qty Requested' => $b->slip->qty,
							'Qty Released' => $b->slip->qty_r,
							'Purpose' => $b->req->details,
							'Released Date' => date('m/d/Y', strtotime($b->rel_date)),
							'Return Date Indicated' => date('m/d/Y', strtotime($b->req->slip->must_date)),
							'Item Returned Date' => $ret_date,
							'Received By' => $b->slip->get_by,
							'Missing Accessories' => '-',
							'Received by (Admin)' => '-'
						];
					}
				}
			}
			Excel::create('Item Tracking - Overdue Items (' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->sheet('Items', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAutoSize(true);
					$sheet->mergeCells('A1:T1');
					$sheet->row(1, array('Item Tracking - Overdue Borrowed Items'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A2:T2');
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:T3');
					$sheet->row(3, array('' . $date_from . ' to ' . $date_to . ''));
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setBackground('#68A6FB');
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->fromArray($data, null, 'A4', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with(['date_from' => $date_from, 'date_to' => $date_to])->with('is_null', 'Null Data');
		}
	}

	public function mgenerate(Request $request)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		$date_from = date($request->date_from);

		$date_to = date($request->date_to);

		$date_now = date('m/d/Y');

		$results = AdminSupplyRequestDetail::getReports($date_from, $date_to);

		if (!empty($results)) {
			$data = [];
			foreach ($results as $key => $value) {
				$data[$key] = [
					'MRS NO.' => $value->req->req_no,
					'DATE' => date('m/d/y', strtotime($value->req->created_at)),
					'REQUESTOR' => strtoupper($value->req->user->first_name . ' ' . $value->req->user->last_name),
					'COMPANY' => strtoupper($value->req->user->company),
					'DEPARTMENT' => strtoupper($value->req->user->department->department),
					'PURPOSE' => strtoupper($value->req->details),
					'ADDRESS' => strtoupper($value->req->deliver),
					'VIA' => strtoupper($value->req->via),
					'QTY REQUESTED' => $value->qty,
					'QTY RELEASED' => $value->qty_r,
					'U/M' => $value->measurement,
					'CATEGORY' => $value->item,
					'ITEM DESCRIPTION' => $value->item,
					'RECEIVED BY' => $value->req->received_by,
					'DATE RECEIVED' => $value->updated_at,
				];
			}
			Excel::create('Released Materials Report (' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->sheet('Asset', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAutoSize(true);
					$sheet->mergeCells('A1:O1');
					$sheet->row(1, array('MRS Report'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A2:O2');
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:O3');
					$sheet->row(3, array('' . $date_from . ' to ' . $date_to . ''));
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setBackground('#68A6FB');
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->fromArray($data, null, 'A4', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with(['date_from' => $date_from, 'date_to' => $date_to])->with('is_null', 'Null Data');
		}
	}

	public function jogenerate(Request $request)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		$date_from = date($request->date_from);

		$date_to = date($request->date_to);

		$date_now = date('m/d/Y');

		$results = JobOrder::getReports($date_from, $date_to);

		if (!empty($results)) {
			$data = [];
			foreach ($results as $key => $value) {
				if ($value->jo_status == 0) {
					$status = 'APPROVED';
				}
				if ($value->jo_status == 1) {
					$status = 'LOOKING FOR SERVICE PROVIDER';
				}
				if ($value->jo_status == 2) {
					$status = 'DONE';
				}
				if ($value->jo_status == 4) {
					$status = 'ONGOING';
				}
				if ($value->jo_status == 5) {
					$status = 'CANCELED';
				}
				if (!empty($value->date_started)) {
					$started = date('m/d/y', strtotime($value->date_started));
				} else {
					$started = '';
				}
				if (!empty($value->date_finished)) {
					$finished = date('m/d/y', strtotime($value->date_finished));
				} else {
					$finished = '';
				}
				$data[$key] = [
					'JO NO' => $value->jo_no,
					'STATUS' => $status,
					'DATE FILED' => date('m/d/y', strtotime($value->created_at)),
					'REPORTED BY' => strtoupper($value->user->first_name . ' ' . $value->user->last_name),
					'COMPANY' => strtoupper($value->user->company),
					'DEPARTMENT' => strtoupper($value->user->department->department),
					'REQUESTED WORK' => strtoupper($value->req_work),
					'ASSET NUMBER' => $value->asset_no,
					'ITEM CLASS' => $value->item_class,
					'PROBLEM' => strtoupper($value->description),
					'SERVICE PROVIDER' => strtoupper($value->served_by),
					'FINDINGS' => strtoupper($value->work_done),
					'RECOMMENDATION' => strtoupper($value->reco),
					'DATE STARTED' => $started,
					'DATE FINISHED' => $finished,
					'LABOR COST' => '',
					'MATERIAL COST' => '',
					'TOTAL COST' => $value->total_cost,
				];
			}
			Excel::create('JOB ORDER REPORT (' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->sheet('Asset', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAutoSize(true);
					$sheet->mergeCells('A1:R1');
					$sheet->row(1, array('Job Order Report'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A2:R2');
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:R3');
					$sheet->row(3, array('' . $date_from . ' to ' . $date_to . ''));
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setBackground('#68A6FB');
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->fromArray($data, null, 'A4', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with(['date_from' => $date_from, 'date_to' => $date_to])->with('is_null', 'Null Data');
		}
	}

	public function gpgenerate(Request $request)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', -1);
		$date_from = date($request->date_from);

		$date_to = date($request->date_to);

		$date_now = date('m/d/Y');

		$results = GatePass::getReports($date_from, $date_to);

		if (!empty($results)) {
			$data = [];
			foreach ($results as $key => $value) {
				$data[$key] = [
					'GATE PASS NO' => $value->req_no,
					'DATE FILED' => date('m/d/y', strtotime($value->created_at)),
					'FILED BY' => strtoupper($value->user->first_name . ' ' . $value->user->last_name),
					'REQUESTED BY' => strtoupper($value->requested_by),
					'COMPANY' => strtoupper($value->user->company),
					'DEPARTMENT' => strtoupper($value->user->department->department),
					'REF NO' => strtoupper($value->ref_no),
					'PURPOSE' => $value->purpose,
					'CONTROL NO' => $value->control_no,
					'DATE' => date('m/d/y', strtotime($value->date)),
					'GATE' => strtoupper('GATE ' . $value->exit_gate_no)
				];
			}
			Excel::create('GATEPASS REPORT (' . $date_from . '-' . $date_to . ')', function ($excel) use ($data, $date_from, $date_to, $date_now) {
				$excel->sheet('Gatepass', function ($sheet) use ($data, $date_from, $date_to, $date_now) {
					$sheet->setAutoSize(true);
					$sheet->mergeCells('A1:R1');
					$sheet->row(1, array('GATEPASS Report'));
					$sheet->row(1, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A2:K2');
					$sheet->row(2, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->mergeCells('A3:K3');
					$sheet->row(3, array('' . $date_from . ' to ' . $date_to . ''));
					$sheet->row(3, function ($row) {
						$row->setFontWeight('bold');
						$row->setBackground('#D9D1D1');
						$row->setAlignment('center');
					});
					$sheet->row(4, function ($row) {
						$row->setBackground('#68A6FB');
						$row->setFontWeight('bold');
						$row->setAlignment('center');
					});
					$sheet->fromArray($data, null, 'A4', true);
				});
			})->export('xls');
		} else {
			return redirect()->back()->with(['date_from' => $date_from, 'date_to' => $date_to])->with('is_null', 'Null Data');
		}
	}
}
