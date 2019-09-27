<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\RoomRequest;
use App\RoomRequestRemark;
use App\User;
use App\AccessControl;
use App\Events\SendRoomRequest;
use App\Events\ChangeStatusRoomRequest;
use App\Events\RoomRequestClosed;
use Calendar;
use Auth;
use Response;

class RoomRequestController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $reqs = [];
        $rooms = RoomRequest::getMyRequest($id);
        $others = RoomRequest::all();
        if (!empty($others)) {
            foreach ($others as $key => $value) {
                $start = date('Y-m-d H:i:s', strtotime($value->start_date . ' ' . $value->start_time));
                $end = date('Y-m-d H:i:s', strtotime($value->end_date . ' ' . $value->end_time));

                $room = $value->room . "\n" . ' (' . date('h:i a', strtotime($start)) . '-' . date('h:i a', strtotime($end)) . ')';

                if ($value->status < 2) {
                    $reqs[] = Calendar::event(
                        $room,
                        false,
                        new \DateTime($start),
                        new \DateTime($end),
                        null,
                        [
                            'color' => '#f05050',
                        ]
                    );
                } else {
                    $reqs[] = Calendar::event(
                        $room,
                        false,
                        new \DateTime($start),
                        new \DateTime($end),
                        null,
                        [
                            'color' => '#B9B8B8',
                        ]
                    );
                }
            }
        }
        $calendar = Calendar::addEvents($reqs);
        return view('room_reqs.index', compact('rooms', 'calendar'));
    }

    public function create()
    {
        if (date('H:i') >= date('H:i', strtotime('16:00'))) {
            $rooms = Room::getAllExceptPantry();
        } else {
            $rooms = Room::getAllVacant();
        }
        $date_from = date('m/d/Y');
        $date_to = date('m/d/Y');
        return view('room_reqs.create', compact('rooms', 'date_from', 'date_to'));
    }

    public function store(Request $request)
    {
        if ($request->room != '-') {
            if (date('m/d/Y', strtotime($request->start_date)) <= date('m/d/Y', strtotime($request->end_date))) {
                if (date('m/d/Y H:i', strtotime($request->start_date . ' ' . $request->start_time)) < date('m/d/Y H:i', strtotime($request->end_date . ' ' . $request->end_time))) {
                    $old = RoomRequest::findByRequest($request->room, $request->start_date);
                    // dd($old);
                    // dd($request->all());
                    $num = 0;
                    if (!empty($old)) {
                        // dd(['num 1' => $old]);

                        foreach ($old as $o) {
                            if (date('m/d/Y H:i', strtotime($o->start_date . ' ' . $o->start_time)) < date('m/d/Y H:i', strtotime($request->start_date . ' ' . $request->start_time)) && date('m/d/Y H:i', strtotime($o->end_date . ' ' . $o->end_time)) > date('m/d/Y H:i', strtotime($request->start_date . ' ' . $request->start_time))) {
                                $num++;
                            }
                            if (date('m/d/Y H:i', strtotime($o->start_date . ' ' . $o->start_time)) > date('m/d/Y H:i', strtotime($request->start_date . ' ' . $request->start_time)) && date('m/d/Y H:i', strtotime($o->start_date . ' ' . $o->start_time)) < date('m/d/Y H:i', strtotime($request->end_date . ' ' . $request->end_time))) {
                                $num++;
                            }
                            if (date('m/d/Y', strtotime($o->start_date)) != date('m/d/Y', strtotime($o->end_date))) {
                                if (date('m/d/Y', strtotime($o->start_date . ' ' . $o->start_time)) < date('m/d/Y', strtotime($request->start_date . ' ' . $request->start_time)) && date('m/d/Y', strtotime($o->end_date . ' ' . $o->end_time)) > date('m/d/Y', strtotime($request->end_date . ' ' . $request->end_time))) {
                                    if (date('m/d/Y H:i', strtotime($o->end_date . ' ' . $o->end_time)) > date('m/d/Y H:i', strtotime($request->start_date . ' ' . $request->start_date)) && date('m/d/Y H:i', strtotime($o->start_date . ' ' . $o->start_time)) < date('m/d/Y H:i', strtotime($request->start_date . ' ' . $request->start_time))) {
                                        $num++;
                                    }
                                }
                            }
                            if ($o->status == '5' && $o->approval == '5') {
                                $num = 0;
                            } else {
                                $num++;
                            }
                        }
                        // dd(['num 1' => $num]);
                    }
                    if ($num == 0) {
                        $req = new RoomRequest();
                        $req->req_no = 'req_no';
                        $req->dept_id = Auth::user()->dept_id;
                        $req->user_id = Auth::user()->id;
                        $req->room = $request->room;
                        $req->details = $request->details;
                        $req->start_date = $request->start_date;
                        $req->end_date = $request->end_date;
                        $req->start_time = $request->start_time;
                        $req->end_time = $request->end_time;
                        $req->facilitator = $request->facilitator;
                        $req->att_no = $request->att_no;
                        $req->setup = $request->setup;
                        $req->status = 0;
                        $req->save();

                        $strlength = 6;
                        $str = substr(str_repeat(0, $strlength) . $req->id, -$strlength);
                        $req->req_no = "ASD-RM-" . $str;
                        $req->update();

                        $id = 67;
                        $acss = AccessControl::findByModule($id);
                        foreach ($acss as $acs) {
                            $user = User::findOrFail($acs->user_id);
                            try {
                                broadcast(new SendRoomRequest($req, $user))->toOthers();
                            } catch (\Exception $e) { }
                        }
                        return redirect('room_reqs')->with('is_success', 'Success');
                    } else {
                        return redirect()->back()->with('oops_room', 'Error');
                    }
                }
                return redirect()->back()->with('error_date', 'Error');
            }
            return redirect()->back()->with('error_date', 'Error');
        } else {
            return redirect()->back()->with('is_error', 'Error');
        }
    }

    public function show($id)
    {
        $req = RoomRequest::findOrFail($id);
        if (!empty($req)) {
            $routings = RoomRequestRemark::findByReqId($req->id);
            return view('room_reqs.details', compact('req', 'routings'));
        }
        return redirect()->back()->with('is_error', 'Error');
    }

    public function remarks(Request $request)
    {
        $req = RoomRequest::findOrFail($request->id);
        if (!empty($req)) {
            $remark = new RoomRequestRemark();
            $remark->user_id = Auth::id();
            $remark->remarks = $request->details;
            $remark->room_req_id = $req->id;
            $remark->save();

            return redirect()->back()->with('is_success', 'Success');
        } else {
            return redirect()->back()->with('is_error', 'Error');
        }
    }

    public function adminindex()
    {
        $reqs = RoomRequest::getAll();

        $rooms = RoomRequest::getOngoingRooms();
        $time_now = date('h:i a');

        return view('room_reqs.admin_index', compact('reqs', 'rooms', 'time_now'));
    }

    public function admindetails($id)
    {
        $req = RoomRequest::findOrFail($id);
        if (!empty($req)) {
            $routings = RoomRequestRemark::findByReqId($req->id);
            return view('room_reqs.admin_details', compact('req', 'routings'));
        } else {
            return redirect()->back()->with('is_error', 'Error');
        }
    }

    public function adminremarks(Request $request)
    {
        $req = RoomRequest::findOrFail($request->id);
        if (!empty($req)) {
            $sub = $request->sub;
            if ($sub == 1) {
                if (!empty($request->details)) {
                    $remark = new RoomRequestRemark();
                    $remark->user_id = Auth::id();
                    $remark->remarks = $request->details;
                    $remark->room_req_id = $req->id;
                    $remark->save();

                    return redirect()->back()->with('is_success', 'Success');
                } else {
                    return redirect()->back()->with('is_null', 'Error');
                }
            }
            if ($sub == 2) {
                $room = Room::findByName($req->room);
                if ($req->status != 5) {
                    if ($room->vacancy == 0) {
                        $req->approval = 2;
                        $req->approver = Auth::id();
                        $req->update();

                        $user = User::findOrFail($req->user_id);

                        if (!empty($request->details)) {
                            $details = $request->details;
                        } else {
                            $details = 'Approved!';
                        }
                        $remark = new RoomRequestRemark();
                        $remark->user_id = Auth::id();
                        $remark->remarks = $details;
                        $remark->room_req_id = $req->id;
                        $remark->save();

                        try {
                            broadcast(new ChangeStatusRoomRequest($req, $user))->toOthers();
                        } catch (Exception $e) { }
                        return redirect('room_request_list')->with('is_approved', 'Success');
                    }
                } else {
                    return redirect('room_request_list')->with('is_already_canceled', 'Okay');
                }
            }
            if ($sub == 3) {
                if (!empty($request->details)) {
                    $details = $request->details;
                } else {
                    $details = 'Denied!';
                }
                $remark = new RoomRequestRemark();
                $remark->user_id = Auth::id();
                $remark->remarks = $details;
                $remark->room_req_id = $req->id;
                $remark->save();

                if ($req->status != 5) {
                    $req->approval = 3;
                    $req->status = 3;
                    $req->approver = Auth::id();
                    $req->update();

                    $user = User::findOrFail($req->user_id);
                    try {
                        broadcast(new ChangeStatusRoomRequest($req, $user))->toOthers();
                    } catch (Exception $e) { }
                    return redirect('room_request_list')->with('is_denied', 'Denied');
                } else {
                    return redirect('room_request_list')->with('is_already_canceled', 'Denied');
                }
            }
            if ($sub == 4) {
                $req->status = 2;
                $req->save();

                $room = Room::findByName($req->room);
                if (!empty($room)) {
                    $room->vacancy = 0;
                    $room->save();

                    if (!empty($request->details)) {
                        $details = $request->details;
                    } else {
                        $details = 'All of the Terms and Agreements were followed by the requestor!';
                    }
                    $remark = new RoomRequestRemark();
                    $remark->user_id = Auth::id();
                    $remark->remarks = $details;
                    $remark->room_req_id = $req->id;
                    $remark->save();

                    $user = User::findOrFail($req->user_id);
                    try {
                        broadcast(new RoomRequestClosed($req, $user))->toOthers();
                    } catch (Exception $e) { }
                    return redirect('room_request_list')->with('is_closed', 'Success');
                } else {
                    return redirect('room_request_list')->with('is_not_close', 'Success');
                }
            }
            if ($sub == 5) {
                $req->status = 1;
                $req->save();

                $room = Room::findByName($req->room);
                if (!empty($room)) {
                    $room->vacancy = 1;
                    $room->save();

                    $user = User::findOrFail($req->user_id);

                    if (!empty($request->details)) {
                        $details = $request->details;
                    } else {
                        $details = 'Ongoing';
                    }
                    $remark = new RoomRequestRemark();
                    $remark->user_id = Auth::id();
                    $remark->remarks = $details;
                    $remark->room_req_id = $req->id;
                    $remark->save();

                    try {
                        broadcast(new ChangeStatusRoomRequest($req, $user))->toOthers();
                    } catch (Exception $e) { }
                    return redirect('room_request_list')->with('is_served', 'Success');
                }
            }
            if ($sub == 6) {
                $req->status = 0;
                $req->save();

                $user = User::findOrFail($req->user_id);

                if (!empty($request->details)) {
                    $details = $request->details;
                } else {
                    $details = 'The Requestor has violated the Terms and Agreements!';
                }
                $remark = new RoomRequestRemark();
                $remark->user_id = Auth::id();
                $remark->remarks = $details;
                $remark->room_req_id = $req->id;
                $remark->save();

                try {
                    broadcast(new ChangeStatusRoomRequest($req, $user))->toOthers();
                } catch (Exception $e) { }
                return redirect('room_request_list')->with('is_returned_to_pending', 'Success');
            }
        }
    }

    public function cancel(Request $request)
    {
        $req = RoomRequest::findOrFail($request->id);
        if (!empty($req)) {
            // if($req->approval < 2){
            $req->status = 5;
            $req->approval = 5;
            $req->save();

            return Response::json('S');
            // }else{
            //     return Response::json(['type'=>'2']);
            // }
        } else {
            return Response::json('E');
        }
    }
}
