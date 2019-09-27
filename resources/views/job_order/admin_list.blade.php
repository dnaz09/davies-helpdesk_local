@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> LIST OF ALL APPROVED JOB ORDER REQUESTS</h2> 
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
            <div class="col-lg-6">
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
            <div class="col-lg-6">
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
        </div>   
    </center>    
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">            
            <div class="ibox-content">
                <div class="panel blank-panel">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> JOB ORDER REQUEST LISTS</h5>
                </div>               
                    <div class="panel-body">                   
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-admin-jo">
                                    <thead>
                                        <tr>        
                                            <th>DATE SUBMITTED</th>
                                            <th>CONTROL#</th>
                                            <th>JO STATUS</th>      
                                            <th>REQUESTED BY</th>                                                              
                                            <th>WORK FOR</th>
                                            <th>DOWNLOAD</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($jos as $jo)
                                        <tr>
                                            <td>{!! date('Y/m/d',strtotime($jo->date_submitted)) !!}</td>
                                            <td>
                                                @if($jo->status != 5)
                                                {!! Html::decode(link_to_route('job_order_admin.details', $jo->jo_no,$jo->id, array())) !!}
                                                @else
                                                {!! $jo->jo_no !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($jo->status == 2)
                                                @if($jo->jo_status == 1)
                                                    <span class="label label-warning"> Looking for Service Provider</span>
                                                @elseif($jo->jo_status == 0)
                                                    <span class="label label-success"> Approved</span>
                                                @elseif($jo->jo_status == 2)
                                                    <span class="label label-primary"> Done</span>
                                                @elseif($jo->jo_status == 4)
                                                    <span class="label label-warning"> Ongoing</span>
                                                @elseif($jo->jo_status == 5)
                                                    <span class="label label-danger"> Canceled</span>
                                                @endif
                                                @elseif($jo->status < 2)
                                                <span class="label label-warning"> For Approval</span>
                                                @endif
                                            </td>
                                            <td>
                                                {!! strtoupper($jo->user->first_name.' '.$jo->user->last_name) !!}
                                            </td>
                                            <td>
                                                {!! strtoupper($jo->work_for) !!}
                                            </td>
                                            <td>
                                                @if($jo->status != 5)
                                                @if($jo->status == 2)
                                                {{-- <a href="http://pdf-generator.davies-helpdesk.com/job_order/{{$jo->id}}/{{$jo->user_id}}/generate" id="{{$jo->id}}" target="__blank"><button class="btn btn-primary btn-xs"><i class="fa fa-download"> Download</i></button></a> --}}
                                                <a href="/job_order/{{$jo->id}}/{{$jo->user_id}}/generate" id="{{$jo->id}}" target="__blank"><button class="btn btn-primary btn-xs"><i class="fa fa-download"> </i>Download</button></a>
                                                @endif
                                                @else
                                                CANCELED
                                                @endif
                                            </td>
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
