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
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request Has Been Denied!<i class="fa fa-check"></i></h4></center>                
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
                            <td style="width:30%"><i><strong>CERTIFICATE OF EMPLOYMENT:</strong></i></td>
                            <td>
                                @if($req->coe > 0)  
                                    <i class="fa fa-check" style="color:green;"></i>                                                                            
                                @else
                                    <i class="fa fa-close" style="color:red;"></i>
                                @endif
                            </td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>ITR 2316:</strong></i></td>
                            <td>
                                @if($req->itr2316 > 0)  
                                    <i class="fa fa-check" style="color:green;"></i>                                                                            
                                @else
                                    <i class="fa fa-close" style="color:red;"></i>
                                @endif
                            </td>
                        </tr>                                                                                        
                        <tr>
                            <td style="width:30%"><i><strong>PHILHEALTH DOCUMENTS:</strong></i></td>
                            <td>
                                @if($req->philhealth > 0)  
                                    <i class="fa fa-check" style="color:green;"></i>                                                                            
                                @else
                                    <i class="fa fa-close" style="color:red;"></i>
                                @endif
                            </td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>OTHERS:</strong></i></td>
                            <td>
                                @if($req->others > 0)  
                                    <i class="fa fa-check" style="color:green;"></i>                                                                            
                                @else
                                    <i class="fa fa-close" style="color:red;"></i>
                                @endif
                            </td>

                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>SPECIFY:</strong></i></td><td>{!! strtoupper($req->others_details) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>EMPLOYEE NAME:</strong></i></td><td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($req->user->department->department) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>DATE REQUESTED:</strong></i></td><td>{!! date('m/d/y',strtotime($req->created_at)) !!}</td>
                        </tr>                                       
                        <tr>
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td><td>{!! date('m/d/y',strtotime($req->date_needed)) !!}</td>
                        </tr>                                  
                        <tr>
                            <td style="width:30%"><i><strong>MANAGER</strong></i></td>
                            <td>
                                @if($req->supervisor_id > 0)
                                    {!! strtoupper($req->mngr->first_name.' '.$req->mngr->last_name)!!}
                                @else
                                    <i class="fa fa-minus"></i>
                                @endif
                            </td>
                        </tr>    
                        <tr>
                            <td style="width:30%"><i><strong>MANAGER ACTION</strong></i></td>
                            <td>
                                @if($req->sup_action == 1)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($req->sup_action == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @else
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
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
                            </td>
                        </tr>                                  
                        <tr>
                            <td style="width:30%"><i><strong>HR ACTION</strong></i></td>
                            <td>
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
                            <th>DESCRIPTION</th>
                            <th>QTY</th>
                            <th>UNIT</th>                                                            
                            <th>PURPOSE</th>
                        </tr>
                        <tbody>                            
                            <tr>
                                @if(!empty($req->item_no1))
                                <td>{!! $req->item_no1 !!}</td>
                                <td>{!! $req->desc1 !!}</td>
                                <td>{!! $req->qty1 !!}</td>
                                <td>{!! $req->unit1 !!}</td>
                                <td>{!! $req->purpose1 !!}</td>
                                @else
                                @endif
                            </tr>                           
                            <tr>
                                @if(!empty($req->item_no2))
                                <td>{!! $req->item_no2 !!}</td>
                                <td>{!! $req->desc2 !!}</td>
                                <td>{!! $req->qty2 !!}</td>
                                <td>{!! $req->unit2 !!}</td>
                                <td>{!! $req->purpose2 !!}</td>                                
                                @else
                                @endif
                            </tr>                  
                            <tr>
                                @if(!empty($req->item_no3))
                                <td>{!! $req->item_no3 !!}</td>
                                <td>{!! $req->desc3 !!}</td>
                                <td>{!! $req->qty3 !!}</td>
                                <td>{!! $req->unit3 !!}</td>
                                <td>{!! $req->purpose3 !!}</td>
                                @else
                                @endif
                            </tr>                           
                            <tr>
                                @if(!empty($req->item_no4))
                                <td>{!! $req->item_no4 !!}</td>
                                <td>{!! $req->desc4 !!}</td>
                                <td>{!! $req->qty4 !!}</td>
                                <td>{!! $req->unit4 !!}</td>
                                <td>{!! $req->purpose4 !!}</td>
                                @else
                                @endif
                            </tr>                           
                            <tr>
                                @if(!empty($req->item_no5))
                                <td>{!! $req->item_no5 !!}</td>
                                <td>{!! $req->desc5 !!}</td>
                                <td>{!! $req->qty5 !!}</td>
                                <td>{!! $req->unit5 !!}</td>
                                <td>{!! $req->purpose5 !!}</td>
                                @else
                                @endif
                            </tr>                                    
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
                    @if($req->sup_action < 2) 
                    {!! Form::open(array('route'=>'manager_requisition_remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('details','Add Your Remarks') !!}
                            {!! Form::textarea('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('req_id',$req->id) !!}          
                            @if($req->hrd_action < 2)
                                
                                <button class="btn btn-warning" name ="sub" value="1" this.form.submit();>Remarks Only</button>
                                <button class="btn btn-primary" name ="sub" value="2" this.form.submit();>Approve</button>                           
                                <button class="btn btn-danger" name ="sub" value="3" this.form.submit();>Denied</button>
                                                 
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

@endsection
