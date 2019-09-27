@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF EMPLOYEE REQUISITION (HR APPROVER)</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Requisition was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Requisition was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> REQUISITION LISTS</h5>	                	
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>DATE FILED</th>               
				                <th>CONTROL #</th>
				                <th>EMPLOYEE</th>
				                <th>DATE NEEDED</th>		                
				                <th>HR ACTION</th>	
				                <th>STATUS</th>
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($reqs as $req)
				           		<tr>
				           			<td>{!! date('Y/m/d',strtotime($req->created_at)) !!} {!! date('h:i a',strtotime($req->created_at)) !!}</td>				           							
				           			<td>
                                    	@if($req->sup_action != 5 && $req->hrd_action != 5)
                                        	{!! Html::decode(link_to_route('hrd_emp_req.details', $req->ereq_no ,$req->ereq_no, array())) !!}
                                        @else
                                        	{!! $req->ereq_no !!}
                                        @endif
				           			</td>
				           			<td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>		
				           			<td>{!! date('Y/m/d',strtotime($req->date_needed)) !!}</td>
				           			<td>
				           				@if($req->hr_action == 0)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->hr_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->hr_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @endif
				           			</td>
				           			<td>
                                        @if($req->approver_action == 0)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->approver_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->approver_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
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