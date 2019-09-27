@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> LIST OF BORROWER'S SLIP</h2> 
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
                        <h1 class="m-xs">{!! $user_acc_total !!}</h1>
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
                        <h1 class="m-xs">{!! $user_acc_ongoing !!}</h1>
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
                        <h1 class="m-xs">{!! $user_acc_closed !!}</h1>
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
                                            <th>DATE FILED</th>                                
                                            <th>CONTROL #</th>
                                            <th>BORROWED BY</th>
                                            <th>DATE NEEDED</th>
                                            <th>DATE RETURN</th>
                                            <th>STATUS</th>      
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($asset_reqs as $asset_req)
                                        <tr>
                                            <td>
                                                {!! date('Y/m/d',strtotime($asset_req->created_at)) !!} {!! date('h:i a',strtotime($asset_req->created_at)) !!}
                                            </td>
                                            <td>
                                                @if($asset_req->status != 5)
                                                    {!! Html::decode(link_to_route('asset_request.details', $asset_req->req_no,$asset_req->req_no, array())) !!}
                                                @else
                                                    {!! $asset_req->req_no !!}
                                                @endif
                                            </td>
                                            <td>                                                
                                                {!! strtoupper($asset_req->borrower_name) !!}                                                
                                            </td>
                                            <td>
                                                @if($asset_req->slip->date_needed != '')
                                                {!! date('Y/m/d',strtotime($asset_req->slip->date_needed))!!}
                                                @endif
                                            </td>
                                            <td>{!! date('Y/m/d',strtotime($asset_req->slip->must_date)) !!}</td>
                                            <td>
                                                @if($asset_req->status < 2)
                                                    <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                                @elseif($asset_req->status == 5)
                                                    <span class="label label-info"> <i class="fa fa-check"></i> Canceled</span>
                                                @else
                                                    <span class="label label-success"> <i class="fa fa-check"></i> Approved</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($asset_req->status != 5)
                                                    @if($asset_req->sup_action == 2)
                                                    {{-- <a href="http://pdf-generator.davies-helpdesk.com/borrower_slip/{{$asset_req->req_no}}/{{$asset_req->user_id}}/generate" id="{{$asset_req->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a> --}}
                                                    <a href="/borrower_slip/{{$asset_req->req_no}}/{{$asset_req->user_id}}/generate" id="{{$asset_req->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>
                                                    @endif
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
