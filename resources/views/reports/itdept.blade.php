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
            <?php if (session('is_update')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Role was successfully updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> IT DEPARTMENT REPORT</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'reports.store','method'=>'POST')) !!}
				<div class="form-group" id="data_5">
				    {!! Form::label('start','Date Range') !!}
				    <div class="input-daterange input-group" id="datepicker">
				        <input type="text" class="input-md form-control" name="start" value="{{$start}}"/>
				        <span class="input-group-addon">to</span>
				        <input type="text" class="input-md form-control" name="end" value="{{$end}}" />
				    </div>				    
				</div>
				<div class="form-group">
                    <button class="btn btn-warning" type="button" id="dlbtn"> Export to Excel</button>                        
				    {!! Form::button('<i class="fa fa-save"></i> Export To Excel', array('type' => 'submit', 'id' => 'dlstart', 'class' => 'btn btn-warning hidden')) !!}
				</div> 
				{!! Form::close() !!}
            </div>
        </div>        
    </div>
</div>


@endsection

    
@section('page-script')
  $('#data_5 .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
});

$('#dlbtn').click(function () {
        swal({
            title: "Please wait",
            text: "Your download will start in a moment",
            icon: "info",
            dangerMode: true,
            confirmButtonText: "Ok!"
        },function(){
            $('#dlstart').click();
        });
    }); 

@endsection