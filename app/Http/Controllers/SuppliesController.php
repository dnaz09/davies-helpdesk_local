<?php

namespace App\Http\Controllers;

use App\SupplyMaintenance;
use Response;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SuppliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplies = SupplyMaintenance::all();

        return view('supplies.index', compact('supplies'));
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
        $supp = new SupplyMaintenance($request->all());
        $supp->save();

        return back()->with('is_success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplies  $supplies
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyMaintenance $supplies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplies  $supplies
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplyMaintenance $supplies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplies  $supplies
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request)
    {
        $supplies = SupplyMaintenance::findOrFail($request->sup_id);
        $supplies->category = $request->category;
        $supplies->material_code = $request->material_code;
        $supplies->description = $request->description;
        $supplies->update();

        return back()->with('is_updated', 'Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplies  $supplies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplies $supplies)
    {
        //
    }

    public function getDetails(Request $request)
    {

        $supp = SupplyMaintenance::findOrFail($request->supid);

        return Response::json($supp);
    }

    public function import()
    {

        return view('supplies.import');
    }

    public function upload(Request $request)
    {

        if (Input::hasFile('attached')) {

            $reqs = $request->file('attached');

            foreach ($reqs as $req) {

                $destinationPath = public_path() . '/uploads/files/';
                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $filename = $req->getClientOriginalName();
                $req->move($destinationPath, $filename);

                Excel::selectSheets('davies')->load($destinationPath . $filename, function ($reader) {
                    Supplies::import1($reader->get());
                });

                Excel::selectSheets('charter')->load($destinationPath . $filename, function ($reader) {
                    Supplies::import2($reader->get());
                });
                if (\File::exists($destinationPath)) {
                    \File::delete($destinationPath);
                }
            }

            return redirect('supplies');
        } else {

            print_r("no file");
            die;
        }
    }
}
