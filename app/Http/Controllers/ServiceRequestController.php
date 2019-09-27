<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceRequestCategory;
use App\ServiceRequestSubCategory;
use App\ServiceRequestSubSubCategory;

class ServiceRequestController extends Controller
{	
	protected $request;

	public function __construct(Request $request){

		$this->request = $request;
	}
    public function index(){

		$serve_reqs = ServiceRequestCategory::all();
		$serve_reqs_subs = ServiceRequestSubCategory::all();
		$serve_reqs_branch = ServiceRequestSubSubCategory::all();

		return view('service_request.list',compact('serve_reqs','serve_reqs_subs','serve_reqs_branch')); 

	}

	public function create(){

		return view('service_request.create');
	}

	public function store(Request $request){

		$postdata = $this->request->all();

		$u_acc = new ServiceRequestCategory($postdata);
		$u_acc->save();

		return redirect('service_request')->with('is_success','Save!');
	}

	public function edit($id){

		$serve_reqs = ServiceRequestCategory::findOrFail($id);

		return view('service_request.edit',compact('serve_reqs'));
	}

	public function update(Request $request, $id){

		$serve_reqs = ServiceRequestCategory::findOrFail($id);
		$serve_reqs->category = $this->request->get('category');
		$serve_reqs->update();

		return redirect('service_request')->with('is_updated','Updated!');

	}

	public function create_sub(){

		$category = ServiceRequestCategory::pluck('category','id');

		return view('service_request.create_sub',compact('category'));
	}

	public function store_sub(Request $request){

		$postdata = $this->request->all();
		$postdata['category_id'] = $this->request->get('category');

		$u_acc = new ServiceRequestSubCategory($postdata);
		$u_acc->save();

		return redirect('service_request')->with('is_success_sub','Save!');
	}

	public function edit_sub($id){

		$user_accs = ServiceRequestSubCategory::findOrFail($id);
		$category = ServiceRequestCategory::pluck('category','id');

		return view('service_request.edit_sub',compact('user_accs','category'));
	}

	public function update_sub(Request $request, $id){

		$user_accs = ServiceRequestSubCategory::findOrFail($id);
		$user_accs->category_id = $this->request->get('category');
		$user_accs->sub_category = $this->request->get('sub_category');
		$user_accs->update();

		return redirect('service_request')->with('is_updated_sub','Updated!');

	}

	public function create_error()
	{
		$subs = ServiceRequestSubCategory::pluck('sub_category','id');

		return view('service_request.create_error',compact('subs'));
	}

	public function store_error(Request $request)
	{
		$postdata = $this->request->all();
		$postdata['sub_categ_id'] = $this->request->get('sub_category');

		$err = new ServiceRequestSubSubCategory($postdata);
		$err->save();

		return redirect('service_request')->with('is_success_error','Save!');
	}

	public function edit_error($id){

		$error = ServiceRequestSubSubCategory::findOrFail($id);
		$subs = ServiceRequestSubCategory::pluck('sub_category','id');

		return view('service_request.edit_error',compact('error','subs'));
	}

	public function update_error(Request $request, $id){

		$error = ServiceRequestSubSubCategory::findOrFail($id);
		$error->sub_categ_id = $this->request->get('sub_category');
		$error->sub_sub_category = $this->request->get('sub_sub_category');
		$error->update();

		return redirect('service_request')->with('is_updated_error','Updated!');

	}
}
