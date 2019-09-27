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
                    <h5 style="color:white"><i class="fa fa-plus"></i> JOB ORDER DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST NUMBER:</strong></i></td><td>{!! strtoupper($jo->jo_no) !!}</td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>DATE SUBMITTED:</strong></i></td><td>{!! date('m/d/y',strtotime($jo->date_submitted)) !!}</td>
                        </tr>                     

                        <tr>
                            <td style="width:30%"><i><strong>REPORTED BY:</strong></i></td><td>{!! strtoupper($jo->user->first_name.' '.$jo->user->last_name) !!}</td>
                        </tr>                                                                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($jo->department->department) !!}</td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>ROLE:</strong></i></td><td>{!! strtoupper($jo->role->role) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>LOCATION:</strong></i></td><td>{!! strtoupper($jo->section) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTED WORK:</strong></i></td><td>{!! strtoupper($jo->req_work) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>WORK FOR:</strong></i></td><td>{!! strtoupper($jo->work_for).' '.$jo->item_class !!}</td>
                        </tr>
                        @if ($jo->asset_no) 
                            <tr>
                                <td style="width:30%"><i><strong>FACILITIES/BUILDING:</strong></i></td>
                                <td>{{strtoupper($jo->facility ?? "-")}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="width:30%"><i><strong><?php empty($jo->asset_no) ? print"FACILITIES/BUILDING" : print"EQUIPMENT NO." ?></strong></i></td><td>{!! strtoupper($jo->other_info) !!}
                                @if(!empty($jo->asset_no)) {!! '('.$jo->asset_no.')' !!}
                                @endif</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DESCRIPTION OF PROBLEM/ REASON/ REMARKS:</strong></i></td><td>{!! strtoupper($jo->description).' '.$jo->item_class !!}</td>
                        </tr>                                                          
                    </table>                           
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>SUPERIOR ACTION: </strong></i></td>
                            <td>
                                @if($jo->sup_action < 1 && $jo->status != 5)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($jo->status == 5)
                                    <span class="label label-ino"> <i class="fa fa-angellist"></i>Canceled</span>
                                @else
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span> 
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
                        @if($jo->status == 2)
                            @if($jo->jo_status == 0)
                            <tr>
                                <td style="width:30%"><i><strong>PRINT JOB ORDER:</strong></i></td>
                                <td>
                                    <a href="http://pdf-generator.davies-helpdesk.com/job_order/{{$jo->id}}/{{$jo->user_id}}/generate" id="{{$jo->id}}" target="__blank"><button class="btn btn-primary btn-xs"><i class="fa fa-download"> Download</i></button></a>
                                </td>
                            </tr>
                            @endif
                        <tr>
                            <td style="width:30%"><i><strong>JOB ORDER STATUS:</strong></i></td>
                            <td>
                                @if($jo->jo_status == 1)
                                    <span class="label label-warning"> Looking for Service Provider</span>
                                @elseif($jo->jo_status == 0)
                                    <span class="label label-success"> Closed</span>
                                @elseif($jo->jo_status == 2)
                                    <span class="label label-primary"> Done</span>
                                @elseif($jo->jo_status == 4)
                                    <span class="label label-warning"> Ongoing</span>
                                @elseif($jo->jo_status == 5)
                                    <span class="label label-danger"> Canceled</span>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </table>
                    <table class="table table-hover table-bordered">
                        @if(!empty($jo->served_by))
                        <tr>
                            <td style="width:30%"><i><strong>SERVICED BY: </strong></i></td>
                            <td>
                                {!! strtoupper($jo->served_by) !!}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($jo->reco))
                        <tr>
                            <td style="width:30%"><i><strong>RECOMMENDATION: </strong></i></td>
                            <td>
                                {!! strtoupper($jo->reco) !!}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($jo->work_done))
                        <tr>
                            <td style="width:30%"><i><strong>WORK DONE: </strong></i></td>
                            <td>
                                {!! strtoupper($jo->work_done) !!}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($jo->date_started))
                        <tr>
                            <td style="width:30%"><i><strong>DATE STARTED: </strong></i></td>
                            <td>
                                {!! $jo->date_started !!}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($jo->date_finished))
                        <tr>
                            <td style="width:30%"><i><strong>DATE FINISHED: </strong></i></td>
                            <td>
                                {!! $jo->date_finished !!}
                            </td>
                        </tr>
                        @endif
                    </table>                                           
                </div>                   
            </div>                                      
        </div>
        @if($jo->status < 2) 
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Add Remarks</h5>
                </div>
                {!! Form::open(array('route'=>'job_order.remarks','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>
                    <div class="form-group">  
                        {!! Form::hidden('jo_id',$jo->id) !!}     
                        <button class="btn btn-warning" name ="sub" value="1" type="submit">Remarks</button>                       
                    </div>                      
                </div> 
                {!! Form::close() !!}
            </div>
        </div>
        @elseif($jo->status == 2)
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Add Remarks</h5>
                </div>
                @if($jo->jo_status == 2)
                {!! Form::open(array('route'=>'job_order.add_dets','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="form-group">  
                        {!! Form::hidden('jo_id',$jo->id) !!}     
                        <button class="btn btn-warning" name ="sub" value="1" type="submit">Return to Pending</button>                       
                        <button class="btn btn-primary" name ="sub" value="2" type="submit">Close Job Order</button>                       
                    </div>                      
                </div>
                @endif 
                {!! Form::close() !!}
            </div>
        </div>
        @endif
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
                                            {!! Form::open(array('route'=>'job_order.download_file','method'=>'POST', 'target'=>'_blank', 'target'=>'_blank')) !!}
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

@stop
