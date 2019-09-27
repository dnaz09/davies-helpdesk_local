<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Response;
use Auth;
    
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();

        return view('location.lists',compact('locations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = new Location($request->all());
        $location->save();
        
        return redirect('locations');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LocationController  $locationController
     * @return \Illuminate\Http\Response
     */
    public function show(LocationController $locationController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LocationController  $locationController
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationController $locationController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LocationController  $locationController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocationController $locationController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LocationController  $locationController
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationController $locationController)
    {
        //
    }

    public function locationDetails(Request $request){

        $location = Location::findOrFail($request->get('locationid'));

        return Response::json($location);
    }

    public function locationUpdates(Request $request){

        $location = Location::findOrFail($request->get('location_id'));
        $location->location = $request->get('location');        
        $location->update();

        return back()->with('is_update','Updated!');
        
    }
}
