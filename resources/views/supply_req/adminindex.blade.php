@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> MATERIAL REQUEST LISTS</h2> 
    </div>
</div>    
<br>
   
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="panel-options">
        <ul class="nav nav-tabs">                            
            <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i> FOR ADMIN APPROVAL</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-user-circle"></i> FOR SUPERIOR APPROVAL</a></li>
        </ul>
    </div> 

    <div class="row">
        <div class="tab-content">
            <div id="tab-1" class="row tab-pane active">

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="background-color:#009688">
                            <h5 style="color:white"><i class="fa fa-futbol-o"></i> MATERIAL REQUEST LISTS</h5>                                      
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>DATE FILED</th>
                                            <th>CONTROL #</th>
                                            <th>REQUESTED BY</th>
                                            <th>STATUS</th>
                                            <th>DETAILS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supps as $supp)
                                        <tr>
                                            <td>{!! date('Y/m/d h:i a',strtotime($supp->created_at)) !!} </td>
                                            <td>
                                                @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                    {!! Html::decode(link_to_route('supplies_request_admin.view', $supp->req_no,$supp->id, array())) !!}
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
                                            <td>
                                                @if($supp->status != 5 && $supp->manager_action != 5 && $supp->admin_action != 5)    
                                                {{-- <a href="http://pdf-generator.davies-helpdesk.com/mrs-generate/{{$supp->req_no}}/{{$supp->user_id}}/generate" id="{{$supp->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>                                                 --}}
                                                <a href="/mrs-generate/{{$supp->req_no}}/{{$supp->user_id}}/generate" id="{{$supp->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>                                                
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
            <div id="tab-2" class="row tab-pane">

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="background-color:#009688">
                            <h5 style="color:white"><i class="fa fa-futbol-o"></i> MATERIAL REQUEST LISTS</h5>                                      
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>DATE FILED</th>
                                            <th>CONTROL #</th>
                                            <th>REQUESTED BY</th>
                                            <th>STATUS</th>
                                            <th>DETAILS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($forsuperiors as $forsuperior)
                                        <tr>
                                            <td>{!! date('Y/m/d h:i a',strtotime($forsuperior->created_at)) !!} </td>
                                            <td>
                                                {{-- @if($forsuperior->status != 5 && $forsuperior->manager_action != 5 && $forsuperior->admin_action != 5)    
                                                    {!! Html::decode(link_to_route('supplies_request_admin.view', $forsuperior->req_no,$forsuperior->id, array())) !!}
                                                @else --}}
                                                    {!! $forsuperior->req_no !!}
                                                {{-- @endif --}}
                                            </td>
                                            <td>{!! $forsuperior->user->first_name.' '.$forsuperior->user->last_name !!}</td>
                                            <td>
                                                @if($forsuperior->status < 2)
                                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                @elseif($forsuperior->status == 2)
                                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                                @elseif($forsuperior->status == 3)
                                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                @elseif($forsuperior->status == 5)
                                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($forsuperior->status != 5 && $forsuperior->manager_action != 5 && $forsuperior->admin_action != 5)    
                                                {{-- <a href="http://pdf-generator.davies-helpdesk.com/mrs-generate/{{$forsuperior->req_no}}/{{$forsuperior->user_id}}/generate" id="{{$forsuperior->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>                                                 --}}
                                                <a href="/mrs-generate/{{$forsuperior->req_no}}/{{$forsuperior->user_id}}/generate" id="{{$forsuperior->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>                                                
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

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });
@stop