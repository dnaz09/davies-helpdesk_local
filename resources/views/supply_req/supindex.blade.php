@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> MATERIAL REQUEST FORM</h2> 
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> SUPPLIES REQUEST LISTS</h5>                                      
                </div>
                <div class="ibox-content">
                        <div class="panel blank-panel">
                            <div class="panel-heading">                            
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">                            
                                        <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i> PENDING REQUESTS</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-bullseye"></i> APPROVED REQUESTS</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-bullseye"></i> RELEASED REQUESTS</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-bullseye"></i> DENIED REQUESTS</a></li>
                                        <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-bullseye"></i> CANCELED REQUESTS</a></li>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>DATE FILED</th>
                                                                <th>CONTROL #</th>
                                                                <th>REQUESTED BY</th>
                                                                <th>STATUS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($supps as $supp)
                                                                @if ($supp->status === 1)
                                                                    <tr>
                                                                        <td>{!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}</td>
                                                                        <td>
                                                                            @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                                                {!! Html::decode(link_to_route('supplies_request_head.view', $supp->req_no,$supp->id, array())) !!}
                                                                            @else
                                                                                {!! $supp->req_no !!}
                                                                            @endif
                                                                        </td>
                                                                        <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
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
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                            <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                                <thead>
                                                                    <tr>
                                                                        <th>DATE FILED</th>
                                                                        <th>CONTROL #</th>
                                                                        <th>REQUESTED BY</th>
                                                                        <th>STATUS</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($supps as $supp)
                                                                        @if ($supp->manager_action === 1 && $supp->status === 2 && $supp->admin_action === 0)
                                                                            <tr>
                                                                                <td>{!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}</td>
                                                                                <td>
                                                                                    @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                                                        {!! Html::decode(link_to_route('supplies_request_head.view', $supp->req_no,$supp->id, array())) !!}
                                                                                    @else
                                                                                        {!! $supp->req_no !!}
                                                                                    @endif
                                                                                </td>
                                                                                <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
                                                                                <td>
                                                                                    @if($supp->status < 2)
                                                                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                                                    @elseif($supp->status == 2)
                                                                                    <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                                                                    @elseif($supp->status == 3)
                                                                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                                                    @elseif($supp->status == 5)
                                                                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                            </div>
                                    </div>
                                    <div id="tab-3" class="tab-pane">
                                        <div class="col-lg-12">
                                                <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>DATE FILED</th>
                                                                    <th>CONTROL #</th>
                                                                    <th>REQUESTED BY</th>
                                                                    <th>STATUS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($supps as $supp)
                                                                    @if ($supp->manager_action === 1 && $supp->status === 2 && $supp->admin_action === 1)
                                                                        <tr>

                                                                            <td>{!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}</td>
                                                                            <td>
                                                                                @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                                                    {!! Html::decode(link_to_route('supplies_request_head.view', $supp->req_no,$supp->id, array())) !!}
                                                                                @else
                                                                                    {!! $supp->req_no !!}
                                                                                @endif
                                                                            </td>
                                                                            <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
                                                                            <td>
                                                                                @if($supp->status < 2)
                                                                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                                                @elseif($supp->status == 2)
                                                                                <span class="label label-primary"> <i class="fa fa-angellist"></i> Released</span>
                                                                                @elseif($supp->status == 3)
                                                                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                                                @elseif($supp->status == 5)
                                                                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                        </div>
                                    </div>
                                    <div id="tab-4" class="tab-pane">
                                        <div class="col-lg-12">
                                                <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>DATE FILED</th>
                                                                    <th>CONTROL #</th>
                                                                    <th>REQUESTED BY</th>
                                                                    <th>STATUS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($supps as $supp)
                                                                    @if ($supp->status === 3)
                                                                        <tr>
                                                                            <td>{!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}</td>
                                                                            <td>
                                                                                @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                                                    {!! Html::decode(link_to_route('supplies_request_head.view', $supp->req_no,$supp->id, array())) !!}
                                                                                @else
                                                                                    {!! $supp->req_no !!}
                                                                                @endif
                                                                            </td>
                                                                            <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
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
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                        </div>
                                    </div>
                                    <div id="tab-5" class="tab-pane">
                                        <div class="col-lg-12">
                                                <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>DATE FILED</th>
                                                                    <th>CONTROL #</th>
                                                                    <th>REQUESTED BY</th>
                                                                    <th>STATUS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($supps as $supp)
                                                                    @if ($supp->status === 5)
                                                                        <tr>
                                                                            <td>{!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}</td>
                                                                            <td>
                                                                                @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                                                    {!! Html::decode(link_to_route('supplies_request_head.view', $supp->req_no,$supp->id, array())) !!}
                                                                                @else
                                                                                    {!! $supp->req_no !!}
                                                                                @endif
                                                                            </td>
                                                                            <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
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
                                                                        </tr>
                                                                    @endif
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
</div>  
@stop
@section('page-script')
$('#date_must .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});


@stop

@section('page-script')

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });

@stop