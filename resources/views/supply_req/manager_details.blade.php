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
            <?php if (session('is_denied')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been denied!<i class="fa fa-check"></i></h4></center>                
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
                    <div class="ibox-title clearfix" style="background-color:#009688">
                            <h5 style="color:white"><i class="fa fa-plus"></i> ITEMS </h5>   
                            <div class="btn-group pull-right" style="margin-bottom: 0%;">
                                @if ($supp->manager_action == 0)
                                @if ($supp->user->first_name.' '.$supp->user->last_name 
                                        !== 
                                    request()->user()->first_name.' '.request()->user()->last_name)
                                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#addNewItemModal"><i class="fa fa-plus"></i> Add More Items</button>
                                @endif
                                @endif
                            </div>   
                    </div>
                    @if ($items)
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>QTY</th>
                            <th>QTY APPROVED</th>
                            <th>ITEM</th>
                        </tr>
                        @foreach($items as $item)
                        @if ($item)
                        <tr>
                            <td>
                                @if ($supp->user->first_name.' '.$supp->user->last_name 
                                !== 
                                request()->user()->first_name.' '.request()->user()->last_name)
                                    @if($supp->manager_action < 1)
                                    <div class="normalcol">
                                        <span class="span_qty">{!! $item->qty !!}</span>
                                        <button type="button" class="btn btn-warning btn-xs pull-right btneditqty">Edit</button>
                                    </div>

                                    <div class="editform hidden">
                                        <div class="input-group">
                                                {!! Form::hidden('value', $item->id, ['class'=>'hiddeneditid']) !!}
                                                {!! Form::number('value',$item->qty,['class'=>'input-sm form-control numberqty','required','placeholder'=>'Value...','id'=>'value_id']) !!}
                                            <span class="input-group-btn">
                                                <button class="btn btn-warning btn-sm saveqtyedit" id="saveqtyedit" type="submit">Save</button>
                                                <button class="btn btn-danger btn-sm cancelqtyedit"  id="cancelqtyedit" type="button">Cancel</button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @else
                                    {!! $item->qty !!}
                                    @endif
                                    @else
                                {!! $item->qty !!}
                                @endif

                            </td>
                            <td>
                                {!! $item->qty_a !!}
                            </td>
                            <td>{!! strtoupper($item->item) !!}</td>
                        </tr>
                        @endif           
                        @endforeach                                 
                    </table>
                    @endif
                     <br>
                </div>                   
            </div>                                       
        </div>
        <div class="col-lg-6">            
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> ADD REMARKS <small></small></h5>          
                </div>        
                @if($supp->manager_action < 1)                     
                    {!! Form::open(array('route'=>'supplies_request_head.remarks','method'=>'POST','files'=>true)) !!}                
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
                                {!! Form::label('approve','Approve') !!}
                                <p style="font-size: 15px;">
                                    <input type="radio" name="sub" value="2" id="sub"> <strong>YES</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="sub" value="3" id="sub2"> <strong>NO</strong>
                                </p>
                                <button class="btn btn-warning" id="send" type="button"> Save</button>  
                                @else
                                @endif
                                <button class="hidden" id="sent" type="submit"></button> 
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
$(".btneditqty").click(function(){
    var parent = $(this).parent();

    parent.addClass('hidden');
    parent.next().removeClass('hidden');

}); 

$(".cancelqtyedit").click(function(){
    var getclass = $(this).closest("td");
    var qty = getclass.find(".span_qty").text();

    getclass.find(".editform").addClass("hidden");
    getclass.find(".normalcol").removeClass("hidden");
    getclass.find(".numberqty").val(qty);

}); 

$('.saveqtyedit').click(function () {
    var closest = $(this).closest("td");
    var newqty =  closest.find(".numberqty").val();
    var id = closest.find(".hiddeneditid").val();
    var type = 2;
    swal({
        title: "Are you sure you want to edit the quantity of this item?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $.ajax({
              url: '/supplies_request/{{isset($item) ? $item->id : '0'}}/edit_item_quantity',
              type: "get",
              data: {id:id, newqty:newqty, type:type},
              success: function(response){ 
                if(response == 'S'){

                    closest.find(".editform").addClass("hidden");
                    closest.find(".normalcol").removeClass("hidden");
                    closest.find(".span_qty").text(newqty);
                    
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
        text: "This request will be approved!",
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
$('#send').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your remarks will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        if($('#sub').is(':checked') || $('#sub2').is(':checked')){
            $('#sent').click();
        }else{
            setTimeout(function() {
                swal('Please Select Transaction Status!');
            },400)
        }
    });
});

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
