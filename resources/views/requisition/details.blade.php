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
                    <h5 style="color:white"><i class="fa fa-plus"></i>REQUISITION DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">                                       
                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>
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
                            <td style="width:30%"><i><strong>MANAGER</strong></i></td>
                            <td>
                                @if($req->supervisor_id > 0)
                                    @if($req->user_id == $req->supervisor_id)
                                        SUPERVISOR LEVEL
                                    @else
                                        {!! strtoupper($req->mngr->first_name.' '.$req->mngr->last_name)!!}
                                    @endif
                                @elseif($req->supervisor_id == 0)
                                    <i class="fa fa-minus"></i>
                                @endif
                                @if($req->sup_action == 1)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($req->sup_action == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($req->sup_action == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @else
                                <span class="label label-info"> <i class="fa fa-angellist"></i></span>
                                @endif
                            </td>
                        </tr>                                      
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY HR:</strong></i></td>
                            <td>
                                @if($req->hrd > 0)
                                    {!! strtoupper($req->hr->first_name.' '.$req->hr->last_name)!!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                                 @if($req->hrd_action == 1)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($req->hrd_action == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($req->hrd_action == 3 || $req->sup_action == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @else
                                <span class="label label-info"> <i class="fa fa-minus"></i></span>
                                @endif
                            </td>
                        </tr>
                    </table>                           
                    <h3>More Details</h3>
                    <table class="table table-hover table-bordered">
                        <tr>                                                        
                            <th>ITEM NO</th>
                            <th>ITEM</th>
                            <th>QTY</th>                                                            
                            <th>PURPOSE</th>
                        </tr>
                        <tbody>
                            @if(!empty($req->item1))                           
                            <tr>
                                <td>{!! $req->item_no1 !!}</td>
                                <td>{!! strtoupper($req->item1) !!}</td>
                                <td>{!! $req->qty1 !!}</td>
                                <td>{!! $req->purpose1 !!}</td>
                            </tr>
                            @endif
                            @if(!empty($req->item2))
                            <tr>
                                <td>{!! $req->item_no2 !!}</td>
                                <td>{!! strtoupper($req->item2) !!}</td>
                                <td>{!! $req->qty2 !!}</td>
                                <td>{!! $req->purpose2 !!}</td>
                            </tr>
                            @endif
                            @if(!empty($req->item3))                  
                            <tr>
                                <td>{!! $req->item_no3 !!}</td>
                                <td>{!! strtoupper($req->item3) !!}</td>
                                <td>{!! $req->qty3 !!}</td>
                                <td>{!! $req->purpose3 !!}</td>
                            </tr>
                            @endif
                            <!-- @if(!empty($req->item4))                     
                            <tr>
                                <td>{!! $req->item_no4 !!}</td>
                                <td>{!! strtoupper($req->item4) !!}</td>
                                <td>{!! $req->qty4 !!}</td>
                                <td>{!! $req->purpose4 !!}</td>
                            </tr>
                            @endif
                            @if(!empty($req->item5))                     
                            <tr>
                                <td>{!! $req->item_no5 !!}</td>
                                <td>{!! strtoupper($req->item5) !!}</td>
                                <td>{!! $req->qty5 !!}</td>
                                <td>{!! $req->purpose5 !!}</td>
                            </tr>
                            @endif  -->                                   
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
                    @if($req->status != 3)                         
                    @if($req->hrd_action < 2 || $req->level != 5 && $req->sup_action != 5 && $req->hrd_action != 5)
                    {!! Form::open(array('route'=>'requisition.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('req_id',$req->id) !!}          
                            @if($req->hrd_action < 2)
                                <button class="btn btn-warning" id="remarksonly" type="button"> Remarks</button>
                                <button class="btn btn-warning hidden" id="remarksent" name ="sub" value="1" type="submit">Remarks Only</button>                                                         
                            @else
                            @endif
                        </div>                      
                    </div>         
                    {!! Form::close() !!}                                  
                    @endif                               
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
@stop
