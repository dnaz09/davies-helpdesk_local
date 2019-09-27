@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> GATEPASS DETAILS</h2>       
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Remarks has been Added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_pass')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Password Doesn't Match!</h4></center>   
                </div>
           <?php endif;?>
        </div>    
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0 )
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>ASSIGNEE:</strong></i></td><td>{!! strtoupper($gatepass->user->first_name.' '.$gatepass->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($gatepass->user->first_name.' '.$gatepass->user->last_name) !!}</td>
                            <td style="width:30%"><i><strong>CONTROL NO:</strong></i></td><td>{!! strtoupper($gatepass->control_no) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>COMPANY:</strong></i></td><td>{!! strtoupper($gatepass->company) !!}</td>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date('m/d/y',strtotime($gatepass->date)) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($gatepass->department) !!}</td>
                            <td style="width:30%"><i><strong>EXIT IN GATE NO:</strong></i></td><td>{!! strtoupper($gatepass->exit_gate_no) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REF NO:</strong></i></td><td>{!! strtoupper($gatepass->ref_no) !!}</td>
                            <td style="width:30%"><i><strong>FILES:</strong></i></td>
                            <td>
                                @if(!empty($files))
                                @foreach($files as $filer)
                                    {!! Form::open(array('route'=>'gatepass.download','method'=>'POST')) !!}
                                        {!! Form::hidden('filename',$filer->filename) !!}
                                        {!! Form::hidden('id',$filer->gate_pass_id) !!}
                                        {!! Form::submit($filer->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}                                          
                                    {!! Form::close() !!}         
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE:</strong></i></td><td>{!! strtoupper($gatepass->purpose) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>ISSUED BY:</strong></i></td><td>
                                @if(!empty($gatepass->issue))
                                {!! strtoupper($gatepass->issue->first_name.' '.$gatepass->issue->last_name) !!}
                                @else
                                <strong>-</strong>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($gatepass->status < 2)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($gatepass->status == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($gatepass->status == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @elseif($gatepass->status == 5)
                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                        </tr>                                                    
                    </table>
                    <div class="ibox-title" style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-plus"></i> ITEMS <small></small></h5>          
                    </div>
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>ITEM NO.</th>
                            <th>QTY</th>
                            <th>U/M</th>
                            <th>ITEM DESCRIPTION</th>
                        </tr>
                        @foreach($details as $detail)           
                        <tr>
                            <td>{!! $detail->item_no !!}</td>
                            <td>{!! $detail->item_qty !!}</td>
                            <td>{!! strtoupper($detail->item_measure) !!}</td>
                            <td>{!! strtoupper($detail->description) !!}</td>
                        </tr>
                        @endforeach                                 
                    </table>                                         
                </div>                   
            </div>                                      
        </div>
        <div class="col-lg-6">            
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>        
                @if($gatepass->checked_by == null)                     
                    {!! Form::open(array('route'=>'gatepass.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('name','Name of Guard') !!}
                            {!! Form::text('checked_by','',['class'=>'form-control','placeholder'=>'Enter Your Name here','required','id'=>'guard_id']) !!}                      
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('id',$gatepass->id) !!}          
                            @if($gatepass->status < 2 && $gatepass->status != 5)
                                <button class="btn btn-warning" id="send" type="button"> Save</button>  
                            @else
                            @endif
                            <button class="hidden" name="sub" value="5" id="sent" type="submit"></button> 
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
                @forelse($routings as $remark)
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
                                <p><strong>{!! $remark->remarks2 !!}</strong></p>
                                <div style="margin-top: 10px;">                      
                                <p>{!! $remark->remark !!}</p>              
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
$('#sendremark').click(function () {
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

$('#send').click(function () {
    swal({
        title: "Are you sure?",
        text: "Make sure that you have thoroughly inspected the details!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        if($('#guard_id').val() != ''){
            $('#sent').click();
        }else{
            setTimeout(function() {
                swal('Enter your name!');
            },400)
        }
    });
});
@endsection
