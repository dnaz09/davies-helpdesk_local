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
                    <center><h4>Success! <i class="fa fa-check"></i></h4></center>                
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
                    <h5 style="color:white"><i class="fa fa-plus"></i>REQUEST DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width:30%"><i><strong>FILED BY:</strong></i></td><td>{!! strtoupper($asset_reqs->user->first_name.' '.$asset_reqs->user->last_name) !!}</td>
                            <td style="width:30%"><i><strong>BORROWER'S SLIP NO:</strong></i></td><td>{!! strtoupper($asset_reqs->req_no) !!}</td>
                        </tr>                       
                        <tr>
                            <td style="width:30%"><i><strong>BORROWED BY:</strong></i></td><td>{!! strtoupper($asset_reqs->borrower_name) !!}</td>
                            <td style="width:30%"><i><strong>DATE FILED:</strong></i></td><td>{!! date('m/d/y',strtotime($asset_reqs->created_at)) !!}</td>
                        </tr>                                                                   
                        <tr>
                            <td style="width:30%"><i><strong>PURPOSE:</strong></i></td><td>{!! strtoupper($asset_reqs->details) !!}</td>
                            <td style="width:30%"><i><strong>SUPERIOR STATUS:</strong></i></td>
                            <td>
                                @if($asset_reqs->sup_action < 2)
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
                            <td style="width:30%"><i><strong>DATE NEEDED:</strong></i></td>
                            <td>
                                @if($asset_reqs->slip->date_needed != '')
                                {!! date('Y/m/d',strtotime($asset_reqs->slip->date_needed))!!}
                                @endif
                            </td>
                            <td style="width:30%"><i><strong>DATE RETURN:</strong></i></td>
                            <td>{!! date('Y/m/d',strtotime($asset_reqs->slip->must_date)) !!}</td>
                        </tr>
                        <tr>
                            <td style="width:30%"><i><strong>DOWNLOAD:</strong></i></td>
                            <td>
                                @if($asset_reqs->status != 5)
                                    @if($asset_reqs->sup_action == 2)
                                    {{-- <a href="http://pdf-generator.davies-helpdesk.com/borrower_slip/{{$asset_req->req_no}}/{{$asset_req->user_id}}/generate" id="{{$asset_req->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a> --}}
                                    <a href="/borrower_slip/{{$asset_reqs->req_no}}/{{$asset_reqs->user_id}}/generate" id="{{$asset_reqs->id}}" target="__blank"><span class="label label-primary"><i class="fa fa-check"></i> Download</span></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>                      
                </div>                   
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> LIST OF ITEMS</h5>  
                </div> 
                <div class="ibox-content"> 
                        <table class="table table-hover table-bordered">
                            <tr>      
                                <th>ITEM NAME</th>                                
                                <th>QTY</th>
                                @if ($asset_reqs->sup_action < 2)
                                    <th>ACTION</th>
                                @endif
                            </tr>
                            <tbody> 
                                @foreach($asset_reqs->dets as $det)
                                <tr>
                                    <td>{!! $det->item_name !!}</td>
                                    <td>
                                            @if($asset_reqs->sup_action < 2)
                                            <div class="normalcol">
                                                <span class="span_qty">{!! $det->qty !!}</span>
                                                <button type="button" class="btn btn-warning btn-xs pull-right btneditqty">Edit</button>
                                            </div>

                                            <div class="editform hidden">
                                                <div class="input-group">
                                                        {!! Form::hidden('value', $det->id, ['class'=>'hiddeneditid']) !!}
                                                        {!! Form::number('value',$det->qty,['class'=>'input-sm form-control numberqty','required','placeholder'=>'Value...','id'=>'value_id']) !!}
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-warning btn-sm saveqtyedit" id="saveqtyedit" type="submit">Save</button>
                                                        <button class="btn btn-danger btn-sm cancelqtyedit"  id="cancelqtyedit" type="button">Cancel</button>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            @else
                                            {!! $det->qty !!}
                                            @endif
                                </td>
                                @if ($asset_reqs->sup_action < 2)
                                    <td>
                                    <button class ="btn btn-danger btn-xs removeItem" value = "{{ $det->id }}">Remove</button>
                                    </td> 
                                @endif
                                </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                        @if($asset_reqs->sup_action == 2 && $asset_reqs->status != 5)
                        <h3>RELEASING OF ASSETS</h3>
                        <p><b>Note:</b> Click here to release the assets</p>
                        {!! Html::decode(link_to_Route('asset_request.showrelease','<i class="fa fa-pencil"></i> Release Assets', $asset_reqs->req_no, array('class' => 'btn btn-warning btn-xs')))!!}
                        @endif   

                </div>
            </div>                                      
        </div> 
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i>ADD REMARKS <small></small></h5>          
                </div>
                @if($asset_reqs->sup_action < 2 && $asset_reqs->status != 5)  
                {!! Form::open(array('route'=>'asset_request.remarks','method'=>'POST','files'=>true)) !!}
                <div class="ibox-content">
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('attached','Attached File')!!}
                            {!! Form::file('attached[]', array('id' => 'filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                        </div>
                    </div>
                    <div class="form-group">  
                        {!! Form::hidden('request_id',$asset_reqs->id) !!}                               
                        {!! Form::hidden('ticket_no',$asset_reqs->req_no) !!}                                                   
                        <button class="btn btn-warning" id="remarksonly" type="button"> Remarks</button>
                        <button class="btn btn-warning hidden" id="remarksent" name ="sub" value="1" type="submit">Remarks Only</button>
                        <button class="btn btn-primary" id="resolvedonly" type="button"> Mark as Resolved</button>
                        <button class="btn btn-primary hidden" id="resolvedsent" name ="sub" value="2" type="submit">Mark as Resolved</button>
                    </div>                      
                </div> 
                {!! Form::close() !!}                  
                @else
                @endif
            </div> 
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Remarks</h5>                    
                </div>

                <div class="ibox-content inspinia-timeline" id="flow2">
                @forelse($remarks as $remark)
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
                                <p>{!! $remark->details !!}</p>                                
                                <div>
                                    @if(!empty($remark->files))
                                        @foreach($remark->files as $filer)
                                            {!! Form::open(array('route'=>'asset_request.remarks_download_files','method'=>'POST', 'target'=>'_blank')) !!}
                                            {!! Form::hidden('encname',$filer->encryptname) !!}
                                            {!! Form::submit($filer->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}                                                                                                  
                                            {!! Form::close() !!}                                                                                                                                         
                                        @endforeach
                                    @endif
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
@stop
@section('page-script')

    $(".removeItem").click(function(){
        id = $(this).val();
        console.log(id);
        var data_to_send = {
            id: id
        };
        var data = {
            swal_title: "Are you sure you want to remove this item?",
            swal_text: "Your request will be sent",
            swal_icon: "warning",
            swal_button: "Yes, I am sure!",
            ajax_url: "/asset_request/"+id+"/removeItem",
            ajax_type: "get",
            ajax_data: data_to_send,
            swal_success: "Item removed successfully",
            process_type: 2
        };
    
        swal_ajax(data);
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
                url: '/asset_request/{{$asset_reqs->id}}/editquantity',
                type: "get",
                data: {id:id, newqty:newqty},
                success: function(response){
                    console.log(response); 
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

    $('#filer_inputs').filer({

        showThumbs:true,
        addMore:true
    }); 

$('#remarksonly').click(function () {
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

$('#resolvedonly').click(function () {
    swal({
        title: "Are you sure?",
        text: "This request will be resolved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#resolvedsent').click();
    });
});   
@stop