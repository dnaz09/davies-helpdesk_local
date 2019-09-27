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
                    <h5 style="color:white"><i class="fa fa-plus"></i>LEAVE DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! date('m/d/y',strtotime($leave->created_at)) !!}</td>
                        </tr>                     

                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($leave->user->first_name.' '.$leave->user->last_name) !!}</td>
                        </tr>                                                                       
                        <tr>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date('m/d/y',strtotime($leave->date)) !!}</td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>TIME:</strong></i></td><td>{!! strtoupper($leave->sched) !!}</td>
                        </tr>  
                        <tr>
                            <td style="width:30%"><i><strong>REASON:</strong></i></td><td>{!! strtoupper($leave->reason) !!}</td>
                        </tr>                                                          
                    </table>                           
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>MANAGER:</strong></i></td>
                            <td>
                                @if(!empty($leave->approve_by))
                                    {!! strtoupper($leave->approver->first_name.' '.$leave->approver->last_name) !!}
                                @endif
                                @if($leave->sup_action < 1)
                                    <i class="fa fa-minus"></i>
                                @elseif($leave->sup_action == 1)
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($leave->sup_action == 2)
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>YOUR APPROVAL:</strong></i></td>
                            <td>
                                @if($leave->hrd_action < 1)
                                    <i class="fa fa-minus"></i>
                                @elseif($leave->hrd_action == 1)
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($leave->hrd_action == 2)
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>                         
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>                          
                                @if($leave->status == 2)  
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($leave->status == 3)    
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <tr>
                            <td style="width:30%"><i><strong>TYPE:</strong></i></td>
                            <td>
                                @if($leave->type == 1)
                                    <strong>LEAVE</strong>
                                @elseif($leave->type == 2)
                                    <strong>UNDERTIME</strong>
                                @endif
                            </td>
                        </tr>
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
                    @if($leave->hrd_action < 1 && $leave->status != 5 && $leave->level != 5) 
                    {!! Form::open(array('route'=>'leaves.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('leave_id',$leave->id) !!}          
                            @if($leave->status < 2)
                                <button class="btn btn-warning" id="remarkbtn" type="button">Remarks Only</button>
                                <button class="btn btn-primary" id="approvebtn" type="button"> Approve</button>
                                <button class="btn btn-danger" id="denybtn" type="button"> Deny</button>
                                <button class="btn hidden" id="remarkbtnpressed" type="submit" name="sub" value="1"></button>
                                <button class="btn hidden" id="approvebtnpressed" type="submit" name="sub" value="4"></button>
                                <button class="btn hidden" id="denybtnpressed" type="submit" name="sub" value="3"></button>
                            @else
                            @endif
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
                                    <br/>
                                    <small class="text-navy">{!! $remark->created_at->diffForHumans() !!}</small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>{!! strtoupper($remark->user->first_name.' '.$remark->user->last_name ) !!}</strong></p>
                                    <p>{!! $remark->remarks !!}</p>                                
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
$('#remarkbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#remarkbtnpressed').click();
    });
});
$('#approvebtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#approvebtnpressed').click();
    });
});
$('#denybtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#denybtnpressed').click();
    });
});
@endsection
