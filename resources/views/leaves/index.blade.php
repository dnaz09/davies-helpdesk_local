@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> LEAVE</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been Created!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_cancel')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been Canceled!<i class="fa fa-check"></i></h4></center>                
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Leave Request Form <small></small></h5>          
                </div>
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'leaves.store','method'=>'POST'))!!}
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('date','Filing Date') !!}
                            <input class="form-control" type="text" value="{{date('m-d-Y')}}" readonly>
                        </div>
                    </div><br>
                    <div class="row">               
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('dept','Department') !!}
                                {!! Form::text('department',Auth::user()->department->department,['class'=>'form-control','placeholder'=>'Department','required'=>'required','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('user','Employee Name') !!}
                                {!! Form::text('user',Auth::user()->first_name.' '.Auth::user()->last_name,['class'=>'form-control','placeholder'=>'User','required'=>'required','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('sup','Superior') !!}
                                {!! Form::text('supervisor',Auth::user()->supervisor->first_name.' '.Auth::user()->supervisor->last_name,['class'=>'form-control','placeholder'=>'User','required'=>'required','readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group" id="date_1">
                                {!! Form::label('date_needed','Date Needed') !!}
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$date}}" name="date" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('type','Type') !!}
                                <select name="type" class="form-control" id="typeId">
                                    <option value="-">Choose Type</option>
                                    <option value="1">Leave</option>
                                    <option value="2">Undertime</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('reason','Reason') !!}
                                {!!Form::text('reason','',['class'=>'form-control','required','placeholder'=>'Enter Reason'])!!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('sched','Time Of Exit') !!}
                                <select name="sched" class="form-control" required id="schedId" disabled>
                                    <option value="-"> PLEASE CHOOSE TIME</option>
                                    @foreach($timeslots as $times)
                                    <option value="{{$times->time}}">{{$times->time}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <button class="btn btn-primary" type="button" id="savebtn"> Save</button>
                                {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit','id'=>'savebtnclicked', 'class' => 'btn btn-primary hidden')) !!}
                            </div>
                        </div>    
                    </div>
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    {{Form::close()}}
                </div>
            </div>
        </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY LEAVE LISTS</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>REQUISITION#</th>                                
                                <th>DATE REQUESTED</th>
                                <th>DATE NEEDED</th>
                                <th>MANAGER ACTION</th> 
                                <th>HRD ACTION</th>
                                <th>ACTION</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lvs as $lv)
                            <tr>
                                <td>{!!$lv->req_no!!}</td>
                                <td>{!!date('m/d/y',strtotime($lv->created_at))!!}</td>
                                <td>{!!date('m/d/y',strtotime($lv->date))!!}</td>
                                <td>
                                    @if($lv->sup_action < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($lv->sup_action == 1)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @elseif($lv->sup_action == 3)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                    @elseif($lv->level == 5 && $lv->sup_action == 5 && $lv->hrd_action == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lv->hrd_action < 1)
                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                    @elseif($lv->hrd_action == 1)
                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                    @elseif($lv->hrd_action == 3)
                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                    @elseif($lv->level == 5 && $lv->sup_action == 5 && $lv->hrd_action == 5)
                                    <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lv->status != 5 && $lv->level != 5)
                                    {!! Html::decode(link_to_Route('leaves.detail','<i class="fa fa-eye"></i> Details', $lv->id, array('class' => 'btn btn-warning btn-xs')))!!}
                                    @if($lv->status != 2 && $lv->status != 3)
                                    {!! Html::decode(link_to_Route('leaves.cancel','<i class="fa fa-eye"></i> Cancel', $lv->id, array('class' => 'btn btn-danger btn-xs')))!!}
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
</div>    
@stop
@section('page-script')


$('#date_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "mm-dd-yy",
    startDate: new Date()
});

$('#typeId').on('change', function(e) { 
    var selected = $('#typeId').val();
    if(selected == 1){
        $("#schedId").prop('disabled',true);
    }
    if(selected == 2){
        $("#schedId").prop('disabled',false);
    }
});

$('#savebtn').click(function () {
    var x = $('#typeId').val();
    var time = $('#schedId').val();
    if(x.indexOf('-')!=-1){
        swal('Please Choose Type of Leave');
    }else{
        if(x == 2){
            if(time.indexOf('-')!=-1){
                swal('Please Choose Time of Exit');
            }else{
                swal({
                    title: "Are you sure?",
                    text: "Your request will be sent!",
                    icon: "warning",
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonText: "Yes, i am sure!"
                },function(){
                    $('#savebtnclicked').click();
                });
            }
        }else{
            swal({
                title: "Are you sure?",
                text: "Your request will be sent!",
                icon: "warning",
                dangerMode: true,
                showCancelButton: true,
                confirmButtonText: "Yes, i am sure!"
            },function(){
                $('#savebtnclicked').click();
            });
        }
    }
});
@stop