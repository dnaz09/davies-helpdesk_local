@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> ITEM TRACKING - RELEASED BORROWED ITEMS </h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully returned!<i class="fa fa-check"></i></h4></center>                
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
		    <?php if (session('is_returned')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Asset was successfully Returned!<i class="fa fa-check"></i></h4></center>                
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
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Released Items</h5>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
	            		<div class="panel-body">
			            	<table class="table table-striped table-bordered table-hover dataTables-example" >
					            <thead>
						            <tr>
						            	<th>Control #</th>
						            	<th>Filed By</th>
						            	<th>Borrower's Name</th>
						            	<th>Released Date</th>
						            	<th>Return Date Indicated</th>
						            	<th>Category</th>
						                <th>Item Code</th>
						                <th>Item Type</th>
						                <th>Qty</th>
						                <th>Accessories</th>
						                <th>Return of Item</th>
						            </tr>
					            </thead>
					            <tbody>
						           	@forelse($items as $item)
						           		@if($item->must_date < date('Y-m-d'))
						           		<tr class="danger" style="opacity:0.6; filter:alpha(opacity=40);">
						           			<td>{!! $item->asset_request_no !!}</td>
						           			<td>
						           				{!! strtoupper($item->asset->user->first_name.' '.$item->asset->user->last_name) !!}
						           			</td>
						           			<td>{!! strtoupper($item->assreq->borrower_name) !!}</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($item->updated_at)) !!}
						           			</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($item->must_date)) !!}
						           			</td>
						           			<td>ASSET</td>
						           			<td>{!! $item->asset_barcode !!}</td>
						           			<td>{!! $item->item !!}</td>
						           			<td>{!! $item->qty !!}</td>
						           			<td>
						           				@if($item->accs != null)
						           				{!! strtoupper($item->accs) !!}
						           				@else
						           				NO ACCESSORIES INCLUDED
						           				@endif
						           			</td>
						           			<td>
						           				{!!Form::open(array('route'=>'returned_assets.returning','method'=>'POST'))!!}
						           					<input type="hidden" name="id" value="{{$item->id}}">
						           					<input type="hidden" name="asset_id" value="{{$item->asset->id}}">
						           					<input type="hidden" name="rno" value="{{$item->asset_request_no}}">
						           					<input type="hidden" name="barcode" value="{{$item->asset_barcode}}">
						           					<input type="hidden" name="category" value="{{$item->asset->category}}">
					           						{{Form::label('incomplete','Missing Accessories (Leave blank if none)')}}
												 	<input type="text" class="form-control" name="missing" placeholder="Accessory...">
						           					<button type="submit" class="btn btn-xs btn-success"> Return</button>
						           				{!!Form::close()!!}
						           			</td>
						           		</tr>
						           		@else
						           		<tr>
						           			<td>
												   {!! $item->asset_request_no !!}
												</td>
						           			<td>
												
						           				{{ strtoupper($item->asset['user']['first_name'].' '.$item->asset['user']['last_name']) }}
						           			</td>
						           			<td>{!! strtoupper($item->assreq->borrower_name) !!}</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($item->updated_at)) !!}
						           			</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($item->must_date)) !!}
						           			</td>
						           			<td>ASSET</td>
						           			<td>{!! $item->asset_barcode !!}</td>
						           			<td>{!! $item->item !!}</td>
						           			<td>{!! $item->qty !!}</td>
						           			<td>
						           				@if($item->accs != null)
						           				{!! strtoupper($item->accs) !!}
						           				@else
						           				NO ACCESSORIES INCLUDED
						           				@endif
						           			</td>
						           			<td>
						           				{!!Form::open(array('route'=>'returned_assets.returning','method'=>'POST'))!!}
						           					<input type="hidden" name="id" value="{{$item->id}}">
						           					<input type="hidden" name="asset_id" value="{{$item->asset['id']}}">
						           					<input type="hidden" name="rno" value="{{$item->asset_request_no}}">
						           					<input type="hidden" name="barcode" value="{{$item->asset_barcode}}">
						           					<input type="hidden" name="category" value="{{$item->asset['category']}}">
					           						{{Form::label('incomplete','Missing Accessories (Leave blank if none)')}}
												 	<input type="text" class="form-control" name="missing" placeholder="Accessory...">
						           					<button type="submit" class="btn btn-xs btn-success"> Return</button>
						           				{!!Form::close()!!}
						           			</td>
						           		</tr>				           		
						           		@endif				           		
						           	@empty
						           	@endforelse
						           	@forelse($naitems as $naitem)
						           		@if($naitem->must_date <= date('Y-m-d'))
						           		<tr class="danger" style="opacity:0.6; filter:alpha(opacity=40);">
						           			<td>{!! $naitem->asset_request_no !!}</td>
						           			<td>
						           				{!! strtoupper($naitem->assreq->user->first_name.' '.$naitem->assreq->user->last_name) !!}
						           			</td>
						           			<td>
						           				{!! strtoupper($naitem->assreq->borrower_name) !!}
						           			</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($naitem->updated_at)) !!}
						           			</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($naitem->must_date)) !!}
						           			</td>
						           			<td>NON-ASSET</td>
						           			<td> - </td>
						           			<td>{!! $naitem->item !!}</td>
						           			<td>{!! $naitem->qty_r !!}</td>
						           			<td> - </td>
						           			<td>
						           				{!!Form::open(array('route'=>'returned_nonassets.returning','method'=>'POST'))!!}
						           					<input type="hidden" name="id" value="{{$naitem->id}}">
						           					<input type="hidden" name="rno" value="{{$naitem->asset_request_no}}">
						           					<button type="submit" class="btn btn-xs btn-success"> Return</button>
						           				{!!Form::close()!!}
						           			</td>
						           		</tr>
						           		@else
						           		<tr>
						           			<td>{!! $naitem->asset_request_no !!}</td>
						           			<td>
						           				{!! strtoupper($naitem->assreq->user->first_name.' '.$naitem->assreq->user->last_name) !!}
						           			</td>
						           			<td>
						           				{!! strtoupper($naitem->assreq->borrower_name) !!}
						           			</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($naitem->updated_at)) !!}
						           			</td>
						           			<td>
						           				{!! date('Y/m/d',strtotime($naitem->must_date)) !!}
						           			</td>
						           			<td>NON-ASSET</td>
						           			<td> - </td>
						           			<td>{!! $naitem->item !!}</td>
						           			<td>{!! $naitem->qty_r !!}</td>
						           			<td> - </td>
						           			<td>
						           				{!!Form::open(array('route'=>'returned_nonassets.returning','method'=>'POST'))!!}
						           					<input type="hidden" name="id" value="{{$naitem->id}}">
						           					<input type="hidden" name="rno" value="{{$naitem->asset_request_no}}">
						           					<button type="submit" class="btn btn-xs btn-success"> Return</button>
						           				{!!Form::close()!!}
						           			</td>
						           		</tr>				           		
						           		@endif				           		
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
</div>
<!-- MODAL -->
<div id="rtermsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Terms and Agreement</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p><b>NOTE:</b> Read Carefully</p>
                <li>I have thouroughly inspected the item and it is in good working condition before accepting it back from the user who borrowed it.</li>
                <li>All the accessories that are tagged with the returned item are complete and in good working condition.</li>
                <br><br>
            <p><strong>If you agree with the terms and agreement, kindly close this pop-up modal and click the checkbox.</strong></p>
            <!-- <li>I borrowed the item/s enumerated above and recieved them in good working conditions from Charter Chemical & Coating Corporation/Davies Paints Philippine Inc. for the</li> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@stop