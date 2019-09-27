@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>LEAVE DETAILS</h2>        
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
            <?php if (session('is_denied')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been denied!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('no_remarks')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Error! remarks field is empty!<i class="fa fa-check"></i></h4></center>                
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
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> LEAVE DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE FILED:</strong></i></td><td>{!! date('m/d/y',strtotime($undertime->created_at)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>TIME FILED:</strong></i></td><td>{!! date('h:i a',strtotime($undertime->created_at)) !!}</td>
                        </tr>                     
                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($undertime->user->first_name.' '.$undertime->user->last_name) !!}</td>
                        </tr>                                                                       
                        <tr>
                            <td style="width:30%">
                                <i><strong>DATE:</strong></i>
                            </td>
                            <td>
                                @if($undertime->status != 5 && $undertime->status != 3)
                                        <div class="normalcol">
                                            <span class="span_qty">{!! date('m/d/y',strtotime($undertime->date)) !!}</span>
                                            <button type="button" class="btn btn-warning btn-xs pull-right btnEditDate">Edit</button>
                                        </div>

                                        <div class="editform hidden">
                                            <div class="row">
                                                    {!! Form::hidden('value', $undertime->id, ['class'=>'hiddeneditid']) !!}
                                                    {{-- {!! Form::text('value', date('m/d/y',strtotime($work->date_needed)),['class'=>'input-sm form-control numberqty','required','placeholder'=>'Value...','id'=>'value_id']) !!} --}}
                                                <div class="col-xs-6">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control inputDate" value="{{ date('m/d/y',strtotime($undertime->date)) }}" id="input_text" name="date_needed" required="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                        <button class="btn btn-warning btn-sm saveEditDate" id="saveqtyedit" type="submit">Save</button>
                                                        <button class="btn btn-danger btn-sm cancelEditDate"  id="cancelqtyedit" type="button">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                @else
                                {!! date('m/d/y',strtotime($undertime->date)) !!}
                                @endif
                            </td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>TIME:</strong></i></td><td>{!! strtoupper($undertime->sched) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>TYPE:</strong></i></td>
                            <td>
                                @if($undertime->type == 1)
                                HALF DAY
                                @elseif($undertime->type == 2)
                                UNDERTIME
                                @else
                                @endif
                            </td>
                        </tr>  
                        <tr>
                            <td style="width:30%"><i><strong>REASON:</strong></i></td><td>{!! strtoupper($undertime->reason) !!}</td>
                        </tr>                                                          
                    </table>                           
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>MANAGER:</strong></i></td>
                            <td>
                                @if($undertime->manager > 0 AND !empty($undertime->manager))
                                    {!! strtoupper($undertime->mngrs->first_name.' '.$undertime->mngrs->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                                @if($undertime->manager_action < 1)
                                <button class="btn btn-info btn-xs pull-right" onclick="showHrdModal()"><i class="fa fa-angellist"></i> Approve</i></button>
                                @else
                                @if(!empty($undertime->remark))
                                <p class="pull-right">{!! strtoupper($undertime->remark) !!}</p>
                                @endif
                                @endif
                            </td>
                        </tr>                           
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>                          
                                @if($undertime->status == 2)  
                                    {{-- <i class="fa fa-check" style="color:green;"></i> --}}
                                    <span class="label label-primary"> <i class="fa fa-clock"></i> Approved</span>
                                @elseif($undertime->status == 3)    
                                    {{-- <i class="fa fa-close" style="color:red;"></i> --}}
                                    <span class="label label-danger"> <i class="fa fa-clock"></i> Denied</span>
                                @elseif($undertime->status == 5)
                                    {{-- <i class="fa fa-minus"></i> --}}
                                    <span class="label label-info"> <i class="fa fa-clock"></i> Cancelled</span>
                                @endif
                            </td>
                        </tr>  
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY:</strong></i></td>
                            <td>
                                @if($undertime->approve_by > 0 AND !empty($undertime->approve_by))
                                    {!! strtoupper($undertime->approver->first_name.' '.$undertime->approver->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>        
                    <div class="ibox-content">
                    @if($undertime->status < 2) 
                        {!! Form::open(array('route'=>'undertime.remarks','method'=>'POST','files'=>true)) !!}                
                            <div class="form-group" >
                                {!! Form::label('details','Add Your Remarks') !!}
                                {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...']) !!}                       
                            </div>                    
                            <div class="form-group">  
                                {!! Form::hidden('undertime_id',$undertime->id) !!}       
                                @if($undertime->approved_by < 1 && $undertime->status != 5 && $undertime->level != 5)
                                    @if($undertime->approver_action < 1 && $undertime->manager_action == 1)
                                    <button type="button" id="remarkonly" class="btn btn-warning"> Remarks</button>
                                    <!-- <button type="button" id="approval" class="btn btn-primary"> Approve</button> -->
                                    <button type="button" id="approvalgenerate" class="btn btn-primary"> Approve </button>
                                    <button type="button" id="denial" class="btn btn-danger"> Deny</button>
                                    <button class="btn btn-warning hidden" id="remarksent" name ="sub" value="1" type="submit">Remarks Only</button>
                                    <!-- <button class="btn btn-primary hidden" id="approved" name ="sub" value="2" type="submit">Approve</button>                            -->
                                    <button class="btn btn-info hidden" id="approvegenerate" name ="sub" value="4" type="submit">Approve and Generate Exit Pass</button>                           
                                    <button class="btn btn-danger hidden" id="denied" name ="sub" value="3" type="submit">Denied</button>
                                    @endif
                                @else
                                @endif
                            </div>                      
                        {!! Form::close() !!}
                        @endif 

                        @if($undertime->status != 5 && $undertime->manager_action != 5 && $undertime->level != 5)
                            <div class="form-group">  
                                <button type="button" id="cancel" class="btn btn-info btncancelall"> Cancel</button>
                            </div>
                        @endif
                    </div>         

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
<!-- Modal -->
<div id="hrdManagerApproval" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header" style="background-color:#009688">                
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
                <center><h2 style="color: white;">Add Remarks</h2></center>
            </div>
            {!! Form::open(array('route'=>'undertime.remarks','method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('remarks','Remarks') !!}
                    {!! Form::text('remarks','',['class'=>'form-control','placeholder'=>'Your Remarks...','required'=>'required']) !!}
                </div>
                <input type="hidden" name="undertime_id" value="{{$undertime->id}}">
            </div>
            <div class="modal-footer">          
                {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'button', 'class' => 'btn btn-primary','id'=>'managerApprove')) !!}
                <button class="hidden" type="submit" id="managerApproveClicked" value="6" name="sub"></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
            {!! Form::close() !!}
        </div>        
    </div>
</div> 
<script type="text/javascript">
    function showHrdModal(){
        $('#hrdManagerApproval').modal('show'); 
    }
</script> 
@stop
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
                  url: '/hrd_undertime/{{$undertime->id}}/editDate',
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
    swal({
        title: "Are you sure you want to cancel this undertime request?",
        text: "This action cannot be undone",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $.ajax({
            type:"get",
            data: {
                "id": {{$undertime->id}},
            },
            url: '/hrd_undertime/{{$undertime->id}}/cancel',
            success: function(data){
                var type = data.type;
                if(type == 1){
                    
                    swal(
                      'Success!',
                      'Undertime Request cancelled successfuly',
                      'success'
                    )

                    setTimeout(function() {
                          location.reload();
                          }, 800);
                }

                if(type == 2){
                    swal('There is an error in approving your request');
                    location.reload();
                }
            }    
        });
    });
});

$('#managerApprove').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be approved and will be moved to the HR Department!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#managerApproveClicked').click();
    });
});
$('#remarkonly').click(function () {
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
});
$('#approval').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#approved').click();
    });
});
$('#approvalgenerate').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be approved and an exit pass will be generated!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#approvegenerate').click();
    });
});
$('#denial').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#denied').click();
    });
});
@stop
