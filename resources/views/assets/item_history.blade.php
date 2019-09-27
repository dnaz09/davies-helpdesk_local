@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> BORROWED ITEM CURRENT STATUS</h2>       
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Success! <i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_pass')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Password Doesn't Match!</h4></center>   
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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">        
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> ASSET DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                                        
                        <tr>
                            <td style="width:30%"><i><strong>BARCODE #:</strong></i></td><td>{!! $asset->barcode !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>ITEM NAME #:</strong></i></td><td>{!! $asset->item_name !!}</td>
                        </tr>          
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($asset->io > 0)
                                    <span class="label label-warning">IN</span>
                                @else
                                    <span class="label label-primary">OUT</span>
                                @endif
                            </td>
                        </tr>                        
                        <tr>
                            <td style="width:30%"><i><strong>DETAILS:</strong></i></td><td>{!! strtoupper($asset->remarks) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>HOLDER:</strong></i></td>
                            <td>
                                @if($asset->io != 1)
                                {!! strtoupper($asset->user->first_name.' '.$asset->user->last_name) !!}
                                @endif
                                {!! strtoupper('currently on hand') !!}
                            </td>
                        </tr>                                                    
                    </table>                                         
                </div>                   
            </div>                                      
        </div> 
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> BORROW HISTORY <small></small></h5>          
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Asset</th>
                                <th>Borrower's Request Number</th>
                                <th>User</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                            <tr>
                                <td>{{$history->barcode}}</td>
                                <td>{{$history->req_no}}</td>
                                <td>{{$history->user->first_name.' '.$history->user->last_name}}</td>
                                <td>{{$history->remarks}}</td>
                                <td>{{date('m/d/y h:ia',strtotime($history->created_at))}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>      
    </div>    
</div>   
@stop
