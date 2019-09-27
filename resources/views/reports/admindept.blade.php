@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-play-circle-o"></i> Administrative Services Department Reports</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Your download will start in a moment!<i class="fa fa-check"></i></h4></center>                
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
            <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i> ITEM TRACKING</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-user-circle"></i> OVERDUE ITEMS</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-user-circle"></i> MATERIALS REQUEST</a></li>
            <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-user-circle"></i> JOB ORDER REQUEST</a></li>
            <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-user-circle"></i> GATEPASS REQUEST</a></li>
            <!-- <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-check-square-o"></i> REQUISITION</a></li> -->
            <!-- <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-clock-o"></i> OBP</a></li>                              -->
        </ul>
    </div>
    <div class="tab-content">
    <!-- RELEASED ITEMS -->
    <div id="tab-1" class="row tab-pane active">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> BORROWED ITEMS RELEASED</h5>
                </div>
                <div class="ibox-content">                    
                    {!! Form::open(array('route'=>'admin_reports.bgenerate','method'=>'POST', 'target'=>'blank')) !!}
    				<div class="form-group" id="data_date">
    				    <label for="Date Range">Date Range</label>
    				    <div class="input-daterange input-group" id="datepicker">
    				        <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
    				        <span class="input-group-addon">to</span>
    				        <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
    				    </div>				    
    				</div>
    				<div class="form-group">
                        <button class="btn btn-warning" id="generateb" type="button"> Produce Report</button>                   
    				    {!! Form::button('<i class="fa fa-save"></i> Produce Report', array('type' => 'submit', 'class' => 'btn btn-warning hidden','id'=>'bgenerate')) !!}
                        <!-- <button type="submit" class="btn btn-primary" value="2" name="submit"><i class="fa fa-save"></i> Download Report</button> -->
    				</div> 
    				{!! Form::close() !!}
                </div>
            </div>   
        </div>
    </div>
    <!-- OVERDUE ITEMS -->
    <div id="tab-2" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> OVERDUE ITEMS REPORT</h5>
                </div>
                <div class="ibox-content">                    
                    {!! Form::open(array('route'=>'admin_reports.ogenerate','method'=>'POST', 'target'=>'blank')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
                        </div>                  
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" id="generateo" type="button"> Produce Report</button>                       
                        {!! Form::button('<i class="fa fa-save"></i> Produce Report', array('type' => 'submit', 'class' => 'btn btn-warning hidden', 'id' => 'ogenerate')) !!}
                        <!-- <button type="submit" class="btn btn-primary" value="2" name="submit"><i class="fa fa-save"></i> Download Report</button> -->
                    </div> 
                    {!! Form::close() !!}
                </div>
            </div>   
        </div>
    </div>
    <!-- MATERIAL REPORT -->
    <div id="tab-3" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> MATERIAL REQUEST</h5>
                </div>
                <div class="ibox-content">                    
                    {!! Form::open(array('route'=>'admin_reports.mgenerate','method'=>'POST', 'target'=>'blank')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
                        </div>                  
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" id="generatem" type="button"> Produce Report</button>                   
                        {!! Form::button('<i class="fa fa-save"></i> Produce Report', array('type' => 'submit', 'class' => 'btn btn-warning hidden','id'=>'mgenerate')) !!}
                        <!-- <button type="submit" class="btn btn-primary" value="2" name="submit"><i class="fa fa-save"></i> Download Report</button> -->
                    </div> 
                    {!! Form::close() !!}
                </div>
            </div>   
        </div>
    </div>
    <!-- JOB ORDER REPORT -->
    <div id="tab-4" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> JOB ORDER REQUEST</h5>
                </div>
                <div class="ibox-content">                    
                    {!! Form::open(array('route'=>'admin_reports.jogenerate','method'=>'POST', 'target'=>'blank')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
                        </div>                  
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" id="generatejo" type="button"> Produce Report</button>                   
                        {!! Form::button('<i class="fa fa-save"></i> Produce Report', array('type' => 'submit', 'class' => 'btn btn-warning hidden','id'=>'jogenerate')) !!}
                        <!-- <button type="submit" class="btn btn-primary" value="2" name="submit"><i class="fa fa-save"></i> Download Report</button> -->
                    </div> 
                    {!! Form::close() !!}
                </div>
            </div>   
        </div>
    </div>
    <!-- GATEPASS -->
    <div id="tab-5" class="row tab-pane">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> GATEPASS REQUEST</h5>
                </div>
                <div class="ibox-content">                    
                    {!! Form::open(array('route'=>'admin_reports.gpgenerate','method'=>'POST', 'target'=>'blank')) !!}
                    <div class="form-group" id="data_date">
                        <label for="Date Range">Date Range</label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-md form-control" name="date_from" value="{{$date_from}}"/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-md form-control" name="date_to" value="{{$date_to}}" />
                        </div>                  
                    </div>
                    <div class="form-group">
                        <button class="btn btn-warning" id="generategp" type="button"> Produce Report</button>                   
                        {!! Form::button('<i class="fa fa-save"></i> Produce Report', array('type' => 'submit', 'class' => 'btn btn-warning hidden','id'=>'gpgenerate')) !!}
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
$('#generateb').click(function () {
    swal({
        title: "Are you sure you want to generate this report?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#bgenerate').click();
    });
});
$('#generateo').click(function () {
    swal({
        title: "Are you sure you want to generate this report?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#ogenerate').click();
    });
});
$('#generatem').click(function () {
    swal({
        title: "Are you sure you want to generate this report?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#mgenerate').click();
    });
});
$('#generatejo').click(function () {
    swal({
        title: "Are you sure you want to generate this report?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#jogenerate').click();
    });
});
$('#generategp').click(function () {
    swal({
        title: "Are you sure you want to generate this report?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#gpgenerate').click();
    });
});
@endsection