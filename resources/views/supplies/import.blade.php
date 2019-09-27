@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> IMPORT SUPPLIES</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> Import</h5>                    
                </div>
                <div class="ibox-content"> 
                    {!! Form::open(array('route'=>'supplies.upload','method'=>'POST','files'=>'true','enctype'=>'multipart/form-data')) !!}
                    	<div class="row">
							<div class="form-group">
								<div class="col-lg-4">
									{!! Form::label('upload','Upload File') !!}
									{!! Form::file('attached', array('id' => 'filer_inputs_u_access', 'class' => 'photo_files', 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application/vnd.ms-excel')) !!}          
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="form-group">     
								<div class="col-lg-12">
									{!! Form::button('<i class="fa fa-save"></i> Upload', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
								</div>                                           	
	                    	</div>  
	                    </div>
					{!! Form::close() !!}      
                </div>                                    
            </div>      			
		</div>
	</div>
</div>
@endsection
@section('page-script')

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });
@stop