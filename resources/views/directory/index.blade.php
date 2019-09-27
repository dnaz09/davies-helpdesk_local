@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-users"></i> Directory List</h2>       
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-users"></i> Directory Table</h5>	                
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
			            <table class="table table-striped table-bordered table-hover dataTables-example">
				            <thead>
					            <tr>				                					                
					                <th>Fullname</th>
					           		<th style="text-align: center">Local</th>
					           		<th style="text-align: center">Email</th>
					                <th style="text-align: center">Status</th>
									<th style="text-align: center">Location</th>					                
					            </tr>
				            </thead>
				            <tbody>
					           @forelse($users as $user)
					           		<tr>					           			
					           			<td>{!! strtoupper($user->first_name.' '.$user->last_name) !!}</td>
					           			<td style="text-align: center">
					           				@if($user->localno != null)
					           					{!! $user->localno !!}
					           				@else
					           					<strong> - </strong>
					           				@endif
					           			</td>			
					           			<td style="text-align: center">
					           				@if($user->email != null)
					           					{!! $user->email !!}
					           				@else
					           					<strong> - </strong>
					           				@endif
					           			</td>	
					           			<td style="text-align: center">
					           				@if($user->online == 1)
												<label class="badge badge-primary">Online</label><br>
					           				@else					           					
					           					<label class="badge badge-default">Offline</label>
					           				@endif					           				
					           			</td>
					           			<td style="text-align: center">
					           				@if($user->location != null)
					           					{!! $user->location->location !!}
					           				@else
					           					<strong> - </strong>
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
@endsection