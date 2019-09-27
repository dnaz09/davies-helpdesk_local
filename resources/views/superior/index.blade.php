@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF EMPLOYEE REQUEST</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was successfully approved!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('is_updated')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was successfully Updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> REQUEST LISTS</h5>                       
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-superior">
                        <thead>
                            <tr>
                                <th>DATE FILED</th>
                                <th>CONTROL #</th>
                                <th>EMPLOYEE</th>
                                <th>TYPE OF REQUEST</th>
                                <th>STATUS</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            <div class="hidden">{!! $count = 1 !!}</div>
                            @forelse($obps as $obp)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($obp->created_at)) !!} {!! date('h:i a',strtotime($obp->created_at)) !!}</td>
                                    <td>
                                        @if($obp->manager_action != 5 && $obp->level != 5)
                                            {!! Html::decode(link_to_Route('mngr_obp.details', $obp->obpno , $obp->id, array()))!!}
                                        @else
                                            {!! $obp->obpno !!}
                                        @endif
                                        </td>
                                    <td>{!! strtoupper($obp->user->first_name.' '.$obp->user->last_name) !!}</td>
                                    <td>{!! strtoupper('Official Business pass') !!}</td>
                                    <td>
                                        @if($obp->manager_action < 2)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($obp->manager_action == 2)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($obp->manager_action == 3)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @elseif($obp->manager_action == 5)
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @else
                                        <span class="label label-danger"> <i class="fa fa-minus"></i></span>
                                        @endif
                                    </td>                                  
                                </tr>
                            @empty
                            @endforelse
                            @forelse($undertimes as $undertime)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($undertime->created_at)) !!} {!! date('h:i a',strtotime($undertime->created_at)) !!}</td>
                                    <td>@if($undertime->status != 5 && $undertime->level != 5)
                                        {!! Html::decode(link_to_Route('mngr_undertime.details',$undertime->und_no, $undertime->id, array()))!!}
                                        @else
                                        {!! $undertime->und_no !!}
                                        @endif
                                    </td>
                                    <td>{!! strtoupper($undertime->user->first_name.' '.$undertime->user->last_name) !!}</td>
                                    <td>{!! strtoupper('Leave') !!}</td>
                                    <td>
                                        @if($undertime->status == 1 || $undertime->status < 1)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($undertime->status == 2)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($undertime->status == 3)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @endif
                                    </td>                                   
                                </tr>
                            @empty
                            @endforelse
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($ticket->created_at)) !!} {!! date('h:i a',strtotime($ticket->created_at)) !!}</td>
                                    <td>
                                        @if($ticket->status != 5)  
                                        {!! Html::decode(link_to_Route('sap_manager.details',strtoupper($ticket->reqit_no), $ticket->reqit_no, array()))!!}
                                        @else
                                        {!! strtoupper($ticket->reqit_no) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {!! strtoupper($ticket->user->first_name.' '.$ticket->user->last_name) !!}
                                    </td>
                                    <td>{!! strtoupper('it - sap') !!}</td>
                                    <td>
                                        @if($ticket->sup_action < 1 && $ticket->status != 5)
                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                        @elseif($ticket->sup_action == 1 && $ticket->status != 5)
                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                        @elseif($ticket->status == 5)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Canceled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            @forelse($its as $it)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($it->created_at)) !!} {!! date('h:i a',strtotime($it->created_at)) !!}</td>
                                    <td>
                                        @if($it->status != 5)   
                                            {!! Html::decode(link_to_Route('sup_user_access.details',strtoupper($it->reqit_no), $it->id, array()))!!}
                                        @else
                                            {!! strtoupper($it->reqit_no) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {!! strtoupper($it->user->first_name.' '.$it->user->last_name) !!}
                                    </td> 
                                    <td>{!! strtoupper('it - user access') !!}</td>
                                    <td>
                                        @if($it->sup_action < 1 && $it->status != 5)
                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                        @elseif($it->sup_action == 1 && $it->status != 5)
                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                        @elseif($it->sup_action == 3 && $it->status == 3)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                        @elseif($it->status == 5)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Canceled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            @forelse($works as $work)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($work->work->created_at)) !!} {!! date('h:i a',strtotime($work->work->created_at)) !!}</td>
                                    <td>
                                        @if($work->superior_action != 5)                                 
                                            {!! Html::decode(link_to_Route('sup_work_authorization.details',$work->work->work_no, $work->work_auth_id, array()))!!}
                                        @else
                                            {!! $work->work->work_no !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($work->user))
                                        {!! strtoupper($work->user->first_name.' '.$work->user->last_name) !!}
                                        @endif
                                    </td>
                                    <td>{!! strtoupper('work authorization') !!}</td>
                                    <td>
                                        @if($work->superior_action < 1)
                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                        @elseif($work->superior_action == 1)
                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                        @elseif($work->superior_action == 2)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                        @else
                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                        @endif
                                    </td>                                  
                                </tr>
                            @empty
                            @endforelse
                            @forelse($requis as $req)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($req->created_at)) !!} {!! date('h:i a',strtotime($req->created_at)) !!}</td>
                                    <td>
                                        @if($req->level != 5 && $req->sup_action != 5 && $req->hrd_action != 5)
                                            {!! Html::decode(link_to_Route('mngr_requisition.mngr_details', strtoupper($req->rno), $req->id, array()))!!}
                                        @else
                                            {!! strtoupper($req->rno) !!}
                                        @endif
                                    </td>
                                    <td>{!! strtoupper($req->user->first_name.' '.$req->user->last_name) !!}</td>
                                    <td>{!! strtoupper('requisition') !!}</td>
                                    <td>
                                        @if($req->hrd_action < 2)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->hrd_action == 2)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->level == 5 && $req->sup_action == 5 && $req->hrd_action == 5)
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @else
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @endif
                                    </td>                
                                </tr>
                            @empty
                            @endforelse
                            @forelse($asset_reqs as $asset_req)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($asset_req->created_at)) !!} {!! date('h:i a',strtotime($asset_req->created_at)) !!}</td>
                                    <td>
                                        @if($asset_req->status != 5)
                                            {!! Html::decode(link_to_Route('sup_asset_request.mngr_details',strtoupper($asset_req->req_no), $asset_req->req_no, array()))!!}
                                        @else
                                        {!! strtoupper($asset_req->req_no) !!}
                                        @endif
                                    </td>
                                    <td>                                                
                                        {!! strtoupper($asset_req->user->first_name.' '.$asset_req->user->last_name) !!}                                                
                                    </td>
                                    <td>{!! strtoupper('item request') !!}</td>
                                    <td>
                                        @if($asset_req->status < 2)
                                            <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                        @elseif($asset_req->status == 5)
                                            <span class="label label-info"> <i class="fa fa-clock-o"></i> Canceled</span>
                                        @else
                                            <span class="label label-success"> <i class="fa fa-check"></i> v</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            <!-- @forelse($emps as $emp)
                                <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! date('Y/m/d',strtotime($emp->created_at)) !!}</td>
                                    <td>{!! date('H:i:s',strtotime($emp->created_at)) !!}</td>
                                    <td>{!! strtoupper($emp->ereq_no) !!}</td>
                                    <td>{!! strtoupper('Employee Requisition') !!}</td>
                                    <td>
                                        {!! strtoupper($emp->user->first_name.' '.$emp->user->last_name) !!}
                                    </td>
                                    <td>
                                        @if($emp->sup_action < 1)
                                            <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                        @elseif($emp->sup_action == 1)
                                            <span class="label label-success"> <i class="fa fa-check"></i> Approved</span>
                                        @elseif($emp->sup_action == 2)
                                            <span class="label label-danger"> <i class="fa fa-check"></i> Denied</span>
                                        @else
                                            <span class="label label-info"> <i class="fa fa-check"></i> Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($emp->sup_action != 5 && $emp->hr_action != 5)
                                        {!! Html::decode(link_to_Route('sup_emp_requisition.details','<i class="fa fa-eye"></i> Details', $emp->ereq_no, array('class' => 'btn btn-warning btn-xs')))!!}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse -->
                            @forelse($jos as $jo)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($jo->created_at)) !!} {!! date('h:i a',strtotime($jo->created_at)) !!}</td>
                                    <td>
                                        @if($jo->status != 5)
                                            {!! Html::decode(link_to_route('sup_jo_request.jo_detail',strtoupper($jo->jo_no),$jo->id, array())) !!}
                                        @else
                                            {!! strtoupper($jo->jo_no) !!}
                                        @endif
                                    </td>
                                    <td>{!! strtoupper($jo->user->first_name.' '.$jo->user->last_name) !!}</td>
                                    <td>{!! strtoupper('Job Order') !!}</td>
                                    <td>
                                        @if($jo->status < 2)
                                            <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                        @elseif($jo->status == 5)
                                            <span class="label label-info"> <i class="fa fa-clock-o"></i> Canceled</span>
                                        @else
                                            <span class="label label-success"> <i class="fa fa-check"></i> Approved</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            @forelse($supps as $supp)
                                <tr>
                                    <td>{!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}</td>
                                    <td>
                                        @if($supp->status != 5)
                                            {!! Html::decode(link_to_route('supplies_request_manager.view',strtoupper($supp->req_no),$supp->id, array())) !!}
                                        @else
                                            {!! strtoupper($supp->req_no) !!}
                                        @endif
                                    </td>
                                    <td>{!! strtoupper($supp->user->first_name.' '.$supp->user->last_name) !!}</td>
                                    <td>{!! strtoupper('Supplies Request') !!}</td>
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
                            @empty
                            @endforelse
                        </tbody>                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
@section('page-script')
    function functionapproveObp(elem){
        var obp_id = elem.value;
        var sub = 5;
        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {
                "obp_id": obp_id,
                "sub": sub
            },
            url: "../mngr_obp/remarks",
            success: function(data){            
                location.reload();
            }    
        });
    }
@endsection