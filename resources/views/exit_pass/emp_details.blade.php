 @extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>EXIT PASS DETAILS</h2>        
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>Exit Pass DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! date('m/d/y',strtotime($exit_pass->created_at)) !!}</td>
                        </tr>                     

                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($exit_pass->user->first_name.' '.$exit_pass->user->last_name) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>POSITION:</strong></i></td><td>{!! strtoupper($exit_pass->position) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($exit_pass->user->department->department) !!}</td>
                        </tr>                                                                                                                                              
                        <tr>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date('m/d/y',strtotime($exit_pass->date)) !!}</td>
                        </tr>   
 						<tr>
                            <td style="width:30%"><i><strong>TIME IN:</strong></i></td><td>{!! date('h:i a',strtotime($exit_pass->time_in)) !!}</td>
                        </tr>      
                        <tr>
                            <td style="width:30%"><i><strong>TIME OUT:</strong></i></td><td>{!! date('h:i a',strtotime($exit_pass->time_out)) !!}</td>
                        </tr>                                          
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE</strong></i></td><td>{!! strtoupper($exit_pass->purpose) !!}</td>
                        </tr>      
                        <tr>
                            <td style="width:30%"><i><strong>HR:</strong></i></td>
                            <td>
                                @if($exit_pass->hrd_approver > 0 AND !empty($exit_pass->hrd_approver))
                                    {!! strtoupper($exit_pass->hrds->first_name.' '.$exit_pass->hrds->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>                           
                        <tr>
                            <td style="width:30%"><i><strong>HR ACTION:</strong></i></td>
                            <td>                          
                                @if($exit_pass->hrd_action == 2)  
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($exit_pass->hrd_action == 3)    
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>LINKED OBP:</strong></i></td>
                            <td>                          
                                OBP{!!$exit_pass->obp_id!!}
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
                    @if($exit_pass->hrd_action < 2) 
                    {!! Form::open(array('route'=>'hrd_exit.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('exit_id',$exit_pass->id) !!}          
                            @if($exit_pass->hrd_action < 2)
                                
                                <button class="btn btn-warning" name ="sub" value="1" type="submit">Remarks Only</button>                               
                                                 
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

@stop
