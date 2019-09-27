@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> OFFICIAL BUSINESS FORM</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>OB was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>OB was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY OB LISTS</h5>	                
	                {!! Html::decode(link_to_Route('obp.create', '<i class="fa fa-plus"></i> Add', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				            	<th>DATE FILED</th>
				                <th>CONTROL #</th>
				                <th>OB DATE</th>
				                <th>MANAGER APPROVAL</th>
				                <th>HR APPROVAL</th>			                
				                <th>STATUS</th>
				                <th>ACTION</th>				                
				            </tr>
			            </thead>
			            <tbody>
				           	@forelse($obps as $obp)
				           		<tr>
				           			<td>{!! date('Y/m/d',strtotime($obp->created_at)) !!} {!! date('h:i a',strtotime($obp->created_at)) !!}</td>	
				           			<td>
				           				@if($obp->manager_action != 5 && $obp->level != 5)
				           				{!! Html::decode(link_to_Route('obp.details',$obp->obpno, $obp->id, array()))!!}
				           				@else
				           				{!! $obp->obpno !!}
				           				@endif
				           			</td>
				           			<td>{!! date('m/d/y',strtotime($obp->date)) !!}</td>		           							
				           			<td>
				           				@if($obp->manager_action < 2)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($obp->manager_action == 2)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($obp->manager_action == 5)
				           				<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@elseif($obp->manager_action == 3)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@endif
				           			</td>
				           			<td>
				           				@if($obp->hr_action < 1 && $obp->manager_action != 3)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($obp->hr_action == 1 && $obp->manager_action != 3)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($obp->hr_action == 2 || $obp->manager_action == 3)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@elseif($obp->hr_action == 5)
				           				<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@endif
				           			</td>
				           			<td>
				           				@if($obp->level < 2)
				           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
				           				@elseif($obp->level == 2)
				           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
				           				@elseif($obp->level == 5)
				           				<span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
				           				@elseif($obp->level == 3)
				           				<span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
				           				@endif
				           			</td>
				           			<td>
				           				@if($obp->level < 2)
				           					{!! Html::decode(link_to_Route('obp.edit','<i class="fa fa-pencil"></i> Edit', $obp->id, array('class' => 'btn btn-info btn-xs')))!!}
				           				@elseif($obp->level == 2)
				           					<a href="http://pdf-generator.davies-helpdesk.com/obp/{{$obp->id}}/{{$uid}}/generate" id="{{$obp->id}}" target="__blank"><button class="btn btn-primary btn-xs"><i class="fa fa-download"> Download</i></button></a>
				           				@else
				           				@endif
				           				@if($obp->manager_action != 2 && $obp->level != 2 && $obp->level != 3)
				           				<button class="btn btn-danger btn-xs" onclick="functionCancelObp(this)" value="{{$obp->id}}" id="cancelBtn" type="button"> Cancel</button>
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
@section('page-javascript')
function functionCancelObp(elem){
    swal({
        title: "Are you sure?",
        text: "Your request will be canceled!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        var obp_id = elem.value;
        $.ajax({
            type:"POST",
            dataType: 'json',
            data: {
                "id": obp_id,
            },
            url: "{{ url('obp/cancel') }}",
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