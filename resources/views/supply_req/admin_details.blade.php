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
            <?php if (session('other_save')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Other data has been Added!<i class="fa fa-check"></i></h4></center>                
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
           <?php if (session('other_save_not')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Error! Please refresh page!</h4></center>   
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
                            <td style="width:30%"><i><strong>MRS NO:</strong></i></td><td>{!! $supp->req_no !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date('m/d/y',strtotime($supp->created_at)) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($supp->user->first_name.' '.$supp->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTED BY:</strong></i></td><td>{!! strtoupper($supp->user->first_name.' '.$supp->user->last_name) !!}</td>
                        </tr>                     
                        <tr>
                            <td style="width:30%"><i><strong>COMPANY:</strong></i></td><td>{!! strtoupper($supp->user->company) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($supp->user->department->department) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE:</strong></i></td><td>{!! strtoupper($supp->details) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>ADDRESS:</strong></i></td>
                            <td>
                                {!! strtoupper($supp->deliver) !!}
                            </td>
                        </tr>
                         <tr>
                            <td style="width:30%"><i><strong>VIA:</strong></i></td>
                            <td>
                                {!! strtoupper($supp->via) !!}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>VALUE:</strong></i></td>
                            <td>
                                {!! $supp->value !!}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>RECEIVED BY:</strong></i></td>
                            <td>
                                {!! strtoupper($supp->received_by) !!}
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>MANAGER:</strong></i></td>
                            <td>
                                @if($supp->manager_action < 1)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($supp->manager_action == 1)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                {!! strtoupper($supp->approver->first_name.' '.$supp->approver->last_name) !!}
                                @elseif($supp->manager_action == 2)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @elseif($supp->manager_action == 5)
                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
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
                        <tr style="width:30%">
                                <td><i><strong>DOWNLOAD:</strong></i></td>
                                <td>
                                        <a href="/mrs-generate/{{$supp->req_no}}/{{$supp->user_id}}/generate" id="{{$supp->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>
                                </td>
                            </tr>  
                    </table>
                    @if ($supp->user->first_name.' '.$supp->user->last_name 
                        !== 
                        request()->user()->first_name.' '.request()->user()->last_name)
                    <div>
                        @if($supp->status < 2 && $supp->status != 5)
                            @if(count($items) > 1)
                                <button class="btn btn-primary btnReleaseAllitems" value="{{$supp->id}}" id="btnReleaseAllitems">Release All Items</button>
                                <!-- <button class="btn btn-danger btnRejectAllitems" value="{{$supp->id}}" id="btnRejectAllitems">Reject All Items</button> -->
                            @endif
                        @endif
                    </div>
                    @endif
                    <div class="ibox-title clearfix" style="background-color:#009688">
                            <h5 style="color:white"><i class="fa fa-plus"></i> ITEMS </h5>   
                            <div class="btn-group pull-right" style="margin-bottom: 0%;">
                                @if ($supp->user->first_name.' '.$supp->user->last_name 
                                !== 
                                request()->user()->first_name.' '.request()->user()->last_name)
                                    @if ($supp->status == 1)
                                        <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#addNewItemModal"><i class="fa fa-plus"></i> Add More Items</button>
                                    @endif
                                @endif
                            </div>   
                    </div>
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>QTY REQUESTED</th>
                            <th>QTY APPROVED </th>
                            <th>QTY RELEASED</th>
                            <th>U/M</th>
                            <th>ITEM DESCRIPTION</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                        @foreach($items as $item)           
                        <tr>
                            <td>{!! $item->qty !!}</td>
                            <td>{!! $item->qty_a !!}</td>
                            <td>{!! $item->qty_r !!}</td>
                            <td>{!! strtoupper($item->measurement) !!}</td>
                            <td>{!! strtoupper($item->item) !!}</td>
                            <td>
                                @if($item->status < 2)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($item->status == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Served</span>
                                @elseif($item->status == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Out of Stock</span>
                                @elseif($item->status == 5)
                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                            <td>
                                @if ($supp->user->first_name.' '.$supp->user->last_name 
                                !== 
                                request()->user()->first_name.' '.request()->user()->last_name)
                                    @if($item->status < 2)
                                    <button class="btn btn-xs btn-primary releaseallBtn" value="{{$item->id}}|{{$item->qty_a}}" id="releaseallBtn"><i class="fa fa-angellist"></i> Release All Quantity</button>
                                    {!! Html::decode(link_to_route('supplies_request_admin.releasing',' <i class="fa fa-angellist"></i> Release Certain Quantity',$item->id, array('class'=>'btn btn-xs btn-success'))) !!}
                                    <button class="btn btn-xs btn-danger" id="rejectBtn" value="{{$item->id}}" onclick="functionReject(this)"><i class="fa fa-angellist"></i> Reject</button>
                                    @endif
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach                                 
                    </table><br>
                </div>                   
            </div>                                      
        </div>
        <div class="col-lg-6">            
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>        
                @if($supp->admin_action < 1)                     
                    {!! Form::open(array('route'=>'supplies_request_admin.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        @if ($supp->user->first_name.' '.$supp->user->last_name 
                        !== 
                        request()->user()->first_name.' '.request()->user()->last_name)
                            <div class="form-group" >
                                {!! Form::label('details','Add Your Remarks') !!}
                                {!! Form::text('details','',['class'=>'form-control','placeholder'=>'You Remarks Here...']) !!}                       
                            </div>                    
                            <div class="form-group">  
                                {!! Form::hidden('id',$supp->id) !!}          
                                @if($supp->status < 2 && $supp->status != 5)
                                    <!-- <button class="btn btn-warning" id="sendremark" type="button">Remarks</button>
                                    <button class="btn btn-warning hidden" name ="sub" value="1" id="remarksent" type="submit">Remarks Only</button> -->
                                    <button class="btn btn-success" id="approve" type="button">Close</button>
                                    <button class="btn btn-warning hidden" name ="sub" value="4" id="approvesent" type="submit">Close Request</button>
                                    <!-- <button class="btn btn-danger" id="deny" type="button">Deny</button>
                                    <button class="btn btn-warning hidden" name ="sub" value="3" id="denysent" type="submit">Deny</button> -->
                                @else
                                @endif
                            </div>   
                        @endif                   
                    </div>         
                    {!! Form::close() !!}
                @endif                                    
            </div> 
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Remarks</h5>                    
                </div>
                <div class="ibox-content inspinia-timeline" id="flow2">
                @forelse($routings as $remark)
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-briefcase"></i>
                                {!! $remark->created_at->format('M-d-Y h:i a') !!}
                                <br/>
                                <small class="text-navy">{!! $remark->created_at->diffForHumans() !!}</small>
                            </div>
                            <div class="col-xs-7 content no-top-border">
                                <p class="m-b-xs"><strong>{!! strtoupper($remark->user->first_name.' '.$remark->user->last_name ) !!}</strong></p>
                                <p><strong>{!! $remark->remarks2 !!}</strong></p>
                                <div style="margin-top: 10px;">                      
                                <p>{!! $remark->remarks !!}</p>              
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    ....No Remarks Found
                @endforelse   
                </div>
            </div>
        </div>    
                   
    </div>    
</div>
@include('supply_req.add_item')
@stop
@section('page-script')


/* data.process types:
   0 = alert data
   1 = alert url
   2 = production
*/

$('.btnReleaseAllitems').click(function () {
    
    id = $(this).val();
    var data_to_send = {
        id: id
    };
    var data = {
        swal_title: "Are you sure you want to release all of these items?",
        swal_text: "Your request will be sent",
        swal_icon: "warning",
        swal_button: "Yes, I am sure!",
        ajax_url: "/supplies_request_admin/"+id+"/release_all_items",
        ajax_type: "get",
        ajax_data: data_to_send,
        swal_success: "Items released successfully",
        process_type: 2
    };

    swal_ajax(data);
    
});


$('.btnRejectAllitems').click(function () {
    
});

$('.releaseallBtn').click(function () {
    var releaseval = $(this).val();
    var values = releaseval.split('|');
    id = values[0];
    qty = values[1];

    swal({
        title: "Are you sure you want to release all of this?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $.ajax({
              url: '/supplies_request_admin/'+id+'/release_all',
              type: "get",
              data: {id:id, qty:qty},
              success: function(response){ 
                if(response == 'S'){
                    swal(
                      'Success!',
                      'Quantity edited successfully',
                      'success'
                    )

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
              }
        });
    });
});

$('#saveOther').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#saveOtherPressed').click();
    });
});
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
        text: "This request will be closed!",
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
@section('page-javascript')
console.log("here");
function functionReject(elem){
    swal({
        title: "Are you sure?",
        text: "This supply will be rejeceted!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        var det_id = elem.value;
        $.ajax({
            type:"POST",
            dataType: 'json',
            data: {
                "id": det_id,
            },
            url: "{{ url('supplies_request_admin/reject') }}",
            success: function(data){
                var type = data.type;
                if(type == 1){
                    swal('Supply has been rejected');
                    location.reload();
                }
                if(type == 2){
                    swal('Sorry Your Request was already approved');
                    location.reload();
                }
                if(type == 3){
                    swal('Supply rejected');
                    location.reload();
                }
            }    
        });
    });
}

$('#category').on('change', function(e) {
    selection = $('#items');
    selection.empty();
    var selected = $('#category').val();
    $.ajax({
        type:"POST",
        dataType: 'json',
        data: {
            "category": selected,
        },
        url: "{{url('get_supply_category')}}",
        success: function(data){
            select = $('#items');
            select.empty();
            $.each(data.selection, function(i,text) {
                $('<option value="'+i+'">'+i+'</option>').appendTo(select);
            });
        }
    });
});
@endsection

