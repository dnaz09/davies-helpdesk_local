@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF USER ACCESS REQUEST</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> USER ACCESS REQUEST LISTS</h5>	                	
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				            	<th>DATE FILED</th>
				                <th>CONTROL #</th>
				                <th>EMPLOYEE</th>
				                <th>STATUS</th>			                
				                <th>YOUR APPROVAL</th>
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($its as $it)
				           		<tr>
				           			<td>{!! date('Y/m/d',strtotime($it->created_at)) !!} {!! date('h:i a',strtotime($it->created_at)) !!}</td>
				           			<td>
				           				{!! Html::decode(link_to_Route('user_access.details',$it->reqit_no, $it->id, array()))!!}
				           			</td>
				           			<td>{!! strtoupper($it->user->first_name.' '.$it->user->last_name) !!}</td>
				           			<td>
				           				@if($it->status < 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>@elseif($it->status == 1)
				           				<span class="label label-success"> <i class="fa fa-angellist"></i>Returned</span>
				           				@elseif($it->status == 2)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($it->status == 3)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@else
				           				<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@endif
				           			</td>
				           			<td>
				           				@if($it->sup_action < 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($it->sup_action == 1)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@else
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