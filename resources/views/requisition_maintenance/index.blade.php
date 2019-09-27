@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> REQUISITION CATEGORIES MAINTENANCE</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Maintenance added successfully!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_delete')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>File was successfully Deleted!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_active')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully Activated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_inactive')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Item was successfully Deactivated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
		<div class="col-lg-12 animated flash">
		    <?php if (session('error')): ?>
		        <div class="alert alert-warning alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Error in uploading file!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>		    
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Requisition Categories Maintenance</h5>
	                <button class="btn btn-xs btn-info pull-right" data-toggle="modal" data-target="#categAdd">Add</button>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
				            <thead>
					            <tr>
					                <th>Form Type</th>
					            </tr>
				            </thead>
				            <tbody>
				            	@foreach($forms as $form)
				            	<tr>
				            		<th>{{$form->form}}</th>
				            	</tr>
				            	@endforeach
				            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Requisition Description Maintenance</h5>
	                <button class="btn btn-xs btn-info pull-right" data-toggle="modal" data-target="#DescAdd">Add</button>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
				            <thead>
					            <tr>
					                <th>Description</th>
					            </tr>
				            </thead>
				            <tbody>
				            	@foreach($descs as $desc)
				            	<tr>
				            		<th>{{$desc->description}}</th>
				            	</tr>
				            	@endforeach
				            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title"style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Requisition Purpose Maintenance</h5>
	                <button class="btn btn-xs btn-info pull-right" data-toggle="modal" data-target="#PurposeAdd">Add</button>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
				            <thead>
					            <tr>
					                <th>Purpose</th>
					            </tr>
				            </thead>
				            <tbody>
				            	@foreach($purposes as $purpose)
				            	<tr>
				            		<th>{{$purpose->purpose}}</th>
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
<!-- modal -->
<div id="categAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Category</h4>
            </div>
            {!! Form::open(array('route'=>'requisition_maintenance.create','method'=>'POST','files'=>true)) !!}
            <div class="modal-body">
            	{!! Form::label('Form','Category Name')!!}           	
                <input type="text" name="form" class="form-control" required>  
            </div>
            <div class="modal-footer">
            	<button class="btn btn-warning" type="submit" name="sub" value="1">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div id="DescAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Description</h4>
            </div>
            {!! Form::open(array('route'=>'requisition_maintenance.create','method'=>'POST','files'=>true)) !!}
            <div class="modal-body">            	
                {!! Form::label('descss','Description')!!}
                <input type="text" name="description" class="form-control" required>   
            </div>
            <div class="modal-footer">
            	<button class="btn btn-warning" type="submit" name="sub" value="2">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div id="PurposeAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Purpose</h4>
            </div>
            {!! Form::open(array('route'=>'requisition_maintenance.create','method'=>'POST','files'=>true)) !!}
            <div class="modal-body">            	
                {!! Form::label('purp','Purpose')!!}
                <input type="text" name="purpose" class="form-control" required>  
            </div>
            <div class="modal-footer">
            	<button class="btn btn-warning" type="submit" name="sub" value="3">Upload</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('page-script')

    $('#filer_inputs').filer({

        showThumbs:true,
        addMore:true
    });
@stop