@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> HR LEAVE LIST</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been Created!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_cancel')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been Canceled!<i class="fa fa-check"></i></h4></center>                
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
                <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY LEAVE LISTS</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>REQUISITION#</th>                                
                                <th>DATE REQUESTED</th>
                                <th>DATE NEEDED</th>
                                <th>MANAGER ACTION</th> 
                                <th>HRD ACTION</th>
                                <th>ACTION</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lvs as $lv)
                            <tr>
                                <td>{!!$lv->req_no!!}</td>
                                <td>{!!date('m-d-y',strtotime($lv->created_at))!!}</td>
                                <td>{!!date('m-d-y',strtotime($lv->date))!!}</td>
                                <td>
                                    @if($lv->sup_action < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($lv->sup_action == 1)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @elseif($lv->sup_action == 3)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                    @elseif($lv->level == 5 && $lv->sup_action == 5 && $lv->hrd_action == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lv->hrd_action < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($lv->hrd_action == 1)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @elseif($lv->hrd_action == 3)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                    @elseif($lv->level == 5 && $lv->sup_action == 5 && $lv->hrd_action == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lv->status != 5 && $lv->level != 5)
                                    {!! Html::decode(link_to_Route('leaves.hr_details','<i class="fa fa-eye"></i> Details', $lv->id, array('class' => 'btn btn-warning btn-xs')))!!}
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