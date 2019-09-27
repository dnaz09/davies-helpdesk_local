@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> SUPERIOR WORK AUTHORIZATION</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Work Authorization was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Work Authorization was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i>WORK AUTHORIZATION LISTS</h5>		
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>WA#</th>
				                <th>EMPLOYEE</th>
				                <th>STATUS</th>			                
				                <th>DATE CREATED</th>
				                <th>ACTION</th>				                
				            </tr>
			            </thead>
			            <tbody>
				           	@foreach($works as $work)
				           		<tr>
				           			<td>{!! $work->work->work_no !!}</td>			           			
				           			<td>{!! strtoupper($work->user->first_name.' '.$work->user->last_name) !!}</td>
				           			<td>
				           				@if($work->superior_action < 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($work->superior_action == 1)
				           				<span class="label label-success"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($work->superior_action == 2)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@else
				           				<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@endif
				           			</td>
				           			<td>{!! date('m/d/y',strtotime($work->created_at)) !!}</td>
				           			<td>
				           				@if($work->superior_action != 5)		           			
				           				{!! Html::decode(link_to_Route('sup_work_authorization.details','<i class="fa fa-eye"></i> Details', $work->work_auth_id, array('class' => 'btn btn-warning btn-xs')))!!}
				           				@endif
				           			</td>				           			
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