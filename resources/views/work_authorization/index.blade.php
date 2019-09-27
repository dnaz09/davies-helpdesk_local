@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> WORK AUTHORIZATION</h2>        
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
		    <?php if (session('is_overtime')): ?>
		        <div class="alert alert-danger alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Sorry but the it is past the filing time for Work Authorization!<i class="fa fa-check"></i></h4></center>                
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
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY WORK AUTHORIZATION LISTS</h5>	                
	                {!! Html::decode(link_to_Route('work_authorization.create', '<i class="fa fa-plus"></i> Add', [], ['class' => 'btn btn-white btn-xs pull-right', 'id' => 'add_workauth'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>CONTROL #</th>				                
				                <th>DATE CREATED</th>
				                <th>STATUS</th>
				                <th>ACTION</th>				                
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($works as $work)
				           		<tr>
				           			<td>
				           				@if($work->level != 5)
				           				{!! Html::decode(link_to_Route('work_authorization.details',$work->work_no, $work->id, array()))!!}
				           				@else
				           					<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@endif
				           			</td>				           			
				           			<td>{!! $work->created_at !!}</td>
				           			<td>
				           				@if($work->level < 2)
			                                <span class="label label-warning"> <i class="fa fa-clock"></i> Pending</span>
			                            @elseif($work->level == 2)
			                                <span class="label label-primary"> <i class="fa fa-check"></i> Approved</span>
			                            @elseif($work->level == 5)
			                                <span class="label label-danger"> <i class="fa fa-close"></i> Cancelled</span>
			                            @endif
				           			</td>
				           			<td>
				           				@if($work->level != 2)
				           				{!! Html::decode(link_to_Route('work_authorization.edit','<i class="fa fa-pencil"></i> Edit', $work->id, array('class' => 'btn btn-info btn-xs')))!!}
				           				<button class="btn btn-danger btn-xs" value="{{$work->id}}" onclick="functionCancelWas(this)"><i class="fa fa-eye"></i> Cancel</button>
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
	if(n > 14){
		console.log('sorry lagpas na');
		$('#add_workauth').attr('disabled', true);
		$('#add_workauth').removeAttr('href', true);
	}
}
@endsection
@section('page-javascript')
function functionCancelWas(elem){
    swal({
        title: "Are you sure?",
        text: "Your request will be canceled!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        var was_id = elem.value;
        $.ajax({
            type:"POST",
            dataType: 'json',
            data: {
                "id": was_id,
            },
            url: "{{ url('work_authorization/cancel') }}",
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