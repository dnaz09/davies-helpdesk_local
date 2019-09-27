@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> USER'S BORROW HISTORY</h2>        
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
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> My Borrow History</h5>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>Control #</th>				                
				                <th>Borrower Code</th>
				                <th>Item Code</th>
				                <th>Item</th>
				                <th>Qty Requested</th>
				                <th>Qty Received</th>
				                <th>Received By</th>
				            </tr>
			            </thead>
			            <tbody>
			            	@foreach($histories as $history)
	           				@forelse($history->items as $item)
	           				<tr>
	           					<td>{{$item->asset_request_no}}</td>
	           					<td>{{$item->borrow_code}}</td>
	           					<td>
	           						@if($item->asset_barcode != null)
	           							{{$item->asset_barcode}}
	           						@else
	           						-
	           						@endif
	           					</td>
		           				<td>{{$item->item}}</td>
		           				<td>{{$item->qty}}</td>
		           				<td>{{$item->qty_r}}</td>
		           				<td>
		           					@if($item->received_by != null && $item->received_by != ' ')
		           						{{ strtoupper($item->receiever->first_name.' '.$item->receiever->last_name) }}
		           					@else
		           					-
		           					@endif
		           				</td>
	           				</tr>
	           				@empty
	           				@endforelse
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