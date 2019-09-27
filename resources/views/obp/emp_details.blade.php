@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> OB DETAILS</h2>        
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>Official Business Pass DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">                
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE CREATED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->created_at)) !!}</td>
                        </tr>                     

                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($obp->user->first_name.' '.$obp->user->last_name) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>POSITION:</strong></i></td><td>{!! strtoupper($obp->position) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($obp->user->department->department) !!}</td>
                        </tr>                                               
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE:</strong></i></td><td>{!! strtoupper($obp->purpose) !!}</td>
                        </tr>                                                          
                    </table>         
                    <h3>ITINERARY</h3>
                    <table class="table table-hover table-bordered">
                        <tr>                                                        
                            <th>DESTINATION</th>
                            <th>PERSON VISITED</th>
                            <th>TIME OF ARRIVAL</th>
                            <th>TIME OF DEPARTURE</th>                                                            
                        </tr>
                        <tbody>                            
                            <tr>
                                @if(!empty($obp_details->destination))
                                <td>{!! $obp_details->destination !!}</td>
                                <td>{!! $obp_details->person_visited !!}</td>
                                <td>{!! $obp_details->time_of_arrival !!}</td>
                                <td>{!! $obp_details->time_of_departure !!}</td>
                                @else
                                @endif
                            </tr>
                            <tr>
                                @if(!empty($obp_details->destination2))
                                <td>{!! $obp_details->destination2 !!}</td>
                                <td>{!! $obp_details->person_visited2 !!}</td>
                                <td>{!! $obp_details->time_of_arrival2 !!}</td>
                                <td>{!! $obp_details->time_of_departure2 !!}</td>
                                @else
                                @endif
                            </tr>
                                @if(!empty($obp_details->destination3))
                                <td>{!! $obp_details->destination3 !!}</td>
                                <td>{!! $obp_details->person_visited3 !!}</td>
                                <td>{!! $obp_details->time_of_arrival3 !!}</td>
                                <td>{!! $obp_details->time_of_departure3 !!}</td>
                                @else
                                @endif
                            <tr>
                                @if(!empty($obp_details->destination4))
                                <td>{!! $obp_details->destination4 !!}</td>
                                <td>{!! $obp_details->person_visited4 !!}</td>
                                <td>{!! $obp_details->time_of_arrival4 !!}</td>
                                <td>{!! $obp_details->time_of_departure4 !!}</td>
                                @else
                                @endif
                            </tr>
                            <tr>
                                @if(!empty($obp_details->destination5))
                                <td>{!! $obp_details->destination5 !!}</td>
                                <td>{!! $obp_details->person_visited5 !!}</td>
                                <td>{!! $obp_details->time_of_arrival5 !!}</td>
                                <td>{!! $obp_details->time_of_departure5 !!}</td>
                                @else
                                @endif                                
                            </tr>                            
                        </tbody>
                    </table>             
                    <table class="table table-hover table-bordered">
                        <tr>
                            @if($obp->date2 != null && $obp->date2 != ' ')
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->date)) !!} <strong>-</strong> {!! date('m/d/Y',strtotime($obp->date2)) !!}</td>
                            @else
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->date)) !!}</td>
                            @endif
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>TIME LEFT:</strong></i></td><td>{!! strtoupper($obp->time_left) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>TIME ARRIVED:</strong></i></td><td>{!! strtoupper($obp->time_arrived) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY:</strong></i></td>
                            <td>
                                @if($obp->manager_action == 2 AND !empty($obp->approver))
                                    <i class="fa fa-check" style="color:green;"></i>
                                    {!! strtoupper($obp->solver->first_name.' '.$obp->solver->last_name) !!}
                                @elseif($obp->manager_action == 3 AND !empty($obp->approver))
                                    <i class="fa fa-close" style="color:red;"></i>
                                    {!! strtoupper($obp->solver->first_name.' '.$obp->solver->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>HRD:</strong></i></td>
                            <td>
                                @if($obp->hr_action == 1 AND !empty($obp->hrd))
                                    <i class="fa fa-check" style="color:green;"></i>
                                    {!! strtoupper($obp->hrds->first_name.' '.$obp->hrds->last_name) !!}
                                @elseif($obp->hr_action == 2 AND !empty($obp->hrd))
                                    <i class="fa fa-times" style="color:red;"></i>
                                    {!! strtoupper($obp->hrds->first_name.' '.$obp->hrds->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>                          
                                @if($obp->level == 2)  
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($obp->level == 3)    
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>        
                @if($obp->level < 2)                     
                    {!! Form::open(array('route'=>'obp.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('obp_id',$obp->id) !!}          
                            @if($obp->manager_action < 2 && $obp->manager_action != 5 || $obp->level != 5)
                                <button class="btn btn-warning" id="obpremarkbtn" type="button">Remarks</button>
                                <button class="btn btn-warning hidden" name ="sub" value="1" id="remarkobp" type="submit">Remarks Only</button>                                                         
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
@section('page-script')
$('#obpremarkbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#remarkobp').click();
    });
});
@stop
