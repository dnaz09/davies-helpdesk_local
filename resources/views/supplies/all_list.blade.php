@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> LIST OF ALL SUPPLIES REQUESTS</h2> 
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
                        <h1 class="m-xs"></h1>
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
                        <h1 class="m-xs"></h1>
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
                        <h1 class="m-xs"></h1>
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
                                            <th>DATE CREATED</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($supplies as $sup)
                                        <tr>
                                            <td>{!! Html::decode(link_to_route('supplies_request.details', $sup->req_no,$sup->req_no, array())) !!}</td>
                                            <td>
                                               @if($sup->status < 2)
                                                    <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                               @else
                                                    <span class="label label-success"> <i class="fa fa-check"></i> Approved</span>
                                               @endif
                                            </td>
                                            <td>                                                
                                                {!! strtoupper($sup->user->first_name.' '.$sup->user->last_name) !!}                                                
                                            </td>
                                            <td>
                                                @if($sup->done_by > 0)
                                                    {!! strtoupper($sup->solve->first_name.' '.$sup->solve->last_name) !!}
                                                @else
                                                    N/A
                                                @endif    
                                            </td>
                                           
                                            <td>{!! $sup->created_at !!}</td>
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
