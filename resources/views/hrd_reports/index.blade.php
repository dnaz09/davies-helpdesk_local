@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-play-circle-o"></i> HRD Reports</h2>
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
    <div class="panel-options">
        <ul class="nav nav-tabs">                            
            <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i> WORK AUTHORIZATION</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-user-circle"></i> LEAVE</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-check-square-o"></i> REQUISITION</a></li>                                
            <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-clock-o"></i> OBP</a></li>                             
        </ul>
    </div>
    <div class="tab-content">
    <!-- WORK AUTH -->
    <div id="tab-1" class="row tab-pane active">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> WORK AUTHORIZATION REPORT</h5>
                </div>
                <div class="ibox-content">                    
                    {!! Form::open(array('route'=>'work_auth.generate','method'=>'POST')) !!}
    				<div class="form-group" id="data_date">
    				    <label for="Date Range">Date Range</label>
    				    <div class="input-daterange input-group" id="datepicker">
    				        <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
    				    </div> 			    
    				</div>
                    <div class="form-group" id="data_date">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}"/>
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
    <!-- UNDERTIME -->
    <div id="tab-2" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> LEAVE REPORT</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'undertime.generate','method'=>'POST')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                        </div>                 
                    </div>
                    <div class="form-group" id="data_date">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}"/>
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
    <!-- REQUISITION -->
    <div id="tab-3" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> REQUISITION REPORT</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'requisition.generate','method'=>'POST')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                        </div>              
                    </div>
                    <div class="form-group" id="data_date">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}"/>
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
    <!-- OBP -->
    <div id="tab-4" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> OBP REQUEST REPORT</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'obp_request.generate','method'=>'POST')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                        </div>               
                    </div>
                    <div class="form-group" id="data_date">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}"/>
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
</div>

@endsection

    
@section('page-script')
  $('#data_date .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
});

@endsection