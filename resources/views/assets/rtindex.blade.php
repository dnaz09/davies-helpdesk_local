@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> ITEM TRACKING - RETURNED BORROWED ITEMS </h2>        
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
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_active')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Asset was successfully Activated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_inactive')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Asset was successfully Deactivated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('delete_error')): ?>
		        <div class="alert alert-warning alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Asset deletion error! You must deactivate the asset first before deleting it!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
    		<div class="panel-body">
            	<div class="tab-content">
                	<div class="tab-pane active">
			        	<p><strong>Note: </strong> All item/s below are returned completely.</p>
				        <div class="ibox float-e-margins">
				            <div class="ibox-title"style="background-color:#009688">
				                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Returned Items</h5>
				            </div>
				            <div class="ibox-content">
				            	<div class="table-responsive">
					            	<table class="table table-striped table-bordered table-hover dataTables-example" >
						            <thead>
							            <tr>
							            	<th>Control #</th>
							            	<th>Filed By</th>
							            	<th>Borrower's Name</th>
							            	<th>Returned Date</th>
							            	<th>Category</th>
							                <th>Item Code</th>
							                <th>Item Description</th>
							                <th>Accessories</th>
							            </tr>
						            </thead>
						            <tbody>
						            	<!-- assets -->
							           	@forelse($assets as $asset)
							           		<tr>
							           			<td>{!! $asset->asset_request_no !!}</td>
							           			<td>
							           				{!! strtoupper($asset->assreq->user->first_name.' '.$asset->assreq->user->last_name) !!}
							           			</td>
							           			<td>
							           				{!! strtoupper($asset->assreq->borrower_name) !!}
							           			</td>
							           			<td>
							           				{!! date('Y/m/d',strtotime($asset->return_date)) !!}
							           			</td>
							           			<td>ASSET</td>
							           			<td>@if(!empty($asset->asset)){!! $asset->asset->barcode !!}@endif</td>
							           			<td>@if(!empty($asset->asset)){!! $asset->asset->item_name !!}@endif</td>
							           			<td>{!! $asset->accs !!}</td>
							           		</tr>
							           	@empty
							           	@endforelse
							           	<!-- non assets -->
							           	@forelse($na_assets as $na_asset)
							           		<tr>
							           			<td>{!! $na_asset->asset_request_no !!}</td>
							           			<td>{!! $na_asset->assreq->user->first_name.' '.$na_asset->assreq->user->last_name !!}</td>
							           			<td>
							           				{!! strtoupper($na_asset->assreq->borrower_name) !!}
							           			</td>
							           			<td>
							           				{!! date('Y/m/d',strtotime($na_asset->return_date)) !!}
							           			</td>
							           			<td>NON - ASSET</td>
							           			<td> - </td>
							           			<td>{!! $na_asset->item !!}</td>
							           			<td> - </td>
							           		</tr>
							           	@empty
							           	@endforelse
						            </tbody>			            
					            	</table>
					            </div>
				            </div>
				        </div>
				    </div>
				    <div id="tab-2" class="tab-pane">
			        	<p><strong>Note: </strong> All non asset items below are returned completely and in good condition.</p>
				        <div class="ibox float-e-margins">
				            <div class="ibox-title"style="background-color:#009688">
				                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Returned Non Asset Items</h5>
				            </div>
				            <div class="ibox-content">
				            	<div class="table-responsive">
					            	<table class="table table-striped table-bordered table-hover dataTables-example" >
						            <thead>
							            <tr>
							            	<th>Request Number</th>
							                <th>Item Status</th>
							                <th>Item Name</th>
							            </tr>
						            </thead>
						            <tbody>
							           	
						            </tbody>			            
					            	</table>
					            </div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
	    </div>
    </div>
</div>	
@stop