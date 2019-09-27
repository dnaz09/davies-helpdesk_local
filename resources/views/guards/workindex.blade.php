@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF EMPLOYEE WORK AUTHORIZATION</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Work was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('time_added')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Exit time was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Work was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_released')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Work was successfully Relased!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
	<div class="animated fadeInDown">    
	    <center>    
	        <div class="col-lg-12 text-center">            
	            <div class="col-lg-12">                
	                <center><h1 class="logo-name" style="font-size:80px;"></h1></center>
	            </div>
	            <div class="col-lg-12">
	                <div class="widget navy-bg p-lg text-center">
	                    <div class="m-b-md">
	                        <i class="fa fa-tasks fa-4x"></i>
	                        <h1 class="m-xs">{!! count($works) !!}</h1>
	                        <h3 class="font-bold no-margins">
	                            WORK AUTHORIZATIONS
	                        </h3>                            
	                    </div>
	                </div>
	            </div>            
	        </div>   
	    </center>     
	</div>
	<div class="row">
	    <div class="col-lg-12">
	        <div class="ibox float-e-margins">            
	            <div class="ibox-content">
	                <div class="panel blank-panel">                    
	                    <div class="panel-body">                                                                                                            
	                        <div class="col-lg-12">
	                            <div class="table-responsive">
	                                <table class="table table-striped table-bordered table-hover dataTables-example" >
	                                    <thead>
	                                        <tr>        
	                                            <th>CONTROL #</th>	                                            	
	                                            <th>EMPLOYEE</th>
	                                            <th>DEPARTMENT</th>
	                                            <th>DATE</th>
	                                            <th>O.T. FROM</th>
	                                            <th>O.T. TO</th>
	                                            <th>ACTION</th>
	                                        </tr>
	                                    </thead>
	                                   <tbody>
	                                        @foreach($works as $work)
	                                        <tr>
	                                            <td>{!! $work->work->work_no !!}</td>                               
	                                            <td>{!! strtoupper($work->user->first_name.' '.$work->user->last_name) !!}</td>
	                                            <td>{!! strtoupper($work->user->department->department) !!}</td>
	                                            <td>{!! date('Y/m/d',strtotime($work->work->date_needed)) !!}</td>
	                                            <td>{!! date('h:i a',strtotime($work->work->ot_from)) !!}</td>
	                                            <td>{!! date('h:i a',strtotime($work->work->ot_to)) !!}</td>
	                                            <td>
	                                            	@if(!empty($work->exit_time))
	                                            	<span class="label label-info"> <i class="fa fa-close"></i> Already left</span>
                                            		@else
                                            		<!-- <button name="rbtn" class="deptbuttn btn btn-info btn-xs" id="{{$work->id}}" value="{{$work->id}}" onclick="addExitTime(this)"> -->
                                            		<button class="btn btn-info btn-xs" onclick="AddTimeModalShow(this)" value="{{$work->id}}">
                                            			<i class="fa fa-pencil"> Add Exit Time</i>
                                            		</button>
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
	    </div>
	</div>
</div>
<div id="addTimeModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header" style="background-color:#009688">                
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
                <center><h2 style="color: white;">Add Time Left</h2></center>
            </div>
            {!! Form::open(array('route'=>'workauth.addTimeLeft','method'=>'POST')) !!}
            <div class="modal-body">
            	{{Form::text('time','',['class'=>'form-control','required','placeholder'=>'Enter Time...'])}}
                <input type="hidden" name="id" id="was_id">
            </div>
            <div class="modal-footer">          
                {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'button', 'class' => 'btn btn-primary','id'=>'editBtn')) !!} 
                <button class="hidden" id="editBtnPressed"></button>     
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
            {!! Form::close() !!}
        </div>        
    </div>
</div>
@stop
@section('page-javascript')
function AddTimeModalShow(elem){
	var x = elem.value;
	
	$.ajax({
		type:'POST',
		dataType: 'json',
		data: {id: x},
		url: "{{ route('workauth.getTime') }}",
		success: function(data){
			if(data != ''){
				$('#was_id').val(data.id);
				$('#addTimeModal').modal('show');
			}else{
				swal('Error! Please Referesh this page!');
			}
        }
	});
}

$('#editBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Time indicated will be saved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#editBtnPressed').click();
    });
});

@endsection