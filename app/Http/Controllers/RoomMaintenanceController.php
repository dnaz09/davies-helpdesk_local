<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomMaintenanceController extends Controller
{
    public function index()
    {
    	$rooms = Room::all();

    	return view('rooms.index',compact('rooms'));
    }

    public function create()
    {
    	return view('rooms.create');
    }

    public function store(Request $request)
    {
    	if(!empty($request->room_name)){
    		$room = new Room();
    		$room->room_name = strtoupper($request->room_name);
    		$room->vacancy = 0;
    		$room->save();

    		return redirect('rooms')->with('is_success','Success');
    	}
    	return redirect()->back()->with('is_error','Error');
    }

    public function edit($id)
    {
    	$room = Room::findOrFail($id);
    	if(!empty($room)){
    		return view('rooms.edit',compact('room'));
    	}
    	return redirect()->back()->with('is_error','Error');
    }

    public function update(Request $request,$id)
    {
    	$room = Room::findOrFail($id);
    	if(!empty($room)){
    		$room->room_name = $request->room_name;
    		$room->update();

    		return redirect('rooms')->with('is_updated','Success');
    	}
    	return redirect('rooms')->with('is_error','Error');
    }
}
