@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> GATEPASS DETAILS</h2>       
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>{{ session()->get('is_success') }} <i class="fa fa-check"></i></h4></center>
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
                    <center>
                    <h4>Oh snap! You got an error!</h4>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </center>   
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
                            <td style="width:30%"><i><strong>ASSIGNEE:</strong></i></td><td>{!! strtoupper($gatepass->requested_by) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REQUESTED BY:</strong></i></td><td>{!! strtoupper($gatepass->user->first_name.' '.$gatepass->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($gatepass->user->first_name.' '.$gatepass->user->last_name) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>CONTROL NO:</strong></i></td><td>{!! strtoupper($gatepass->control_no) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>COMPANY:</strong></i></td><td>{!! strtoupper($gatepass->company) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date('m/d/y',strtotime($gatepass->date)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DEPARTMENT:</strong></i></td><td>{!! strtoupper($gatepass->department) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>EXIT IN GATE NO:</strong></i></td><td>{!! strtoupper($gatepass->exit_gate_no) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>REF NO:</strong></i></td><td>{!! strtoupper($gatepass->ref_no) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>FILES:</strong></i></td>
                            <td>
                                @if(!empty($files))
                                @foreach($files as $filer)
                                    {!! Form::open(array('route'=>'gatepass.download','method'=>'POST')) !!}
                                        {!! Form::hidden('filename',$filer->filename) !!}
                                        {!! Form::hidden('id',$filer->gate_pass_id) !!}
                                        {!! Form::submit($filer->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}                                          
                                    {!! Form::close() !!}         
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE:</strong></i></td><td>{!! strtoupper($gatepass->purpose) !!}</td>
                        </tr>
                        <tr>
                                <td style="width:30%"><i><strong>NOTED BY:</strong></i></td><td>
                                    @if(!empty($gatepass->approve_for_release))
                                    {!! strtoupper($gatepass->approver->first_name.' '.$gatepass->approver->last_name) !!}
                                    @else
                                    <strong>-</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%"><i><strong>ADMIN ASSISTANT STATUS:</strong></i></td>
                                <td>
                                    @if($gatepass->approval < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($gatepass->approval == 1)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @elseif($gatepass->approval == 3)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                    @endif
                                    
                                </td>
                            </tr>
                            <tr>
                                    <td style="width:30%"><i><strong>APPROVED BY:</strong></i></td><td>
                                        @if(!empty($gatepass->issue))
                                        {!! strtoupper($gatepass->issue->first_name.' '.$gatepass->issue->last_name) !!}
                                        @else
                                        <strong>-</strong>
                                        @endif
                                    </td>
                                </tr>
                            <tr>
                                <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                                <td>
                                    @if($gatepass->status < 2)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($gatepass->status == 2)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @elseif($gatepass->status == 3)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                    @elseif($gatepass->status == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                    @endif
                                </td>
                            </tr>
                            @if($gatepass->status != 5 && !empty($gatepass->approval == 1))
                            <tr>
                                <td style="width:30%"><i><strong>DOWNLOAD PDF:</strong></i></td>
                                <td>
                                    <a href="/gatepass/{{$gatepass->id}}/{{$gatepass->user_id}}/generate" id="{{$gatepass->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a>
                                </td>
                            </tr>
                            @endif
                        {{-- <tr>
                            <td style="width:30%"><i><strong>NOTED BY:</strong></i></td><td>
                                @if(!empty($gatepass->issue))
                                {!! strtoupper($gatepass->issue->first_name.' '.$gatepass->issue->last_name) !!}
                                @else
                                <strong>-</strong>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>APPROVER STATUS:</strong></i></td>
                            <td>
                                @if($gatepass->approval < 1)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($gatepass->approval == 1)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($gatepass->approval == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @endif
                                
                            </td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($gatepass->status < 2)
                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                @elseif($gatepass->status == 2)
                                <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                @elseif($gatepass->status == 3)
                                <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                @elseif($gatepass->status == 5)
                                <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                @endif
                            </td>
                        </tr> --}}
                    </table>
                    <div class="ibox-title clearfix" style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-plus"></i> ITEMS </h5>   
                        <div class="btn-group pull-right" style="margin-bottom: 0%;">
                            @if ($gatepass->status == 1)
                                <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#addNewItemModal"><i class="fa fa-plus"></i> Add More Items</button>
                            @endif
                        </div>   
                    </div>
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>ITEM NO.</th>
                            <th>QTY</th>
                            <th>U/M</th>
                            <th>ASSET NO./SERIAL NUMBER/REFERENCE NUMBER</th>
                            <th>Description</th>
                            <th>Purpose</th>
                        </tr>
						<?php $count = 0;?>
                        @foreach($details as $detail)
						<?php $count++;?>
                        <tr>
                            <td>{!! $count."." !!}</td>
                            <td>
                                @if($gatepass->approval < 1)
                                <div class="normalcol">
                                    <span class="span_qty">{!! $detail->item_qty !!}</span>
                                    <button type="button" class="btn btn-warning btn-xs pull-right btneditqty">Edit</button>
                                </div>

                                <div class="editform hidden">
                                    <div class="input-group">
                                            {!! Form::hidden('value', $detail->id, ['class'=>'hiddeneditid']) !!}
                                            {!! Form::number('value',$detail->item_qty,['class'=>'input-sm form-control numberqty','required','placeholder'=>'Value...','id'=>'value_id']) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-warning btn-sm saveqtyedit" id="saveqtyedit" type="submit">Save</button>
                                            <button class="btn btn-danger btn-sm cancelqtyedit"  id="cancelqtyedit" type="button">Cancel</button>
                                        </span>
                                    </div>
                                </div>
                                
                                @else
                                {!! $detail->item_qty !!}
                                @endif
                            </td>
                            <td>{!! strtoupper($detail->item_measure) !!}</td>
                            <td>{!! strtoupper($detail->description) !!}</td>
                            <td>{!! $detail->description2 !!}</td>
                            <td>{!! $detail->remarks !!}</td>
                        </tr>
                        @endforeach                                 
                    </table>                                         
                </div>                  
            </div>                                      
        </div>
        <div class="col-lg-6">            
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>        
                @if($gatepass->status < 2)                     
                    {!! Form::open(array('route'=>'gatepass.remarks','method'=>'POST','files'=>true)) !!}                
                    <div class="ibox-content">
                        <div class="form-group" >
                            {!! Form::label('remarks','Add Your Remarks') !!}
                            {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                        </div>                    
                        <div class="form-group">  
                            {!! Form::hidden('id',$gatepass->id) !!}          
                            @if($gatepass->status < 2 && $gatepass->status != 5)
                                <button class="btn btn-warning" id="sendremark" type="button">Remarks</button>
                                <button class="btn btn-warning hidden" name ="sub" value="1" id="remarksent" type="submit">Remarks Only</button>
                            @else
                            @endif
                            @if($gatepass->status != 2 && $gatepass->status != 5)
                                <button class="btn btn-danger cancelgp" id="cancel" type="button"> Cancel Gatepass</button>  
                            @endif  
                        </div>                      
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
                                <p>{!! $remark->remark !!}</p>              
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

  <!-- Detail Modal Modal -->
  <div class="modal fade" id="addNewItemModal" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->       
        <div class="modal-content">         
          <div class="modal-header">         
            <button type="button" class="close" data-dismiss="modal">&times;</button>           
            <h4 class="modal-title">Add New Item</h4></div>         
            <div class="modal-body">    
                {!!Form::open(array('route'=>'gatepass.addNewItem','method'=>'POST','files'=>true, 'class' => 'form-horizontal calender'))!!} 
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Quantity</label>
                            <div class="col-sm-9">
                                    <input type="hidden" class="form-control" name="gate_pass_id" id="gate_pass_id"  value="{{$gatepass->id}}">
                                    <input type="number" class="form-control" name="item_qty" id="na_qty_id" min="1" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">U/M</label>
                            <div class="col-sm-9">
                                    <select class="form-control" name="item_measure" id="na_um_id">
                                            <option value="EA">EA</option>
                                            <option value="KLS">KLS</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item No.</label>
                            <div class="col-sm-9">
                                    {!! Form::text('item_no','',['class'=>'form-control','id'=>'na_item_no']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Asset Number/Serial Number/Reference Number if any</label>
                            <div class="col-sm-9">
                                    {!! Form::text('description','',['class'=>'form-control','id'=>'na_item_id']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                        {!! Form::text('description2','',['class'=>'form-control','id'=>'na_item_desc']) !!}
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">Purpose</label>
                                <div class="col-sm-9">
                                        {!! Form::text('remarks','',['class'=>'form-control','id'=>'na_item_purpose']) !!}
                                </div>
                        </div>
                    </div>
                <div class="modal-footer" style="margin:0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="send" type="submit" class="btn btn-primary">Save</button>
                </div>
            {!! Form::close() !!} 
            </div>
      </div>
          
        </div>
      </div>
@stop
@section('page-script')
    $('.cancelgp').click(function () {
        swal({
            title: "Are you sure you want to cancel your request?",
            text: "Your request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $.ajax({
                  url: '/gatepass/{{$gatepass->id}}/cancel',
                  type: "get",
                  data: {id:'{{$gatepass->id}}',type:"0"},
                   success: function(response){ 
                    window.location = response.url;
                }
                });
        });
    }); 

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

    swal({
        title: "Are you sure you want to edit the quantity of this item?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $.ajax({
              url: '/gatepass/{{$detail->id}}/edit_gatepass_item_quantity',
              type: "get",
              data: {id:id, newqty:newqty},
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
@endsection
