@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> ROOM RESERVATION REQUEST</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-7 animated flash">
            @if ( count( $errors ) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Error in requesting!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('error_date')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Error in requesting!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('oops_room')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Someone has already reserved that room! Kindly check the calendar to help you in filing a reservation<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>    
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Reservation Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            {!!Form::open(array('route'=>'room_reqs.store','method'=>'POST'))!!}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('user','User')!!}
                                        {!!Form::text('user',Auth::user()->first_name.' '.Auth::user()->last_name,['class'=>'form-control','readonly'])!!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!!Form::label('dept','Department')!!}
                                        {!!Form::text('dept',Auth::user()->department->department,['class'=>'form-control','readonly'])!!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('roomname','Name of Room')!!}                       
                                    <select name="room" class="form-control" required="" id="roomselect">
                                        <option value=""> PLEASE SELECT ROOM</option>
                                        @foreach($rooms as $room)
                                        <option value="{{$room->room_name}}">{!! $room->room_name !!}</option>
                                        @endforeach
                                    </select>                                            
                                    @if ($errors->has('room')) <p class="help-block" style="color:red;">{{ $errors->first('room') }}</p> @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="date_1">
                                        {!! Form::label('date_needed','Start Date') !!}
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$date_from}}" name="start_date" id="input_text_start" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="date_1">
                                        {!! Form::label('date_needed','End Date') !!}
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$date_to}}" name="end_date" id="input_text_end" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('start_time','Start Time') !!}
                                        <select name="start_time" class="form-control" required="">
                                            <option value="7:00">7:00 AM</option>
                                            <option value="7:30">7:30 AM</option>
                                            <option value="8:00">8:00 AM</option>
                                            <option value="8:30">8:30 AM</option>
                                            <option value="9:00">9:00 AM</option>
                                            <option value="9:30">9:30 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="11:30">11:30 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="12:30">12:30 PM</option>
                                            <option value="13:00">1:00 PM</option>
                                            <option value="13:30">1:30 PM</option>
                                            <option value="14:00">2:00 PM</option>
                                            <option value="14:30">2:30 PM</option>
                                            <option value="15:00">3:00 PM</option>
                                            <option value="15:30">3:30 PM</option>
                                            <option value="16:00">4:00 PM</option>
                                            <option value="16:30">4:30 PM</option>
                                            <option value="17:00">5:00 PM</option>
                                            <option value="17:30">5:30 PM</option>
                                            <option value="18:00">6:00 PM</option>
                                            <option value="18:30">6:30 PM</option>
                                            <option value="19:00">7:00 PM</option>
                                            <option value="19:30">7:30 PM</option>
                                            <option value="20:00">8:00 PM</option>
                                            <option value="20:30">8:30 PM</option>
                                            <option value="21:00">9:00 PM</option>
                                            <option value="21:30">9:30 PM</option>
                                            <option value="22:00">10:00 PM</option>
                                        </select>
                                        <!-- {!! Form::time('start_time','',['class'=>'form-control','required']) !!} -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('end_time','End Time') !!}
                                        <select name="end_time" class="form-control" required="">
                                            <option value="9:00">9:00 AM</option>
                                            <option value="9:30">9:30 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="11:30">11:30 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="12:30">12:30 PM</option>
                                            <option value="13:00">1:00 PM</option>
                                            <option value="13:30">1:30 PM</option>
                                            <option value="14:00">2:00 PM</option>
                                            <option value="14:30">2:30 PM</option>
                                            <option value="15:00">3:00 PM</option>
                                            <option value="15:30">3:30 PM</option>
                                            <option value="16:00">4:00 PM</option>
                                            <option value="16:30">4:30 PM</option>
                                            <option value="17:00">5:00 PM</option>
                                            <option value="17:30">5:30 PM</option>
                                            <option value="18:00">6:00 PM</option>
                                            <option value="18:30">6:30 PM</option>
                                            <option value="19:00">7:00 PM</option>
                                            <option value="19:30">7:30 PM</option>
                                            <option value="20:00">8:00 PM</option>
                                            <option value="20:30">8:30 PM</option>
                                            <option value="21:00">9:00 PM</option>
                                            <option value="21:30">9:30 PM</option>
                                            <option value="22:00">10:00 PM</option>
                                        </select>
                                        <!-- {!! Form::time('end_time','',['class'=>'form-control','required']) !!} -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!!Form::label('details','Meeting Title')!!}                       
                                    {!!Form::text('details','',['class'=>'form-control','placeholder'=>'Meeting Title...','required'])!!}                                           
                                    @if ($errors->has('details')) <p class="help-block" style="color:red;">{{ $errors->first('details') }}</p> @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('fac','Name of Facilitator') !!}
                                    {!! Form::text('facilitator','',['class'=>'form-control','required','placeholder'=>'Name of Facilitator']) !!}
                                </div> 
                                <div class="form-group">
                                    {!! Form::label('att_no','Number of Attendees') !!}
                                    {!! Form::text('att_no','',['id' => 'att_no','class'=>'form-control','required','placeholder'=>'Number of Attendees']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('setup','Room Setup') !!}
                                    <br>
                                    <input type="radio" name="setup" value="Classroom" required="" id="setup1"><strong>Classroom</strong> 
                                    <br>
                                    <input type="radio" name="setup" value="U-Shape" id="setup2"><strong>U-Shape</strong>
                                    <br>
                                    <input type="radio" name="setup" value="" id="setup3"><strong>Others</strong>
                                    {!! Form::text('setup','',['id' => 'other_setup','class'=>'form-control','required','placeholder'=>'Others','disabled','required']) !!}
                                </div>
                                <div class="form-group">
                                    <center>
                                        <p><input type="checkbox" required> I agree to the <a data-toggle="modal" data-target="#termsModal"><strong>terms and agreements</strong></a></p>
                                    </center>
                                </div>                                   
                                <div class="form-group pull-right">
                                    {!! Html::decode(link_to_Route('room_reqs.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default','type'=>'button'])) !!}
                                    {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'button', 'class' => 'btn btn-primary','id'=>'saveBtn')) !!}
                                    <button class="btn hidden" type="submit" id="sendRequest"></button>
                                </div>                  
                            {!! Form::close() !!}
                        </div>                        
                    </div>
                </div>                   
            </div>                                      
        </div>              
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
            <li>Meetings must be held during regular business hours 7:30-4:00, Monday through Saturday.</li>
            <li>Meetings are scheduled on a first-come, first served basis.</li>
            <li>The requestor is required to submit the <strong>Meeting Room Reservation Form</strong> to
            receptionist.  Completing the reservation form constitutes acknowledgement of the Meeting Room Usage and Policy.</li>
            <li>Reservations may be made up to 15 days in advance.</li>
            <li>If there’s cancellation or any changes to the requested schedule and set up, please let the Reception know as soon as possible. Only the requestor who made the reservation is allowed to cancel the schedule.</li>
            <li>The Receptionist will cancel the reservation if the requestor fails to appear within 15 minutes after the scheduled time.</li>
            <li>The priority for the meeting room use is for those who reserved. The receptionist may as an employee to vacate the room if he/she will use it without reservation form.</li>
            <li>Meeting room is not designed for food service only light refreshments may be served (drinks & biscuits only) during the meeting.  No meals are allowed inside the meeting room.</li>
            <li>Smoking, use of alcoholic beverages and use of open flames is prohibited.</li>
            <li>Equipment to be used in a meeting should be prepared and set up by requestor.</li>
            <li>Nothing may be fastened or affixed to the walls of the meeting rooms.</li>
            <li>Requestor is responsible for knowing how their equipment works.</li>
            <li>The requestor and attendees assume full responsibility for any damage incurred resulting from the misuse of the meeting rooms or any equipment used.</li>
            <li>The requestor is responsible in returning the borrowed equipment after use.</li>
            <li>The requestor is responsible in cleaning and clearing the meeting room after use as well as the tables and chairs.</li>
            <li>Aircon and light must be turned off after the meeting.</li>
            <li>Noise during meeting should be controlled so as not to disturb other offices.</li>
            <li>Do not store any materials inside the meeting rooms.</li>
            <li>Failure to comply with any of Meeting Room Usage and Policy may result in prohibition of the group’s use of meeting rooms.</li>
            <br><br>
            <p><strong>If you agree, kindly close this window and click the checkbox.</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>   
@stop
@section('page-script')
$('#setup1').on('change', function(e) {
    $('#other_setup').prop('disabled',true);
    $('#other_setup').val('');
});
$('#setup2').on('change', function(e) {
    $('#other_setup').prop('disabled',true);
    $('#other_setup').val('');
});
$('#setup3').on('change', function(e) {
    $('#other_setup').prop('disabled',false);
});

$('#att_no').keydown(function (e){
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

$('#input_text_start').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});

$('#input_text_end').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});

$('#date_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});

$('#saveBtn').click(function () {
    var room = $('#roomselect').val();
    if(room === ""){
        swal('You cannot proceed without selecting a room!');
    }else{
        swal({
            title: "Are you sure?",
            text: "Your Request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#sendRequest').click();
        });
    }
});

@endsection