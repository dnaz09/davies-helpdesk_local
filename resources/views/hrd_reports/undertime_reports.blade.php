@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-play-circle-o"></i> Reports</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Role was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_null')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>No data found!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> UNDERTIME REPORT</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'undertime.generate','method'=>'POST')) !!}
    				<div class="form-group" id="data_date">
    				    <label for="Date Range">Date Range</label>
    				    <div class="input-daterange input-group" id="datepicker">
    				        <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
    				        <span class="input-group-addon">to</span>
    				        <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
    				    </div>				    
    				</div>
    				<div class="form-group">                        
    				    {!! Form::button('<i class="fa fa-save"></i> Produce Report', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                        <!-- <button type="submit" class="btn btn-primary" value="2" name="submit"><i class="fa fa-save"></i> Download Report</button> -->
    				</div> 
				{!! Form::close() !!}
                </div>
            </div>   
        </div>
    </div>
</div>


@endsection

    
@section('page-script')
  $('#data_date .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
});

@endsection