<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\AssetTracking;
use App\AssetRouting;
use App\BorrowerSlip;
use App\User;

class AssetTrackingUserController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $assets = AssetTracking::byUserId($id);
        $non_assets = BorrowerSlip::getMyNonAssets($id);
        // $assets = AssetTracking::byUserId($id);

        return view('assets.user_list',compact('assets','non_assets'));
    }

    public function show($id)
    {
        $asset = AssetTracking::findOrFail($id);        
        $routings = AssetRouting::byAsset($id);
        $users = User::FullDetails();
        $date_now = date('Y-m-d');
        return view('assets.user_details',['routings'=>$routings,'asset'=>$asset,'users'=>$users,'date_now'=>$date_now]);
    }
}
