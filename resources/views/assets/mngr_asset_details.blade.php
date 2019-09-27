@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>BORROWER'S REQUEST DETAILS</h2>
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
                    <center><h4>Request Has Been Approved and will be moved to the Admin Department!</h4></center>   
                </div>
           <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('no_remarks')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Error! remarks field is empty!</h4></center>   
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>REQUEST DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>BORROWER'S SLIP NO:</strong></i></td><td>{!! strtoupper($asset_reqs->req_no) !!}</td>
                            <td style="width:30%"><i><strong>DATE FILED:</strong></i></td><td>{!! date('m/d/y',strtotime($asset_reqs->created_at)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>BORROWED BY:</strong></i></td><td>{!! strtoupper($asset_reqs->borrower_name) !!}</td>
                            <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($asset_reqs->user->first_name.' '.$asset_reqs->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>SUPERIOR STATUS :</strong></i></td><td>
                                    @if($asset_reqs->sup_action < 2)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($asset_reqs->status == 5)
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                    @else
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @endif</td>
                            <td style="width:30%"><i><strong>REQUEST STATUS:</strong></i></td>
                            <td>
                                @if($asset_reqs->status < 2)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($asset_reqs->status == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @else
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                             <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! strtoupper($asset_reqs->slip->date_needed) !!}</td>
                            <td style="width:30%"><i><strong>DATE RETURN:</strong></i></td><td>{!! date('Y/m/d',strtotime($asset_reqs->slip->must_date)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE :</strong></i></td><td>{!! strtoupper($asset_reqs->details) !!}</td>
                            <td style="width:30%"><i><strong>DOWNLOAD:</strong></i></td>
                            <td>
                                @if($asset_reqs->status != 5)
                                    @if($asset_reqs->sup_action == 2)
                                    {{-- <a href="http://pdf-generator.davies-helpdesk.com/borrower_slip/{{$asset_req->req_no}}/{{$asset_req->user_id}}/generate" id="{{$asset_req->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a> --}}
                                    <a href="/borrower_slip/{{$asset_reqs->req_no}}/{{$asset_reqs->user_id}}/generate" id="{{$asset_reqs->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table> 
                    <h3>LIST OF ITEMS</h3>
                    <table class="table table-hover table-bordered">
                        <tr>                  
                            <th>QTY</th>                                      
                            <th>ITEM DESCRIPTION</th>                                
                        </tr>
                        <tbody> 
                            @foreach($asset_reqs->dets as $det)                           
                            <tr>
                                <td>{!! $det->qty !!}</td>
                                <td>{!! $det->item_name !!}</td>                                   
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>                        
                </div>                 
            </div>                                      
        </div> 
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>
                @if($asset_reqs->sup_action < 2 && $asset_reqs->status != 5)  
                {!! Form::open(array('route'=>'sup_asset_request.mngr_remarks','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...']) !!}                       
                    </div>
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('attached','Attached File')!!}
                            {!! Form::file('attached[]', array('id' => 'filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                        </div>
                    </div>
                    <div class="form-group">  
                        {!! Form::hidden('request_id',$asset_reqs->id) !!}                               
                        {!! Form::hidden('ticket_no',$asset_reqs->req_no) !!}
                        <button class="btn btn-warning" id="remarksonly" type="button"> Remarks</button>                                               
                        <button class="btn btn-primary" id="approveonly" type="button"> Approve</button>                                               
                        <button class="btn btn-warning hidden" id="remarksent" name="sub" value="1" type="submit">Remarks Only</button>
                        <button class="btn btn-primary hidden" id="approvesent" name="sub" value="2" type="submit">Approve</button>                         
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
                                            {!! Form::open(array('route'=>'asset_request.remarks_download_files','method'=>'POST', 'target'=>'_blank')) !!}
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
@stop