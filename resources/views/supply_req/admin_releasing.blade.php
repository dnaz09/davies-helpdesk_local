@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> MATERIAL REQUEST DETAILS</h2>       
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
            <?php if (session('no_remarks')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Error! remarks field is empty!</h4></center>   
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">            
                        <tr>
                            <td style="width:30%"><i><strong>REQUEST #:</strong></i></td><td>{!! $item->req->req_no !!}</td>
                        </tr>                     
                        <tr>
                            <td style="width:30%"><i><strong>DETAILS:</strong></i></td><td>{!! strtoupper($item->req->details) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTOR:</strong></i></td><td>{!! strtoupper($item->req->user->first_name.' '.$item->req->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($item->status < 2)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($item->status == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Released</span>
                                @elseif($item->status == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Out of Stock</span>
                                @elseif($item->status == 5)
                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                        </tr>                                                    
                    </table>                                      
                </div>
            </div>                                      
        </div>      
    </div>    
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">        
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> RELEASE <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'supplies_request_admin.release','method'=>'POST'))!!}
                    <div class="row">
                        <div class="col-md-4">
                            {!! Form::label('item','Item')!!}
                            <input type="text" value="{{$item->item}}" readonly="" class="form-control">
                        </div>
                        {!!Form::hidden('id',$item->id)!!}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('QTY','Qty to Release')!!}
                                <select class="form-control" name="qty_r" required>
                                    @foreach($qtys as $qty)
                                    <option value="{{$qty}}">{{$qty}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="button" id="approve"> Release</button>
                            <button class="hidden" type="submit" id="approvesent"></button>
                        </div>
                    </div>
                    {!!Form::close()!!}                                        
                </div>                   
            </div>                                      
        </div>      
    </div>    
</div>   
@stop
@section('page-script')
$('#sendremark').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#remarksent').click();
    });
});
$('#approve').click(function () {
    swal({
        title: "Are you sure?",
        text: "This supply will be released!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#approvesent').click();
    });
});
$('#deny').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be denied!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#denysent').click();
    });
});
@endsection
