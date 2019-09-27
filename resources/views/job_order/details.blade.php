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
                            <td style="width:30%"><i><strong>DATE SUBMITTED:</strong></i></td><td>{!! strtoupper($jo->date_submitted) !!}</td>
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
                            <td style="width:30%"><i><strong>SECTION:</strong></i></td><td>{!! strtoupper($jo->section) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTED WORK:</strong></i></td><td>{!! strtoupper($jo->req_work) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DESCRIPTION OF PROBLEM/ REASON/ REMARKS:</strong></i></td><td>{!! strtoupper($jo->description) !!}</td>
                        </tr>
                        <tr>
                            @if($jo->repair == 1)
                            <td style="width:30%"><i><strong>TYPE OF REPAIR:</strong></i></td><td>FACILITIES</td>
                            @endif
                            @if($jo->repair == 2)
                            <td style="width:30%"><i><strong>TYPE OF REPAIR:</strong></i></td><td>PRODUCTION EQUIPMENT</td>
                            @endif
                        </tr>
                        <tr>
                            @if($jo->project == 1)
                            <td style="width:30%"><i><strong>TYPE OF PROJECT:</strong></i></td><td>GENERAL SERVICES</td>
                            @endif
                            @if($jo->project == 2)
                            <td style="width:30%"><i><strong>TYPE OF PROJECT:</strong></i></td><td>SPECIAL PROJECT</td>
                            @endif
                        </tr>                                                           
                    </table>                           
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>SUPERIOR ACTION: </strong></i></td>
                            <td>
                                @if($jo->sup_action < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
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
                                @if($jo->approved_by ==0)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
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
                    <h5 style="color:white">Add Remarks</h5>
                </div>
                @if($jo->status < 2 && $jo->status != 5)  
                {!! Form::open(array('route'=>'job_order.admin_remarks','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('attached','Attached File')!!}
                            {!! Form::file('attached[]', array('id' => 'filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                        </div>
                    </div>
                    <div class="form-group">  
                        {!! Form::hidden('jo_id',$jo->id) !!}     
                        <button class="btn btn-warning" name ="sub" value="1" this.form.submit()>Remarks</button>                           
                        <button class="btn btn-primary" name ="sub" value="2" this.form.submit()>Approve</button>
                    </div>                      
                </div> 
                {!! Form::close() !!}                  
                @else
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white">DESCRIPTION OF PROBLEM/REASON/REMARK</h5>
                    </div>
                    @if($jo->work_done == null )
                    {!! Form::open(array('route'=>'job_order.add_details','method'=>'POST','files'=>true)) !!}
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('work','Word Done by Service Provider') !!}
                            {!! Form::textarea('work_done','',['class'=>'form-control','placeholder'=>'Remarks about the work done by the service provider...','required'=>'required']) !!}                       
                            <div style="padding-top:5px;">
                                {!!Form::label('worker', 'Seviced By')!!}
                                <input type="text" name="served_by" class="form-control" placeholder="Name of the individual who served the request..." required>
                            </div>
                            <div style="padding-top:5px;">
                                {!!Form::label('verified', 'Verified By')!!}
                                <input type="text" name="verified_by" class="form-control" placeholder="Name of the individual who verified the request" required>
                            </div>
                        </div>
                        <div class="form-group">  
                            {!! Form::hidden('jo_id',$jo->id) !!}     
                            <button class="btn btn-warning" name ="sub" this.form.submit()>Add Details</button>
                        </div>                      
                    </div> 
                    {!! Form::close() !!}
                    @endif
                </div>
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
        <div class="col-lg-6">
            
        </div>
    </div>    
</div>   

@stop
