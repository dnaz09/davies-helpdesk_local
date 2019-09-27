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
	                        <h1 class="m-xs">{!! $exit_pass_count !!}</h1>
	                        <h3 class="font-bold no-margins">
	                            TO DATE EXIT PASS
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
	                                <table class="table table-striped table-bordered table-hover dataTables-example">
	                                    <thead>
	                                        <tr>        
	                                            <th>CONTROL #</th>                               	
	                                            <th>EMPLOYEE</th>
	                                            <th>DATE</th>                     
	                                            <th>STATUS</th>
	                                        </tr>
	                                    </thead>
	                                   <tbody>
	                                        @foreach($exit_pass as $pass)
	                                        <tr>
	                                            <td>
	                                            	{!! Html::decode(link_to_route('hrd_exit_list.details', $pass->exit_no,$pass->id, array())) !!}
	                                            </td>	                                           
	                                            <td>{!! strtoupper($pass->user->first_name.' '.$pass->user->last_name) !!}</td>
	                                            <td>{!! date('Y/m/d',strtotime($pass->date)) !!}</td>        
	                                            <td>
							           				@if($pass->date === date('Y-m-d'))
							           				<span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
							           				@elseif($pass->date < date('Y-m-d'))
							           				<span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
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
@stop