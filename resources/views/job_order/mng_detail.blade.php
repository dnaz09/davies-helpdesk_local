@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> JOB ORDER DETAILS</h2>        
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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row"> 
        <div class="col-lg-12">     
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-plus"></i> REQUEST DETAILS <small></small></h5>          
                    </div>
                    <div class="col-md-12 ibox-content">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <td style="width:30%"><i><strong>REQUEST NUMBER:</strong></i></td><td>{!! strtoupper($jo->jo_no) !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%"><i><strong>DATE :</strong></i></td><td>{!! date('m/d/y',strtotime($jo->created_at)) !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%"><i><strong>TYPE :</strong></i></td><td>JOB ORDER</td>
                                </tr>
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
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-plus"></i> WORK <small></small></h5>          
                    </div> 
                    <div class="col-md-12 ibox-content">
                        <div class="col-md-12">
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <td style="width:30%"><i><strong>LOCATION:</strong></i></td><td>{!! strtoupper($jo->section) !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%"><i><strong>REQUESTED WORK:</strong></i></td><td>{!! strtoupper($jo->req_work) !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%"><i><strong>WORK FOR:</strong></i></td><td>{!! strtoupper($jo->work_for) !!}
                                        @if(!empty($jo->item_class))
                                        {!! $jo->item_class !!}
                                        @endif
                                    </td>
                                </tr>
                                @if ($jo->asset_no) 
                                    <tr>
                                        <td style="width:30%"><i><strong>FACILITIES/BUILDING:</strong></i></td>
                                        <td>{{strtoupper($jo->facility ?? "-")}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="width:30%"><i><strong><?php empty($jo->asset_no) ? print"FACILITIES/BUILDING:" : print"EQUIPMENT NO:" ?></strong></i></td><td>{!! strtoupper($jo->other_info).' '.$jo->asset_no !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%"><i><strong>DESCRIPTION OF PROBLEM/ REASON/ REMARKS:</strong></i></td><td>{!! strtoupper($jo->description).' '.$jo->item_class !!}</td>
                                </tr>                    
                                <tr>
                                    <td style="width:30%"><i><strong>APPROVAL STATUS: </strong></i></td>
                                    <td>
                                        @if($jo->sup_action < 2 && $jo->status != 5)
                                            <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($jo->status == 5)
                                            <span class="label label-ino"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @elseif($jo->status == 2)
                                            <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($jo->status == 3)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span> 
                                        @endif
                                    </td>
                                </tr> 
                            </table>
                        </div>                                               
                    </div>                   
                </div>                                      
            </div>
        </div>   
        <div class="col-lg-12">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white">Add Remarks</h5>
                    </div>
                    @if($jo->status < 2 && $jo->status != 5)  
                    {!! Form::open(array('route'=>'sup_jo_request.jo_remarks','method'=>'POST','files'=>true)) !!}
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('remarks','Purpose') !!}
                            {!! Form::text('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','id' => 'remarks']) !!}                       
                        </div>
                        <div class="form-group">  
                            {!! Form::hidden('jo_id',$jo->id) !!}
                            <!-- show -->
                            <!-- <button class="btn btn-warning" id="remarksBtn" type="button"> Remarks Only</button>
                            <button class="btn btn-primary" id="approveBtn" type="button"> Approve</button>
                            <button class="btn btn-danger" id="dangerBtn" type="button"> Deny</button> -->
                            <!-- hiddens -->
                            <!-- <button class="hidden" name ="sub" value="1" type="submit" id="remarksBtnPressed"></button>                  
                            <button class="hidden" name ="sub" value="2" type="submit" id="approveBtnPressed"></button>
                            <button class="hidden" name ="sub" value="3" type="submit" id="dangerBtnPressed"></button> -->
                            {!! Form::label('label','Approve') !!}
                            <p style="font-size: 15px;">
                                <input type="radio" name="sub" value="2" id="sub"> <strong>YES</strong>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="sub" value="3" id="sub2"> <strong>NO</strong>
                            </p>
                        </div>
                        <button class="btn btn-warning" id="send" type="button"> Save</button>                     
                        <button class="hidden" id="sent" type="submit"></button>                      
                    </div> 
                    {!! Form::close() !!}
                    @endif
                </div>
            </div>    
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white">Remarks</h5>                    
                    </div>
                    <div class="ibox-content inspinia-timeline" id="flow2">
                    @forelse($remarks as $remark)
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-briefcase"></i>
                                    {!! $remark->created_at->format('M-d-Y h:i a') !!}
                                    <br/>
                                    <small class="text-navy">{!! $remark->created_at->diffForHumans() !!}</small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>{!! strtoupper($remark->user->first_name.' '.$remark->user->last_name ) !!}</strong></p>
                                    <p>{!! $remark->remark !!}</p>                                
                                    <div>
                                        @if(!empty($remark->files))
                                            @foreach($remark->files as $filer)
                                                {!! Form::open(array('route'=>'job_order.download_file','method'=>'POST', 'target'=>'_blank')) !!}
                                                {!! Form::hidden('encname',$filer->encryptname) !!}
                                                {!! Form::submit($filer->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}
                                                {!! Form::close() !!}
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        ....No Remarks Found
                    @endforelse   
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>   
@stop
@section('page-script')
$('#remarksBtn').click(function () {
    var x = $('#remarks').val();
    if(x == ''){
        swal('Cannot Send Remarks without entering remarks!');
    }else{
        swal({
            title: "Are you sure?",
            text: "Your request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#remarksBtnPressed').click();
        });
    }
});
$('#approveBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#approveBtnPressed').click();
    });
});
$('#dangerBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#dangerBtnPressed').click();
    });
});
$('#send').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        if($('#sub').is(':checked') || $('#sub2').is(':checked')){
            $('#sent').click();
        }else{
            setTimeout(function() {
                swal('Please Select Transaction Status!');
            },400)
        }
    });
});
@endsection
