@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>SUPPLIES DETAILS</h2>       
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>REQUEST DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTED BY:</strong></i></td><td>{!! strtoupper($supply->user->first_name.' '.$supply->user->last_name) !!}</td>
                        </tr>                    
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST #:</strong></i></td><td>{!! strtoupper($supply->req_no) !!}</td>
                        </tr>                           
                        <tr>
                            <td style="width:30%"><i><strong>REMARKS:</strong></i></td><td>{!! strtoupper($supply->remarks) !!}</td>
                        </tr>                                                                                                                           
                        <tr>
                            <td style="width:30%"><i><strong>DONE BY:</strong></i></td>
                            <td>
                                @if($supply->done_by > 0)
                                    {!! strtoupper($supply->solve->first_name.' '.$supply->solve->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>     
                         <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($supply->status > 1)
                                    <span class="label label-primary">APPROVED</span>
                                @else
                                    <span class="label label-warning">PENDING</span>
                                @endif
                            </td>
                        </tr>
                    </table> 
                    <h3>LIST OF SUPPLIES</h3>
                    <table class="table table-hover table-bordered">
                        <tr>                    
                            <th>CATEGORY</th>                                    
                            <th>ITEM NAME</th>
                            <th>QTY</th>                                
                        </tr>
                        <tbody> 
                            @foreach($supply->dets as $det)                           
                            <tr>
                                <td>{!! $det->category !!}</td>                                   
                                <td>{!! $det->item_name !!}</td>
                                <td>{!! $det->qty !!}</td>                                    
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
                {!! Form::open(array('route'=>'supplies_request.remarks','method'=>'POST','files'=>true)) !!}
                @if($supply->status < 2)
                <div class="ibox-content">                    
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>                    
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('password','Requestor Password')!!}
                            <input type="password" name="password" class="form-control" required=""></input>
                        </div>
                    </div>
                    {!! Form::hidden('sup_req_id',$supply->id) !!}
                    <div class="form-group">                                                                         
                        <button class="btn btn-warning" name ="sub" value="1" this.form.submit();>Release</button>                                                
                    </div>                      
                </div>                 
                @else
                @endif              
                
                {!! Form::close() !!}   
               
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
                                <div style="margin-top: 10px;">                      
                                <p>{!! $remark->remarks !!}</p>              
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
