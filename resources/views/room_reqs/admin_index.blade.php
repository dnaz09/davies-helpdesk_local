@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-reply"></i> ALL ROOMS RESERVATION REQUEST</h2>        
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
		    <?php if (session('is_closed')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room Request was successfully closed!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_approved')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room Request was approved!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_already_canceled')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room Request was already canceled!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_returned_to_pending')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Room Request was returned to Pending!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
	</div>
	<div class="row">
	    <div class="col-lg-12">
	        <div class="ibox float-e-margins">            
	            <div class="ibox-content">
	                <div class="panel blank-panel">
	                    <div class="ibox-title"style="background-color:#009688">
	                        <h5 style="color:white"><i class="fa fa-futbol-o"></i> ON GOING ROOM RESERVATIONS</h5>
	                    </div> 
	                    <div class="ibox-content">              
		                    <div class="table-responsive">                   
		                        <div class="col-lg-12">
		                            <table class="table table-striped table-bordered table-hover">
		                            	<thead>
		                            		<tr>
		                            			<th>Room</th>
		                            			<th>Employee</th>
		                            			<th>Time</th>
		                            			<th>Action</th>
		                            		</tr>
		                            	</thead>
		                            	<tbody>
		                            		@foreach($rooms as $room)
		                            		@if(strtotime($room->end_time) >= strtotime($time_now))
		                            		<tr style="background-color:#6CD0FF">
		                            			<td>{!! $room->room !!}</td>
		                            			<td>{!! $room->user->first_name.' '.$room->user->last_name !!}</td>
		                            			<td>{!! date('h:i a',strtotime($room->start_time)) !!} - {!! date('h:i a',strtotime($room->end_time)) !!}</td>
		                            			<td>{!! Html::decode(link_to_Route('room_request_list.details','<i class="fa fa-pencil"></i> Close', $room->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
		                            		</tr>
		                            		@else
		                            		<tr style="background-color:#FEC25A">
		                            			<td>{!! $room->room !!}</td>
		                            			<td>{!! $room->user->first_name.' '.$room->user->last_name !!}</td>
		                            			<td>{!! date('h:i a',strtotime($room->start_time)) !!} - {!! date('h:i a',strtotime($room->end_time)) !!}</td>
		                            			<td>{!! Html::decode(link_to_Route('room_request_list.details','<i class="fa fa-pencil"></i> Close', $room->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
		                            		</tr>
		                            		@endif
		                            		@endforeach
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
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> LIST OF ROOMS</h5>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover room-datatable-admin">
			            <thead>
				            <tr>
				                <th>Control #</th>
				                <th>Room</th>
				                <th>Date</th>
				                <th>Time</th>
				                <th>Department</th>
				                <th>Employee</th>
				                <th>Status</th>
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($reqs as $req)
				           		<tr>
				           			<td>{!! Html::decode(link_to_Route('room_request_list.details',strtoupper($req->req_no), $req->id, array()))!!}</td>
				           			<td>{!! strtoupper($req->room) !!}</td>
				           			<td>{!! date('Y/m/d',strtotime($req->start_date)).' - '.date('Y/m/d',strtotime($req->end_date)) !!}</td>
				           			<td>{!! date('h:i a',strtotime($req->start_time)).' - '.date('h:i a',strtotime($req->end_time)) !!}</td>
				           			<td>{!! strtoupper($req->user->department->department) !!}</td>
				           			<td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>
				           			<td>
				           				@if($req->status == 0)
				                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				                        @elseif($req->status == 1)
				                        <span class="label label-success"> <i class="fa fa-angellist"></i>Ongoing</span>
				                        @elseif($req->status == 2)
				                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				                        @elseif($req->status == 3)
				                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				                        @elseif($req->status == 5)
				                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				                        @endif
				           			</td>
				           			
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