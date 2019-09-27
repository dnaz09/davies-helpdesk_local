<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use App\ITRequest;
use Auth;
use App\EmployeeExitPass;
use App\OBP;
use App\Undertime;
use App\Requisition;
use App\WorkAuthorization;
use App\AssetRequest;
use App\SupplyRequest;
use App\JobOrder;
use App\Note;
use App\BorrowerSlip;
use App\WorkAuthorizationDetail;
use App\EmployeeRequisition;
use App\User;
use App\AccessControl;

class DashboardController extends Controller
{

	public function index()
	{

		$user = Auth::user();
		$uid = $user->id;
		// $announcements = Announcement::orderBy('created_at','Desc')->get();		
		// $announcements = Announcement::byDept($user->dept_id);
		$announcements = Announcement::getByMyDept($user->dept_id);
		$ann_cntr = count($announcements);

		$notes = Note::byUser($user->id);


		if ($user->dept_id === 7) {

			// dd($announcements); die;
			//IT DEPARTMENT
			// $totalIT = ITRequest::count();
			// if($totalIT < 1){
			// 	$totalIT = 1;
			// }
			// $totalITpending = ITRequest::getTotalOngoing();
			// $totalITreturned = ITRequest::getTotalReturned();
			// $totalITsolved = ITRequest::getTotalClosed();

			// //service
			// $totalSIT = ITRequest::getTotalService();
			// if($totalSIT < 1){
			// 	$totalSIT = 1;
			// }
			// $totalSPending = ITRequest::serviceOngoing();
			// $totalSReturned = ITRequest::serviceReturned();
			// $totalSSolved = ITRequest::serviceSolved();

			// //useraccess
			// $totalAIT = ITRequest::getAccessTotal();
			// if($totalAIT < 1){
			// 	$totalAIT = 1;
			// }
			// $totalUPending = ITRequest::accessOngoing();
			// $totalUReturned = ITRequest::accessReturned();
			// $totalUSolved = ITRequest::accessSolved();		

			// //individual
			// $solvedService = ITRequest::solvedService(Auth::id());
			// $solvedAccess = ITRequest::solvedAccess(Auth::id());	

			// return view('dashboard.indexIT',compact('announcements','ann_cntr','totalIT','totalSIT','totalAIT','totalITpending','totalITreturned','totalITsolved','totalSPending','totalSReturned','totalSSolved','totalUPending','totalUReturned','totalUSolved','solvedService','solvedAccess','notes','uid'));
			return view('dashboard.indexIT', compact('announcements', 'ann_cntr', 'notes', 'uid'));
		}

		if ($user->dept_id === 6) {

			//HR DEPARTMENT
			// $obpP = OBP::getPendingHR();
			// $undertimeP = Undertime::getPendingHR();
			// $requisitionP = Requisition::getPendingHR();
			// $exitpassP = EmployeeExitPass::getPendingHR();
			// $workauthP = WorkAuthorization::getPendingHR();

			// if(count(OBP::all()) > 0){
			// 	$totalobp = ($obpP/count(OBP::all()))*100;
			// }else{
			// 	$totalobp = 0;
			// }
			// if(count(Undertime::all()) > 0){
			// 	$totalundertime = ($undertimeP/Undertime::count())*100;
			// }else{
			// 	$totalundertime = 0;
			// }
			// if(count(Requisition::all()) > 0){
			// 	$totalrequisition = ($requisitionP/Requisition::count())*100;
			// }else{
			// 	$totalrequisition = 0;
			// }
			// if(count(EmployeeExitPass::all()) > 0){
			// 	$totalexitpass = ($exitpassP/EmployeeExitPass::count())*100;
			// }else{
			// 	$totalexitpass = 0;
			// }
			// if(count(WorkAuthorization::all()) > 0){
			// 	$totalworkauth = ($workauthP/WorkAuthorization::count())*100;
			// }else{
			// 	$totalworkauth = 0;
			// }

			// return view('dashboard.indexHR',compact('announcements','ann_cntr','totalobp','totalundertime','totalrequisition','totalexitpass','totalworkauth','obpP','undertimeP','requisitionP','exitpassP','workauthP','notes','uid'));
			return view('dashboard.indexHR', compact('announcements', 'ann_cntr', 'notes', 'uid'));
		}

		if ($user->dept_id === 1) {

			//ADMIN DEPARTMENT

			// $assetP = AssetRequest::getTotalOngoing();
			// $supplyP = SupplyRequest::getTotalOngoing();

			// if(SupplyRequest::count() > 0){
			// 	$totalsupply =($supplyP/SupplyRequest::count())*100;
			// }else{
			// 	$totalsupply = 0;
			// }
			// if(AssetRequest::count() > 0){
			// 	$totalasset = ($assetP/AssetRequest::count())*100;
			// }else{
			// 	$totalasset = 0;
			// }

			// return view('dashboard.indexAS',compact('announcements','ann_cntr','assetP','supplyP','totalasset','totalsupply','notes','uid'));
			// return view('dashboard.indexAS',compact('announcements','ann_cntr','assetP','supplyP','totalasset','totalsupply','notes','uid'));
			// 
			return view('dashboard.indexAS', compact('announcements', 'ann_cntr', 'notes', 'uid'));
		}

		if ($user->id === 25) {

			return view('dashboard.indexMT', compact('announcements', 'ann_cntr', 'notes', 'uid'));
		}


		return view('dashboard.index', compact('announcements', 'ann_cntr', 'notes', 'uid'));

		//

		// return view('dashboard.index',compact('announcements'));
	}
	public function hrdash()
	{
		//HR DEPARTMENT
		$obpP = OBP::getPendingHR();
		$pendingobps = OBP::fetchPendingHR();

		$undertimeP = Undertime::getPendingCount();
		$undertimes = Undertime::getPending();

		$requisitionP = Requisition::getPendingHR();
		$reqs = Requisition::getPending();

		$exitpassP = EmployeeExitPass::getPendingHRCount();
		$exitpass = EmployeeExitPass::getPendingHR();

		$workauthP = WorkAuthorizationDetail::countPending();
		$workauths = WorkAuthorizationDetail::Pending();

		$empreqP = EmployeeRequisition::countPending();
		$empreqs = EmployeeRequisition::Pending();

		if (count(OBP::all()) > 0) {
			$totalobp = number_format($obpP / count(OBP::all())) * 100;
		} else {
			$totalobp = number_format(0);
		}
		if (count(Undertime::all()) > 0) {
			$totalundertime = number_format($undertimeP / Undertime::count()) * 100;
		} else {
			$totalundertime = number_format(0);
		}
		if (count(Requisition::all()) > 0) {
			$totalrequisition = number_format($requisitionP / Requisition::count()) * 100;
		} else {
			$totalrequisition = number_format(0);
		}
		if (count(EmployeeExitPass::all()) > 0) {
			$totalexitpass = number_format($exitpassP / EmployeeExitPass::count()) * 100;
		} else {
			$totalexitpass = number_format(0);
		}
		if (count(WorkAuthorization::all()) > 0) {
			$totalworkauth = number_format($workauthP / WorkAuthorization::count()) * 100;
		} else {
			$totalworkauth = number_format(0);
		}
		return [
			'totalworkauth' => $totalworkauth,
			'workauthP' => $workauthP,
			'obpP' => $obpP,
			'totalobp' => $totalobp,
			'totalundertime' => $totalundertime,
			'undertimeP' => $undertimeP,
			'totalrequisition' => $totalrequisition,
			'requisitionP' => $requisitionP,
			'pendingobps' => $pendingobps,
			'workauths' => $workauths,
			'undertimes' => $undertimes,
			'reqs' => $reqs,
			'exitpassP' => $exitpassP,
			'exitpass' => $exitpass,
			'empreqP' => $empreqP,
			'empreqs' => $empreqs
		];
	}
	public function itdash()
	{
		$totalIT = ITRequest::count();
		if ($totalIT < 1) {
			$totalIT = 1;
		}
		$totalITpending1 = ITRequest::getTotalOngoing();
		if ($totalITpending1 > 0) {
			$totalITpending = number_format($totalITpending1 / $totalIT * 100);
		} else {
			$totalITpending = 0;
		}
		$totalITreturned1 = ITRequest::getTotalReturned();
		if ($totalITreturned1 > 0) {
			$totalITreturned = number_format($totalITreturned1 / $totalIT * 100);
		} else {
			$totalITreturned = 0;
		}
		$totalITsolved1 = ITRequest::getTotalClosed();
		if ($totalITsolved1 > 0) {
			$totalITsolved = number_format($totalITsolved1 / $totalIT * 100);
		} else {
			$totalITsolved = 0;
		}

		//service
		$totalSIT = ITRequest::getTotalService();
		if ($totalSIT < 1) {
			$totalSIT = 1;
		}
		$totalSPending1 = ITRequest::serviceOngoing();
		if (count($totalSPending1) > 0) {
			$totalSPending = number_format($totalSPending1 / $totalSIT * 100);
		} else {
			$totalSPending = 0;
		}
		$totalSReturned1 = ITRequest::serviceReturned();
		if (count($totalSReturned1) > 0) {
			$totalSReturned = number_format($totalSReturned1 / $totalSIT * 100);
		} else {
			$totalSReturned = 0;
		}
		$totalSSolved1 = ITRequest::serviceSolved();
		if (count($totalSSolved1) > 0) {
			$totalSSolved = number_format($totalSSolved1 / $totalSIT * 100);
		} else {
			$totalSSolved = 0;
		}


		//useraccess
		$totalAIT = ITRequest::getAccessTotal();
		if ($totalAIT < 1) {
			$totalAIT = 1;
		}
		$totalUPending1 = ITRequest::accessOngoing();
		if ($totalUPending1 > 0) {
			$totalUPending = number_format($totalUPending1 / $totalAIT * 100);
		} else {
			$totalUPending = 0;
		}
		$totalUReturned1 = ITRequest::accessReturned();
		if ($totalUReturned1 > 0) {
			$totalUReturned = number_format($totalUReturned1 / $totalAIT * 100);
		} else {
			$totalUReturned = 0;
		}
		$totalUSolved1 = ITRequest::accessSolved();
		if ($totalUSolved1 > 0) {
			$totalUSolved = number_format($totalUSolved1 / $totalAIT * 100);
		} else {
			$totalUSolved = 0;
		}

		//individual
		$solvedService1 = count(ITRequest::solvedService(Auth::id()));
		if ($solvedService1 < 1) {
			$solvedService = number_format($solvedService1 / $totalSIT * 100);
		} else {
			$solvedService = 0;
			$solvedService1 = 0;
		}
		$solvedAccess1 = count(ITRequest::solvedAccess(Auth::id()));
		if ($solvedAccess1 < 1) {
			$solvedAccess = number_format($solvedAccess1 / $totalSIT * 100);
		} else {
			$solvedAccess = 0;
			$solvedAccess1 = 0;
		}

		$its = ITRequest::getAllPending();
		$itscount = ITRequest::getAllPendingCount();
		return [
			'totalSPending' => $totalSPending,
			'totalSPending1' => $totalSPending1,
			'totalSReturned' => $totalSReturned,
			'totalSReturned1' => $totalSReturned1,
			'totalSSolved' => $totalSSolved,
			'totalSSolved1' => $totalSSolved1,
			'totalUPending' => $totalUPending,
			'totalUPending1' => $totalUPending1,
			'totalUReturned' => $totalUReturned,
			'totalUReturned1' => $totalUReturned1,
			'totalUSolved' => $totalUSolved,
			'totalUSolved1' => $totalUSolved1,
			'totalITpending' => $totalITpending,
			'totalITpending1' => $totalITpending1,
			'totalITreturned' => $totalITreturned,
			'totalITreturned1' => $totalITreturned1,
			'totalITsolved' => $totalITsolved,
			'totalITsolved1' => $totalITsolved1,
			'solvedService' => $solvedService,
			'solvedAccess' => $solvedAccess,
			'solvedService1' => $solvedService1,
			'solvedAccess1' => $solvedAccess1,
			'its' => $its,
			'itscount' => $itscount,
		];
	}

	public function asdash()
	{
		$assetpending = AssetRequest::getPending();
		$assetrp = BorrowerSlip::getToRelease();
		$totalassetrp = BorrowerSlip::getToReleaseCount();
		$assetP = AssetRequest::getTotalOngoing();
		$joP = JobOrder::getAdminAllPending();

		if (AssetRequest::count() > 0) {
			$totalasset = number_format($assetP / AssetRequest::count()) * 100;
		} else {
			$totalasset = 0;
		}
		if (JobOrder::count() > 0) {
			$totaljo = number_format($joP / JobOrder::count()) * 100;
		} else {
			$totaljo = 0;
		}

		return [
			'assetP' => $assetP,
			'joP' => $joP,
			'totalasset' => $totalasset,
			'totaljo' => $totaljo,
			'assetpending' => $assetpending,
			'assetrp' => $assetrp,
			'totalassetrp' => $totalassetrp
		];
	}

	public function mtdash()
	{
		$mtuseraccs = ITRequest::getTotalMamTifOngoing();
		$saps = ITRequest::ManagerPendingCount();

		return ['mtuseraccs' => $mtuseraccs, 'saps' => $saps];
	}

	public function mydashboard()
	{
		$id = Auth::id();

		$myworksp = WorkAuthorizationDetail::getMineCount($id);
		$myworks = WorkAuthorizationDetail::getMine($id);
		$myundsp = Undertime::getMineCount($id);
		$myunds = Undertime::getMine($id);
		$myitemsp = AssetRequest::getMineCount($id);
		$myitems = AssetRequest::getMine($id);
		$myobpsp = OBP::getMineCount($id);
		$myobps = OBP::getMine($id);
		$myreqsp = Requisition::getMineCount($id);
		$myreqs = Requisition::getMine($id);
		$myitsp = ITRequest::getMineCount($id);
		$myits = ITRequest::getMine($id);

		$mysum = $myworksp + $myundsp + $myitemsp + $myobpsp + $myreqsp + $myitsp;


		return [
			'myworks' => $myworks,
			'myunds' => $myunds,
			'myitems' => $myitems,
			'myobps' => $myobps,
			'myreqs' => $myreqs,
			'myits' => $myits,
			'mysum' => $mysum
		];
	}

	public function addModule($id)
	{
		$users_id = User::get()->pluck('id')->toArray();
		$userThatHasAccess = AccessControl::where('module_id', $id)->get()->pluck('user_id')->toArray();
		$result_id = array_diff($users_id, $userThatHasAccess);

		if (!empty($result_id)) {
			foreach ($result_id as $key => $value) {
				$access = new AccessControl();

				$access->user_id = $value;
				$access->module_id = $id;
				$access->save();
			}
		}
	}
}
