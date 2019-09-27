@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> MATERIAL REQUEST SLIP</h2> 
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-7 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            <?php if (session('is_error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Sending Request Failed! No item indicated!<i class="fa fa-cross"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Material Request Slip <small></small></h5>
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('QTY','Qty') !!}
                                <input type="number" class="form-control" name="qty" id="qty" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('QTY','U/M') !!}
                                <select class="form-control" id="measure">
                                    <option value="EA">EA</option>
                                    <option value="KLS">KLS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">                                                      
                            <div class="form-group">
                                {!! Form::label('supplies','Category') !!}
                                {!! Form::select('supply',$categs,'',array('class'=>'form-control','id'=>'category'))!!}
                            </div>                                                          
                        </div> 
                        <div class="col-sm-4">                                                      
                            <div class="form-group">
                                {!! Form::label('supplies','Item Description') !!}
                                <select class="form-control" data-placeholder="SELECT ITEM..." id='items'></select>
                            </div>                                                          
                        </div>                 
                        <div class="col-sm-12">
                            <div class="form-group pull-right">
                                <button class="btn btn-primary" id="add_supply" onclick="getSupplyFunction()"><i class="fa fa-plus"></i> Add Item</button>
                            </div>
                        </div>    
                    </div>
                </div>                   
            </div>             	                        
        </div>             
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Item Lists <small></small></h5>
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'supplies_request.store','method'=>'POST','files'=>true))!!}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('items','Items') !!}                                
                                <ul id=lstid>                                 
                                </ul>
                            </div>                            
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('deliver','Address (If Deliver)') !!}
                                {!! Form::text('deliver','',['class'=>'form-control','placeholder'=>'Leave blank if none...']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('via','Via') !!}
                                {!! Form::text('via','',['class'=>'form-control','placeholder'=>'Via...']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('value','Value') !!}
                                {!! Form::number('value','',['class'=>'form-control','placeholder'=>'Value...','id'=>'value_id']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('received_by','Received By') !!}
                                {!! Form::text('received_by',strtoupper(Auth::user()->first_name.' '.Auth::user()->last_name),['class'=>'form-control','placeholder'=>'Name Of Receiver']) !!}
                            </div>                           
                            <div class="form-group">
                                {!!Form::label('details','Purpose')!!}                        
                                {!!Form::textarea('details','',['class'=>'form-control','placeholder'=>'Enter Purpose here...','required'=>'required'])!!}                                               
                                @if ($errors->has('details')) <p class="help-block" style="color:red">{{ $errors->first('details') }}</p> @endif
                            </div>                                         
                            {!! Form::hidden('supplies','',['id'=>'supps']) !!}                                           
                            <div class="form-group pull-right">                               
                                <button class="btn btn-primary" type="button" id="submit">Submit</button>
                                <button class="hidden" type="submit" id="submitted"></button>
                            </div>          
                        </div>                        
                    </div>
                    {!! Form::close() !!}
                </div>                   
            </div>                                      
        </div>             
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY SUPPLIES REQUEST LISTS</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Control #</th>
                                    <th>Date</th>
                                    <th>Requested By</th>
                                    <th>Manager's Approval</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supps as $supp)
                                <tr>
                                    <td>
                                        @if($supp->status != 5)
                                        {!! Html::decode(link_to_route('supplies_request.view', $supp->req_no,$supp->id, array())) !!}
                                        @else
                                        {!! $supp->req_no !!}
                                        @endif
                                    </td>
                                    <td>
                                        {!! date('Y/m/d',strtotime($supp->created_at)) !!} {!! date('h:i a',strtotime($supp->created_at)) !!}
                                    </td>
                                    <td>{!! $supp->user->first_name.' '.$supp->user->last_name !!}</td>
                                    <td>
                                        @if($supp->manager_action < 1)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($supp->manager_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($supp->manager_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @elseif($supp->manager_action == 5)
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @endif
                                    </td>
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
                                    <td>
                                        @if($supp->status != 5)
                                        @if($supp->manager_action < 1 && $supp->admin_action < 1)
                                        <button class="btn btn-xs btn-danger" onclick="functionCancelthis(this)" value="{{$supp->id}}">Cancel</button>
                                        @endif
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
@stop
@section('page-script')
$('#value_id').keydown(function (e){
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
$('#date_must .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});

$('#qty').keydown(function (e){
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
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

$('#submit').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your Request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#submitted').click();
    });
});

$('#filer_inputs_u_access').filer({

    showThumbs:true,
    addMore:true
});

@stop
<script type="text/javascript">

    var spls = [];
    function getSupplyFunction(){
        var supply = $('#items option:selected').text();
        if(supply == null){
            swal('Please Select a supply to be requested');
        }else{
            var um = $('#measure').val();
            var qty = $('#qty').val();
            var mer = supply + '|' + qty + '|' + um;

            var ul = document.getElementById("lstid");
            var li = document.createElement("li");
            var button = document.createElement("button");
            button.innerHTML = "remove";        
            button.setAttribute("class", "btn btn-danger btn-xs");
            button.setAttribute("type", "button");
            button.setAttribute("onclick", "remFunction(this)");
            button.setAttribute("id", mer); // added line
            button.setAttribute("value", mer); // added line
            
            li.appendChild(document.createTextNode(mer));
            // li.appendChild(button);  
            li.setAttribute("id", mer); // added line
            ul.appendChild(li);

            document.getElementById('items').value = ' ';

            spls.push(mer);

            $('#supps').val(spls);
        }
        
        // var exist = document.getElementById('lstid').innerHTML;
        // document.getElementById('lstid').innerHTML = exist + mer;
    }
    
</script>
@section('page-javascript')

    function functionCancelthis(elem){
        var supp_id = elem.value;
        swal({
            title: "Are you sure?",
            text: "Your request will be canceled!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            var supp_id = elem.value;
            $.ajax({
                type:"POST",
                dataType: 'json',
                data: {
                    "id": supp_id,
                },
                url: "{{url('supplies_request/cancel')}}",
                success: function(data){            
                    var type = data.type;
                    if(type == 1){
                        swal('You have canceled your request!');
                        location.reload();
                    }
                    if(type == 2){
                        swal('Sorry but your request was already approved!');
                        location.reload();
                    }
                    if(type == 3){
                        swal('Sorry cannot process your request right now');
                        location.reload();
                    }
                }    
            });
        });
    }
@stop