@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> FOR APPROVAL USER ACCESS REQUEST</h2>        
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
            <div class="col-lg-12">
                <div class="widget navy-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-tasks fa-4x"></i>
                        <h1 class="m-xs">{!! count($tickets) !!}</h1>
                        <h3 class="font-bold no-margins">
                            TOTAL REQUEST
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
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>DATE FILED</th>
                                        <th>CONTROL#</th>
                                        <th>REQUESTED BY</th>
                                        <th>COMPANY</th>
                                        <th>CATEGORY</th>                                                     
                                        <th>SUB CATEGORY</th>
                                        <th>YOUR APPROVAL</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                        @foreach($tickets as $ticket)
                                            <tr>
                                                <td>{!! date('Y/m/d h:i a',strtotime($ticket->created_at)) !!}</td>
                                                <td>{!! Html::decode(link_to_route('it_request_list.manager_details', $ticket->reqit_no,$ticket->reqit_no, array())) !!}</td>
                                                <td>
                                                    {!! strtoupper($ticket->user->first_name.' '.$ticket->user->last_name) !!}
                                                </td>
                                                <td>
                                                    {!! strtoupper($ticket->user->company) !!}
                                                </td>
                                                <td>{!! $ticket->category !!}</td>
                                                <td>{!! $ticket->sub_category !!}</td>
                                                <td>
                                                    @if($ticket->level == 2)
                                                        <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                                    @else
                                                        <span class="label label-success"> <i class="fa fa-angellist"></i> Approved</span>
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
@endsection
