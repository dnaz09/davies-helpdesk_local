@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> LIST OF EMPLOYEE OFFICIAL BUSINESS PASS</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>OBP was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('is_updated')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>OBP was successfully Updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> OBP LISTS</h5>                       
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>OBP#</th>
                                <th>EMPLOYEE</th>
                                <th>FILED DATE</th>
                                <th>DATE CREATED</th>                               
                                <th>STATUS</th>
                                <th>ACTION</th>                             
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($obps as $obp)
                                <tr>
                                    <td>{!! $obp->id !!}</td>
                                    <td>{!! strtoupper($obp->user->first_name.' '.$obp->user->last_name) !!}</td>
                                    <td>{!! date('m/d/y',strtotime($obp->created_at)) !!}</td>
                                    <td>{!! date('m/d/y',strtotime($obp->created_at)) !!}</td>
                                    <td>
                                        @if($obp->manager_action < 1)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($obp->manager_action == 2)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($obp->manager_action == 3)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-danger"> <i class="fa fa-minus"></i></span>
                                        @endif
                                    </td>
                                    <td>                                                                                
                                        {!! Html::decode(link_to_Route('mngr_obp.details','<i class="fa fa-eye"></i> Details', $obp->id, array('class' => 'btn btn-warning btn-xs')))!!}
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