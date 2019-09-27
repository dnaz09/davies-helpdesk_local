@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> OB DETAILS</h2>        
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
                    <center><h4>Error! Remarks field is empty!<i class="fa fa-check"></i></h4></center>                
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>Official Business Pass DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->created_at)) !!}</td>
                        </tr>                     

                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($obp->user->first_name.' '.$obp->user->last_name) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>POSITION:</strong></i></td><td>{!! strtoupper($obp->position) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($obp->user->department->department) !!}</td>
                        </tr>                                               
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE:</strong></i></td><td>{!! strtoupper($obp->purpose) !!}</td>
                        </tr>                                                          
                    </table>         
                    <h3>ITINERARY</h3>
                    <table class="table table-hover table-bordered">
                        <tr>                                                        
                            <th>DESTINATION</th>
                            <th>PERSON VISITED</th>                                                                        
                        </tr>
                        <tbody>                            
                            <tr>
                                @if(!empty($obp_details->destination))
                                <td>{!! $obp_details->destination !!}</td>
                                <td>{!! $obp_details->person_visited !!}</td>                                
                                @else
                                @endif
                            </tr>
                            <tr>
                                @if(!empty($obp_details->destination2))
                                <td>{!! $obp_details->destination2 !!}</td>
                                <td>{!! $obp_details->person_visited2 !!}</td>                                
                                @else
                                @endif
                            </tr>
                                @if(!empty($obp_details->destination3))
                                <td>{!! $obp_details->destination3 !!}</td>
                                <td>{!! $obp_details->person_visited3 !!}</td>                                
                                @else
                                @endif
                            <tr>
                                @if(!empty($obp_details->destination4))
                                <td>{!! $obp_details->destination4 !!}</td>
                                <td>{!! $obp_details->person_visited4 !!}</td>                                
                                @else
                                @endif
                            </tr>
                            <tr>
                                @if(!empty($obp_details->destination5))
                                <td>{!! $obp_details->destination5 !!}</td>
                                <td>{!! $obp_details->person_visited5 !!}</td>                                
                                @else
                                @endif                                
                            </tr>                            
                        </tbody>
                    </table>             
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE FILED:</strong></i></td><td>{!! strtoupper($obp->created_at) !!}</td>
                        </tr>
                        <tr>
                            @if($obp->date2 != null && $obp->date2 != ' ')
                            <td style="width:30%">
                                <i><strong>DATE NEEDED:</strong></i>
                            </td>
                            <td>
                                @if($obp->level != 5)
                                        <div class="normalcol">
                                            <span class="date1">{!! date('m/d/Y',strtotime($obp->date)) !!} </span><strong>-</strong><span class="date2"> {!! date('m/d/Y',strtotime($obp->date2)) !!}</span>
                                            <button type="button" class="btn btn-warning btn-xs pull-right btnEditDate">Edit</button>
                                        </div>

                                        <div class="editform hidden">
                                            <div class="row">
                                                    {!! Form::hidden('value', $obp->id, ['class'=>'hiddeneditid']) !!}
                                                    {{-- {!! Form::text('value', date('m/d/y',strtotime($work->date_needed)),['class'=>'input-sm form-control numberqty','required','placeholder'=>'Value...','id'=>'value_id']) !!} --}}
                                                <div class="col-md-12">
                                                    <div class="col-md-4">
                                                         <label for="inputDate1">Date From</label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control inputDate1" value="{{ date('m/d/y',strtotime($obp->date)) }}" id="inputDate1" name="date" required="" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="inputDate2">Date To</label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control inputDate2" value="{{ date('m/d/y',strtotime($obp->date2)) }}" id="inputDate2" name="date2" required="" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <br>
                                                            <button class="btn btn-warning btn-sm saveEditDate" id="saveqtyedit" type="submit">Save</button>
                                                            <button class="btn btn-danger btn-sm cancelEditDate"  id="cancelqtyedit" type="button">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @else
                                    {!! date('m/d/y',strtotime($obp->date)) !!} <strong>-</strong> {!! date('m/d/Y',strtotime($obp->date2)) !!}
                                @endif
                            </td>
                            @else
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->date)) !!}</td>
                            @endif
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>TIME LEFT:</strong></i></td><td>{!! strtoupper($obp->time_left) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>TIME ARRIVED:</strong></i></td><td>{!! strtoupper($obp->time_arrived) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY:</strong></i></td>
                            <td>
                                @if($obp->manager_action == 2 AND !empty($obp->approver))
                                    <i class="fa fa-check" style="color:green;"></i>
                                    {!! strtoupper($obp->solver->first_name.' '.$obp->solver->last_name) !!}
                                @elseif($obp->manager_action == 3 AND !empty($obp->approver))
                                    <i class="fa fa-close" style="color:red;"></i>
                                    {!! strtoupper($obp->solver->first_name.' '.$obp->solver->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>HRD:</strong></i></td>
                            <td>
                                @if($obp->hr_action == 1 AND !empty($obp->hrd))
                                    <i class="fa fa-check" style="color:green;"></i>
                                    {!! strtoupper($obp->hrds->first_name.' '.$obp->hrds->last_name) !!}
                                @elseif($obp->hr_action == 2 AND !empty($obp->hrd))
                                    <i class="fa fa-times" style="color:red;"></i>
                                    {!! strtoupper($obp->hrds->first_name.' '.$obp->hrds->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($obp->level == 2)  
                                    {{-- <i class="fa fa-check" style="color:green;"></i> --}}
                                    <span class="label label-primary"> <i class="fa fa-clock"></i> Approved</span>
                                @elseif($obp->level == 3)    
                                    {{-- <i class="fa fa-close" style="color:red;"></i> --}}
                                    <span class="label label-danger"> <i class="fa fa-clock"></i> Denied</span>
                                @elseif($obp->level == 5)
                                    {{-- <i class="fa fa-minus"></i> --}}
                                    <span class="label label-info"> <i class="fa fa-clock"></i> Cancelled</span>
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
                    @if($obp->level < 2)                     
                        {!! Form::open(array('route'=>'obp.remarks','method'=>'POST','files'=>true)) !!}                
                            <div class="form-group" >
                                {!! Form::label('details','Add Your Remarks') !!}
                                {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...']) !!}                       
                            </div>                    
                            <div class="form-group">  
                                {!! Form::hidden('obp_id',$obp->id) !!}          
                                @if($obp->manager_action < 2 && $obp->manager_action != 5 || $obp->level != 5)
                                    <button class="btn btn-warning" type="button" id="remarksbtnobp"> Remarks</button>
                                    <button class="btn btn-warning hidden" name ="sub" value="1" type="submit" id="obpremark">Remarks </button>
                                    <!-- <button class="btn btn-primary" name ="sub" value="2" type="submit">Approve</button> -->
                                    <button class="btn btn-primary" type="button" id="obpapprovebtn">Approve</button>
                                    <button class="btn btn-info hidden" name ="sub" value="4" type="submit" id="obpapprove">Approve</button>
                                    <button class="btn btn-danger" type="button" id="denyobpbtn">Denied</button>
                                    <button class="btn btn-danger hidden" name ="sub" value="3" type="submit" id="obpdeny">Denied</button>              
                                @else
                                @endif
                            </div>                      
                        {!! Form::close() !!}

                    @endif 
                    @if($obp->status != 5 && $obp->manager_action != 5 && $obp->level != 5)
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
    var date1 = getclass.find(".date1").text();
    var date2 = getclass.find(".date2").text();

    getclass.find(".editform").addClass("hidden");
    getclass.find(".normalcol").removeClass("hidden");
    getclass.find(".inputDate1").val(date1);
    getclass.find(".inputDate2").val(date2);

}); 

$('.saveEditDate').click(function () {

    var closest = $(this).closest("td");
    var newDate1 =  closest.find(".inputDate1").val();
    var newDate2 =  closest.find(".inputDate2").val();
    var id = closest.find(".hiddeneditid").val();
    if(!newDate1 == "" || !newDate2 == ""){
        swal({
            title: "Are you sure you want to edit the date of this request?",
            text: "Your request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $.ajax({
                  url: '/hrd_obp/{{$obp->id}}/editDate',
                  type: "get",
                  data: {id:id, newDate1:newDate1,newDate2:newDate2},
                  success: function(response){ 
                    if(response == 'S'){

                        closest.find(".editform").addClass("hidden");
                        closest.find(".normalcol").removeClass("hidden");
                        closest.find(".date1").text(newDate1);
                        closest.find(".date2").text(newDate2);

                        swal(
                          'Success!',
                          'Dates edited successfully',
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
                "id": {{$obp->id}},
            },
            url: '/hrd_obp/{{$obp->id}}/cancel',
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

$('#remarksbtnobp').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpremark').click();
    });
});
$('#obpapprovebtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpapprove').click();
    });
});
$('#denyobpbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpdeny').click();
    });
});
@stop
