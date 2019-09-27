@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LEAVE</h2>        
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
		    <?php if (session('is_past')): ?>
		        <div class="alert alert-danger alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Sorry it is already past the filing time!<i class="fa fa-check"></i></h4></center>                
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
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY LEAVE LISTS</h5>	                
	                {!! Html::decode(link_to_Route('undertime.create', '<i class="fa fa-plus"></i> Add', [], ['class' => 'btn btn-white btn-xs pull-right','id'=>'add_udtime'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>CONTROL #</th>
				                <th>SCHEDULE</th>
				                <th>FILED DATE</th>
				                <th>DATE CREATED</th>				                
				                <th>STATUS</th>			                
				                <th>ACTION</th>				                
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($undertimes as $undertime)
				           		<tr>
				           			<td>
				           				@if($undertime->status != 5 && $undertime->level != 5)
				           				{!! Html::decode(link_to_Route('undertime.details',$undertime->und_no , $undertime->id, array()))!!}
				           				@else
				           				{!! $undertime->und_no !!}
				           				@endif
				           			</td>
				           			<td>{!! $undertime->sched !!}</td>
				           			<td>{!! date('Y/m/d',strtotime($undertime->date)) !!}</td>
				           			<td>{!! date('Y/m/d',strtotime($undertime->created_at)) !!}</td>		
				           			<td>
				           				@if($undertime->status < 1)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($undertime->status == 2)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($undertime->status == 3)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@elseif($undertime->status == 5)
				           				<span class="label label-info"> <i class="fa fa-minus"></i>Canceled</span>
				           				@endif
				           			</td>
				           			<td>
				           				@if($undertime->status < 2)
				           					{!! Html::decode(link_to_Route('undertime.edit','<i class="fa fa-pencil"></i> Edit', $undertime->id, array('class' => 'btn btn-info btn-xs')))!!}
				           				@elseif($undertime->status == 2)
				           					<a href="http://pdf-generator.davies-helpdesk.com/undertime/{{$undertime->id}}/{{$uid}}/generate" id="{{$undertime->id}}" target="__blank"><button class="btn btn-primary btn-xs"><i class="fa fa-download"> Download</i></button></a>
				           				@else
				           					
				           				@endif
				           				@if($undertime->status != 2 && $undertime->status != 3)
				           				<button class="btn btn-danger btn-xs" value="{{$undertime->id}}" onclick="functionCancelUndertime(this)"><i class="fa fa-eye"></i> Cancel</button>
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
@section('page-script')
$(document).ready(function(){
	console.log('checking time');
	TimeCheck();
});
function TimeCheck() {
	var d = new Date();
	var n = d.getHours();
	if(n > 15){
		swal('It is already past the filing time, You will not be able to file a request');
		$('#add_udtime').attr('disabled', true);
		$('#add_udtime').removeAttr('href', true);
	}
}
@endsection
@section('page-javascript')
function functionCancelUndertime(elem){
    swal({
        title: "Are you sure?",
        text: "Your request will be canceled!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        var und_id = elem.value;
        $.ajax({
            type:"POST",
            dataType: 'json',
            data: {
                "id": und_id,
            },
            url: "{{ url('undertime/cancel') }}",
            success: function(data){
            	var type = data.type;
            	if(type == 1){
            		swal('Your Request will be canceled');
            		location.reload();
            	}
            	if(type == 2){
            		swal('Sorry Your Request was already approved');
            		location.reload();
            	}
            	if(type == 3){
            		swal('There is an error in approving your request');
            		location.reload();
            	}
            }    
        });
    });
}
@endsection