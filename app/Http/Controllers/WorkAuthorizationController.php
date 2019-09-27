<?php

namespace App\Http\Controllers;

use App\WorkAuthorization;
use App\WorkAuthorizationDetail;
use App\WorkAuthorizationRemark;
use App\WorkAuthorizationRemarkFile;
use App\TimeSlotTwo;
use App\TimeSlotThree;
use App\AccessControl;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Events\ManagerWorkAuthSent;
use App\Events\WorkAuthSent;
use App\Events\HrDashboardLoader;
use App\Events\WorkAuthApproved;
use App\Events\WorkAuthUserOk;
use App\Events\WorkAuthApprovedPerson;
use App\Events\WorkAuthRequested;

class WorkAuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $uid = Auth::id();

        $works = WorkAuthorization::byCreated($uid);

        return view('work_authorization.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(date('H:i') > date('H:i',strtotime('16:00'))){
        //     return redirect()->back()->with('is_overtime','Overtime');
        // }
        $user = Auth::user();
        $dept_id = $user->dept_id;
        $users = User::exceptUser($user->id, $dept_id);
        $times = TimeSlotTwo::orderBy('id', 'ASC')->get();
        $froms = TimeSlotThree::orderBy('id', 'ASC')->get();
        $supers = User::getAllSuperiors($user->dept_id);

        return view('work_authorization.create', compact('user', 'users', 'times', 'froms', 'supers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->others != null) {
            $curr_user = Auth::user();
            $postdata = $request->all();
            $postdata['user_id'] = Auth::id();
            $postdata['requested_by'] = strtoupper($request->requested_by);
            $postdata['security'] = 0;
            $postdata['level'] = 1;
            $postdata['time_out'] = "";
            if (!empty($request->reason)) {
                $postdata['reason'] = $request->reason;
            } else {
                $postdata['reason'] = " ";
            }
            $time_from = explode(":", $request->ot_from);
            $time_to = explode(":", $request->ot_to);
            $total_time_from = $time_from[0] + ($time_from[1] / 60);
            $total_time_to = $time_to[0] + ($time_to[1] / 60);
            // $time_not = round($total_time_to - $total_time_from);
            $time_not = $total_time_to - $total_time_from;
            $work = new WorkAuthorization($postdata);
            $work->not_exceed_to = $time_not;
            $work->date_needed = date('Y/m/d', strtotime($request->date_needed));
            $work->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength) . $work->id, -$strlength);
            $work->work_no = 'HRD-WA-' . $str;
            $work->update();

            $wd = new WorkAuthorizationDetail();
            $wd->work_auth_id = $work->id;
            $wd->user_id = $curr_user->id;
            $wd->superior = $curr_user->superior;
            $wd->superior_action = 0;
            $wd->save();

            foreach ($request->others as $id) {
                $user = User::findOrFail($id);
                $wd = new WorkAuthorizationDetail();
                $wd->work_auth_id = $work->id;
                $wd->user_id = $id;
                $wd->superior = $user->superior;
                $wd->superior_action = 0;
                $wd->save();
            }
            try {
                broadcast(new ManagerWorkAuthSent($work, $curr_user, $request->others))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();
                $module_id = 4;
                $accesses = AccessControl::findByModule($module_id);
                foreach ($accesses as $access) {
                    $user = User::findUserByidandDeptid($access->user_id, $curr_user->dept_id);
                    try {
                        // dept manager notif
                        broadcast(new WorkAuthRequested($work, $user))->toOthers();
                    } catch (\Exception $e) { }
                }
            } catch (\Exception $e) { }
            return redirect('work_authorization')->with('is_success', 'Saved!');
        } else {
            $curr_user = Auth::user();
            $postdata = $request->all();
            $postdata['user_id'] = Auth::id();
            $postdata['requested_by'] = strtoupper($request->requested_by);
            $postdata['security'] = 0;
            $postdata['level'] = 1;
            $postdata['time_out'] = "";
            if (!empty($request->reason)) {
                $postdata['reason'] = $request->reason;
            } else {
                $postdata['reason'] = " ";
            }
            $time_from = explode(":", $request->ot_from);
            $time_to = explode(":", $request->ot_to);
            $total_time_from = $time_from[0] + ($time_from[1] / 60);
            $total_time_to = $time_to[0] + ($time_to[1] / 60);
            // $time_not = round($total_time_to - $total_time_from);
            $time_not = $total_time_to - $total_time_from;
            $work = new WorkAuthorization($postdata);
            $work->not_exceed_to = $time_not;
            $work->date_needed = date('Y/m/d', strtotime($request->date_needed));
            $work->save();

            $strlength = 6;
            $str = substr(str_repeat(0, $strlength) . $work->id, -$strlength);
            $work->work_no = 'HRD-WA-' . $str;
            $work->update();

            $wd = new WorkAuthorizationDetail();
            $wd->work_auth_id = $work->id;
            $wd->user_id = $curr_user->id;
            $wd->superior = $curr_user->superior;
            $wd->superior_action = 0;
            $wd->save();

            $to_user = $curr_user->id;
            try {
                broadcast(new ManagerWorkAuthSent($work, $curr_user, $to_user))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();
                $module_id = 4;
                $accesses = AccessControl::findByModule($module_id);
                foreach ($accesses as $access) {
                    $user = User::findUserByidandDeptid($access->user_id, $curr_user->dept_id);
                    try {
                        // dept manager notif
                        broadcast(new WorkAuthRequested($work, $user))->toOthers();
                    } catch (\Exception $e) { }
                }
            } catch (\Exception $e) { }
            return redirect('work_authorization')->with('is_success', 'Saved!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkAuthorization  $workAuthorization
     * @return \Illuminate\Http\Response
     */
    public function show(WorkAuthorization $workAuthorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkAuthorization  $workAuthorization
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkAuthorization $workAuthorization)
    {
        $work = $workAuthorization;
        $user = Auth::user();
        $dept_id = $user->dept_id;
        $user = Auth::user();
        $details = WorkAuthorizationDetail::pendingByWorkGetUserId($work->id);
        $approves = WorkAuthorizationDetail::pendingByWorkGetUserIdApproved($work->id);
        $times = TimeSlotTwo::orderBy('id', 'ASC')->get();
        $froms = TimeSlotThree::orderBy('id', 'ASC')->get();
        $supers = User::getAllSuperiors($user->dept_id);
        $users = User::exceptUser($user->id, $dept_id);

        return view('work_authorization.edit', compact('work', 'user', 'times', 'froms', 'supers', 'users', 'details', 'approves'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkAuthorization  $workAuthorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkAuthorization $workAuthorization)
    {
        $curr_user = Auth::user();
        $time_from = explode(":", $request->ot_from);
        $time_to = explode(":", $request->ot_to);
        $total_time_from = $time_from[0] + ($time_from[1] / 60);
        $total_time_to = $time_to[0] + ($time_to[1] / 60);
        // $time_not = round($total_time_to - $total_time_from);
        $time_not = $total_time_to - $total_time_from;
        $workAuthorization->ot_from = $request->ot_from;
        $workAuthorization->ot_to = $request->ot_to;
        $workAuthorization->reason = $request->reason;
        $workAuthorization->not_exceed_to = $time_not;
        $workAuthorization->requested_by = $request->requested_by;
        $workAuthorization->update();

        $work_details = WorkAuthorizationDetail::byWorkUnapproved($workAuthorization->id);
        if (!empty($work_details)) {
            foreach ($work_details as $details) {
                $details->delete();
            }
        }
        $wd = new WorkAuthorizationDetail();
        $wd->work_auth_id = $workAuthorization->id;
        $wd->user_id = $curr_user->id;
        $wd->superior = $curr_user->superior;
        $wd->superior_action = 0;
        $wd->save();
        if (!empty($request->others)) {
            foreach ($request->others as $id) {
                $user = User::findOrFail($id);
                $wd = new WorkAuthorizationDetail();
                $wd->work_auth_id = $workAuthorization->id;
                $wd->user_id = $id;
                $wd->superior = $user->superior;
                $wd->superior_action = 0;
                $wd->save();
            }
        }

        return redirect('work_authorization')->with('is_updated', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkAuthorization  $workAuthorization
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkAuthorization $workAuthorization)
    {
        //
    }

    public function details($id)
    {

        $work = WorkAuthorization::findOrFail($id);
        $remarks = WorkAuthorizationRemark::byWork($id);
        $emps = WorkAuthorizationDetail::byWork($id);

        return view('work_authorization.emp_details', compact('work', 'remarks', 'emps'));
    }

    public function cancel(Request $request)
    {
        $work = WorkAuthorization::findOrFail($request->id);
        if (!empty($work)) {
            $emps = WorkAuthorizationDetail::byWork($work->id);
            if (!empty($emps)) {
                foreach ($emps as $emp) {
                    // if($emp->superior_action < 1){
                    $emp->superior_action = 5;
                    $emp->update();
                    // }
                }
                $work->level = 5;
                $work->update();
            }
            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
            } catch (\Exception $e) { }
            return \Response::json(['type' => '1']);
        }
        return \Response::json(['type' => '3']);
    }

    public function remarks(Request $request)
    {

        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if ($sub < 2) {
            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            return back()->with('is_sucess', 'Saved!');
        }

        if ($sub == 2) {

            $work = WorkAuthorization::where('id', $postdata['work_id'])->first();
            $curr_user = User::findOrFail($work->user_id);
            if ($work->superior_action < 2) {
                $work->superior_action = 2;
                $work->superior = Auth::id();
                $work->level = 2;
            } else {
                $work->hrd_action = 2;
                $work->hrd = Auth::id();
            }
            $work->update();

            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try {
                broadcast(new WorkAuthApproved($work, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();
                return redirect('dashboard')->with('is_closed', 'Close');
            } catch (\Exception $e) {
                return redirect('dashboard')->with('is_closed', 'Close');
            }
        } elseif ($sub == 3) {

            $work = WorkAuthorization::where('id', $postdata['work_id'])->first();
            if ($work->superior_action < 2) {
                $work->superior_action = 3;
                $work->superior = Auth::id();
                $work->level = 1;
            } else {
                $work->hrd_action = 3;
                $work->hrd = Auth::id();
            }
            $work->update();

            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
                return redirect('dashboard')->with('is_closed', 'Close');
            } catch (\Exception $e) {
                return redirect('dashboard')->with('is_closed', 'Close');
            }
        }

        return back()->with('is_sucess', 'Saved!');
    }

    public function sup_work_authorization_list()
    {

        // $works = WorkAuthorization::bySup();
        $id = Auth::id();
        $wds = WorkAuthorizationDetail::bySup($id);
        foreach ($wds as $wd) {
            $works = WorkAuthorization::findOrFail($wd->work_auth_id);
        }
        return view('work_authorization.sup_lists', compact('works'));
    }

    // public function sup_details($id){

    //     $work = WorkAuthorization::findOrFail($id);
    //     $remarks = WorkAuthorizationRemark::byWork($id);

    //     return view('work_authorization.sup_details',compact('work','remarks'));
    // }
    // HR DETAILS
    public function hrd_details($id)
    {

        $work = WorkAuthorization::find($id);
        $remarks = WorkAuthorizationRemark::byWork($id);
        $emps = WorkAuthorizationDetail::byWork($id);

        $files = WorkAuthorizationRemarkFile::byWork($id);

        return view('work_authorization.hrd_details', ['work' => $work, 'remarks' => $remarks, 'emps' => $emps]);
    }

    public function editDate(Request $request)
    {
        $result = "E";

        $work = WorkAuthorization::findOrFail($request->id);
        if (!empty($work)) {
            $work->date_needed = date('Y/m/d', strtotime($request->newDate));
            $work->save();
            $result = "S";
        }
        return response()->json($result);
    }

    //HR LIST
    public function hr_work_authorization_list(Request $request)
    {
        // echo date('Y-m-d H:i:s',strtotime($request->textsearch)); die;
        $ispaginate = 0;

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $works = [];
        $searchkey = $request->textsearch;
        if ($request->textsearch != '') {
            // $works = WorkAuthorization::where('requested_by', 'LIKE', '%' .$searchkey. '%')
            //             ->orWhere('created_at', 'LIKE', '%' .date('Y-m-d H:i:s',strtotime($searchkey)). '%')
            //             ->orWhere('work_no', 'LIKE', '%' .$searchkey. '%')
            //             ->paginate(15)
            //             ->setPath('');
            $works = WorkAuthorization::searchByWord($searchkey);
            // $pagination = $works->appends ( array ('textsearch' => $request->textsearch));
            // 
            if (count($works) > 0) {
                return view('work_authorization.hrd_lists', compact('works', 'ispaginate', 'searchkey'))->withDetails($works)->withQuery($searchkey);
            } else {
                return view('work_authorization.hrd_lists', compact('works', 'ispaginate', 'searchkey'))->withMessage('No Details found. Try to search again!');
            }
        } else {
            $ispaginate = 1;
            $works = WorkAuthorization::orderBy('created_at', 'desc')->paginate(15);
            // $works = WorkAuthorization::all();
            return view('work_authorization.hrd_lists', compact('works', 'ispaginate', 'searchkey'));
        }
        // $works = WorkAuthorizationDetail::byHrd();
        // $works = WorkAuthorization::getAllWorkAuths();

    }
    //SUPERIOR LIST
    public function mngrsup_work_authorization_list()
    {
        $manager_dept_id = Auth::user()->dept_id;

        $id = Auth::id();
        $works = WorkAuthorizationDetail::bySup($id);

        return view('work_authorization.sup_lists', compact('works'));

        // $works = WorkAuthorization::byDeptId($manager_dept_id);

        // $works = WorkAuthorization::byUnder(Auth::id());

        // return view('manager.mng_workauth_list',['works'=>$works]);
    }
    // SUPERIOR DETAILS
    public function mngrsup_details($id)
    {
        $work = WorkAuthorization::find($id);
        $remarks = WorkAuthorizationRemark::byWork($id);
        $emps = WorkAuthorizationDetail::byWork($id);

        $files = WorkAuthorizationRemarkFile::byWork($id);
        $type = "sup";
        return view('dept_manager.work_auth_details', ['work' => $work, 'remarks' => $remarks, 'emps' => $emps, 'type' => $type]);
    }
    public function workremarks(Request $request)
    {
        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if ($sub < 2) {
            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        if ($sub == 2) {

            $work = WorkAuthorization::where('id', $postdata['work_id'])->first();

            $curr_user = User::findOrFail($work->user_id);

            $work->superior_action = 2;
            $work->superior = Auth::id();
            $work->level = 2;
            $work->update();

            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try {
                broadcast(new WorkAuthSent($work, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();
                return redirect('dashboard')->with('is_sucess', 'Saved!');
            } catch (\Exception $e) {
                return redirect('dashboard')->with('is_sucess', 'Saved!');
            }
        } elseif ($sub == 3) {

            $work = WorkAuthorization::where('id', $postdata['work_id'])->first();
            if ($work->superior_action < 2) {
                $work->superior_action = 3;
                $work->superior = Auth::id();
                $work->level = 1;
            } else {
                $work->hrd_action = 3;
                $work->hrd = Auth::id();
            }
            $work->update();
            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
                return redirect('dashboard')->with('is_sucess', 'Saved!');
            } catch (\Exception $e) {
                return redirect('dashboard')->with('is_closed', 'Close');
            }
        }

        return back()->with('is_sucess', 'Saved!');
    }
    public function mngr_work_authorization_list()
    {
        $manager_dept_id = Auth::user()->dept_id;

        $works = WorkAuthorizationDetail::byDept($manager_dept_id);

        // $works = WorkAuthorization::byUnder(Auth::id());

        return view('dept_manager.work_auth_list', ['works' => $works]);
    }
    public function mngr_work_authorization_details($id)
    {
        $work = WorkAuthorization::find($id);
        $remarks = WorkAuthorizationRemark::byWork($id);
        $emps = WorkAuthorizationDetail::byWork($id);

        $files = WorkAuthorizationRemarkFile::byWork($id);
        $type = 'mng';
        return view('dept_manager.work_auth_details', ['work' => $work, 'remarks' => $remarks, 'emps' => $emps, 'type' => $type]);
    }
    public function approving(Request $request)
    {
        ini_set('memory_limit', '-1');
        $work = $request->work_id;
        $workauth = WorkAuthorization::findOrFail($work);

        $user = $request->user_id;
        $curr_user = Auth::user();
        $sub = $request->sub;
        if ($sub == 1) {
            $wd = WorkAuthorizationDetail::byWorkAndUser($work, $user);
            $wd->superior_action = 1;
            $wd->save();

            $works = WorkAuthorization::findOrFail($work);
            $emps = WorkAuthorizationDetail::pendingByWork($work);
            if (count($emps) == 0) {
                $works->level = 2;
                $works->save();
            }

            $wduser = User::findOrFail($wd->user_id);
            try {
                broadcast(new WorkAuthApprovedPerson($workauth, $wduser))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();

                if ($works->user->superior == Auth::user()->id) {
                    return \Response::json(1);
                } else {
                    return \Response::json(2);
                }
            } catch (\Exception $e) {
                if ($works->user->superior == Auth::user()->id) {
                    return \Response::json(1);
                } else {
                    return \Response::json(2);
                }
            }
        } elseif ($sub == 2) {
            $wd = WorkAuthorizationDetail::byWorkAndUser($work, $user);
            $wd->superior_action = 2;
            $wd->save();

            $works = WorkAuthorization::findOrFail($work);
            $emps = WorkAuthorizationDetail::pendingByWork($work);
            if (count($emps) == 0) {
                $works->level = 2;
                $works->save();
            }
            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
                if ($works->user->superior == Auth::user()->id) {
                    return \Response::json(1);
                } else {
                    return \Response::json(2);
                }
            } catch (\Exception $e) {
                if ($works->user->superior == Auth::user()->id) {
                    return \Response::json(1);
                } else {
                    return \Response::json(2);
                }
            }
        } elseif ($sub == 3) {

            $works = WorkAuthorization::findOrFail($work);

            if (!empty($works)) {
                $works->level = 2;
                $works->save();
            }

            $wds = WorkAuthorizationDetail::pendingByWork($work);

            foreach ($wds as $wd) {
                //comment to approve all
                // if($wd->user->superior == Auth::id()){
                $wd->superior_action = 1;
                $wd->save();
                $wduser = User::findOrFail($wd->user_id);

                try {
                    broadcast(new WorkAuthApprovedPerson($workauth, $wduser))->toOthers();
                } catch (\Exception $e) { }
                // }
            }
            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
                // if($works->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_success','Saved!');
                // }else{
                return redirect()->back()->with('is_success', 'Saved!');
                // } 
            } catch (\Exception $e) {
                // if($works->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_success','Saved!');
                // }else{
                return redirect()->back()->with('is_success', 'Saved!');
                // } 
            }
        } elseif ($sub == 4) {
            $works = WorkAuthorization::findOrFail($work);
            if (!empty($works)) {
                $works->level = 2;
                $works->save();
            }
            $wds = WorkAuthorizationDetail::pendingByWork($work);
            foreach ($wds as $wd) {
                // if($wd->user->superior == Auth::id()){
                $wd->superior_action = 2;
                $wd->save();
                // }
            }
            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
                // if($works->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_deny','Saved!');
                // }else{
                return redirect()->back()->with('is_deny', 'Saved!');
                // } 
            } catch (\Exception $e) {
                // if($works->user->superior == Auth::user()->id){
                //     return redirect('superior')->with('is_deny','Saved!');
                // }else{
                return redirect()->back()->with('is_deny', 'Saved!');
                // }
            }
        } elseif ($sub == 5) {

            $wd = WorkAuthorizationDetail::byWorkAndUser($work, $user);
            $wd->superior_action = 5;
            $wd->save();

            $works = WorkAuthorization::findOrFail($work);
            $emps = WorkAuthorizationDetail::pendingByWork($work);
            $approved = WorkAuthorizationDetail::getApproved($work);
            if (count($emps) == 0) {
                if (count($approved) == 0) {
                    $works->level = 5;
                } else {
                    $works->level = 2;
                }
                $works->save();
            }

            $wduser = User::findOrFail($wd->user_id);
            try {
                broadcast(new WorkAuthApprovedPerson($workauth, $wduser))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();

                if ($works->user->superior == Auth::user()->id) {
                    return \Response::json(1);
                } else {
                    return \Response::json(2);
                }
            } catch (\Exception $e) {
                if ($works->user->superior == Auth::user()->id) {
                    return \Response::json(1);
                } else {
                    return \Response::json(2);
                }
            }
        }
    }
    public function mngr_work_authorization_remarks(Request $request)
    {
        $curr_user = Auth::user();
        $postdata = $request->all();
        $postdata['remarks_by'] = Auth::id();
        $sub = $request->sub;

        if ($sub < 2) {
            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();
        }

        if ($sub == 2) {

            $work = WorkAuthorization::where('id', $postdata['work_id'])->first();

            $work->superior_action = 2;
            $work->superior = Auth::id();
            $work->level = 2;
            $work->update();

            $remark = new WorkAuthorizationRemark();
            $remark->work_authorization_id = $request->work_id;
            $remark->details = $request->details;
            $remark->remarks_by = Auth::id();
            $remark->save();

            try {
                broadcast(new WorkAuthSent($work, $curr_user))->toOthers();
                broadcast(new HrDashboardLoader($work))->toOthers();
                return redirect('dashboard')->with('is_sucess', 'Close');
            } catch (\Exception $e) {
                return redirect('dashboard')->with('is_sucess', 'Close');
            }
        } elseif ($sub == 3) {

            $work = WorkAuthorization::where('id', $postdata['work_id'])->first();
            if ($work->superior_action < 2) {
                $work->superior_action = 3;
                $work->superior = Auth::id();
                $work->level = 1;
            } else {
                $work->hrd_action = 3;
                $work->hrd = Auth::id();
            }
            $work->update();
            try {
                broadcast(new HrDashboardLoader($work))->toOthers();
                return redirect('dashboard')->with('is_deny', 'Denied');
            } catch (\Exception $e) {
                return redirect('dashboard')->with('is_deny', 'Denied');
            }
        }

        return back()->with('is_sucess', 'Saved!');
    }

    // work auth checker
    public function guardindex()
    {
        $works = WorkAuthorizationDetail::getAllForToday();

        return view('guards.workindex', compact('works'));
    }

    public function guardadd(Request $request)
    {
        $work = WorkAuthorizationDetail::findOrFail($request->id);
        if (!empty($work)) {
            $work->exit_time = date('H:i');
            $work->save();
        }

        return;
    }

    public function get_time(Request $request)
    {
        $id = $request->id;
        $work = WorkAuthorizationDetail::findOrFail($id);
        if (!empty($work)) {
            return \Response::json($work);
        }
        return \Response::json();
    }

    public function add_time(Request $request)
    {
        $id = $request->id;
        $work = WorkAuthorizationDetail::findOrFail($id);
        if (!empty($work)) {
            $work->exit_time = date('H:i', strtotime($request->time));
            $work->save();

            return redirect()->back()->with('time_added', 'Success');
        }
        return redirect()->back()->with('error', 'Error');
    }
}
