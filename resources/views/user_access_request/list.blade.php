@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-user-plus"></i> USER ACCESS REQUEST LIST</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Dashboard</a>
            </li>                
            <li class="active">
                <strong>User Access Request List</strong>
            </li>
        </ol>
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access Request was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access Request was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success_sub')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access Request Sub Category was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update_sub')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access Request Sub Category was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success_error')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access Request Error was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update_error')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access Request Error was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> Category Table</h5>
	                {!! Html::decode(link_to_Route('user_access_request.create', '<i class="fa fa-plus"></i> New Category', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Category</th>
				                <th>Action</th>			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($user_acc_reqs as $user_acc_req)
				           		<tr>
				           			<td>{!! $user_acc_req->id !!}</td>
				           			<td>{!! $user_acc_req->category !!}</td>
				           			<td>{!! Html::decode(link_to_Route('user_access_request.edit','<i class="fa fa-pencil"></i> Edit', $user_acc_req->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
				           		</tr>
				           	@empty
				           	@endforelse
			            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> Sub Category Table</h5>
	                {!! Html::decode(link_to_Route('user_access_request.create_sub', '<i class="fa fa-plus"></i> New Sub Category', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Category</th>
				                <th>Sub Category</th>
				                <th>Action</th>			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($user_acc_reqs_subs as $user_acc_req_sub)
				           		<tr>
				           			<td>{!! $user_acc_req_sub->id !!}</td>
				           			<td>{!! $user_acc_req_sub->category->category !!}</td>
				           			<td>{!! $user_acc_req_sub->sub_category !!}</td>
				           			<td>{!! Html::decode(link_to_Route('user_access_request.edit_sub','<i class="fa fa-pencil"></i> Edit', $user_acc_req_sub->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
				           		</tr>
				           	@empty
				           	@endforelse
			            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> Sub Category Errors Table</h5>
	                {!! Html::decode(link_to_Route('user_access_request.create_error', '<i class="fa fa-plus"></i> New Sub Category', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Category</th>
				                <th>Sub Category</th>
				                <th>Action</th>			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($user_acc_reqs_errors as $sub)
				           		<tr>
				           			<td>{!! $sub->id !!}</td>
				           			<td>{!! $sub->subcategory->sub_category !!}</td>
				           			<td>{!! $sub->error !!}</td>
				           			<td>{!! Html::decode(link_to_Route('user_access_request.edit_error','<i class="fa fa-pencil"></i> Edit', $sub->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
				           		</tr>
				           	@empty
				           	@endforelse
			            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
</div>	
@stop