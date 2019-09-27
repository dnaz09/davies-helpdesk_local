@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> LIST OF ALL REQUESTS TO IT DEPARTMENT</h2>        
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
            @if( count ($errors) > 0 )
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
            <div class="col-lg-3">
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
            <div class="col-lg-3">
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
            <div class="col-lg-3">
                <div class="widget lazur-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-exchange fa-4x"></i>
                        <h1 class="m-xs">{!! $user_acc_returned !!}</h1>
                        <h3 class="font-bold no-margins">
                            RETURNED
                        </h3>                            
                    </div>
                </div>
            </div>          
            <div class="col-lg-3">
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
                    <div class="panel-heading">                            
                        <div class="panel-options">
                            <ul class="nav nav-tabs">                            
                                <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i>NON SAP</a></li>                                
                                <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-book"></i> SAP REQUEST</a></li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">      
                                <br>
                                &nbsp;
                                <center><h2>YOUR RESOLVED REQUEST IN THIS USER ACCESS: {!! $user_acc_solve !!}</h2></center>
                                <center><h2>YOUR RESOLVED REQUEST IN THIS SERVICE REQUEST: {!! $service_solve !!} </h2></center>
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-it-all" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>DATE & TIME</th>
                                                    <th>CONTROL#</th>
                                                    <th>REQUESTED BY</th>
                                                    <th>DEPARTMENT</th>
                                                    <th>COMPANY</th>
                                                    <th>TYPE</th>
                                                    <th>CATEGORY</th>                                                     
                                                    <th>SUB CATEGORY</th>
                                                    <th>RESOLVED BY</th>
                                                    <th>STATUS</th>  
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                @forelse($reqs as $req)
                                                <tr>
                                                    <td>{!! date('Y/m/d h:i a',strtotime($req->created_at)) !!}</td>
                                                    <td>
                                                        @if($req->status != 5)
                                                            @if($req->service_type == 1)
                                                                {!! Html::decode(link_to_route('it_request_list.details', $req->reqit_no,$req->reqit_no, array())) !!}
                                                            @elseif($req->service_type == 2)
                                                                {!! Html::decode(link_to_route('it_request_list.details',$req->reqit_no,$req->reqit_no, array())) !!}
                                                            @endif
                                                        @else
                                                            {!! $req->reqit_no !!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}
                                                    </td>
                                                    <td>{!! strtoupper($req->user->department->department) !!}</td>
                                                    <td>
                                                        {!! strtoupper($req->user->company) !!}
                                                    </td>
                                                    <td>
                                                        @if($req->service_type == 1)
                                                        USER ACCESS
                                                        @elseif($req->service_type == 2)
                                                        SERVICE
                                                        @endif
                                                    </td>
                                                    <td>{!! $req->category !!}</td>
                                                    <td>{!! $req->sub_category !!}</td>
                                                    <td>
                                                        @if($req->solved_by > 0)
                                                            {!! strtoupper($req->solve->first_name.' '.$req->solve->last_name) !!}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($req->status < 1)
                                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                        @elseif($req->status == 1)
                                                            <span class="label label-success"> <i class="fa fa-angellist"></i> Returned</span>
                                                        @elseif($req->status == 5)
                                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                        @else
                                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                @endforelse                                            
                                            </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">      
                                <br>
                                &nbsp;
                                <center><h2>YOUR RESOLVED REQUEST IN THIS CATEGORY: {!! $saps_solve !!}</h2></center>
                                
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-it_all-two">
                                            <thead>
                                                <tr>        
                                                    <th>DATE & TIME</th>
                                                    <th>CONTROL#</th>
                                                    <th>REQUESTED BY</th>
                                                    <th>DEPARTMENT</th>
                                                    <th>COMPANY</th>
                                                    <th>CATEGORY</th>                                                     
                                                    <th>SUB CATEGORY</th>
                                                    <th>RESOLVED BY</th>
                                                    <th>STATUS</th>  
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                    @foreach($saps as $sap)
                                                        <tr>
                                                            <td>{!! date('m/d/y h:i a',strtotime($sap->created_at)) !!}</td>
                                                            <td>
                                                                @if($sap->status != 5)
                                                                {!! Html::decode(link_to_route('it_request_list.details', $sap->reqit_no,$sap->reqit_no, array())) !!}
                                                                @else
                                                                 {!! $sap->reqit_no !!}
                                                                @endif
                                                               
                                                            </td>
                                                            <td>
                                                                {!! strtoupper($sap->user->first_name.' '.$sap->user->last_name) !!}              
                                                            </td>
                                                            <td>{!! strtoupper($sap->user->department->department) !!}</td>
                                                            <td>
                                                                {!! strtoupper($sap->user->company) !!}              
                                                            </td>
                                                            <td>{!! $sap->category !!}</td>
                                                            <td>{!! $sap->sub_category !!}</td>
                                                            <td>
                                                            @if($sap->solved_by > 0)
                                                                {!! strtoupper($sap->solve->first_name.' '.$sap->solve->last_name) !!}
                                                            @else
                                                                N/A
                                                            @endif
                                                            </td>
                                                            <td>
                                                                @if($sap->status < 1)
                                                                    <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                                @elseif($sap->status == 1)
                                                                    <span class="label label-success"> <i class="fa fa-angellist"></i> Returned</span>
                                                                @elseif($sap->status == 5)
                                                                    <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                                @else
                                                                    <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
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
    </div>
</div>
@endsection
