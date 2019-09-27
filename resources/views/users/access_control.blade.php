@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-users"></i> ACCESS OF <strong>{!! strtoupper($user->first_name.' '.$user->last_name) !!}</strong></h2>
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">		
    <div class="row">
    	<div class="col-md-12 animated flash">
            @if ( count( $errors ) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                    <center><h4>Select a module before you save!</h4></center>
                </div>
            @endif
        </div>    
        <div class="col-lg-12">
        	{!! Form::open(array('route'=>'users.access_control_store', 'method'=>'POST','enctype'=>'multipart/form-data')) !!}
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-users"></i> Modules List</h5>
	                {!! Form::button('<i class="fa fa-users"></i> HR ACCESS', array('type' => 'submit', 'value' => '2', 'name' => 'sub', 'class' => 'btn btn-xs btn-white pull-right')) !!}
	                {!! Form::button('<i class="fa fa-laptop"></i> IT ACCESS', array('type' => 'submit', 'value' => '3', 'name' => 'sub', 'class' => 'btn btn-xs btn-white pull-right')) !!}              
	                {!! Form::button('<i class="fa fa-user"></i> ADMIN ACCESS', array('type' => 'submit', 'value' => '4', 'name' => 'sub', 'class' => 'btn btn-xs btn-white pull-right')) !!}  
	                {!! Form::button('<i class="fa fa-plus"></i> DEFAULT ACCESS', array('type' => 'submit', 'value' => '5', 'name' => 'sub', 'class' => 'btn btn-xs btn-white pull-right')) !!}              
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-users">
			            <thead>
				            <tr>				                
				            	<th></th>	
				                <th>#</th>
				                <th>Module</th>
				                <th>Description</th>
				                <th>Department</th>  
				            </tr>
			            </thead>
			            <tbody>
				            @forelse($modules as $module)				           				           								
			           			<tr>
			           				@if(count($access_control) < 1)				           			
					           			<td><input type="checkbox" name="module_id[]" value="{!! $module->id !!}"></td>
					           			<td>{!! $module->id !!}</td>
					           			<td>{!! $module->module !!}</td>
					           			<td>{!! $module->description !!}</td>
					           			<td>{!! $module->department !!}</td>						           		
					           		@elseif(count($access_control) > 0)
					           			
				           				@if(in_array($module->id, $access_control))
					           				<td><input type="checkbox" name="module_id[]" value="{!! $module->id !!}" checked></td>							           			
					           			@else
					           				<td><input type="checkbox" name="module_id[]" value="{!! $module->id !!}"></td>							           			
					           			@endif						
					           			<td>{!! $module->id !!}</td>
					           			<td>{!! $module->module !!}</td>
					           			<td>{!! $module->description !!}</td>
					           			<td>{!! $module->department !!}</td>	           		
					           		@endif
				           		</tr>
				           	@empty
				           	@endforelse
			            </tbody>			            
		            	</table>
		            </div>		            
		            <div class="ibox-footer">		         
		            	{!! Form::hidden('id',$user->id) !!}   	
						{!! Html::decode(link_to_Route('users.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
						{!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'value' => '1', 'name' => 'sub', 'class' => 'btn btn-primary')) !!}						
					</div>		
	            </div>	
	        </div>
	        {!! Form::close() !!}
	    </div>	    
    </div>
</div>	
@stop
