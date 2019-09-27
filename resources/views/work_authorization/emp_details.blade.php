@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>WORK AUTHORIZATION DETAILS</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <center><h4>Success! <i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_closed')): ?>
                <div class="alert alert-success alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <center><h4>Request Has Been Closed!</h4></center>   
                </div>
           <?php endif;?>
        </div>    
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0)
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> WORK AUTHORIZATION DETAILS </h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! date('m/d/y',strtotime($work->created_at)) !!}</td>
                        </tr>                     
                        <tr>
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! date('m/d/y',strtotime($work->date_needed)) !!}</td>
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
                    </table>
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-plus"></i> EMPLOYEES </h5>          
                    </div>
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME</strong></i></td>
                            <td style="width:30%"><i><strong>STATUS</strong></i></td>
                        </tr>
                        @foreach($emps as $emp)
                        <tr>
                            <td>
                                {!!strtoupper($emp->user->first_name)!!} {!!strtoupper($emp->user->last_name)!!}
                            </td>
                            <td>
                                @if($emp->superior_action < 1)
                                <span class="label label-warning"> <i class="fa fa-clock"></i>Pending</span>
                                @elseif($emp->superior_action == 1)
                                <span class="label label-primary"> <i class="fa fa-check"></i>Approved</span>
                                @elseif($emp->superior_action == 2)
                                <span class="label label-danger"> <i class="fa fa-close"></i>Denied</span>
                                @else
                                <span class="label label-info"><i class="fa fa-close"></i>Canceled</span>
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS </h5>          
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
                            @if($work->hrd_action < 2)
                                <button class="btn btn-warning" type="button" id="workauthremarkbtn"> Remarks</button>
                                <button class="btn btn-warning hidden" name ="sub" value="1" type="submit" id="workauthremarksent">Remarks Only</button>                                                 
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
@stop
@section('page-script')
    $('#workauthremarkbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#workauthremarksent').click();
    });
});
@stop
