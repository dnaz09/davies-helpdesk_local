@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> CREATE OFFICIAL BUSINESS PASS</h2>        
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Official Business Pass Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>array('obp.update',$obp->id),'method'=>'PUT','files'=>true))!!}
                                    
                    <div class="row">
                        
                    </div>                    
                    <div class="row">
                        <div class="col-sm-12">                                                                                
                            <div class="form-group">
                                {!!Form::label('purpose','Purpose')!!}                       
                                {!!Form::textarea('purpose',$obp->purpose,['class'=>'form-control','placeholder'=>'Enter Purpose','required'=>'required'])!!}                                             
                                @if ($errors->has('purpose')) <p class="help-block" style="color:red;">{{ $errors->first('purpose') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                        
                    </div>
                    <div class="row">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">
                                {!!Form::label('destination','Destination')!!}                       
                                {!!Form::text('destination',$obp_details->destination,['class'=>'form-control','placeholder'=>'Enter Desitnation','required'=>'required'])!!}                                             
                                @if ($errors->has('destination')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">
                                {!!Form::label('visited','Name of Person Visited')!!}                       
                                {!!Form::text('visited',$obp_details->person_visited,['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                              
                    </div>
                    <div class="row" id="itinerary2">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('destination2',$obp_details->destination2,['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('visited2',$obp_details->person_visited2,['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                       
                    </div>
                    <div class="row" id="itinerary3">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('destination3',$obp_details->destination3,['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination3')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('visited3',$obp_details->person_visited3,['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited3')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                       
                    </div>
                    <div class="row" id="itinerary4">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('destination4',$obp_details->destination4,['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination4')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                
                                {!!Form::text('visited4',$obp_details->person_visited4,['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited4')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                                   
                    </div>
                    <div class="row" id="itinerary5">
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('destination5',$obp_details->destination5,['class'=>'form-control','placeholder'=>'Enter Destination'])!!}                                             
                                @if ($errors->has('destination5')) <p class="help-block" style="color:red;">{{ $errors->first('destination') }}</p> @endif
                            </div>                                                                                                            
                        </div>            
                        <div class="col-sm-6">                                                                                
                            <div class="form-group">                                                
                                {!!Form::text('visited5',$obp_details->person_visited5,['class'=>'form-control','placeholder'=>'Enter Name Of Person Visited'])!!}                                             
                                @if ($errors->has('visited5')) <p class="help-block" style="color:red;">{{ $errors->first('visited') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                                                            
                    </div>
                    <div class="row" style="padding-top:10px;" id="reminds_time">                         
                        <div class="col-sm-4">
                            <div class="form-group" id="date_1">
                                <label class="font-normal">Date Needed</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$obp->date}}" name="date" required="">
                                </div>
                            </div>
                            <div class="form-group" id="date_2">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$obp->date2}}" name="date2" required="">
                                </div>
                            </div>

                        </div>                             
                        <!-- <div class="col-lg-4">
                            {!!Form::label('time_left','Time Left')!!}       
                            {!! Form::text('time_left',$obp->time_left,['class'=>'form-control','required'=>'required']) !!}
                        </div>       
                        <div class="col-lg-4">
                            {!! Form::label('time_arrived','Time Arrived')!!}       
                            {!! Form::text('time_arrived',$obp->time_arrived,['class'=>'form-control','required'=>'required']) !!}                            
                        </div>                 -->        
                    </div>                    
                    <div class="row">
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('obp.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <button class="btn btn-primary" type="button" id="editobpbtn"><i class="fa fa-save"></i> Save</button>
                            {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit','id'=>'obpedited', 'class' => 'btn btn-primary hidden')) !!}
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
    startDate: new Date()
});
$('#date_2 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    startDate: new Date()
});

$('#editobpbtn').click(function () {
    swal({
        title: "Are you sure?",
        text: "Your Request will be edited!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#obpedited').click();
    });
});

@stop