@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-users"></i> Users List</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_added')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User Access was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_update')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_reset')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>User password was successfully updated!<i class="fa fa-check"></i></h4></center>          
		        </div>
		    <?php endif;?>
		</div>
	</div>
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-users"></i> Users Table</h5>
	                {!! Html::decode(link_to_Route('users.create', '<i class="fa fa-plus"></i> New User', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	                {!! Html::decode(link_to_Route('users.reset_password','<i class="fa fa-refresh"></i> Reset Password', 'reset', ['class' => 'btn btn-white btn-xs pull-right'])) !!} &nbsp;
	                <button type="button" class="btn btn-white btn-xs pull-right" data-toggle="modal" data-target="#myModal">Import</button>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
			            <table class="table table-striped table-bordered table-hover dataTables-example">
				            <thead>
					            <tr>				                
					                <th>Image</th>
					                <th>Emp #</th>
					                <th>Fullname</th>
					                <th>Company</th>
					           		<th>Email</th>					           		
					           		<th>Role</th>					           		
					                <th>Department</th>
					                <th>Status</th>
					                <th>Action</th>			               
					            </tr>
				            </thead>
				            <tbody align="center">
					           @forelse($users as $user)
					           					           		
									@if($user->active < 1)
									<tr class="danger" style="opacity:0.6; filter:alpha(opacity=40);">
									@else
					           		<tr>
					           		@endif
					           			<td>
					           				@if(!empty($user->image))				           					
					           					{!! Html::image('uploads/users/'.$user->employee_number.'/'.$user->image,'',['class'=>'img-circle','style'=>'width:50px; height:50px;']) !!}
					           					
					           				@else				           					
					           					<img src="/uploads/users/default.jpg" class="img-circle" style="width:50px; height:50px;"></img>
					           				@endif				           				
					           			</td>
					           			<td>{!! $user->employee_number !!}</td>
					           			<td>{!! strtoupper($user->first_name.' '.$user->last_name) !!}</td>
					           			<td>{!! strtoupper($user->company) !!}</td>
					           			<td>{!! $user->email !!}</td>

					           			<td>{!! strtoupper($user->role->role) !!}</td>							           			           		
					           			<td>{!! strtoupper($user->department->department) !!}</td>				           			
					           			<td>
					           				@if($user->active > 0)
					           					{!! Html::decode(link_to_Route('users.activate','<i class="fa fa-close"></i> Deactivate Account', $user->id, array('class' => 'btn btn-danger btn-xs')))!!}
					           				@else
					           					{!! Html::decode(link_to_Route('users.activate','<i class="fa fa-check"></i> Activate Account', $user->id, array('class' => 'btn btn-primary btn-xs')))!!}
					           				@endif					           				
					           			</td>				           			
					           			<td>
					           				@if($user->active > 0)
				           						{!! Html::decode(link_to_Route('users.edit','<i class="fa fa-pencil"></i> Edit', $user->id, array('class' => 'btn btn-info btn-xs')))!!}
				           						{!! Html::decode(link_to_Route('users.access_control','<i class="fa fa-pencil"></i> Module Access', $user->id, array('class' => 'btn btn-warning btn-xs')))!!}
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
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-envelope modal-icon"></i>
                <h4 class="modal-title">Import Users</h4>                    
            </div>              
            {!! Form::open(array('route'=>'users.importnow','method'=>'POST','files'=>true)) !!}
                <div class="modal-body">                                                                                
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('attached','Attached File')!!}
                            <input type="file" required="" name="userfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                                              
                    {!! Form::button('Close', array('type' => 'submit', 'class' => 'btn btn-white','data-dismiss'=>'modal')) !!}
                    <button class="btn btn-primary" value="Submit">Submit</button>
                </div>                  
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection