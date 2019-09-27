@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> EDIT WORK AUTHORIZATION</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Work Authorization has been Created!<i class="fa fa-check"></i></h4></center>                
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Work Authorization Form <small></small></h5>
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>array('work_authorization.update',$work->id),'method'=>'PUT','files'=>true))!!} 
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('date','Filing Date') !!}
                            <input class="form-control" type="text" value="{{date('m/d/y')}}" readonly>
                        </div>
                    </div>        
                    <div class="row">
                        <div class="form-group">
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
                    </div>
                    <div class="row">                        
                        <div class="form-group">
                            <div class="col-sm-4">
                                {!! Form::label('ot_from','From') !!}
                                <select class="form-control" name="ot_from" required>
                                    <option value="{{$work->ot_from}}">{{$work->ot_from}}</option>
                                    @foreach($froms as $from)
                                    @if($from->time != $work->ot_from)
                                    <option value="{{$from->time}}">{{$from->time}}</option>
                                    @else
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                {!! Form::label('ot_to','To') !!}
                                <select class="form-control" name="ot_to" required>
                                    <option value="{{$work->ot_to}}">{{$work->ot_to}}</option>
                                    @foreach($times as $time)
                                    @if($time->time != $work->ot_to)
                                    <option value="{{$time->time}}">{{$time->time}}</option>
                                    @else
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="col-sm-4">
                                {!! Form::label('not_exceed_to','Total Overtime not to exceed hours ') !!}
                                {!! Form::text('not_exceed_to','',['class'=>'form-control','placeholder'=>'Total Overtime not to exceed hours','required']) !!}
                            </div> -->
                            <div class="col-sm-4">                                                   
                                <div class="form-group">
                                    {!!Form::label('reason','Reason of Overtime')!!}                       
                                    {!!Form::text('reason',$work->reason,['class'=>'form-control','placeholder'=>'Enter Reason'])!!}                                             
                                    @if ($errors->has('reason')) <p class="help-block" style="color:red;">{{ $errors->first('reason') }}</p> @endif
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">                                                                    
                            <div class="form-group">
                                {!!Form::label('requested_by','Recommended By')!!}                       
                                <!-- <select class="form-control" name="requested_by">
                                    @foreach($supers as $super)
                                    <option value="{{$super->first_name.' '.$super->last_name}}">{{$super->first_name}} {{$super->last_name}}</option>
                                    @endforeach
                                </select>   -->
                                {!!Form::text('requested_by',$work->requested_by,['class'=>'form-control','placeholder'=>'Requested By', 'required'])!!}                                 
                                @if ($errors->has('requested_by')) <p class="help-block" style="color:red;">{{ $errors->first('requested_by') }}</p> @endif
                            </div>              
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('date','Date') !!}
                                <span>{!! Form::text('date_needed', $work->date_needed, array('class' => 'form-control date_input', 'id' => 'date', 'data-date-format' => 'yyyy/mm/dd', 'placeholder' => 'yyyy/mm/dd','required'=>'required')) !!}</span>
                            </div>
                        </div>                                                    
                    </div> 
                    <div class="row">
                        <div class="col-sm-12">
                            {!!Form::label('other_emp','Add other employees (Employees who are approved and denied are not included)')!!}
                            <!-- <select class="form-control" name="others[]" id="usersID" multiple>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{!!strtoupper($user->first_name)!!} {!!strtoupper($user->last_name)!!}</option>
                                @endforeach
                            </select> -->
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="user_tb">
                                        <thead>
                                            <tr>
                                                <th>INCLUDE</th>
                                                <th>USER</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            @if(!in_array($user->id, $approves))
                                            <tr>
                                                @if(in_array($user->id, $details))
                                                <td><input type="checkbox" name="others[]" value="{{ $user->id }}" checked></td>
                                                @else
                                                <td><input type="checkbox" name="others[]" value="{{ $user->id }}"></td>
                                                @endif
                                                <td>{{$user->first_name.' '.$user->last_name}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                              
                    </div>                               
                    <div class="row">
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('work_authorization.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <button class="btn btn-primary" id="editworkauth" type="button"><i class="fa fa-save"></i> Save</button>
                            {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary hidden', 'id'=>'workauthedited')) !!}
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
    $('#editworkauth').click(function () {
    swal({
        title: "Are you sure?",
        text: "Changes will be saved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#workauthedited').click();
    });
});
$("#date").datepicker({
        dateFormat: "yy-mm-dd",   
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true
    });
@stop
