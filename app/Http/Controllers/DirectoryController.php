<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(){

    	$users = User::allActive();

    	return view('directory.index',compact('users'));
    }
}
