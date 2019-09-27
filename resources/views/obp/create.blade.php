@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> OFFICIAL BUSINESS FORM</h2>        
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Official Business Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'obp.store','method'=>'POST','files'=>true))!!}
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('date','Filing Date') !!}
                            <input class="form-control" type="text" value="{{date('m/d/y')}}" readonly>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-sm-4">                            
                            {!! Form::label('user_id','Name') !!}
                            {!! Form::text('user_id',strtoupper($user->first_name.' '.$user->last_name),['class'=>'form-control','id'=>'users_id','readonly'=>'readonly']) !!}                            
                        </div>
                        <div class="col-sm-4">                            
                            {!! Form::label('position','Position') !!}
                            {!! Form::text('position',$user->position,['class'=>'form-control','id'=>'position','readonly'=>'readonly']) !!}                            
                        </div>
                        <div class="col-sm-4">                            
                            {!! Form::label('department','Department') !!}
                            {!! Form::text('department',$user->department->department,['class'=>'form-control','id'=>'department','readonly'=>'readonly']) !!}                            
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-sm-12">                                                                                
                            <div class="form-group">
                                {!!Form::label('purpose','Purpose')!!}                       
                                {!!Form::textarea('purpose','',['class'=>'form-control','placeholder'=>'Enter Purpose','required'=>'required'])!!}                                             
                                @if ($errors->has('purpose')) <p class="help-block" style="color:red;">{{ $errors->first('purpose') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                        
                    </div>
                    <div class="row">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">
                                {!!Form::label('destination','Destination')!!}                       
                                {!!Form::text('destination','',['class'=>'form-control','placeholder'=>'Enter Destination','required'=>'required'])!!}                                             
                                @if ($errors->has('destination')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">
                                {!!Form::label('visited','Name of Person Visited')!!}                       
                                {!!Form::text('visited','',['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited','required'=>'required'])!!}                                             
                                @if ($errors->has('visited')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                       
                        <!-- <div class="col-sm-3">                                                                                
                            <div class="form-group">
                                {!!Form::label('time_of_arrival','Time Of Arrival')!!}                       
                                {!!Form::text('time_of_arrival','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_arrival')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_arrival') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                                            
                        <div class="col-sm-3">                                                                                
                            <div class="form-group">
                                {!!Form::label('time_of_departure','Time Of Departure')!!}                       
                                {!!Form::text('time_of_departure','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_departure')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_departure') }}</p> @endif
                            </div>                                                                                                            
                        </div>          -->                               
                    </div>
                    <div class="row" id="itinerary2">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('destination2','',['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('visited2','',['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                       
                        <!-- <div class="col-sm-3">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('time_of_arrival2','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_arrival2')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_arrival') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                                            
                        <div class="col-sm-3">                                                                                
                            <div class="form-group">                                            
                                {!!Form::text('time_of_departure2','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_departure2')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_departure') }}</p> @endif
                            </div>                                                                                                            
                        </div>            -->                             
                    </div>
                    <div class="row" id="itinerary3">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('destination3','',['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination3')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('visited3','',['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited3')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                       
                        <!-- <div class="col-sm-3">                                                                                
                            <div class="form-group">                                            
                                {!!Form::text('time_of_arrival3','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_arrival3')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_arrival') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                                            
                        <div class="col-sm-3">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('time_of_departure3','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_departure3')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_departure') }}</p> @endif
                            </div>                                                                                                            
                        </div>                   -->                      
                    </div>
                    <div class="row" id="itinerary4">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('destination4','',['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination4')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('visited4','',['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited4')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                       
                        <!-- <div class="col-sm-3">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('time_of_arrival4','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_arrival4')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_arrival') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                                            
                        <div class="col-sm-3">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('time_of_departure4','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_departure4')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_departure') }}</p> @endif
                            </div>                                                                                                            
                        </div>                         -->                
                    </div>
                    <div class="row" id="itinerary5">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('destination5','',['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination5')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('visited5','',['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited5')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                       
                        <!-- <div class="col-sm-3">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('time_of_arrival5','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_arrival5')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_arrival') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                                            
                        <div class="col-sm-3">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('time_of_departure5','',['class'=>'form-control','placeholder'=>'Enter Time'])!!}                                             
                                @if ($errors->has('time_of_departure5')) <p class="help-block" style="color:red;">{{ $errors->first('time_of_departure') }}</p> @endif
                            </div>                                                                                                            
                        </div>                        -->                 
                    </div>
                    <div class="row" style="padding-top:10px;" id="reminds_time">                         
                        <div class="col-sm-4">
                            <div class="form-group" id="date_1">
                                <label class="font-normal">Date From</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="" name="date" required="" id="input_text">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" id="date_1">
                                <label class="font-normal">Date To</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="" name="date2" required="" id="input_text2">
                                </div>
                            </div>

                        </div>                       
                        <!-- <div class="col-lg-4">
                            {!!Form::label('time_left','Time Left')!!}       
                            {!! Form::text('time_left','',['class'=>'form-control','required'=>'required']) !!}
                        </div>       
                        <div class="col-lg-4">
                            {!! Form::label('time_arrived','Time Arrived')!!}       
                            {!! Form::text('time_arrived','',['class'=>'form-control','required'=>'required']) !!}                            
                        </div>                    -->     
                    </div>                    
                    <div class="row">
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('obp.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <button class="btn btn-primary" type="button" id="obpsentbtn"><i class="fa fa-save"></i> Save</button>
                            {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary hidden','id'=>'obpsend')) !!}
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


$('#date_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});
$('#input_text').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});
$('#input_text2').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});

$('#obpsentbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your Request will be sent!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpsend').click();
    });
}); 
@stop