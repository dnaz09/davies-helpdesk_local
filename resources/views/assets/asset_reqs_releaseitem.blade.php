@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i>BORROWER'S SLIP FOR RELEASING</h2>
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <center><h4>Item has been released!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_returned')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <center><h4>Item has been returned!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_closed')): ?>
                <div class="alert alert-success alert-dismissible flash" role="alert">            
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <center><h4>Request Has Been Closed!</h4></center>   
                </div>
           <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_wrong')): ?>
                <div class="alert alert-warning alert-dismissible flash" role="alert">            
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <center><h4>Incorrect Borrower's Code!</h4></center>   
                </div>
           <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('not_available')): ?>
                <div class="alert alert-warning alert-dismissible flash" role="alert">            
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <center><h4>No Available Asset at the moment!</h4></center>   
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
    </div>    
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">        
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> RELEASING OF ITEMS</h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>BORROWER'S SLIP NO:</strong></i></td><td>{!! strtoupper($asset_reqs->req_no) !!}</td>
                            <td style="width:30%"><i><strong>DATE FILED:</strong></i></td><td>{!! date('m/d/y',strtotime($asset_reqs->created_at)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>BORROWED BY:</strong></i></td><td>{!! strtoupper($asset_reqs->borrower_name) !!}</td>
                            <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($asset_reqs->user->first_name.' '.$asset_reqs->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE :</strong></i></td><td>{!! strtoupper($asset_reqs->details) !!}</td>
                            <td style="width:30%"><i><strong>REQUEST STATUS:</strong></i></td>
                            <td>
                                @if($asset_reqs->status < 2)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($asset_reqs->status == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @else
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @endif
                            </td>
                        </tr>                            
                        <tr>
                            <td style="width:30%"><i><strong>RESOLVED BY:</strong></i></td>
                            <td>
                                @if($asset_reqs->solved > 0)
                                    {!! strtoupper($asset_reqs->solved->first_name.' '.$asset_reqs->solved->last_name) !!}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>ITEM RECIPIENT:</strong></i></td>
                            <td>
                                @if($asset_reqs->slip->get_by != null)
                                {!! strtoupper($asset_reqs->slip->get_by) !!}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                    </table>
                    <h3>LIST OF AVAILABLE ITEMS</h3>
                    {!!Form::open(array('route'=>'asset_request.releasing','method'=>'POST'))!!}
                    <div class="form-group">
                        {!!Form::label('asset_label', 'Choose the asset you want to release')!!}
                        <select class="form-control" name="rel_asset">
                            @foreach($assets as $asset)
                            <option value="{{$asset->id}}">
                                {!!$asset->barcode!!} - {!!$asset->item_name!!} ({!!$asset->brand!!}) - {!!$asset->remarks!!}
                            </option>
                            @endforeach
                        </select><br>
                        <div class="form-group">
                            {!!Form::label('accessories','Accessories(If Any)')!!}                        
                            {!!Form::text('accs','',['class'=>'form-control','placeholder'=>'Enter Additional Accessories'])!!}                                               
                            @if ($errors->has('accs')) <p class="help-block" style="color:red">{{ $errors->first('accs') }}</p> @endif
                        </div>
                        <input type="text" name="code" placeholder="Enter Borrower's code" class="form-control" required>
                        <input type="hidden" name="id" value="{{$bSlip->id}}">
                        <input type="hidden" name="user_id" value="{{$asset_reqs->user_id}}">
                        <br>
                        <button class="btn btn-xs btn-success" type="button" id="releasebtn"> Release</button>
                        <button type="submit" class="btn btn-xs btn-success hidden" id="released"> Release</button>
                    </div>
                    {!!Form::close()!!}
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

    $('#releasebtn').click(function () {
        swal({
            title: "Are you sure?",
            text: "This Item will be released!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#released').click();
        });
    });   
@stop