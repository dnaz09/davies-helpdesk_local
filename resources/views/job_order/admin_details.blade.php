@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> ADMIN JOB ORDER DETAILS</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Success! <i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_good')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Details has been Added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_good')): ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>You have no access in this request!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_closed')): ?>
                <div class="alert alert-success alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Request Has Been Closed!</h4></center>   
                </div>
           <?php endif;?>
        </div>    
        <div class="col-md-12 animated flash">
            <?php if (session('is_exitpass')): ?>
                <div class="alert alert-success alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Request Has Been Closed and Exit Pass Has Been Generated!</h4></center>   
                </div>
           <?php endif;?>
        </div>    
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0)
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>       
    </div>
</div>
<div class="col-md-6 pull-right">
    <table class="table table-hover table-bordered" style="background-color: white">
        <tr>
            <td style="width:30%"><i><strong>DATE :</strong></i></td><td>{!! date('m/d/y',strtotime($jo->created_at)) !!}</td>
        </tr>
        <tr>
            <td style="width:30%"><i><strong>REQUEST #:</strong></i></td><td>{!! strtoupper($jo->jo_no) !!}</td>
        </tr>
        <tr>
            <td style="width:30%"><i><strong>TYPE :</strong></i></td><td>JOB ORDER</td>
        </tr>
    </table>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">        
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> JOB ORDER DETAILS <small></small></h5>          
                </div>
                <div class="col-md-12 ibox-content">
                    <div class="col-md-6">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($jo->user->first_name.' '.$jo->user->last_name) !!}</td>
                            </tr>
                            <tr>
                                <td style="width:30%"><i><strong>POSITION:</strong></i></td><td>{!! strtoupper($jo->role->role) !!}</td>
                            </tr>
                            <tr>
                                <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($jo->department->department) !!}</td>
                            </tr>
                        </table>
                    </div>                                               
                </div>                   
            </div>                                      
        </div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> OTHER DETAILS <small></small></h5>          
                </div> 
                <div class="col-md-12 ibox-content">
                    <div class="col-md-6">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td style="width:30%"><i><strong>REQUEST NUMBER:</strong></i></td><td>{!! strtoupper($jo->jo_no) !!}</td>
                            </tr>
                            <tr>
                                <td style="width:30%"><i><strong>REQUESTED WORK:</strong></i></td><td>{!! strtoupper($jo->req_work) !!}</td>
                            </tr>
                            <tr>
                                <td style="width:30%"><i><strong>LOCATION:</strong></i></td><td>{!! strtoupper($jo->section) !!}</td>
                            </tr>                        
                            <tr>
                                <td style="width:30%"><i><strong>SUPERIOR ACTION: </strong></i></td>
                                <td>
                                    @if($jo->sup_action < 1 && $jo->status != 5)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                    @elseif($jo->status == 5)
                                        <span class="label label-ino"> <i class="fa fa-angellist"></i> Canceled</span>
                                    @else
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span> 
                                    @endif
                                </td>
                            </tr> 
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DESCRIPTION OF PROBLEM/ REASON/ REMARKS:</strong></i></td><td>{!! strtoupper($jo->description).' '.$jo->item_class !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>WORK FOR:</strong></i></td><td>{!! strtoupper($jo->work_for).' '.$jo->item_class !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>FACILITIES/BUILDING</strong></i></td><td>{{strtoupper($jo->facility ?? "-")}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>EQUIPMENT NO.</strong></i></td><td>{!! strtoupper($jo->other_info) !!}
                                @if(!empty($jo->asset_no)) 
                                    {!! '('.$jo->asset_no.')' !!}
                                @endif
                            </td>
                        </tr>                      
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY:</strong></i></td>
                            <td>
                                @if($jo->approved_by != 0)
                                    {!! strtoupper($jo->approved->first_name.' '.$jo->approved->last_name) !!}
                                @endif
                                @if($jo->approved_by == 0 && $jo->status != 5)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($jo->status == 5)
                                    <span class="label label-ino"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>JOB ORDER STATUS:</strong></i></td>
                            <td>
                                @if($jo->jo_status == 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i> Looking for Service Provider</span>
                                @elseif($jo->jo_status == 0)
                                    <span class="label label-success"> <i class="fa fa-angellist"></i> Approved</span>
                                @elseif($jo->jo_status == 2)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i> Done</span>
                                @elseif($jo->jo_status == 4)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i> Ongoing</span>
                                @elseif($jo->jo_status == 5)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i> Canceled</span>
                                @endif
                            </td>
                        </tr> 
                        @if($jo->status == 2)
                        <tr>
                            <td style="width:30%"><i><strong>ACTION:</strong></i></td>
                            <td>
                                <a href="/job_order/{{$jo->id}}/{{$jo->user_id}}/generate" id="{{$jo->id}}" target="__blank"><button class="btn btn-primary btn-xs"><i class="fa fa-download"></i> Download</button></a>
                            </td>
                        </tr>
                        @endif
                    </table>
                    </div>                                               
                </div>                   
            </div>                                      
        </div>
        @if($jo->jo_status != 2 && $jo->jo_status != 5)
        <div class="col-lg-8" id="divreload">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Add Other Details</h5>
                </div>
                @if($jo->jo_status != 2 && $jo->jo_status != 5 && $jo->jo_status == 1)  
                {!! Form::open(array('route'=>'job_order_admin.add_info','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" >
                                {!! Form::label('endorse','Endorsed To') !!}<br>
                                <input type="radio" name="service_by" id="end_1" value="Handyman" required=""> Handyman                       
                                <input type="radio" name="service_by" id="inhouse" value="In-house Contractors" required=""> In-house Contractors                       
                                <input type="radio" name="service_by" id="others" value="Other Contractors" required=""> Other Contractors
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('endorse','*For Other Contractors Only') !!}
                                    {!! Form::text('contractor','',['class'=>'form-control','disabled','required','Placeholder'=>'Name of Contractor...','id'=>'contractor']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('endorse','*For Inhouse Contractors Only') !!}
                                    <select id="inhouses" name="inhouse" class="form-control" required disabled="">
                                        <option value="-"> PLEASE SELECT INHOUSE CONTRACTOR</option>
                                        @foreach($inhouses as $inhouse)
                                        <option value="{{$inhouse->inhouse}}">{!!$inhouse->inhouse!!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    {!! Form::hidden('jo_id',$jo->id) !!}
                                    <!-- show -->
                                    <button class="btn btn-warning" id="remarksBtn1" type="button"> Save</button>
                                    <!-- hiddens -->
                                    <button class="hidden" type="submit" name="sub" value="1" id="remarksBtnPressed1"></button> 
                                </div>
                            </div>
                        </div>  
                    </div>             
                </div> 
                {!! Form::close() !!}
                @endif
                @if($jo->jo_status != 2 && $jo->jo_status != 5 && $jo->jo_status == 4)  
                {!! Form::open(array('route'=>'job_order_admin.add_info','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('endorse','Handyman') !!}
                                    <div class="input-group">
                                        {!! Form::text('contractor',$jo->served_by,['class'=>'form-control','required','Placeholder'=>'Name of Contractor...','readonly']) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning btnedithandyman" type="button">Edit</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('finding','Findings') !!}
                                    {!! Form::text('work_done',$jo->work_done,['class'=>'form-control','required','Placeholder'=>'Enter Findings...']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('reco','Recommendation') !!}
                                    {!! Form::text('reco',$jo->reco,['class'=>'form-control','required','Placeholder'=>'Enter Recommendation...']) !!}
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="u_date">
                                        <label class="font-normal"><strong>Date Started</strong></label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$jo->date_started}}" name="date_started" required="" id="input_text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="u_date">
                                        <label class="font-normal"><strong>Date Finished</strong></label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$jo->date_finished}}" name="date_finished" required="" id="input_text2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('reco','Total Cost') !!}
                                        <input type="number" name="total_cost" class="form-control" value="{{$jo->total_cost}}" placeholder="Enter Total Cost" step=".01">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="date_filed" value="{{$jo->created_at}}">
                            <div class="form-group">
                                <div class="col-md-12">
                                    {!! Form::hidden('jo_id',$jo->id) !!}
                                    <!-- show -->
                                    <button class="btn btn-warning" id="remarksBtn2" type="button"> Save</button>
                                    <!-- hiddens -->
                                    <button class="hidden" type="submit" name="sub" value="2" id="remarksBtnPressed2"></button> 
                                </div>
                            </div>
                        </div>  
                    </div>             
                </div> 
                {!! Form::close() !!}
                @endif
            </div>
        </div>
        @endif
        <div class="col-lg-6">
            
        </div>
    </div>    
</div>   
@stop
@section('page-script')
var date = $('#date_filed').val();
$('#u_date .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date(date)
});

$('.btnedithandyman').click(function () {
    swal({
        title: "Are you sure you want to edit your service provider?",
        text: "Your service provider will be changed!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $.ajax({
              url: '/job_order_admin/{{$jo->id}}/editprovider',
              type: "get",
              data: {id:'{{$jo->id}}'},
              success: function(response){ 
                if(response == 'S'){
                    location.hash = '#divreload';
                    location.reload();
                }
              }
        });
    });
}); 

$('#input_text').bind('copy paste',function(e) {
    e.preventDefault();
});
$('#input_text2').bind('copy paste',function(e) {
    e.preventDefault();
});

$('#others').on('change', function(e) {
    var selected = $('#others').val();
    if(selected.indexOf('Other Contractors')!=-1){
        $("#contractor").prop('disabled',false);
        $("#inhouses").prop('disabled',true);
    }
});
$('#input_text').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});
$('#input_text2').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});
$('#end_1').on('change', function(e) {
    var selected = $('#end_1').val();
    if(selected.indexOf('Handyman')!=-1){
        $("#contractor").prop('disabled',true);
        $("#inhouses").prop('disabled',true);
        $("#contractor").val('');
    }
});
$('#inhouse').on('change', function(e) {
    var selected = $('#inhouse').val();
    if(selected.indexOf('In-house Contractors')!=-1){
        $("#inhouses").prop('disabled',false);
        $("#contractor").prop('disabled',true);
        $("#contractor").val('');
    }
});
$('#remarksBtn1').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#remarksBtnPressed1').click();
    });
});
$('#remarksBtn2').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#remarksBtnPressed2').click();
    });
});
@endsection
