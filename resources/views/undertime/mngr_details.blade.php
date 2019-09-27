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
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! strtoupper($undertime->created_at) !!}</td>
                        </tr>                     

                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($undertime->user->first_name.' '.$undertime->user->last_name) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! strtoupper($undertime->date) !!}</td>
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
                            </td>
                        </tr>                           
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>                          
                                @if($undertime->status == 2)  
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($undertime->status == 3)    
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
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
                        <tr>   
                    </table>                                               
                </div>                   
            </div>                                      
        </div> 
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>                            
                    @if($undertime->status < 2) 
                    {!! Form::open(array('route'=>'mngr_undertime.mngr_remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('undertime_id',$undertime->id) !!}          
                            @if($undertime->approved_by < 1 && $undertime->status != 5 && $undertime->level != 5)
                                <button type="button" id="remarkonly" class="btn btn-warning"> Remarks</button>
                                <!-- <button type="button" id="approval" class="btn btn-primary"> Approve</button> -->
                                <button type="button" id="approvalgenerate" class="btn btn-info"> Approve </button>
                                <button type="button" id="denial" class="btn btn-danger"> Deny</button>
                                <button class="btn btn-warning hidden" id="remarksent" name ="sub" value="1" type="submit">Remarks Only</button>
                                <!-- <button class="btn btn-primary hidden" id="approved" name ="sub" value="2" type="submit">Approve</button>                            -->
                                <button class="btn btn-info hidden" id="approvegenerate" name ="sub" value="4" type="submit">Approve and Generate Exit Pass</button>                           
                                <button class="btn btn-danger hidden" id="denied" name ="sub" value="3" type="submit">Denied</button>                                                  
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
