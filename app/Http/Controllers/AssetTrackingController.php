<?php

namespace App\Http\Controllers;

use App\AssetTracking;
use App\AssetRouting;
use App\AssetCategory;
use App\AssetReport;
use App\BorrowerSlip;
use App\AssetBorrowHistory;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Events\ExpiredAssetSent;
use DB;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class AssetTrackingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = AssetTracking::orderBy('item_name', 'ASC')->get();

        return view('assets.lists', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categs = AssetCategory::all();
        // $categs = AssetCategory::getName();

        return view('assets.create', compact('categs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = AssetTracking::findByBarcode($request->get('barcode'));
        if (count($check) < 1) {
            $asset = new AssetTracking();
            $asset->barcode = $request->get('barcode');
            $asset->item_name = $request->get('item_name');
            $asset->remarks = $request->get('remarks');
            $asset->category = $request->get('category');
            $asset->brand = $request->get('brand');
            $asset->io = 1;
            $asset->active = 1;
            $asset->must_date = date('Y-m-d', strtotime('0000-00-00'));
            $asset->returned_date = date('Y-m-d', strtotime('0000-00-00'));
            $asset->holder = 0;

            $asset->save();

            return redirect('asset_trackings')->with('is_success', 'Saved!');
        } else {
            return redirect()->back()->with('is_error', 'Error!');
        }
    }

    public function deactivate($id)
    {
        $asset = AssetTracking::findOrFail($id);
        $asset->active = 0;
        $asset->update();

        return redirect()->back()->with('is_inactive', 'Saved!');
    }

    public function activate($id)
    {
        $asset = AssetTracking::findOrFail($id);
        $asset->active = 1;
        $asset->update();

        return redirect()->back()->with('is_active', 'Saved!');
    }

    public function delete($id)
    {
        $asset = AssetTracking::findOrFail($id);
        if ($asset->active == 0) {
            $asset->delete();
            return redirect()->back()->with('is_deleted', 'Delete');
        } else {
            return redirect()->back()->with('delete_error', 'Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssetTracking  $assetTracking
     * @return \Illuminate\Http\Response
     */
    public function show(AssetTracking $assetTracking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssetTracking  $assetTracking
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetTracking $assetTracking)
    {
        $asset = $assetTracking;
        $ctgry = $assetTracking->category;
        $categs = AssetCategory::getCategs($ctgry);

        return view('assets.edit', compact('asset', 'categs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssetTracking  $assetTracking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetTracking $assetTracking)
    {
        $assetTracking->barcode = $request->barcode;
        $assetTracking->brand = $request->brand;
        $assetTracking->item_name = $request->item_name;
        $assetTracking->remarks = $request->remarks;
        $assetTracking->category = $request->category;
        $assetTracking->update();

        return redirect('asset_trackings')->with('is_updated', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssetTracking  $assetTracking
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetTracking $assetTracking)
    {
        //
    }

    public function route_history($id)
    {

        $asset = AssetTracking::findOrFail($id);
        $routings = AssetRouting::byAsset($id);
        $users = User::FullDetails();
        return view('assets.route_history', compact('routings', 'asset', 'users'));
    }

    public function borrow_history($id)
    {
        $asset = AssetTracking::byBarcode($id);
        if (!empty($asset)) {
            $histories = AssetBorrowHistory::byBarcode($asset->barcode);

            return view('assets.item_history', compact('asset', 'histories'));
        } else {
            return redirect()->back()->with('no_asset', 'Error');
        }
    }

    public function route_history_update(Request $request)
    {

        $type = $request->get('type');
        $asset = AssetTracking::byBarcode($request->get('barcode'));
        $user = User::findOrFail($request->get('user_id'));
        if ($type > 0) {

            if (!empty($asset)) {

                $history = new AssetRouting();
                $history->asset_id = $asset->id;
                $history->holder = $request->get('user_id');
                $history->barcode = $asset->barcode;
                $history->remarks = nl2br($request->get('remarks'));
                $history->remarks2 = "Asset Has Been Released To " . ' ' . strtoupper($user->first_name . ' ' . $user->last_name);
                $history->must_date = date('Y-m-d', strtotime($request->date));
                $history->returned_date = date('Y-m-d', strtotime('0000-00-00'));
                $history->return_status = 0;
                $history->save();

                $asset->io = 0;
                $asset->holder = $user->id;
                $asset->must_date = date('Y-m-d', strtotime($request->date));
                $asset->returned_date = date('Y-m-d', strtotime('0000-00-00'));
                $asset->update();
            }

            return redirect()->action('AssetTrackingController@route_history', ['id' => $asset->id])->with('is_pass', 'Saved');
        } else {
            if (!empty($asset)) {

                $history = new AssetRouting();
                $history->asset_id = $asset->id;
                $history->holder = Auth::id();
                $history->barcode = $asset->barcode;
                $history->remarks = nl2br($request->get('remarks'));
                $history->remarks2 = "Asset Has Been Returned To " . ' ' . strtoupper($user->first_name . ' ' . $user->last_name);
                $history->returned_date = date('Y-m-d');
                $history->must_date = date('Y-m-d', strtotime('0000-00-00'));
                $history->return_status = 0;
                $history->save();
                $asset->io = 1;
                $asset->holder = $user->id;
                $asset->returned_date = date('Y-m-d');
                $asset->update();
                if ($history->returned_date > $asset->must_date) {
                    $history->return_status = 2;
                } else {
                    $history->return_status = 1;
                }
            }
            $history->update();
            return redirect()->action('AssetTrackingController@route_history', ['id' => $asset->id])->with('is_pass', 'Saved');
        }


        return redirect()->action('AssetTrackingController@route_history', ['id' => $asset->id]);
    }

    public function trackexpired()
    {
        $now_date = date('Y-m-d');
        $ass = [];
        // $exps = AssetTracking::where('must_date',$now_date)->get();
        $expss = AssetTracking::where('must_date', $now_date)->count();
        // foreach($exps as $exp){
        //     $users = User::findOrFail($exp->holder);
        //     $all[] = $users;
        // }
        broadcast(new ExpiredAssetSent($expss))->toOthers();
        return ['expss' => $expss];
    }

    public function released_index()
    {
        $items = BorrowerSlip::getReleasedAssets();
        $naitems = BorrowerSlip::getReleasedNonAssets();
        // $nonassets = BorrowerSlip::NAbyReleased();
        return view('assets.rindex', compact('items', 'naitems'));
    }

    public function returned_index()
    {
        // $assets = AssetTracking::byReturned();
        $assets = BorrowerSlip::byReturned();
        $na_assets = BorrowerSlip::NaByReturned();

        return view('assets.rtindex', compact('assets', 'na_assets'));
    }

    public function returning(Request $request)
    {
        $asset = AssetTracking::findOrFail($request->asset_id);
        $asset->io = 1;
        $asset->holder = 0;
        $asset->save();

        return redirect()->back()->with('is_returned', 'success');
    }

    public function category_list()
    {
        $categs = AssetCategory::all();

        return view('assets.category_list', compact('categs'));
    }

    public function category_show_create()
    {
        return view('assets.category_create');
    }

    public function category_list_store(Request $request)
    {
        $categs = new AssetCategory();
        $categs->category_name = $request->category_name;
        $categs->save();

        // return redirect()->back()->with('is_success', 'added');
        return redirect()->action('AssetTrackingController@category_list')->with('is_success', 'Added');
    }

    public function category_list_details($id)
    {
        $categ = AssetCategory::findOrFail($id);

        return view('assets.category_details', compact('categ'));
    }

    public function category_list_update(Request $request)
    {
        $categ = AssetCategory::findOrFail($request->category_id);
        $categ->category_name = $request->category_name;
        $categ->update();

        return redirect()->action('AssetTrackingController@category_list')->with('is_updated', 'Added');
    }
    //  api item upload
    public function apisave(Request $request)
    {
        $fileName = $request->file('data')->getClientOriginalName();

        $c_folder = substr($fileName, 0, 4);
        $b_folder = substr($fileName, 4, 4);
        $t_folder = substr($fileName, 8, 2);
        $destinationPath = storage_path() . '/uploads/assets/' . $c_folder . '/' . $b_folder . '/' . $t_folder;

        if (!\File::exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $request->file('data')->move($destinationPath, $fileName);

        $filePath = $destinationPath . "/" . $fileName;

        DB::beginTransaction();
        $reader = ReaderFactory::create(Type::CSV); // for XLSX files
        $reader->setFieldDelimiter('|');
        $reader->open($filePath);
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                if ($row[0] == 'DPPI') {
                    $barcode = $row[1];
                    $item = $row[3];
                    $category = $row[4];
                    AssetTracking::create([
                        'barcode' => $barcode,
                        'item_name' => $item,
                        'remarks' => $item,
                        'category' => $category,
                        'brand' => $item,
                        'must_date' => '1970-01-01',
                        'returned_date' => '1970-01-01',
                        'io' => 1,
                        'holder' => 0,
                        'active' => 1
                    ]);
                }
            }
        }
        $reader->close();
        DB::commit();
        return response()->json(array('msg' => 'file uploaded', 'status' => 0));
    }
}
