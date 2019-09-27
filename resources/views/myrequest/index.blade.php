@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> My REQUEST</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>            
            <li><a href="#">My Request</a></li>                        
            <li class="active"><strong>List</strong></li>
        </ol>
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
            <?php if (session('is_canceled')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been cancelled!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php Session::forget('is_canceled');?>

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
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title" style="background-color:#009688">
                <h5 style="color:white"><i class="fa fa-futbol-o"></i> My Request Table</h5>                    
            </div>
            <div class="ibox-content">
                <div class="panel blank-panel">
                    <div class="panel-heading">                            
                        <div class="panel-options">
                            <ul class="nav nav-tabs">                            
                                <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i> IT DEPARTMENT</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-user-circle"></i> ASSETS</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-check-square-o"></i> OBF</a></li>                                
                                <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-clock-o"></i> LEAVE</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-6"><i class="fa fa-cube"></i> REQUISITION</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-7"><i class="fa fa-check-square-o"></i> WORK AUTHORIZATION</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-8"><i class="fa fa-check-square-o"></i> JOB ORDER</a></li>                             
                                <li class=""><a data-toggle="tab" href="#tab-9"><i class="fa fa-check-square-o"></i> EXIT PASS</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-10"><i class="fa fa-check-square-o"></i> GATE PASS</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-11"><i class="fa fa-check-square-o"></i> MATERIAL REQUEST</a></li>                             


                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>                                                                           
                                                <th>CONTROL#</th>
                                                <th>STATUS</th>  
                                                <th>DATE CREATED</th>
                                               {{--  <th>ACTION</th> --}}                                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @forelse($reqs as $req)
                                                <tr>
                                                    <td>
                                                        @if($req->status != 5)
                                                        {!! Html::decode(link_to_route('my_request_list.details', $req->reqit_no,$req->reqit_no, array())) !!}
                                                        @else
                                                        {!! $req->reqit_no !!}
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
                                                    <td>{!! $req->created_at->format('M-d-Y h:i a') !!}</td>
                                                    {{-- <td> --}}
                                                        {{-- @if($req->status != 5 && $req->status < 1) --}}
                                                        {{-- {!! Html::decode(link_to_route('my_request_list.it_cancel', 'Cancel',$req->reqit_no, array('class'=>'btn btn-xs btn-danger'))) !!} --}}
                                                        {{-- @endif --}}
                                                    {{-- </td> --}}
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>                                                            
                                                <th>CONTROL#</th>
                                                <th>STATUS</th>  
                                                <th>DATE CREATED</th>
                                                <th>CANCEL REQUEST</th>                                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @forelse($assets as $asset)
                                                <tr>
                                                    <td>
                                                        @if($asset->status != 5)
                                                        {!! Html::decode(link_to_route('my_request_list.details_asset', $asset->req_no,$asset->req_no, array())) !!}
                                                        @else
                                                        {!! $asset->req_no !!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($asset->status < 2)
                                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                        @elseif($asset->status == 5)
                                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                        @else
                                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                        @endif
                                                    </td>
                                                    <td>{!! $asset->created_at->format('M-d-Y h:i a') !!}</td>
                                                    <td>
                                                        @if($asset->status != 5 && $asset->sup_action != 2 && $asset->status != 2)
                                                        {!! Html::decode(link_to_route('my_request_list.cancel', 'Cancel',$asset->req_no, array('class'=>'btn btn-xs btn-danger'))) !!}
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
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>                                                                           
                                                <th>CONTROL#</th>
                                                <th>STATUS</th>  
                                                <th>DATE CREATED</th>                                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @forelse($obp_reqs as $obp_req)
                                                <tr>
                                                    @if($obp_req->manager_action != 5 || $obp_req->level != 5)
                                                    <td>{!! Html::decode(link_to_route('my_request_list.details_obp', $obp_req->obpno,$obp_req->obpno, array())) !!}</td>
                                                    @else
                                                    <td>{!! $obp_req->obpno !!}</td>
                                                    @endif
                                                    <td>
                                                        @if($obp_req->level < 2)
                                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                        @elseif($obp_req->level == 2)
                                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                        @elseif($obp_req->level == 3)
                                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                                        @elseif($obp_req->level == 5 || $obp_req->level == 5)
                                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                        @endif
                                                    </td>
                                                    <td>{!! $obp_req->created_at->format('M-d-Y h:i a') !!}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="tab-5" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>                                                                           
                                                <th>CONTROL#</th>
                                                <th>STATUS</th>  
                                                <th>DATE CREATED</th>                                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @forelse($undertimes as $undertime)
                                                <tr>
                                                    <td>
                                                        @if($undertime->status != 5 && $undertime->level != 5)
                                                        {!! Html::decode(link_to_route('my_request_list.details_undertime', $undertime->und_no,$undertime->id, array())) !!}
                                                        @else
                                                        {!! $undertime->und_no !!}
                                                        @endif
                                                    </td>                                                  
                                                    <td>
                                                        @if($undertime->status == 1)
                                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                        @elseif($undertime->status == 2)
                                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                                        @elseif($undertime->manager_action === 3)
                                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                        @else
                                                        <span class="label label-info"> <i class="fa fa-minus"></i></span>
                                                        @endif
                                                    </td>
                                                    <td>{!! $undertime->created_at->format('M-d-Y h:i a') !!}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-6" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>                                                                           
                                                <th>CONTROL#</th>
                                                <th>STATUS</th>  
                                                <th>DATE CREATED</th>                                                          
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @forelse($work_reqs as $work_req)
                                                <tr>
                                                    <td>
                                                        @if($work_req->level != 5)
                                                        {!! Html::decode(link_to_route('requisition.details', $work_req->rno,$work_req->rno, array())) !!}
                                                        @else
                                                        {!! $work_req->rno !!}
                                                        @endif
                                                    </td>                                               
                                                    <td>
                                                        @if($work_req->level < 2)
                                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                        @elseif($work_req->level == 2)
                                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                        @elseif($work_req->level == 3)
                                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                                        @else
                                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                        @endif
                                                    </td>
                                                    <td>{!! $work_req->created_at->format('M-d-Y h:i a') !!}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-7" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>                                                                           
                                                    <th>CONTROL#</th> 
                                                    <th>DATE CREATED</th>
                                                    <th>STATUS</th>
                                                    <th>ACTION</th>                                                         
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @forelse($work_auths as $work_auth)
                                                    <tr>
                                                        <td>{!! $work_auth->work_no !!}</td>
                                                        <td>{!! $work_auth->created_at->format('M-d-Y h:i a') !!}</td>
                                                        <td>
                                                            @if($work_auth->level < 2)
                                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                            @elseif($work_auth->level == 2)
                                                            <span class="label label-success"> <i class="fa fa-angellist"></i> Approved</span>
                                                            @elseif($work_auth->level == 3)
                                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                                            @elseif($work_auth->level == 5)
                                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {!! Html::decode(link_to_Route('work_authorization.details', '<span class="label label-warning"> <i class="fa fa-angellist"></i> Details</span>', $work_auth->id, array())) !!}
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-8" class="tab-pane">                                       
                                </br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>                                                                           
                                                    <th>CONTROL#</th>
                                                    <th>STATUS</th>  
                                                    <th>DATE CREATED</th>                                                          
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @forelse($jos as $jo)
                                                    <tr>
                                                        <td>
                                                            @if($jo->status != 5)
                                                            {!! Html::decode(link_to_Route('job_order_user.details', $jo->jo_no, $jo->id, array())) !!}
                                                            @else
                                                            {!! $jo->jo_no !!}
                                                            @endif
                                                        </td>                                                    
                                                        <td>
                                                            @if($jo->approved_by == null && $jo->status != 5)
                                                                <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                            @elseif($jo->approved_by != null && $jo->status != 5)
                                                                <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                            @elseif($jo->status == 5)
                                                                <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                            @endif
                                                        </td>
                                                        <td>{!! $jo->created_at->format('M-d-Y h:i a') !!}</td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-9" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>                                                                           
                                                    <th>CONTROL#</th>
                                                    <th>STATUS</th>  
                                                    <th>DATE CREATED</th>                                                          
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @forelse($exits as $exit)
                                                    <tr>
                                                        <td>EXT{!! Html::decode(link_to_Route('emp_exit_pass.details', $exit->id, $exit->id, array())) !!}</td>                                                    
                                                        <td>
                                                            @if($exit->hrd_action < 2)
                                                                <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                            @elseif($exit->hrd_action == 2)
                                                                <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                            @endif
                                                        </td>
                                                        <td>{!! $exit->created_at->format('M-d-Y h:i a') !!}</td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>                        
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-10" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Control #</th>
                                                            <th>Noted By</th>
                                                            <th>Admin Assistant Status</th>
                                                            <th>Released By</th>
                                                            <th>Admin Manager Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            @foreach($gps as $gp)
                                                            <tr>
                                                                <td>
                                                                    {!! date('Y/m/d',strtotime($gp->date)) !!}
                                                                </td>
                                                                <td>
                                                                    @if($gp->status != 5)
                                                                    {!! Html::decode(link_to_route('gatepass.show', $gp->req_no,$gp->id, array())) !!}
                                                                    @else
                                                                    {!! $gp->req_no !!}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(!empty($gp->approve_for_release))
                                                                        {!! $gp->approver->first_name.' '.$gp->approver->last_name !!}
                                                                    @else
                                                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($gp->approval < 1)
                                                                    <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                                    @elseif($gp->approval == 1)
                                                                    <span class="label label-primary"> <i class="fa fa-angellist"></i> Noted</span>
                                                                    @elseif($gp->approval == 3)
                                                                    <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($gp->issue_by)
                                                                        {!! $gp->issue->first_name.' '.$gp->issue->last_name !!}
                                                                    @else
                                                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($gp->status < 2)
                                                                    <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                                    @elseif($gp->status == 2)
                                                                    <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                                    @elseif($gp->status == 3)
                                                                    <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                                                    @elseif($gp->status == 5)
                                                                    <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($gp->status != 5 && !empty($gp->approval == 1))
                                                                    {{-- <a href="http://pdf-generator.davies-helpdesk.com/gatepass/{{$gp->id}}/{{$gp->user_id}}/generate" id="{{$gp->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a> --}}
                                                                    <a href="/gatepass/{{$gp->id}}/{{$gp->user_id}}/generate" id="{{$gp->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                                    
                                            </table>
                                        </div>
                                </div>
                            </div>
                            <div id="tab-11" class="tab-pane">                                       
                                <br>
                                &nbsp;
                                <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                                    <thead>
                                                        <tr>
                                                            <th>Control #</th>
                                                            <th>Date</th>
                                                            <th>Requested By</th>
                                                            <th>Manager's Approval</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($supps as $supp)
                                                        <tr>
                                                            <td>
                                                                @if($supp->status != 5)
                                                                {!! Html::decode(link_to_route('supplies_request.view', $supp->req_no,$supp->id, array())) !!}
                                                                @else
                                                                {!! $supp->req_no !!}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}
                                                            </td>
                                                            <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
                                                            <td>
                                                                @if($supp->manager_action < 1)
                                                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                                @elseif($supp->manager_action == 1)
                                                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                                                @elseif($supp->manager_action == 2)
                                                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                                @elseif($supp->manager_action == 5)
                                                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($supp->status < 2)
                                                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                                @elseif($supp->status == 2)
                                                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                                                @elseif($supp->status == 3)
                                                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                                @elseif($supp->status == 5)
                                                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($supp->status != 5)
                                                                @if($supp->manager_action < 1 && $supp->admin_action < 1)
                                                                <button class="btn btn-xs btn-danger" onclick="functionCancelthis(this)" value="{{$supp->id}}">Cancel</button>
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
    </div>
</div>    
@stop
