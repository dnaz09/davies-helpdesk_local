@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> BORROWER'S SLIP</h2> 
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
                    <center><h4>Sending Request Failed! Please fill the fields correctly!<i class="fa fa-cross"></i></h4></center>                
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
        {!!Form::open(array('route'=>'asset_request.store','method'=>'POST','files'=>true))!!} 
        <div class="col-md-8">
            <table class="table table-hover table-bordered">
                <tr>
                    <td style="width:30%;background-color: white"><i><strong>BORROWER'S NAME:</strong></i></td>
                    <td>
                        {!!Form::text('borrower_name',$user->first_name.' '.$user->last_name,['class'=>'form-control'])!!}
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <table class="table table-hover table-bordered">
                <tr style="background-color: white">
                    <td style="width:30%"><i><strong>DATE:</strong></i></td><td>{!! date('m/d/y') !!}</td>
                </tr>
            </table>
        </div> 
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <!-- <h5 style="color:white"><i class="fa fa-plus"></i> Borrowers Request Form <small></small></h5> -->
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('qty','Qty') !!}
                                <input type="number" class="form-control" name="quantity" id="qty_id" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-sm-6">                                                      
                            <div class="form-group">
                                {!! Form::label('asset_id','Item Description') !!}
                                {!! Form::select('asset_id',$assets,'',['class'=>'form-control','id'=>'item_id']) !!}
                            </div>                                                          
                        </div>                
                        <div class="col-sm-12">
                            <div class="form-group pull-right">
                                <button class="btn btn-info" type="button" id="add_id" onclick="getAssetFunction()"><i class="fa fa-plus"> Add</i></button>
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('non_asset_qty','Qty') !!}
                                <input type="number" class="form-control" name="na_quantity" id="na_qty_id" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-sm-6">                                                      
                            <div class="form-group">
                                {!! Form::label('non_asset_Id','Non Asset Item Description') !!}
                                {!! Form::text('na_item_id','',['class'=>'form-control','id'=>'na_item_id']) !!}
                            </div>                                                          
                        </div>                
                        <div class="col-sm-12">
                            <div class="form-group pull-right">
                                <button class="btn btn-info" type="button" id="add_na_id" onclick="getNonAssetFunction()"><i class="fa fa-plus"> Add</i></button>
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
                </div>                   
            </div>             	                        
        </div>             
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <!-- <h5 style="color:white"><i class="fa fa-plus"></i> Item Lists <small></small></h5> -->
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            <div class="form-group">
                                {!!Form::label('purpose','Purpose')!!}                        
                                {!!Form::textarea('details','',['class'=>'form-control','placeholder'=>'Enter Purpose','required'=>'required'])!!}                                               
                                @if ($errors->has('details')) <p class="help-block" style="color:red">{{ $errors->first('details') }}</p> @endif
                            </div>
                             <div>
                                {!!Form::label('date', 'Date Needed')!!} <label style="color: red"><i>*Required</i></label>
                                <div class="form-group" id="date_must">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" value="" name="date_needed" required="" id="input_text">
                                    </div>
                                </div>
                            </div>
                            <div>
                                {!!Form::label('date', 'Return Date')!!} <label style="color: red"><i>*Required</i></label>
                                <div class="form-group" id="date_must">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" value="" name="must_date" required="" id="input_text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!!Form::label('getBY','Full name of the person who will pick-up the item/s (SURNAME, FIRST NAME)')!!}<strong><p>(Leave blank if none)</p></strong>                   
                                {!!Form::text('get_by','',['class'=>'form-control','placeholder'=>'Surname, First Name'])!!}                                               
                                @if ($errors->has('get_by')) <p class="help-block" style="color:red">{{ $errors->first('get_by') }}</p> @endif
                            </div>
                            <div class="col-lg-12">
                                <p><input type="checkbox" required> I agree to the <a data-toggle="modal" data-target="#termsModal">terms and agreements</a></p>
                            </div>
                            {!! Form::hidden('det','',['id'=>'assDet']) !!}                                           
                            {!! Form::hidden('nadet','',['id'=>'na_assDet']) !!}                                           
                            <div class="form-group pull-right">                               
                                <button class="btn btn-primary" value="Submit">Submit</button>
                            </div>          
                        </div>                        
                    </div>
                </div>                   
            </div>                                      
        </div>
        {!! Form::close() !!} 
    </div>    
</div>
<div id="termsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Terms and Agreement</center></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            I borrowed the item/s enumerated and received them complete and in good working condition. The said item/s will be returned to the <strong>ADMINISTRATIVE SERVICES DEPT.</strong> in the same condition it was received. I will be held fully responsible for the condition and accountability of the said item/s.
            <br><br>
            <p><strong>If you agree, kindly close this window and click the checkbox.</strong></p>
            <!-- <li>I borrowed the item/s enumerated above and recieved them in good working conditions from Charter Chemical & Coating Corporation/Davies Paints Philippine Inc. for the</li> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>   
@stop
@section('page-script')

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
        var na_item = $('#na_item_id').val();
        var na_qty = $('#na_qty_id').val();
        if(na_item == '' || na_item == ' ' || na_item == '  '){
            swal('Please Enter Item');
        }else{
            var na_mer = na_item + '-' + na_qty;

            var na_set = na_qty + '-' + na_item;

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
            $('#na_assDet').val(non_ar);
        }
        // var exist = document.getElementById('lstid').innerHTML;
        // document.getElementById('lstid').innerHTML = exist + mer;
    }
    function getAssetFunction(){

        var item = $('#item_id').val();
        var qty = $('#qty_id').val();
        var mer = item + '-' + qty;

        var set = qty + '-' + item;

        // $('#lstid').append("<li class='btn btn-lg btn-danger toremove' type='button' onclick='removeThis(this)' value='"+ mer +"'>"+ set +" </li>");
        $('#lstid').append("<li>"+ set +" </li>");

        document.getElementById('qty_id').value = 1;

        ar.push(mer);

        $('#assDet').val(ar);
        
        // var exist = document.getElementById('lstid').innerHTML;
        // document.getElementById('lstid').innerHTML = exist + mer;
    }

    function remFunction(elem){
        alert(elem.val());
        ar = jQuery.grep(ar, function(value) {
            return value != elem.id;
        });

        alert(ar);
        $('#assDet').val(ar);
    }

    function removeThis(elem){
        swal({
            title: "Are you sure?",
            text: "This item will be removed!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            var list = $(elem);
            alert(list.val());
            // remFunction(elem);
            $(elem).remove();
        });
    }
    
</script>
@section('page-script')

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });

@stop