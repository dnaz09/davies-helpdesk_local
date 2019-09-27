@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> LEAVE FORM</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Official Business Pass has been Created!<i class="fa fa-check"></i></h4></center>                
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
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Leave Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'undertime.store','method'=>'POST','files'=>true))!!}                    
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('date','Filing Date') !!}
                            <input class="form-control" type="text" value="{{date('m/d/y')}}" readonly>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-sm-4"> 
                            <div class="form-group">                                               
                                {!! Form::label('user_id','Name') !!}
                                {!! Form::text('user_id',strtoupper($user->first_name.' '.$user->last_name),['class'=>'form-control','id'=>'users_id','readonly'=>'readonly']) !!}
                            </div>       
                        </div>                 
                    </div>                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group" id="u_date">
                                <label class="font-normal">Date Needed</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{ date('m/d/Y') }}" id="input_text" name="date" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('type','Type of Leave') !!}
                                <select name="type" class="form-control" required id="typeId">
                                    <option value="-">SELECT TYPE</option>
                                    <option value="1">Half Day</option>
                                    <option value="2">Undertime</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('sched','Time Of Exit') !!}
                                <select name="sched" class="form-control" required id="timeslots">
                                    <option value="-"> PLEASE SELECT TIME</option>
                                    @foreach($timeslots as $times)
                                    <option value="{{$times->time}}">{{$times->time}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">                                                                                
                            <div class="form-group">
                                {!!Form::label('reason','Reason')!!}                       
                                {!!Form::textarea('reason','',['class'=>'form-control','placeholder'=>'Enter Reason','required'=>'required'])!!}                                             
                                @if ($errors->has('reason')) <p class="help-block" style="color:red;">{{ $errors->first('reason') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                        
                    </div>                            
                    <div class="row">
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('undertime.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <button class="btn btn-primary" type="button" id="undertimecreatebtn"> Save</button>
                            {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit','id'=>'createdundertime', 'class' => 'btn btn-primary hidden')) !!}
                        </div>    
                    </div>
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    {!! Form::close() !!}
                </div>                   
            </div>                                      
        </div>                    
    </div>    
</div>    
@stop
@section('page-script')
$('#u_date .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});

$('#typeId').on('change', function(e) { 
    var selected = $('#typeId').val();
    if(selected == 1){
        $("#timeslots").prop('disabled',true);
    }
    if(selected == 2){
        $("#timeslots").prop('disabled',false);
    }
});

$('#input_text').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});

$('#undertimecreatebtn').click(function () {
    var x = $('#typeId').val();
    var time = $('#timeslots').val();
    if(x == 1){
        swal({
            title: "Are you sure?",
            text: "Your request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#createdundertime').click();
        });
    }else{
        if(time.indexOf('-')!=-1){
            swal('Please Select Time');
        }else{ 
            swal({
                title: "Are you sure?",
                text: "Your request will be sent!",
                icon: "warning",
                dangerMode: true,
                showCancelButton: true,
                confirmButtonText: "Yes, i am sure!"
            },function(){
                $('#createdundertime').click();
            });
        }
    }
});
@endsection