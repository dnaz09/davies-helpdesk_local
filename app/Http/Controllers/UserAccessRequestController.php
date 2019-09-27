<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAccessRequestCategory;
use App\UserAccessRequestSubCategory;
use App\UserAccessRequestSubSubCategory;

class UserAccessRequestController extends Controller
{
    
	public function __construct(Request $request){


		$this->request = $request;		
	}

	public function index(){

		$user_acc_reqs = UserAccessRequestCategory::all();
		$user_acc_reqs_subs = UserAccessRequestSubCategory::all();
		$user_acc_reqs_errors = UserAccessRequestSubSubCategory::all();

		return view('user_access_request.list',compact('user_acc_reqs','user_acc_reqs_subs','user_acc_reqs_errors')); 

	}

	public function create(){

		return view('user_access_request.create');
	}

	public function store(Request $request){

		$postdata = $this->request->all();

		$u_acc = new UserAccessRequestCategory($postdata);
		$u_acc->save();

		return redirect('user_access_request')->with('is_success','Save!');
	}

	public function edit($id){

		$user_accs = UserAccessRequestCategory::findOrFail($id);

		return view('user_access_request.edit',compact('user_accs'));
	}

	public function update(Request $request, $id){

		$user_accs = UserAccessRequestCategory::findOrFail($id);
		$user_accs->category = $this->request->get('category');
		$user_accs->update();

		return redirect('user_access_request')->with('is_updated','Updated!');

	}

	public function create_sub(){

		$category = UserAccessRequestCategory::pluck('category','id');

		return view('user_access_request.create_sub',compact('category'));
	}

	public function store_sub(Request $request){

		$postdata = $this->request->all();
		$postdata['category_id'] = $this->request->get('category');

		$u_acc = new UserAccessRequestSubCategory($postdata);
		$u_acc->save();

		return redirect('user_access_request')->with('is_success_sub','Save!');
	}

	public function edit_sub($id){

		$user_accs = UserAccessRequestSubCategory::findOrFail($id);
		$category = UserAccessRequestCategory::pluck('category','id');

		return view('user_access_request.edit_sub',compact('user_accs','category'));
	}

	public function update_sub(Request $request, $id){

		$user_accs = UserAccessRequestSubCategory::findOrFail($id);
		$user_accs->category_id = $this->request->get('category');
		$user_accs->sub_category = $this->request->get('sub_category');
		$user_accs->update();

		return redirect('user_access_request')->with('is_updated_sub','Updated!');

	}

	public function create_error()
	{
		$subs = UserAccessRequestSubCategory::pluck('sub_category','id');

		return view('user_access_request.create_error',compact('subs'));
	}

	public function store_error(Request $request)
	{
		$postdata = $this->request->all();
		$postdata['sub_categ_id'] = $this->request->get('sub_category');

		$err = new UserAccessRequestSubSubCategory($postdata);
		$err->save();

		return redirect('user_access_request')->with('is_success_error','Save!');
	}

	public function edit_error($id)
	{
		$error = UserAccessRequestSubSubCategory::findOrFail($id);
		$subs = UserAccessRequestSubCategory::pluck('sub_category','id');

		return view('user_access_request.edit_error',compact('error','subs'));
	}

	public function update_error(Request $request, $id){

		$err = UserAccessRequestSubSubCategory::findOrFail($id);
		$err->sub_categ_id = $this->request->get('sub_category');
		$err->error = $this->request->get('error');
		$err->update();

		return redirect('user_access_request')->with('is_updated_sub','Updated!');

	}
}
