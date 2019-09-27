@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> HRD WORK AUTHORIZATION DETAILS</h2>        
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
            <?php if (session('is_approved')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Employee has been Approved!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_deny')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Employee has been Denied!<i class="fa fa-check"></i></h4></center>                
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
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> WORK AUTHORIZATION DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! date('m/d/y',strtotime($work->created_at)) !!}</td>
                        </tr>                     
                        <tr>
                            <td style="width:30%">
                                <i><strong>DATE NEEDED:</strong></i>
                            </td>
                            <td>
                                @if($work->level != 5)
                                        <div class="normalcol">
                                            <span class="span_qty">{!! $work->date_needed !!}</span>
                                            <button type="button" class="btn btn-warning btn-xs pull-right btnEditDate">Edit</button>
                                        </div>

                                        <div class="editform hidden">
                                            <div class="row">
                                                    {!! Form::hidden('value', $work->id, ['class'=>'hiddeneditid']) !!}
                                                    {{-- {!! Form::text('value', date('m/d/y',strtotime($work->date_needed)),['class'=>'input-sm form-control numberqty','required','placeholder'=>'Value...','id'=>'value_id']) !!} --}}
                                                <div class="col-xs-6">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control inputDate" value="{{ date('m/d/y',strtotime($work->date_needed)) }}" id="input_text" name="date_needed" required="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                        <button class="btn btn-warning btn-sm saveEditDate" id="saveqtyedit" type="submit">Save</button>
                                                        <button class="btn btn-danger btn-sm cancelEditDate"  id="cancelqtyedit" type="button">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                @else
                                {!! date('m/d/y',strtotime($work->date_needed)) !!}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($work->user->first_name.' '.$work->user->last_name) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>POSITION:</strong></i></td><td>{!! strtoupper($work->user->position) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($work->user->department->department) !!}</td>
                        </tr>        
                        <tr>
                            <td style="width:30%"><i><strong>OVERTIME NEEDED FROM:</strong></i></td><td>{!! strtoupper($work->ot_from) !!}</td>
                        </tr>        
                        <tr>
                            <td style="width:30%"><i><strong>TO:</strong></i></td><td>{!! strtoupper($work->ot_to) !!}</td>
                        </tr>                                               
                        <tr>
                            <td style="width:30%"><i><strong>TOTAL OVERTIME NOT TO EXCEED HOURS:</strong></i></td><td>{!! strtoupper($work->not_exceed_to) !!}</td>
                        </tr>                                               
                        <tr>
                            <td style="width:30%"><i><strong>REASON:</strong></i></td><td>{!! strtoupper($work->reason) !!}</td>
                        </tr>                                                          
                        <tr>
                            <td style="width:30%"><i><strong>RECOMMENDED BY:</strong></i></td><td>{!! strtoupper($work->requested_by) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>WORK AUTHORIZATION STATUS:</strong></i></td>
                            <td>
                            @if($work->level < 2)
                                <span class="label label-warning"> <i class="fa fa-clock"></i> Pending</span>
                            @elseif($work->level == 2)
                                <span class="label label-primary"> <i class="fa fa-check"></i> Approved</span>
                            @elseif($work->level == 5)
                                <span class="label label-danger"> <i class="fa fa-close"></i> Cancelled</span>
                            @endif
                            </td>
                        </tr>                                                                                   
                    </table>
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-plus"></i> EMPLOYEES <small></small></h5>
                    </div>
                    @if ($work->user->first_name.' '.$work->user->last_name !== request()->user()->first_name.' '.request()->user()->last_name)
                        @if(count($emps) > 1)
                        <div class="form-group">
                            <br>
                            @if($work->level != 5)
                            {!!Form::open(array('url'=>'mng_work_authorization/approving','method'=>'POST'))!!}
                                <input type="hidden" id="work_id_hidden" name="work_id" value="{{$work->id}}">
                                @if($work->level != 2)
                                    <button class="btn btn-primary" type="button" id="approveAll"> Approve All</button>
                                    <button class="btn btn-danger" type="button" id="denyAll"> Deny All</button>
                                    <button type="submit" class="btn btn-primary hidden" name="sub" value="3" id="allApproved"> Approve All</button>
                                    <button type="submit" class="btn btn-danger hidden" name="sub" value="4" id="allDenied"> Deny All</button>
                                @endif
                                <button class="btn btn-info btncancelall" type="button">Cancel All</button>
                            {!!Form::close()!!}
                            @endif

                        </div>
                        @endif
                    @endif
                    <table class="table table-hover table-bordered"><br>
                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME</strong></i></td>
                            <td style="width:30%"><i><strong>STATUS</strong></i></td>
                            <td style="width:30%"><i><strong>ACTION</strong></i></td>
                        </tr>
                        @foreach($emps as $emp)
                        <tr>
                            <td>
                                {!!strtoupper($emp->user->first_name)!!} {!!strtoupper($emp->user->last_name)!!}
                            </td>
                            <td>
                                @if($emp->superior_action < 1)
                                <span class="label label-warning"> <i class="fa fa-clock"></i> Pending</span>
                                @elseif($emp->superior_action == 1)
                                <span class="label label-primary"> <i class="fa fa-check"></i> Approved</span>
                                @elseif($emp->superior_action == 2)
                                <span class="label label-danger"> <i class="fa fa-close"></i> Denied</span>
                                @else
                                <span class="label label-info"> <i class="fa fa-close"></i> Canceled</span>
                                @endif
                            </td>
                            <td>
                                @if ($work->user->first_name.' '.$work->user->last_name !== request()->user()->first_name.' '.request()->user()->last_name)
                                    <form class="form-approval">
                                        <input type="hidden" class="work_id_class" name="work_id" value="{{$emp->work_auth_id}}" id="{{$emp->work_auth_id}}">
                                    @if($emp->superior_action < 1 && $emp->superior_action != 5)
                                        <button type="button" class="btn btn-xs btn-primary btnapprove" data-id="{{$emp->user->id}}" name="approveButton">Approve</button>
                                        <button type="button" class="btn btn-xs btn-danger btndeny" data-id="{{$emp->user->id}}" name="denyButton"> Deny</button>
                                    @endif
                                    @if($emp->superior_action != 5 && $emp->superior_action != 2)
                                        <button type="button" class="btn btn-xs btn-info cancelButton" data-id="{{$emp->user->id}}" name="cancelButton"> Cancel</button>
                                    @endif
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>                                                                  
                </div>                   
            </div>                                      
        </div> 
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>
                @if($work->level != 5 || $work->level != 2)                           
                {!! Form::open(array('route'=>'work_authorization.remarks','method'=>'POST','files'=>true)) !!}                
                <div class="ibox-content">
                    <div class="form-group" >
                        {!! Form::label('details','Add Your Remarks') !!}
                        {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>                    
                    <div class="form-group">  
                        {!! Form::hidden('work_id',$work->id) !!}
                        <button class="btn btn-warning" id="remarksonly" type="button">Remarks</button>
                        <button class="btn btn-warning hidden" name ="sub" value="1" type="submit" id="remarksend">Remarks</button>

                    </div>                      
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
                                    <br>
                                    <small class="text-navy">{!! $remark->created_at->diffForHumans() !!}</small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>{!! strtoupper($remark->user->first_name.' '.$remark->user->last_name ) !!}</strong></p>
                                    <p>{!! $remark->details !!}</p>                                
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
@endsection
@section('page-script')
$('.input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});

$(".btnEditDate").click(function(){
    var parent = $(this).parent();

    parent.addClass('hidden');
    parent.next().removeClass('hidden');

}); 

$(".cancelEditDate").click(function(){
    var getclass = $(this).closest("td");
    var qty = getclass.find(".span_qty").text();

    getclass.find(".editform").addClass("hidden");
    getclass.find(".normalcol").removeClass("hidden");
    getclass.find(".inputDate").val(qty);

}); 

$('.saveEditDate').click(function () {

    var closest = $(this).closest("td");
    var newDate =  closest.find(".inputDate").val();
    var id = closest.find(".hiddeneditid").val();
    if(!newDate == ""){
        swal({
            title: "Are you sure you want to edit the date of this request?",
            text: "Your request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $.ajax({
                  url: '/hrd_work_authorization/{{$work->id}}/editDate',
                  type: "get",
                  data: {id:id, newDate:newDate},
                  success: function(response){ 
                    if(response == 'S'){

                        closest.find(".editform").addClass("hidden");
                        closest.find(".normalcol").removeClass("hidden");
                        closest.find(".span_qty").text(newDate);
                        
                        swal(
                          'Success!',
                          'Date edited successfully',
                          'success'
                        )
                    }
                  }
            });
        });
    }else{
        swal(
          'Error!',
          'Date is required.',
          'error'
        )
    }
});

$('.btncancelall').click(function () {
    var work_id = $('#work_id_hidden').val();
    swal({
        title: "Are you sure you want to cancel this work authorization?",
        text: "This action cannot be undone",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $.ajax({
            type:"POST",
            dataType: 'json',
            data: {
                "id": work_id,
            },
            url: "{{ url('work_authorization/cancel') }}",
            success: function(data){
                var type = data.type;
                if(type == 1){
                    
                    swal(
                      'Success!',
                      'Work Authorization cancelled successfuly',
                      'success'
                    )

                    setTimeout(function() {
                          location.reload();
                          }, 800);
                }
                if(type == 2){
                    swal('Sorry Your Request was already approved');
                    location.reload();
                }
                if(type == 3){
                    swal('There is an error in approving your request');
                    location.reload();
                }
            }    
        });
    });
});

$('#approveAll').click(function () {
    swal({
        title: "Are you sure?",
        text: "All users will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#allApproved').click();
    });
});
$('#denyAll').click(function () {
    swal({
        title: "Are you sure?",
        text: "All users will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#allDenied').click();
    });
});
$('#remarksonly').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remark will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#remarksend').click();
    });
});

$(document).on('click', '.cancelButton', function(e) {
    e.preventDefault();
    var work_id = $('.work_id_class').val();
    var user_id = $(this).data('id');

    swal({
        title: "Are you sure you want to cancel this user?",
        text: "This user will be cancelled!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    }, function (willcanceled) {
        if(willcanceled) {
            $.ajax({
                type: "POST",
                url: "/mng_work_authorization/approving",
                data: {
                    user_id: user_id,
                    work_id: work_id,
                    sub: 5
                },
                success: function (response) {

                    swal(
                      'Success!',
                      'User cancelled successfuly',
                      'success'
                    )
                    setTimeout(function(){
                       location.reload(); 
                  }, 1000); 
                },
                failed: function(data){
                    alert("Error in approving, Kindly reload the page");
                }
            });
        }
        else {
            swal("Approving aborted!");
        }
    });
});

$(document).on('click', '.btnapprove', function(e) {
    e.preventDefault();
    var work_id = $('.work_id_class').val();
    var user_id = $(this).data('id');

    swal({
        title: "Are you sure you want to approve this user?",
        text: "This user will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    }, function (willApprove) {
        if(willApprove) {
            $.ajax({
                type: "post",
                url: "{{url('mng_work_authorization/approving')}}",
                data: {
                    user_id: user_id,
                    work_id: work_id,
                    sub: 1
                },
                success: function () {
                    swal(
                      'Success!',
                      'User approved successfuly',
                      'success'
                    )

                 setTimeout(function(){
                       location.reload(); 
                  }, 1000); 
                },
                failed: function(data){
                    alert("Error in approving, Kindly reload the page");
                }
            });
        }
        else {
            swal("Approving aborted!");
        }
    });
});

$(document).on('click', '.btndeny', function(e) {
    e.preventDefault();
    var work_id = $('.work_id_class').val();
    var user_id = $(this).data('id');

    swal({
        title: "Are you sure you want to deny this user?",
        text: "This user will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    }, function (willApprove) {
        if(willApprove) {
            $.ajax({
                type: "post",
                url: "{{url('mng_work_authorization/approving')}}",
                data: {
                    user_id: user_id,
                    work_id: work_id,
                    sub: 2
                },
                success: function () {
                    swal(
                      'Success!',
                      'User denied successfuly',
                      'success'
                    )
                    setTimeout(function(){
                       location.reload(); 
                  }, 1000); 
                },
                failed: function(data){
                    alert("Error in Denying user, Kindly reload the page");
                }
            });
        }
        else {
            swal("Denying aborted!");
        }
    });
});
@stop