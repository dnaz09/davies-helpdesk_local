@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> BORROWED ITEMS TRACKING</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_active')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully Activated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_inactive')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully Deactivated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('delete_error')): ?>
		        <div class="alert alert-warning alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item deletion error! You must deactivate the item first before deleting it!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Items Tracking Table</h5>	                
	                {!! Html::decode(link_to_Route('asset_trackings.create', '<i class="fa fa-plus"></i> New Asset', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>Item Code</th>
				                <th>Item Description</th>
				                <th>Item Type</th>				                
				                <th>Current Holder</th>
				                <th>Action</th>
				                <th>History</th>
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($assets as $asset)
				           		<tr>
				           			<td>{!! $asset->barcode !!}</td>
				           			<td>{!! $asset->item_name !!}</td>	           							
				           			<td>{!! $asset->category !!}</td>           							
				           			<td>
				           				@if($asset->active == 1)
					           				@if($asset->io == 0)
					           				{!! strtoupper($asset->user->first_name.' '.$asset->user->last_name) !!}
					           				@endif
					           				@if($asset->io == 1)
					           				{!! strtoupper('currently onhand') !!}
					           				@endif
					           			@elseif($asset->active == 0)
					           				{!! strtoupper('assigned') !!}
					           			@endif
				           			</td>
				           			<td>
				           				{!! Html::decode(link_to_Route('asset_trackings.edit','<i class="fa fa-pencil"></i> Edit', $asset->id, array('class' => 'btn btn-info btn-xs')))!!}
				           				@if($asset->active == 0)
				           				{!! Html::decode(link_to_Route('asset_trackings.activate','<i class="fa fa-pencil"></i> Activate', $asset->id, array('class' => 'btn btn-info btn-xs')))!!}
				           				@else
				           				{!! Html::decode(link_to_Route('asset_trackings.deactivate','<i class="fa fa-pencil"></i> Deactivate', $asset->id, array('class' => 'btn btn-info btn-xs')))!!}
				           				@endif
				           				{!! Html::decode(link_to_Route('asset_trackings.delete','<i class="fa fa-pencil"></i> Delete', $asset->id, array('class' => 'btn btn-info btn-xs')))!!}
				           			</td>
				           			<!-- <td>{!! Html::decode(link_to_Route('asset_trackings.route_history','<i class="fa fa-eye"></i> View', $asset->id, array('class' => 'btn btn-warning btn-xs')))!!}</td> -->
				           			<td>{!! Html::decode(link_to_Route('asset_trackings.borrow_history','<i class="fa fa-eye"></i> View', $asset->barcode, array('class' => 'btn btn-warning btn-xs')))!!}</td>
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