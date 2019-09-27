@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-reply"></i> JOB ORDER MAINTENANCE LIST</h2>        
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
	                <h5 style="color:white"><i class="fa fa-tags"></i> Location</h5>
	                {!! Html::decode(link_to_Route('job_order_m.show', '<i class="fa fa-plus"></i> New', $type1, ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Location</th>
				                <!-- <th>Action</th> -->			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($locations as $location)
				           		<tr>
				           			<td>{!! $location->id !!}</td>
				           			<td>{!! $location->location !!}</td>
				           			<!-- <td>{!! Html::decode(link_to_Route('service_request.edit','<i class="fa fa-pencil"></i> Edit', $location->id, array('class' => 'btn btn-info btn-xs')))!!}</td> -->
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
	                <h5 style="color:white"><i class="fa fa-tags"></i> Facilities</h5>
	                {!! Html::decode(link_to_Route('job_order_m.show', '<i class="fa fa-plus"></i> New', $type2, ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Facility</th>
				                <!-- <th>Action</th> -->			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($facilities as $facility)
				           		<tr>
				           			<td>{!! $facility->id !!}</td>
				           			<td>{!! $facility->facility !!}</td>
				           			<!-- <td>{!! Html::decode(link_to_Route('service_request.edit_sub','<i class="fa fa-pencil"></i> Edit', $facility->id, array('class' => 'btn btn-info btn-xs')))!!}</td> -->
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
	                <h5 style="color:white"><i class="fa fa-tags"></i> Equipment</h5>
	                {!! Html::decode(link_to_Route('job_order_m.show', '<i class="fa fa-plus"></i> New', $type3, ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Equipment</th>
				                <!-- <th>Action</th>	 -->		               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($equipments as $equipment)
				           		<tr>
				           			<td>{!! $equipment->id !!}</td>
				           			<td>{!! $equipment->equipment !!}</td>
				           			<!-- <td>{!! Html::decode(link_to_Route('service_request.edit_error','<i class="fa fa-pencil"></i> Edit', $equipment->id, array('class' => 'btn btn-info btn-xs')))!!}</td> -->
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
	                <h5 style="color:white"><i class="fa fa-tags"></i> Inhouse Maintenance</h5>
	                {!! Html::decode(link_to_Route('job_order_m.show', '<i class="fa fa-plus"></i> New', $type4, ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Inhouse Name</th>
				                <!-- <th>Action</th>-->
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($inhouses as $inhouse)
				           		<tr>
				           			<td>{!! $inhouse->id !!}</td>
				           			<td>{!! $inhouse->inhouse !!}</td>
			           			<!-- <td>{!! Html::decode(link_to_Route('service_request.edit_error','<i class="fa fa-pencil"></i> Edit', $inhouse->id, array('class' => 'btn btn-info btn-xs')))!!}</td> -->
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
	                <h5 style="color:white"><i class="fa fa-tags"></i> Item Class Maintenance</h5>
	                {!! Html::decode(link_to_Route('job_order_m.show', '<i class="fa fa-plus"></i> New', $type5, ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Item Class</th>
				                <th>Code</th>
				                <!-- <th>Action</th>-->
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($iclasses as $class)
				           		<tr>
				           			<td>{!! $class->id !!}</td>
				           			<td>{!! $class->equipment_type !!}</td>
				           			<td>{!! $class->description !!}</td>
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