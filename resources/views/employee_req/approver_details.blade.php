@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>REQUISITION DETAILS</h2>        
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
                <div class="alert alert-success alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Request Has Been Denied!</h4></center>   
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>EMPLOYEE REQUISITION DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">                                       
                        <tr>
                            <td style="width:30%"><i><strong>REQUISITIONER:</strong></i></td><td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($req->user->department->department) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>DATE REQUESTED:</strong></i></td><td>{!! strtoupper($req->created_at) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! strtoupper($req->date_needed) !!}</td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>WORK SITE:</strong></i></td><td>{!! strtoupper($req->work_site) !!}</td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>NUMBER NEEDED:</strong></i></td><td>{!! strtoupper($req->no_needed) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST TYPE:</strong></i></td>
                            <td>
                            	@if($req->req_type == 1)
                            		CONTRACTUAL
                            	@else
                            		FOR PROBATIONARY
                            	@endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PREFERRED AGE:</strong></i></td><td>{!! strtoupper($req->age) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PREFERRED GENDER:</strong></i></td>
                            <td>
                            	@if($req->gender == 1)
                            		MALE
                            	@else
                            		FEMALE
                            	@endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>EDUCATIONAL BACKGROUND, OTHERS:</strong></i></td>
                            <td>
                            	{!! $req->details !!}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>RECOMMENDED BY:</strong></i></td>
                            <td>
                                {!! $req->mgr->first_name.' '.$req->mgr->last_name !!}
                            </td>
                        </tr>                                                              
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY HR:</strong></i></td>
                            <td>
                                @if($req->hr_action == 1)
                                    {!! strtoupper($req->hr->first_name.' '.$req->hr->last_name)!!}
                                @else
                                @endif
                                @if($req->hr_action == 0)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($req->hr_action == 1)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($req->hr_action == 2)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @else
                                <span class="label label-info"> <i class="fa fa-minus"></i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>YOUR APPROVAL:</strong></i></td>
                            <td>
                                @if($req->approver_action == 1)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($req->approver_action == 0)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($req->approver_action == 2)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @else
                                <span class="label label-info"> <i class="fa fa-minus"></i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST FILES (JOB DESCRIPTION):</strong></i></td>
                            <td>
                                @foreach($files as $file)
                                    {!! Form::open(array('route'=>'emp_requisition.download','method'=>'POST')) !!}
                                    {!! Form::hidden('id',$file->id) !!}
                                    <button type="submit" class="btn btn-xs btn-primary">{!!$file->filename!!}</button><br>
                                    {!! Form::close() !!}
                                @endforeach
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
                    @if($req->sup_action != 5 && $req->hr_action != 5 && $req->approver_action != 1 && $req->approver_action != 5 && $req->approveer_action != 2) 
                    {!! Form::open(array('route'=>'approver.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>
                        <div class="row" style="padding-top:5px;">
                            <div class="col-lg-12">                  
                                {!! Form::label('attached','Attached File')!!}
                                {!! Form::file('attached[]', array('id' => 'filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                            </div>
                        </div>                   
                        <div class="form-group">  
                            {!! Form::hidden('ereq_no',$req->ereq_no) !!}          
                            @if($req->hr_action == 1 && $req->approver_action != 1)
                                <button class="btn btn-warning" id="remarksonly" type="button"> Remarks</button>
                                <button class="btn btn-success" id="approveonly" type="button"> Approve</button>
                                <button class="btn btn-danger" id="denyonly" type="button"> Deny</button>
                                <button class="btn btn-warning hidden" id="remarksent" name ="sub" value="1" type="submit">Remarks Only</button>                                                         
                                <button class="btn btn-warning hidden" id="approvesent" name ="sub" value="2" type="submit">Approve</button>                                                         
                                <button class="btn btn-warning hidden" id="denysent" name ="sub" value="4" type="submit">Deny</button>                                                         
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
                                    <p>{!! $remark->remark !!}</p>
                                    @if(!empty($remark->files))
                                        @foreach($remark->files as $file)
                                            {!! Form::open(array('route'=>'hrd_emp_req.download_remark','method'=>'POST', 'target'=>'_blank')) !!}
                                            {!! Form::hidden('encname',$file->encryptname) !!}
                                            {!! Form::submit($file->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}                                                        
                                            {!! Form::close() !!}                                                                          
                                        @endforeach
                                    @endif                               
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
$('#filer_inputs').filer({
    showThumbs:true,
    addMore:true
});
$('#remarksonly').click(function () {
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
$('#approveonly').click(function () {
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
$('#denyonly').click(function () {
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
@stop
