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
				                <th>WORK AUTHORIZATION#</th>	
				                <th>EMPLOYEE</th>			                
				                <th>DATE CREATED</th>
				                <th>ACTION</th>				                
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($works as $work)
				           		<tr>
				           			<td>{!! $work->id !!}</td>				           			
				           			<td>{!! strtoupper($work->user->first_name.' '.$work->user->last_name) !!}</td>
				           			<td>{!! $work->created_at !!}</td>
				           			<td>				           			
				           				{!! Html::decode(link_to_Route('sup_work_authorization.details','<i class="fa fa-eye"></i> Details', $work->id, array('class' => 'btn btn-warning btn-xs')))!!}
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
@endsection