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
            <?php if (session('is_denied')): ?>
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
                        </tr>
                        <tbody>                            
                            <tr>
                                @if(!empty($obp_details->destination))
                                <td>{!! $obp_details->destination !!}</td>
                                <td>{!! $obp_details->person_visited !!}</td>                                
                                @else
                                @endif
                            </tr>
                            <tr>
                                @if(!empty($obp_details->destination2))
                                <td>{!! $obp_details->destination2 !!}</td>
                                <td>{!! $obp_details->person_visited2 !!}</td>                                
                                @else
                                @endif
                            </tr>
                                @if(!empty($obp_details->destination3))
                                <td>{!! $obp_details->destination3 !!}</td>
                                <td>{!! $obp_details->person_visited3 !!}</td>                                
                                @else
                                @endif
                            <tr>
                                @if(!empty($obp_details->destination4))
                                <td>{!! $obp_details->destination4 !!}</td>
                                <td>{!! $obp_details->person_visited4 !!}</td>                                
                                @else
                                @endif
                            </tr>
                            <tr>
                                @if(!empty($obp_details->destination5))
                                <td>{!! $obp_details->destination5 !!}</td>
                                <td>{!! $obp_details->person_visited5 !!}</td>                                
                                @else
                                @endif                                
                            </tr>                            
                        </tbody>
                    </table>             
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>DATE FILED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->created_at)) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! date('m/d/y',strtotime($obp->date)) !!} <strong>-</strong> {!! date('m/d/y',strtotime($obp->date2)) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>TIME LEFT:</strong></i></td><td>{!! strtoupper($obp->time_left) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>TIME ARRIVED:</strong></i></td><td>{!! strtoupper($obp->time_arrived) !!}</td>
                        </tr>                   
                        <tr>
                            <td style="width:30%"><i><strong>MANAGER:</strong></i></td>
                            <td>
                                @if($obp->manager > 0 AND !empty($obp->manager))
                                    {!! strtoupper($obp->manage->first_name.' '.$obp->manage->last_name) !!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>                           
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>                          
                                @if($obp->manager_action == 2)  
                                    <i class="fa fa-check" style="color:green;"></i>
                                @elseif($obp->manager_action == 3)    
                                    <i class="fa fa-close" style="color:red;"></i>
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>APPROVED BY:</strong></i></td>
                            <td>
                                @if($obp->approver > 0 AND !empty($obp->approver))
                                    {!! strtoupper($obp->solver->first_name.' '.$obp->solver->last_name) !!}
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
                @if($obp->manager_action < 2)                
                    {!! Form::open(array('route'=>'mngr_obp.mngr_remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('obp_id',$obp->id) !!}              
                            @if($obp->manager_action < 2 && $obp->manager_action != 5 || $obp->level != 5)
                                <button class="btn btn-warning" type="button" id="remarksbtnobp"> Remarks</button>
                                <button class="btn btn-warning hidden" name ="sub" value="1" type="submit" id="obpremark">Remarks </button>
                                <!-- <button class="btn btn-primary" name ="sub" value="2" type="submit">Approve</button> -->
                                <button class="btn btn-info" type="button" id="obpapprovebtn">Approve</button>
                                <button class="btn btn-info hidden" name ="sub" value="4" type="submit" id="obpapprove">Approve</button>
                                <button class="btn btn-danger" type="button" id="denyobpbtn">Denied</button>
                                <button class="btn btn-danger hidden" name ="sub" value="3" type="submit" id="obpdeny">Denied</button>              
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
@endsection
@section('page-script')
$('#remarksbtnobp').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpremark').click();
    });
});
$('#obpapprovebtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be approved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpapprove').click();
    });
});
$('#denyobpbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpdeny').click();
    });
});
@stop
