@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> My TAGGED REQUEST</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>            
            <li><a href="#">My Tagged Request</a></li>                        
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
                                <li class="active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-bullseye"></i> WORK AUTHORIZATION</a></li>                            
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
                                                    <th>DATE CREATED</th>
                                                    <th>CONTROL#</th> 
                                                    <th>STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @forelse($work_auths as $work_auth)
                                                    <tr>
                                                        <td>{!! $work_auth->created_at->format('Y/m/d h:i a') !!}</td>
                                                        <td>
                                                            {!! Html::decode(link_to_Route('tagged_request_list.details', 'WA-'.$work_auth->work_auth_id, $work_auth->work_auth_id, array())) !!}
                                                        </td>
                                                        <td>
                                                            @if($work_auth->work->level < 2)
                                                                <span class="label label-warning"> <i class="fa fa-clock"></i> Pending</span>
                                                            @elseif($work_auth->work->level == 2)
                                                                <span class="label label-primary"> <i class="fa fa-check"></i> Approved</span>
                                                            @elseif($work_auth->work->level == 5)
                                                                <span class="label label-danger"> <i class="fa fa-close"></i> Cancelled</span>
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
            </div>
        </div>
    </div>
</div>    
@stop
