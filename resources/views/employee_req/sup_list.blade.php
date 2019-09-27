@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> EMPLOYEE REQUISITION</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_saved')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Requisition has been Created!<i class="fa fa-check"></i></h4></center>                
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
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY REQUISITIONS LISTS</h5>                                      
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>REQUISITION#</th>                                
                                <th>DATE REQUESTED</th>                               
                                <th>DATE NEEDED</th>
                                <th>HRD ACTION</th> 
                                <th>STATUS</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reqs as $req)
                                <tr>
                                    <td>
                                        @if($req->sup_action != 5 && $req->hrd_action != 5)
                                        {!! Html::decode(link_to_route('hrd_emp_req.view', $req->ereq_no,$req->ereq_no, array())) !!}
                                        @else
                                        {!! $req->ereq_no !!}
                                        @endif
                                    </td>                                    
                                    <td>{!! $req->created_at !!}</td>
                                    <td>{!! $req->date_needed !!}</td>
                                    <td>
                                        @if($req->hr_action == 0)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->hr_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->hr_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->approver_action == 0)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->approver_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->approver_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
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
@stop
@section('page-script')

$('#filer_inputs').filer({

        showThumbs:true,
        addMore:true
    }); 

$('#date_needed .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
});

$('#date_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
});

@stop