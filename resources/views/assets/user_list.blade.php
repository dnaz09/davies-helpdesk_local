@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> USER ASSETS TRACKING</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Asset was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Asset was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Onhand Assets</h5>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>Item Code</th>				                
				                <th>Item Name</th>
				                <th>Action</th>
				            </tr>
			            </thead>
			            <tbody>
				           	@foreach($assets as $asset)
				           		<tr>
				           			<td>{{$asset->barcode}}</td>
				           			<td>{{$asset->item_name}}</td>
				           			<td>{!! Html::decode(link_to_Route('userasset_trackings.details','<i class="fa fa-eye"></i> View', $asset->id, array('class' => 'btn btn-warning btn-xs')))!!}</td>
				           		</tr>
				           	@endforeach
				           	@foreach($non_assets as $non_asset)
				           		<tr>
				           			<td> - </td>
				           			<td>{{$non_asset->item}}</td>
				           			<td> - </td>
				           		</tr>
				           	@endforeach
			            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
</div>	
@stop