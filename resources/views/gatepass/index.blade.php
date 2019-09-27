@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> GATEPASS FORM</h2> 
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-md-12 animated flash">
            <?php if (session('is_canceled')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been cancelled! <i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php Session::forget('is_canceled');?>

        </div>

        <div class="col-md-12animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted! <i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <?php if (!empty($is_overtime)): ?>
        <div class="col-md-12 animated flash">
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                <center><h4>Sorry but the it is past the filing time for Gate Pass!<i class="fa fa-check"></i></h4></center>                
            </div>
        </div>
        <?php endif;?>
        <div class="col-md-12 animated flash">
            <?php if (session('is_error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Sending Request Failed! Please fill the fields correctly!<i class="fa fa-cross"></i></h4></center>                
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
        {!!Form::open(array('route'=>'gatepass.store','method'=>'POST','files'=>true))!!} 
        <div class="col-lg-12" id="formdiv">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <!-- <h5 style="color:white"><i class="fa fa-plus"></i> Item Lists <small></small></h5> -->
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!!Form::label('user','Assignee')!!} 
                                {!!Form::text('requested_by',$user->first_name.' '.$user->last_name,['class'=>'form-control','required'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('company','Company')!!} 
                                {!!Form::text('company',$user->company,['class'=>'form-control',''])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('dept','Department')!!} 
                                {!!Form::text('dept',$user->department->department,['class'=>'form-control','readonly'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('ref','Reference No.')!!} 
                                {!!Form::text('ref_no','',['class'=>'form-control','required','placeholder'=>'Enter Reference Number'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('purpose','Remarks')!!}                        
                                {!!Form::text('purpose','',['class'=>'form-control','placeholder'=>'Enter Remarks','required'=>'required'])!!}                                               
                                @if ($errors->has('details')) <p class="help-block" style="color:red">{{ $errors->first('details') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                         {{--<div>
                                {!!Form::label('date', 'Date')!!} <label style="color: red"><i>*Required</i></label>
                                <div class="form-group" id="date_must">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" value="" name="date" required="" id="input_text">
                                    </div>
                                </div>s
                            </div> --}}
                            <div class="form-group">
                                {!!Form::label('exit_gate','Exit in Gate No.')!!} 
                                {!!Form::select('exit_gate_no',$gates,'',['class'=>'form-control','required','placeholder'=>'Choose Gate No.'])!!}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            {!! Form::hidden('det','',['id'=>'assDet']) !!}                                           
                            {!! Form::hidden('nadet','',['id'=>'na_assDet']) !!}          
                        </div>                        
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        {!! Form::label('non_asset_qty','Qty') !!}
                                        <input type="number" class="form-control" name="na_quantity" id="na_qty_id" min="1" value="1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('non_asset_um','U/M') !!}
                                        <select class="form-control" name="na_quantity" id="na_um_id">
                                            <option value="EA">EA</option>
                                            <option value="KLS">KLS</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">                                                      
                                    <div class="form-group">
                                        {!! Form::label('non_asset_item_no','Item No.') !!}
                                        {!! Form::text('na_item_no','',['class'=>'form-control','id'=>'na_item_no']) !!}
                                    </div>                                                          
                                </div> --}}
                                <div class="col-md-6">                                                      
                                    <div class="form-group">
                                        {!! Form::label('non_asset_Id','Asset Number/Serial Number/Reference Number if any') !!}
                                        {!! Form::text('na_item_id','',['class'=>'form-control','id'=>'na_item_id']) !!}
                                    </div>                                                          
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-5">                                                      
                                    <div class="form-group">
                                        {!! Form::label('non_asset_desc','Description') !!}
                                        {!! Form::text('na_item_desc','',['class'=>'form-control','id'=>'na_item_desc']) !!}
                                    </div>                                                          
                                </div>
                                <div class="col-md-5">                                                      
                                    <div class="form-group">
                                        {!! Form::label('non_asset_purpose','Purpose') !!}
                                        {!! Form::text('na_item_purpose','',['class'=>'form-control','id'=>'na_item_purpose']) !!}
                                    </div>                                                          
                                </div>                
                                <div class="col-md-1 pull-right">
                                    <div class="form-group">
                                        <br>
                                        <button class="btn btn-info" type="button" id="add_na_id" onclick="getNonAssetFunction()"><i class="fa fa-plus"> </i> Add</button>
                                    </div>
                                </div>  
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('items','Item/s Breakdown') !!}                                
                                <ul id=lstid>                                 
                                </ul>
                            </div>                            
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('attached','Attached File')!!}
                            {!! Form::file('attached[]', array('id' => 'message_filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group pull-right">                               
                                <button class="btn btn-primary" type="button" id="submitBtn">Submit</button>
                                <button class="hidden" type="submit" id="submitBtnPressed"></button>
                            </div>
                        </div>
                    </div>
                </div>                   
            </div>             	                        
        </div>
        {!! Form::close() !!} 
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY GATEPASS LIST</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Control #</th>
                                    <th>Noted By</th>
                                    <th>Admin Assistant Status</th>
                                    <th>Released By</th>
                                    <th>Admin Manager Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($gps as $gp)
                                    <tr>
                                        <td>
                                            {!! date('Y/m/d',strtotime($gp->date)) !!}
                                        </td>
                                        <td>
                                            @if($gp->status != 5)
                                            {!! Html::decode(link_to_route('gatepass.show', $gp->req_no,$gp->id, array())) !!}
                                            @else
                                            {!! $gp->req_no !!}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($gp->approve_for_release))
                                                {!! $gp->approver->first_name.' '.$gp->approver->last_name !!}
                                            @else
                                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($gp->approval < 1)
                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                            @elseif($gp->approval == 1)
                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Noted</span>
                                            @elseif($gp->approval == 3)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($gp->issue_by)
                                                {!! $gp->issue->first_name.' '.$gp->issue->last_name !!}
                                            @else
                                                <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($gp->status < 2)
                                            <span class="label label-warning"> <i class="fa fa-angellist"></i> Pending</span>
                                            @elseif($gp->status == 2)
                                            <span class="label label-primary"> <i class="fa fa-angellist"></i> Approved</span>
                                            @elseif($gp->status == 3)
                                            <span class="label label-danger"> <i class="fa fa-angellist"></i> Denied</span>
                                            @elseif($gp->status == 5)
                                            <span class="label label-info"> <i class="fa fa-angellist"></i> Canceled</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($gp->status != 5 && !empty($gp->approval == 1))
                                            {{-- <a href="http://pdf-generator.davies-helpdesk.com/gatepass/{{$gp->id}}/{{$gp->user_id}}/generate" id="{{$gp->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a> --}}
                                            <a href="/gatepass/{{$gp->id}}/{{$gp->user_id}}/generate" id="{{$gp->id}}" target="__blank"><button class="btn btn-primary btn-xs">Download</button></a>
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

$(document).ready(function(){
    console.log('checking time');
    TimeCheck();
});
function TimeCheck() {
    var d = new Date();
    var n = d.getHours();
    if(n > 15){
        console.log('sorry lagpas na');
        $("#formdiv").addClass("hidden");
    }
}


$('#message_filer_inputs').filer({
    showThumbs:true,
    addMore:true
})
$('input[type="text"]').keydown(function(e) {
    var ignore_key_codes = [192,189];
    if($.inArray(e.keyCode, ignore_key_codes) >= 0){
        e.preventDefault();
    }
});

$("input").on("paste", function(e) { 
    var pastedData = e.originalEvent.clipboardData.getData('text');
    if(pastedData.indexOf('-')!=-1){
        swal('Invalid Character - ');
        e.preventDefault();
    }  
});

$('#input_text').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});

$('#qty_id').keydown(function (e){
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
$('#na_qty_id').keydown(function (e){
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

$('#submitBtn').on('click', function () {
    swal({
        title: "Are you sure?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#submitBtnPressed').click();
    });
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

@stop
<script type="text/javascript">
    var ar = [];
    var non_ar = [];
    function getNonAssetFunction(){
        var na_qty = $('#na_qty_id').val();
        var na_um = $('#na_um_id').val();
        // var na_item_no = $('#na_item_no').val();
        var na_item = $('#na_item_id').val();
        var na_item_desc = $('#na_item_desc').val();
        var na_item_purpose = $('#na_item_purpose').val();



        if(na_item == ''){
            swal('Item Description not be null');
        }else{
            var na_mer = '' + '|' + na_qty + '|' + na_um + '|' + na_item + '|' + na_item_desc + '|' + na_item_purpose;

            var na_set = '' + ' - ' + na_qty + ' - ' + na_um + ' - ' + na_item + ' - ' + na_item_desc+ ' - ' + na_item_purpose;

            var ul = document.getElementById("lstid");
            var li = document.createElement("li");
            var button = document.createElement("button");
            button.innerHTML = "remove";        
            button.setAttribute("class", "btn btn-danger btn-xs");
            button.setAttribute("type", "button");
            button.setAttribute("onclick", "remFunction(this)");
            button.setAttribute("id", na_set); // added line
            button.setAttribute("value", na_set); // added line
            
            li.appendChild(document.createTextNode(na_set));
            // li.appendChild(button);  
            li.setAttribute("id", na_set); // added line
            ul.appendChild(li);

            document.getElementById('na_qty_id').value = 1;

            non_ar.push(na_mer);
            $('#na_item_id').val('');
            // $('#na_item_no').val('');
            $('#na_assDet').val(non_ar);
            $('#na_item_desc').val('');
            $('#na_item_purpose').val('');
        }
        // var exist = document.getElementById('lstid').innerHTML;
        // document.getElementById('lstid').innerHTML = exist + mer;
    }
    function getAssetFunction(){

        var item = $('#assets_id').val();
        var res = item.split('|');
        
        var mer = res[0] + ' - 1 ' + '- EA ' + ' - ' + res[1];
        var mer_two = res[0] + '|1' + '|EA' + '|' + res[1];

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

        ar.push(mer_two);

        $('#assDet').val(ar);
        
        // var exist = document.getElementById('lstid').innerHTML;
        // document.getElementById('lstid').innerHTML = exist + mer;
    }

    function remFunction(elem){

        ar = jQuery.grep(ar, function(value) {
          return value != elem.id;
        });

        alert(ar);
        $('#assDet').val(ar);
    }
    
</script>
@section('page-script')

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });

@stop