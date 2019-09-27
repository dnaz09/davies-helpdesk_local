@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> LIST OF ALL JOB ORDER REQUESTS</h2> 
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_transfered')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request Has Been Transfered to Next Level!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_returned')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request Has Been Returned!<i class="fa fa-check"></i></h4></center>                
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
<div class="animated fadeInDown">    
    <center>    
        <div class="col-lg-12 text-center">            
            <div class="col-lg-12">                
                <center><h1 class="logo-name" style="font-size:80px;"></h1></center>
            </div>
            <div class="col-lg-4">
                <div class="widget navy-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-tasks fa-4x"></i>
                        <h1 class="m-xs">{!! $jos_total !!}</h1>
                        <h3 class="font-bold no-margins">
                            TOTAL REQUEST
                        </h3>                            
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="widget yellow-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-clock-o fa-4x"></i>
                        <h1 class="m-xs">{!! $jos_pending !!}</h1>
                        <h3 class="font-bold no-margins">
                            PENDING
                        </h3>                            
                    </div>
                </div>
            </div>                                        
            <div class="col-lg-4">
                <div class="widget blue-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-check fa-4x"></i>
                        <h1 class="m-xs">{!! $jos_approved !!}</h1>
                        <h3 class="font-bold no-margins">
                            CLOSED
                        </h3>                            
                    </div>
                </div>
            </div>                
        </div>   
    </center>    
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">            
            <div class="ibox-content">
                <div class="panel blank-panel">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY JOB ORDER LISTS</h5>
                </div>               
                    <div class="panel-body">                   
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>        
                                            <th>CONTROL#</th>    
                                            <th>STATUS</th>      
                                            <th>REQUESTED BY</th>                                                              
                                            <th>RESOLVED BY</th>                                                    
                                            <th>DATE SUBMITTED</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($jos as $jo)
                                        <tr>
                                            <td>
                                                @if($jo->status != 5)
                                                {!! Html::decode(link_to_route('job_order.details', $jo->id,$jo->id, array())) !!}
                                                @else
                                                {!! $jo->jo_no !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($jo->status < 2)
                                                    <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                                @elseif($jo->status == 5)
                                                    <span class="label label-info"> <i class="fa fa-clock-o"></i> Canceled</span>
                                                @else
                                                    <span class="label label-success"> <i class="fa fa-check"></i> Approved</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($jo->solved_by > 0)
                                                    {!! strtoupper($jo->approved->first_name.' '.$jo->approved->last_name) !!}
                                                @else
                                                    N/A
                                                @endif    
                                            </td>
                                           
                                            <td>{!! $jo->date_submitted !!}</td>
                                        </tr>
                                        @endforeach
                                   </tbody>             
                                </table>
                            </div>
                        </div>                                                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
