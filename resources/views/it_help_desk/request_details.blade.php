@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> REQUEST DETAILS</h2>    
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
            @if( count ($errors) > 0 )
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> REQUEST DETAILS</h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST #:</strong></i></td>
                            <td>{!! $user_acss->reqit_no !!}</td>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td>
                            <td>{!! date('m/d/Y',strtotime($user_acss->created_at)) !!}</td>
                        </tr> 
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTED BY:</strong></i></td>
                            <td>{!! strtoupper($user_acss->user->first_name.' '.$user_acss->user->last_name) !!}</td>
                            <td style="width:30%"><i><strong>RESOLVED BY:</strong></i></td>
                            <td>
                                @if($user_acss->solved_by > 0)
                                    {!! strtoupper($user_acss->solve->first_name.' '.$user_acss->solve->last_name) !!}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>     
                        <tr>
                            <td  style="width:30%"><i><strong>TYPE:</strong></i></td>
                            <td>
                                @if($user_acss->service_type == 1)              
                                    USER ACCESS REQUEST
                                @elseif($user_acss->service_type == 2)  
                                    SERVICE REQUEST
                                @else   
                                    ITEM REQUEST
                                @endif   
                            </td>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($user_acss->status < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($user_acss->status == 1)
                                    <span class="label label-success"> <i class="fa fa-angellist"></i>Returned</span>
                                @elseif($user_acss->status == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @else
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @endif
                            </td>
                        </tr>                                           
                        @if($user_acss->service_type > 2)              
                            <tr>
                                <td style="width:30%"><i><strong>ITEM:</strong></i></td>
                                <td>{!! strtoupper($user_acss->category) !!}</td>
                                <td style="width: 30%"><i><strong>ATTACHMENTS:</strong></i></td>
                                <td>
                                    @foreach($files as $file)                                                                         
                                        {!! Form::open(array('route'=>'it_request_list.download_files','method'=>'POST','files'=>true)) !!}
                                        {!! Form::hidden('encname',$file->encryptname) !!}
                                        {!! Form::submit($file->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}          
                                        {!! Form::hidden('service_type',$user_acss->service_type) !!}                                              
                                        {!! Form::close() !!}                                                                                             
                                    @endforeach     
                                </td>
                            </tr>    
                        @else
                            <tr>
                                <td style="width:30%"><i><strong>CATEGORY:</strong></i></td>
                                <td>{!! strtoupper($user_acss->category) !!}</td>
                                <td style="width: 30%"><i><strong>ATTACHMENTS:</strong></i></td>
                                <td>
                                    @foreach($files as $file)                                                                         
                                        {!! Form::open(array('route'=>'it_request_list.download_files','method'=>'POST','files'=>true)) !!}
                                        {!! Form::hidden('encname',$file->encryptname) !!}
                                        {!! Form::submit($file->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}          
                                        {!! Form::hidden('service_type',$user_acss->service_type) !!}                                              
                                        {!! Form::close() !!}                                                                                             
                                    @endforeach     
                                </td>
                            </tr>                                        
                            <tr>
                                <td style="width:30%"><i><strong>SUB CATEGORY:</strong></i></td>
                                <td>{!! strtoupper($user_acss->sub_category) !!}</td>
                            </tr>   
                            <tr>
                                <td style="width:30%"><i><strong>PURPOSE:</strong></i></td>
                                <td>
                                    @if($user_acss->service_type == 1)
                                        @if($user_acss->old > 1)
                                            NEW USER
                                        @else
                                            ADDITIONAL ACCESS
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>    
                        @endif
                        @if($user_acss->service_type == 2)
                        <tr>
                            <td  style="width:30%"><i><strong>ASSET NO:</strong></i></td>
                            <td>
                                {!! strtoupper($user_acss->asset_no) !!} 
                            </td>
                        </tr>
                        @endif                       
                        <tr>
                            <td style="width:30%"><i><strong>DETAILS:</strong></i></td><td>{!! strtoupper($user_acss->details) !!}</td>
                        </tr>
                    </table>                                         
                </div>                   
            </div>                                      
        </div> 
        <div class="col-lg-6">
            
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> ADD REMARKS <small></small></h5>          
                </div>
                @if($user_acss->status < 1) 
                {!! Form::open(array('route'=>'it_request_list.add_remarks','method'=>'POST','files'=>true)) !!}
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
                        {!! Form::hidden('request_id',$user_acss->id) !!}                               
                        {!! Form::hidden('ticket_no',$user_acss->reqit_no) !!}                 
                        {!! Form::hidden('service_type',$user_acss->service_type) !!}
                        @if($user_acss->service_type == 1 AND $user_acss->sub_category == 'SAP' )
                            <button class="btn btn-warning" id="subbtn1" type="button">Remarks Only</button>                            
                            <button class="btn btn-warning hidden" id="sub1" name="sub" value="1" type="submit">Remarks Only</button>
                            @if($user_acss->status == 0)
                                <button class="btn btn-primary" id="subbtn2" type="button"> Mark as Resolved</button>
                                <button class="btn btn-primary hidden" id="sub2" name="sub" value="2" type="submit">Mark as Resolved</button>
                            @endif
                        @elseif($user_acss->service_type == 1 AND $user_acss->sub_category != 'SAP')
                            <button class="btn btn-warning" id="subbtn1" type="button">Remarks Only</button>                            
                            <button class="btn btn-warning hidden" id="sub1" name="sub" value="1" type="submit">Remarks Only</button>
                            @if($user_acss->sup_action == 1)
                                <button class="btn btn-primary" id="subbtn2" type="button"> Mark as Resolved</button>
                                <button class="btn btn-primary hidden" id="sub2" name="sub" value="2" type="submit">Mark as Resolved</button>
                            @endif
                        @elseif($user_acss->service_type == 2)
                            <button class="btn btn-warning" id="subbtn1" type="button">Remarks Only</button>
                            <button class="btn btn-warning hidden" id="sub1" name="sub" value="1" type="submit">Remarks Only</button>
                            <button class="btn btn-primary" id="subbtn2" type="button">Mark as Resolved</button>
                            <button class="btn btn-primary hidden" id="sub2" name="sub" value="2" type="submit">Mark as Resolved</button>
                        @endif                           
                    </div>                      
                </div> 
                {!! Form::close() !!}                  
                @else
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
                                <div>
                                    @if(!empty($remark->files))
                                        @foreach($remark->files as $filer)
                                            {!! Form::open(array('route'=>'it_request_list.remarks_download_files','method'=>'POST', 'target'=>'_blank')) !!}
                                            {!! Form::hidden('encname',$filer->encryptname) !!}
                                            {!! Form::submit($filer->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}     
                                            {!! Form::hidden('service_type',$user_acss->service_type) !!}                                              
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

@endsection
@section('page-script')
    $('#filer_inputs').filer({
        showThumbs:true,
        addMore:true
    });   

    $('#subbtn1').click(function () {
        swal({
            title: "Are you sure?",
            text: "Your remarks will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#sub1').click();
        });
    }); 

    $('#subbtn2').click(function () {
        swal({
            title: "Are you sure?",
            text: "This request will be resolved!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#sub2').click();
        });
    }); 
@stop
