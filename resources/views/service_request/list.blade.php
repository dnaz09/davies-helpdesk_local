@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-reply"></i> SERVICE REQUEST LIST</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Category was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Category was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success_sub')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Sub Category was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update_sub')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Sub Category was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success_error')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Error was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_updated_error')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Error was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> Category Table</h5>
	                {!! Html::decode(link_to_Route('service_request.create', '<i class="fa fa-plus"></i> New Category', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
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
				           @forelse($serve_reqs as $serve_req)
				           		<tr>
				           			<td>{!! $serve_req->id !!}</td>
				           			<td>{!! $serve_req->category !!}</td>
				           			<td>{!! Html::decode(link_to_Route('service_request.edit','<i class="fa fa-pencil"></i> Edit', $serve_req->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
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
	                {!! Html::decode(link_to_Route('service_request.create_sub', '<i class="fa fa-plus"></i> New Sub Category', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
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
				           @forelse($serve_reqs_subs as $serve_reqs_sub)
				           		<tr>
				           			<td>{!! $serve_reqs_sub->id !!}</td>
				           			<td>{!! $serve_reqs_sub->category->category !!}</td>
				           			<td>{!! $serve_reqs_sub->sub_category !!}</td>
				           			<td>{!! Html::decode(link_to_Route('service_request.edit_sub','<i class="fa fa-pencil"></i> Edit', $serve_reqs_sub->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
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
	                <h5 style="color:white"><i class="fa fa-tags"></i> Errors Per Sub Category Table</h5>
	                {!! Html::decode(link_to_Route('service_request.create_error', '<i class="fa fa-plus"></i> New Error', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Sub Category</th>
				                <th>Error</th>
				                <th>Action</th>			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($serve_reqs_branch as $sub)
				           		<tr>
				           			<td>{!! $sub->id !!}</td>
				           			<td>{!! $sub->subcategory->sub_category !!}</td>
				           			<td>{!! $sub->sub_sub_category !!}</td>
				           			<td>{!! Html::decode(link_to_Route('service_request.edit_error','<i class="fa fa-pencil"></i> Edit', $sub->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
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