@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF EMPLOYEE EXIT PASS</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Exit Pass was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_updated')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Exit Pass was successfully Updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_released')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Exit Pass was successfully Relased!<i class="fa fa-check"></i></h4></center>                
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
	            <div class="col-lg-3">
	                <div class="widget navy-bg p-lg text-center">
	                    <div class="m-b-md">
	                        <i class="fa fa-tasks fa-4x"></i>
	                        <h1 class="m-xs">{!! count($today) !!}</h1>
	                        <h3 class="font-bold no-margins">
	                            TODAY
	                        </h3>                            
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="widget navy-bg p-lg text-center">
	                    <div class="m-b-md">
	                        <i class="fa fa-tasks fa-4x"></i>
	                        <h1 class="m-xs">{!! count($tom) !!}</h1>
	                        <h3 class="font-bold no-margins">
	                            TOMORROW
	                        </h3>                            
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="widget yellow-bg p-lg text-center">
	                    <div class="m-b-md">
	                        <i class="fa fa-clock-o fa-4x"></i>
	                        <h1 class="m-xs">{!! $exit_pending !!}</h1>
	                        <h3 class="font-bold no-margins">
	                            PENDING
	                        </h3>                            
	                    </div>
	                </div>
	            </div>            
	            <div class="col-lg-3">
	                <div class="widget lazur-bg p-lg text-center">
	                    <div class="m-b-md">
	                        <i class="fa fa-exchange fa-4x"></i>
	                        <h1 class="m-xs">{!! $exit_released !!}</h1>
	                        <h3 class="font-bold no-margins">
	                            RELEASED
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
	                                            <th>DATE</th>
	                                            <th>CONTROL #</th>	                                            	
	                                            <th>EMPLOYEE</th>
	                                            <th>STATUS</th>          
	                                            <th>CATEGORY</th>                                
	                                            <th>ACTION</th> 
	                                        </tr>
	                                    </thead>
	                                   <tbody>
	                                        @foreach($exit_pass as $pass)
	                                        <tr>
	                                            <td>{!! date('Y/m/d',strtotime($pass->date)) !!}</td>
	                                            <td>{!! $pass->exit_no !!}</td>	                                           
	                                            <td>{!! strtoupper($pass->user->first_name.' '.$pass->user->last_name) !!}</td>
	                                            <td>
	                                            	@if($pass->level == 1)
	                                            		<span class="label label-warning"><i class="fa fa-eye"> Pending</i></span>
	                                            	@else
	                                            		<span class="label label-success"><i class="fa fa-check"> Released</i></span>
	                                            	@endif
	                                            </td>       
	                                            <td>
	                                            	@if($pass->appr_obp > 0)
	                                            		OBP
	                                            	@elseif($pass->appr_leave > 0)
	                                            		LEAVE
	                                            	@else
	                                            		{!! $pass->others_details !!}
	                                            	@endif

	                                            </td>
	                                            <td>
	                                            	@if($pass->level < 2)
		                                            	@if($pass->appr_obp > 0)
		                                            		@if(!empty($pass->departure_time))
		                                            			<span class="label label-success"> <i class="fa fa-angellist"></i> Released</span>
		                                            			<button name="rbtn" class="deptbuttn btn btn-warning btn-md" id="{{$pass->id}}" value="{{$pass->id}}" onclick="passOBPEditFunction(this)">
	                                                    		<i class="fa fa-pencil"> Enter Arrival Time</i>
		                                            		@else
		                                            			<button name="rbtn" class="deptbuttn btn btn-info btn-xs" id="{{$pass->id}}" value="{{$pass->id}}" onclick="passOBPEditFunction(this)">
	                                                    		<i class="fa fa-pencil"> Remark</i>
		                                            		@endif		                                            		
	                                            		</button>
		                                            	@else
			                                            	<button name="rbtn" class="deptbuttn btn btn-info btn-xs" id="{{$pass->id}}" value="{{$pass->id}}" onclick="passEditFunction(this)">
		                                                    	<i class="fa fa-pencil"> Remark</i>
		                                            		</button>
		                                            	@endif							           				
                                            		@else
                                            		<span class="label label-success"> <i class="fa fa-angellist"></i> Released</span>
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
<!-- Modal -->
<div id="editDeptModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(array('route'=>'guard_check.store','method'=>'POST')) !!}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <div class="modal-body">
            	<div class="row">
            		            	
	                <div class="form-group">
	                    {!!Form::label('secguard','Name of Guard')!!}                       
	                    {!!Form::text('secguard','',['class'=>'form-control','placeholder'=>'Enter Name of Guard','required'=>'required'])!!}                                              
	                    @if ($errors->has('secguard')) <p class="help-block" style="color:red;">{{ $errors->first('secguard') }}</p> @endif
	                </div>   
	                <div class="form-group">
	                    {!!Form::label('guard_remarks','Remarks')!!}                       
	                    {!!Form::textarea('guard_remarks','',['class'=>'form-control','placeholder'=>'Enter Remarks','required'=>'required'])!!}                                              
	                    @if ($errors->has('secguard')) <p class="help-block" style="color:red;">{{ $errors->first('secguard') }}</p> @endif
	                </div>   
	                <h3>Employee Details</h3>
		                    <!-- {!!Form::label('time_in','Time In')!!}                     -->
		                    {!!Form::hidden('time_in','',['class'=>'form-control','placeholder'=>'Enter Time In of Employee'])!!}                                              
		                    @if ($errors->has('time_in')) <p class="help-block" style="color:red;">{{ $errors->first('secguard') }}</p> @endif
		            <div class="col-lg-6">	            	            
		                <div class="form-group">
		                    {!!Form::label('time_out','Time Out')!!}                       
		                    {!!Form::text('time_out','',['class'=>'form-control','placeholder'=>'Enter Time Out of Employee'])!!}                                              
		                    @if ($errors->has('time_out')) <p class="help-block" style="color:red;">{{ $errors->first('secguard') }}</p> @endif
		                </div>                             
		            </div>
		        </div>
            </div>
            <div class="modal-footer">
                {!! Form::hidden('pass_id','',['id'=>'passID']) !!}
                {!! Form::button('<i class="fa fa-save"></i> Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
<div id="editOBPModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(array('route'=>'guard_check.store_obp','method'=>'POST')) !!}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <div class="modal-body">
            	<div class="row">
            		            	
	                <div class="form-group">
	                    {!!Form::label('secguard','Name of Guard')!!}                       
	                    {!!Form::text('secguard','',['class'=>'form-control','placeholder'=>'Enter Name of Guard'])!!}                                              
	                    @if ($errors->has('secguard')) <p class="help-block" style="color:red;">{{ $errors->first('secguard') }}</p> @endif
	                </div>   
	                <div class="form-group">
	                    {!!Form::label('guard_remarks','Remarks')!!}                       
	                    {!!Form::textarea('guard_remarks','',['class'=>'form-control','placeholder'=>'Enter Name of Guard','required'=>'required','id'=>'gremarks2'])!!}                                              
	                    @if ($errors->has('secguard')) <p class="help-block" style="color:red;">{{ $errors->first('secguard') }}</p> @endif
	                </div>   
	                <h3>Employee Details</h3>	                
	                <div class="col-lg-6" id="departid">
		                <div class="form-group">
		                    {!!Form::label('departure_time','Time of Departure')!!}                       
		                    {!!Form::text('departure_time','',['class'=>'form-control','placeholder'=>'Enter Departure Time','id'=>'depid'])!!}                                              
		                    @if ($errors->has('departure_time')) <p class="help-block" style="color:red;">{{ $errors->first('departure_time') }}</p> @endif
		                </div>   
		            </div>
		            <div class="col-lg-6">	            	            
		                <div class="form-group" id="arrivalid">
		                    {!!Form::label('arrival_time','Time of Arrival')!!}                       
		                    {!!Form::text('arrival_time','',['class'=>'form-control','placeholder'=>'Enter Arrival Time','id'=>'arrid'])!!}                                              
		                    @if ($errors->has('arrival_time')) <p class="help-block" style="color:red;">{{ $errors->first('arrival_time') }}</p> @endif
		                </div>                             
		            </div>
		        </div>
            </div>
            <div class="modal-footer">
                {!! Form::hidden('pass_id','',['id'=>'passID2']) !!}
                {!! Form::button('<i class="fa fa-save"></i> Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@stop
<script type="text/javascript">
    function passEditFunction(elem){

        var x = elem.id;

        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {pass: x},
            url: "../getpassdetails",
            success: function(data){            
                            
                
                $('#passID').val(data['id']);

                $('#editDeptModal').modal('show');
            }    
        });
    }

    function passOBPEditFunction(elem){

        var x = elem.id;
        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {pass: x},
            url: "../getpassdetails",
            success: function(data){            
                            
                
                $('#passID2').val(data['id']);
                if(data['departure_time']){
                	
                	$('#depid').val(data['departure_time']);
                	$('#arrid').val(data['arrival_time']);
                	$('#gremarks2').val(data['guard_remarks']);
					document.getElementById('depid').readOnly = true;
					document.getElementById('arrid').readOnly = false;
					
                }else{
                	$('#depid').val(data['departure_time']);
                	$('#arrid').val(data['arrival_time']);
                	$('#gremarks2').val(data['guard_remarks']);
                	document.getElementById('depid').readOnly = false;
                	document.getElementById('arrid').readOnly = true;                	
                }

                $('#editOBPModal').modal('show');
            }    
        });
    }
</script>