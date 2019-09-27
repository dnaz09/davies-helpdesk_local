<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\ITRequest;

class ITManagerController extends Controller
{
    public function index(){

    	$tickets = ITRequest::byManager();

        return view('it_help_desk.manager_list',compact('tickets'));
    }
}
