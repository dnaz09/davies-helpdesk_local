@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF EMPLOYEE LEAVE</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Undertime was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Undertime was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> LEAVE LISTS</h5>	                	
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
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($undertimes as $undertime)
				           		<tr>
				           			<td>{!! date('Y/m/d',strtotime($undertime->created_at)) !!} {!! date('h:i a',strtotime($undertime->created_at)) !!}</td>
				           			<td>@if($undertime->status != 5 && $undertime->level != 5)
				           					{!! Html::decode(link_to_Route('mng_undertime.details',$undertime->und_no, $undertime->id, array()))!!}
				           				@else
				           					{!! $undertime->und_no !!}
				           				@endif
				           			</td>
				           			<td>{!! strtoupper($undertime->user->first_name.' '.$undertime->user->last_name) !!}</td>
				           			<td>
				           				@if($undertime->status < 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($undertime->status == 2)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($undertime->manager_action === 3)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@else
				           				<span class="label label-info"> <i class="fa fa-minus"></i>Canceled</span>
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