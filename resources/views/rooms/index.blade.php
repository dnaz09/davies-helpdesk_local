@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-reply"></i> ROOM LIST</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> LIST OF ROOMS</h5>
	                {!! Html::decode(link_to_Route('rooms.create', '<i class="fa fa-plus"></i> New Room', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Room</th>
				                <th>Vacant</th>
				                <th>Action</th>			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($rooms as $room)
				           		<tr>
				           			<td>{!! $room->id !!}</td>
				           			<td>{!! $room->room_name !!}</td>
				           			<td>
				           				@if($room->vacancy == 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Occupied</span>
				           				@elseif($room->vacancy == 0)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Vacant</span>
				           				@else
				           				@endif
				           			</td>
				           			<td>{!! Html::decode(link_to_Route('rooms.edit','<i class="fa fa-pencil"></i> Edit', $room->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
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