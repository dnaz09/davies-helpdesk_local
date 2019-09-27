@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i>GUARD REPORTS</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
	    <div class="col-lg-12">
	        <div class="ibox float-e-margins">            
	            <div class="ibox-content">
	                <div class="panel blank-panel">                    
	                    <div class="panel-body">                                                                                     
	                        <div class="col-lg-12">
	                        	{{Form::open(array('route'=>'guardrep.getreports','method'=>'POST'))}}
	                        	<div class="form-group" id="data_date">
			    				    <label for="Date Range">Date Range</label>
			    				    <div class="input-daterange input-group" id="datepicker">
			    				        <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
			    				        <span class="input-group-addon">to</span>
			    				        <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
			    				    </div>				    
			    				</div>
			    				<button class="btn btn-info" name="sub" value="1"> Exit Pass</button>
			    				<button class="btn btn-primary" name="sub" value="2"> Work Authorization</button>
			    				{{Form::close()}}
	                        </div>                                                                                
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@stop
@section('page-script')
$('#data_date .input-daterange').datepicker({
	keyboardNavigation: false,
    forceParse: false,
    autoclose: true
});
@endsection