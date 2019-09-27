@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> EMPLOYEE REQUISITION</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_saved')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Requisition has been Created!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('with_letter')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Number needed should be numeric characters only!<i class="fa fa-check"></i></h4></center>                
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Employee Requisition Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'emp_requisition.store','method'=>'POST','files'=>true))!!}
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('date','Filing Date') !!}
                            <input class="form-control" type="text" value="{{date('Y-m-d')}}" readonly>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('company','Company') !!}
                            {!! Form::text('company',Auth::user()->company,array('class'=>'form-control','readonly')) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('dept','Department') !!}
                            {!! Form::text('department',Auth::user()->department->department,array('class'=>'form-control','readonly')) !!}
                            {!! Form::hidden('dept_id',Auth::user()->dept_id) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('sup','Supervisor') !!}
                            @if(Auth::user()->superior != 0)
                            {!! Form::text('suprr',Auth::user()->supervisor->first_name.' '.Auth::user()->supervisor->last_name,array('class'=>'form-control','readonly')) !!}
                            {!! Form::hidden('superior',Auth::user()->superior) !!}
                            @else
                            {!! Form::text('suprr','-',array('class'=>'form-control','readonly')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('site', 'Work Site') !!}
                            {!! Form::text('work_site','',array('class'=>'form-control','required','placeholder'=>'Enter Work Site')) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('numbs', 'Number Of Employees Needed') !!}
                            {!! Form::number('no_needed','',array('id'=>'emp_no','class'=>'form-control','required','min'=>'1','placeholder'=>'Number of Employees Needed')) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label('typeOfJob', 'Type Of Employee Requisition') !!}
                            <select class="form-control" name="type" required>
                                <option value="1">For Contractual</option>
                                <option value="2">For Probationary</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('nature_of_request', 'Nature Of Request') !!}
                            {!! Form::text('nature','',array('class'=>'form-control','required','placeholder'=>'Enter Nature of Request','id'=>'nature_req')) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('proj_title', 'Job Title') !!}
                            <!-- {!! Form::text('job_title','',array('class'=>'form-control','required','placeholder'=>'Enter Job Title')) !!} -->
                            <select name="job_title" class="form-control" required="">
                                <option value="staff"> Staff - 30 days </option>
                                <option value="supervisor"> Supervisor - 45 days </option>
                                <option value="managerial"> Managerial - 60 days </option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h3>QUALIFICATIONS</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('Gender', 'Gender') !!}
                            <select class="form-control" name="gender" required="">
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('Age', 'Age') !!}
                            {!! Form::number('age','',array('class'=>'form-control', 'id'=>'age_id','required','placeholder'=>'Enter Age','min'=>'18','max'=>'50')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">        
                            {!! Form::label('attainment', 'Educational Background') !!}
                            {!! Form::textarea('details','',array('class'=>'form-control','required','placeholder'=>'Enter Educational Attainment, etc...')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">        
                            {!! Form::label('supers', 'Recommended By') !!}
                            <select class="form-control" name="manager" required>
                                @foreach($supers as $super)
                                    <option value="{{$super->id}}">{!! $super->first_name.' '.$super->last_name !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            {!! Form::label('attached','Attachments')!!}
                            {!! Form::file('attached[]', array('id' => 'filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('requisition.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <!-- <button class="btn btn-primary" id="requisitionsave" type="button"> Save</button> -->
                            <!-- {!! Form::button('<i class="fa fa-save"></i> Save', array('id'=>'reqsent', 'type' => 'submit', 'class' => 'btn btn-primary hidden')) !!} -->
                            {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                        </div>    
                    </div>
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    {!! Form::close() !!}
                </div>                   
            </div>     
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY REQUISITIONS LISTS</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>CONTROL #</th>                                
                                <th>DATE REQUESTED</th>                               
                                <th>DATE NEEDED</th> 
                                <th>HRD ACTION</th>
                                <th>STATUS</th>
                                <th>CANCEL TRANSACTION</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reqs as $req)
                                <tr>
                                     <td>
                                        @if($req->sup_action != 5 && $req->hrd_action != 5)
                                        {!! Html::decode(link_to_route('emp_requisition.details', $req->ereq_no,$req->ereq_no, array())) !!}
                                        @else
                                        {!! $req->ereq_no !!}
                                        @endif
                                    </td>                                    
                                    <td>{!! $req->created_at !!}</td>
                                    <td>{!! $req->date_needed !!}</td>
                                    <td>
                                        @if($req->hr_action == 0)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->hr_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->hr_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->approver_action == 0)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($req->approver_action == 1)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($req->approver_action == 2)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->hr_action < 1 && $req->approver_action < 1)
                                        {!! Html::decode(link_to_route('emp_requisition.cancel', 'Cancel',$req->ereq_no, array('class'=>'btn btn-xs btn-danger'))) !!}
                                        @endif
                                    </td> 
                                </tr>
                            @empty
                            @endforelse
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
$('#age_id').keydown(function (e){
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
    var number = parseFloat($(this).val());
    if(number > 12){
       $(this).val("");
    }
});
$('#nature_req').keydown(function (e){
    if (e.shiftKey || e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});

$('#emp_no').keydown(function (e){
   var number = parseFloat($(this).val());
    if(number > 12){
       $(this).val("");
    } 
});

$('#filer_inputs').filer({

        showThumbs:true,
        addMore:true
    }); 

$('#date_needed .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
});

$('#date_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
});

@stop