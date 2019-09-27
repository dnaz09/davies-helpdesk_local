@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> ROOM RESERVATION DETAILS</h2>       
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
            <?php if (session('is_pass')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Password Doesn't Match!</h4></center>   
                </div>
            <?php endif;?>
            <?php if (session('is_not_vacant')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>The Room is currently in used!</h4></center>   
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('no_remarks')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Error! remarks field is empty!</h4></center>   
                </div>
           <?php endif;?>
        </div>  
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0 )
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
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">             
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST #:</strong></i></td><td>{!! $req->req_no !!}</td>
                        </tr>                     
                        <tr>
                            <td style="width:30%"><i><strong>MEETING TITLE:</strong></i></td><td>{!! strtoupper($req->details) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTOR:</strong></i></td><td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date($req->start_date).' - '.date($req->end_date) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>TIME:</strong></i></td><td>{!! date('h:i a',strtotime($req->start_time)).' - '.date('h:i a',strtotime($req->end_time)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>NUMBER OF ATTENDEES:</strong></i></td><td>{!! $req->att_no !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>ROOM SETUP:</strong></i></td><td>{!! strtoupper($req->setup) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($req->user->department->department) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>ROOM:</strong></i></td><td>{!! strtoupper($req->room) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($req->status == 0)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($req->status == 1)
                                <span class="label label-success"> <i class="fa fa-angellist"></i>Ongoing</span>
                                @elseif($req->status == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($req->status == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @elseif($req->status == 5)
                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                        </tr>                                                    
                    </table>                                       
                </div>                   
            </div>                                      
        </div>
        <div class="col-lg-6">            
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD NOTES <small></small></h5>          
                </div> 
                    <div class="ibox-content">
                        @if($req->status != 5)
                                <button class="btn btn-danger btnCancelRequest" value="{{$req->id}}" id="btnCancelRequest">Cancel Request</button>
                        @endif
                        @if($req->status < 2)                     
                        {!! Form::open(array('route'=>'room_request_list.remarks','method'=>'POST','files'=>true)) !!}                
                            @if($req->approval == 2)
                            <div class="form-group">  
                                {!! Form::hidden('id',$req->id) !!}        
                                @if($req->status < 2 && $req->status != 5)
                                    {!! Form::label('approve','Clear') !!}
                                    <p style="font-size: 15px;">
                                        <input type="radio" name="sub" value="2" id="sub"> <strong>YES</strong>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="sub" value="3" id="sub2"> <strong>NO</strong>
                                    </p>
                                    <button class="btn btn-warning" id="send" type="button"> Save</button>  
                                    <button class="hidden" id="sent" type="submit"></button> 
                                @else
                                @endif 
                            </div>
                            @elseif($req->approval < 2)
                            <div class="form-group">        
                                @if($req->status < 1 && $req->status != 5)
                                    {!! Form::hidden('id',$req->id) !!}
                                    <button class="btn btn-primary" id="serveBtn" type="button"> Serve</button>
                                    <button class="btn hidden" name="sub" value="5" id="serveBtnPressed" type="submit"></button>
                                    <button class="btn btn-danger" id="cancelBtn" type="button"> Deny</button>
                                    <button class="btn hidden" name="sub" value="3" id="cancelBtnPressed" type="submit"></button>
                                @elseif($req->status == 1)
                                    {!! Form::hidden('id',$req->id) !!}
                                    <div class="form-group">
                                        {!! Form::label('details','Add Your Notes') !!}
                                        {!! Form::text('details','',['class'=>'form-control','placeholder'=>'You Notes Here...','id'=>'remarks']) !!}                       
                                    </div> 
                                    <button class="btn btn-primary" id="vacantBtn" type="button"> Return Room to vacant</button>
                                    <button class="btn btn-primary hidden" name="sub" value="4" id="vacantBtnPressed" type="submit"></button>
                                    <button class="btn btn-danger" id="pendingBtn" type="button"> Return Request to Pending</button>
                                    <button class="btn btn-primary hidden" name="sub" value="6" id="pendingBtnPressed" type="submit"></button>
                                @else
                                @endif 
                            </div>
                            @else
                            @endif                 
                        @endif   
                    </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Notes</h5>                    
                </div>
                <div class="ibox-content inspinia-timeline" id="flow2">
                @forelse($routings as $remark)
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
                                <p><strong>{!! $remark->remarks2 !!}</strong></p>
                                <div style="margin-top: 10px;">                      
                                <p>{!! $remark->remarks !!}</p>              
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
@stop
@section('page-script')

/* data.process types:
   0 = alert data
   1 = alert url
   2 = production
*/


$('.btnCancelRequest').click(function () {
    
    id = $(this).val();
    var data_to_send = {
        id: id
    };
    var data = {
        swal_title: "Are you sure you want to cancel this request?",
        swal_text: "Your request will be sent",
        swal_icon: "warning",
        swal_button: "Yes, I am sure!",
        ajax_url: "/room_request_list/"+id+"/cancel",
        ajax_type: "get",
        ajax_data: data_to_send,
        swal_success: "Request cancelled successfully",
        process_type: 2
    };

    swal_ajax(data);
    
});


$('#sendremark').click(function () {
    var remarks = $('#remarks').val();
    if(remarks != ''){
        swal({
            title: "Are you sure?",
            text: "Your remarks will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#remarksent').click();
        });
    }else{
        swal('Cannot put remarks with a blank field!');
    }
});
$('#serveBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be served!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#serveBtnPressed').click();
    });
});
$('#cancelBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#cancelBtnPressed').click();
    });
});
$('#approve').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#approvesent').click();
    });
});
$('#deny').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#denysent').click();
    });
});
$('#vacantBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Please make sure that the room is in good condition!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#vacantBtnPressed').click();
    });
});
$('#pendingBtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be returned to pending!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#pendingBtnPressed').click();
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
