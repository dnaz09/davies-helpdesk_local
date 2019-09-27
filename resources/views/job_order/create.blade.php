@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> NEW JOB ORDER</h2> 
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-7 animated flash">
            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>  
        <div class="col-md-7 animated flash">
            <?php if (session('is_barcode')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Barcode Already Exists!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            <?php if (session('is_error_facility')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Please select facility!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_error_equipment')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Please select equipment!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Job Order Request Sent!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>  
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-plus"></i> Job Order Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'job_order.store','method'=>'POST'))!!}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!!Form::label('date','Date Submitted')!!}
                                        {!!Form::text('date',date('m/d/y'),['class'=>'form-control','readonly'])!!}
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('date','Reported By')!!}
                                        {!!Form::text('name',Auth::user()->first_name.' '.Auth::user()->last_name,['class'=>'form-control','readonly'])!!}
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('date','Department')!!}
                                        {!!Form::text('dept',Auth::user()->department->department,['class'=>'form-control','readonly'])!!}
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('loc','Location of Work')!!}
                                        <select class="form-control" name="section" required>
                                            <option value="-"> SELECT LOCATION</option>
                                            @foreach($locations as $location)
                                            <option value="{{$location->location}}">{{$location->location}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('section')) <p class="help-block" style="color:red;">{{ $errors->first('section') }}</p> @endif
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('req_work','Requested Work')!!}<br>
                                        <input type="radio" name="req_work" id="req_work" value="Repair/Replacement" required=""> Repair/Replacement <br>
                                        <input type="radio" name="req_work" id="req_work" value="Installation/Fabrication" required=""> Installation/Fabrication <br>
                                        <input type="radio" name="req_work" id="req_work" value="Others" required=""> Others
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('work_for','Facility')!!}<br>
                                        <select class="form-control" name="facility" required id="facility" required="">
                                            <option value="-"> PLEASE SELECT FACILITY</option>
                                            @foreach($facilities as $facility)
                                            <option value="{{$facility->facility}}">{{$facility->facility}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('equipment','Equipment')!!}<br>
                                        <select class="form-control" name="equipment" required id="equipment" required="">
                                            <option value="-"> PLEASE SELECT EQUIPMENT</option>
                                            @foreach($equipments as $equip)
                                            <option value="{{$equip->equipment}}">{{$equip->equipment}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('item_class','Item Class')!!}
                                        <select name="item_class" class="form-control" data-placeholder="SELECT ITEM CLASS..." id='item_class'></select>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('asset_no','Asset Number')!!}
                                        {!!Form::text('asset_no','',['id'=>'asset_no','class'=>'form-control','placeholder'=>'Enter Asset Number','required'])!!}  
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('Desc','Description of Problem/ Reason/ Remarks')!!}                        
                                    {!!Form::textarea('description','',['class'=>'form-control','placeholder'=>'Enter Description of problem','required'])!!}                                              
                                    @if ($errors->has('description')) <p class="help-block" style="color:red;">{{ $errors->first('description') }}</p> @endif
                                </div>
                                {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'button', 'id' => 'submitBtn', 'class' => 'btn btn-primary')) !!}
                                <button type="submit" class="btn hidden" id="submittedButton"></button>
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />		
                        	{!! Form::close() !!}
                        </div>                        
                    </div>
                </div>                   
            </div>             	                        
        </div>           
    </div>    
</div>    
@stop
@section('page-script')
$('#equipment').on('change', function(e) {
    selection = $('#item_class');
    selection.empty();
    var selected = $('#equipment').val();
    $.ajax({
        type:"POST",
        dataType: 'json',
        data: {
            "type": selected,
        },
        url: "{{url('get_jo_item_classes')}}",
        success: function(data){
            select = $('#item_class');
            select.empty();
            $.each(data.selection, function(i,text) {
                $('<option value="'+i+'">'+i+'</option>').appendTo(select);
            });
        }
    });
});
$('#work_for1').on('change', function(e) {
    var selected = $('#work_for1').val();
    if(selected.indexOf('Facilities/Building')!=-1){
        $("#facility").prop('disabled',false);
        $("#equipment").prop('disabled',true);
        $("#asset_no").prop('disabled',true);
        $("#item_class").val('');
        $("#item_class").prop('disabled',true);
        <!-- $("#item_class").prop('disabled',true); -->
        $("#asset_no").val('');
    }
});
$('#work_for2').on('change', function(e) {
    var selected = $('#work_for2').val();
    if(selected.indexOf('Equipment')!=-1){
        $("#equipment").prop('disabled',false);
        $("#item_class").prop('disabled',false);
        <!-- $("#item_class").prop('disabled',false); -->
        {{-- $("#facility").prop('disabled',true); --}}
        $("#asset_no").prop('disabled',false);
    }
});
$('#submitBtn').click(function () {
    var x = $('#work_for1').val();
    swal({
        title: "Are you sure?",
        text: "Your request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#submittedButton').click();
    });
});
@endsection