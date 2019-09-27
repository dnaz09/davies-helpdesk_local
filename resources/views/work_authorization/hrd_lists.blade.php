@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> HRD WORK AUTHORIZATION</h2>        
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
					<div>
						 @if($ispaginate < 1)
								<div>
									<a href="{{ url('hrd_work_authorization') }}" class="btn btn-warning"><i class="glyphicon glyphicon-arrow-left"></i>  Back</a>
									<br>
									<p><strong>Search results for keyword </strong>"{{$searchkey}}"</p>
								</div>
								<br>
						@endif
					</div>
		            @if($ispaginate >= 1)
		            	<div>
	                    	{!!Form::open(array('route'=>'hrd_work_authorization.hr_work_authorization_list','method'=>'GET'))!!}
					            <div class="input-group">
					                <input type="text" class="form-control" name="textsearch" placeholder="Search table"> <span class="input-group-btn">
					                    <button type="submit" class="btn btn-default">
					                        <span class="glyphicon glyphicon-search"></span>
					                    </button>
					                </span>
					            </div>
	                    	{!! Form::close() !!}
						</div>
					@endif
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-was" >
			            <thead>
				            <tr>
				            	<th>DATE FILED</th>
				            	<th>DATE NEEDED</th>
				                <th>CONTROL #</th>
				                <th>REQUESTER</th>			                
				                <th>STATUS</th>
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($works as $work)
				           		<tr>
				           			<td>{!! date('Y/m/d h:i:s a',strtotime($work->created_at)) !!}</td>	 			
				           			<td>{!! date('Y/m/d',strtotime($work->date_needed)) !!} </td>	 			
				           			<td>
				           				@if($work->level != 5)
				           					@if($ispaginate < 1)	
				           						{!! Html::decode(link_to_Route('hrd_work_authorization.details',$work->work_no, $work->id, array()))!!}
				           					@else
				           						{!! Html::decode(link_to_Route('hrd_work_authorization.details',$work->work_no, $work->id, array()))!!}
				           					@endif
				           				@else
				           					{!! $work->work_no !!}
				           				@endif
				           			</td>	
		            				@if($ispaginate >= 1)
				           				<td>{!! strtoupper($work->user->first_name.' '.$work->user->last_name) !!}</td>
		            				@else
				           				<td>{!! strtoupper($work->first_name.' '.$work->last_name) !!}</td>
				           			@endif
				           			<td>
				           				@if($work->level == 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($work->level == 2)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($work->level == 5)
				           				<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@endif
				           			</td>				           			
				           		</tr>
				           	@empty
				           	@endforelse
			            </tbody>			            
		            	</table>
		            	@if($ispaginate >= 1)
		            			{!! $works->render() !!}
		            	@endif
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
</div>	
@stop
@section('page-script')
@if($ispaginate >= 1)
	$('.dataTables-was').DataTable({
	    pageLength: 25,
	    responsive: true,                                          
	    order: [0, 'desc'],
	    searching: false,
	    paging: false
	});
@else
	$('.dataTables-was').DataTable({
	    pageLength: 25,
	    responsive: true,                                          
	    order: [0, 'desc'],
	    // searching: false,
	    // paging: false
	});
@endif
@endsection