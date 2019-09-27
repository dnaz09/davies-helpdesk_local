@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> DOWNLOADABLE FILES</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>File uploaded successfully!<i class="fa fa-check"></i></h4></center>                
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
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> Downloadable Files Table Maintenance</h5>	                
	                <button class="btn btn-xs btn-info pull-right" data-toggle="modal" data-target="#fileUpload">Upload File</button>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>Filename</th>
				                <th>Action</th>
				            </tr>
			            </thead>
			            <tbody>
			            	@foreach($files as $file)
			            	<tr>
			            		<th>{!!$file->filename!!}</th>
			            		<th>
			            			{{Form::open(array('route'=>'files.delete','method'=>'POST'))}}
			            			<input type="hidden" name="file_id" value="{{$file->id}}">
			            			<button type="submit" class="btn btn-xs btn-warning"> Delete</button>
			            			{{Form::close()}}
			            		</th>
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
<div id="fileUpload" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Uploading Files</h4>
            </div>
            {!! Form::open(array('route'=>'files.itupload','method'=>'POST','files'=>true)) !!}
            <div class="modal-body">            	
                {!! Form::label('attached','Attached File')!!}
                {!! Form::file('filename[]', array('id' => 'filer_inputs', 'class' => 'photo_files')) !!}  
            </div>
            <div class="modal-footer">
            	<button class="btn btn-warning" type="submit">Upload</button>
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