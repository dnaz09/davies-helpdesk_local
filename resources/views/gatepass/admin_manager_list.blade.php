@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        {{-- <h2><i class="fa fa-plus"></i> GATEPASS FOR APPROVAL</h2>  --}}
        <h2><i class="fa fa-plus"></i> GATEPASS FOR CLOSING</h2> 

    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

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
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Sending Request Failed! Please fill the fields correctly!<i class="fa fa-cross"></i></h4></center>                
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    {{-- <h5 style="color:white"><i class="fa fa-futbol-o"></i> GATEPASS FOR APPROVAL LIST</h5>--}}
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> GATEPASS FOR CLOSING LIST</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Control #</th>
                                    <th>Noted By</th>
                                    <th>Admin Assistant Status</th>
                                    <th>Approved By</th>
                                    <th>Status</th>
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
                                        {!! Html::decode(link_to_route('gatepass.m_admin_details', $gp->req_no,$gp->id, array())) !!}
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
                                        @if($gp->status != 5)
                                        @if(!empty($gp->approval == 1))
                                        {{-- <a href="http://pdf-generator.davies-helpdesk.com/gatepass/{{$gp->id}}/{{$gp->user_id}}/generate" id="{{$gp->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a> --}}
                                        <a href="/gatepass/{{$gp->id}}/{{$gp->user_id}}/generate" id="{{$gp->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a>
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
@stop