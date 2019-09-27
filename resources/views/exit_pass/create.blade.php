@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> CREATE EMPLOYEE EXIT PASS</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Employee Exit Pass has been Created!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            @if(count($errors)  > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Employee Exit Pass Form <small></small></h5>
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'emp_exit_pass.store','method'=>'POST','files'=>true))!!}
                    <div class="row">                        
                        <div class="col-sm-6">
                            <div class="form-group">                                    
                                {!!Form::label('date','Date')!!}                 
                                <span>{!! Form::text('date', '', array('class' => 'form-control date_input', 'id' => 'date', 'data-date-format' => 'yyyy/mm/dd', 'placeholder' => 'yyyy/mm/dd','required'=>'required')) !!}</span>
                                @if ($errors->has('date')) <p class="help-block" style="color:red;">{{ $errors->first('date') }}</p> @endif                                    
                            </div>     
                        </div>     
                    </div>                          
                    <div class="row">
                        <div class="col-sm-6">                            
                            {!! Form::label('user_id','Name') !!}
                            {!! Form::text('user_id',strtoupper($user->first_name.' '.$user->last_name),['class'=>'form-control','readonly'=>'readonly']) !!}
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-sm-12">                                                                                
                            <div class="form-group">
                                {!!Form::label('purpose','Purpose')!!}                       
                                {!!Form::textarea('purpose','',['class'=>'form-control','placeholder'=>'Enter Purpose'])!!}                                             
                                @if ($errors->has('purpose')) <p class="help-block" style="color:red;">{{ $errors->first('item') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                        
                    </div>
                    <div class="row" style="padding-top:10px;" id="reminds_time"> 
                        <div class="col-lg-6">
                            {!!Form::label('time_out','Time Out')!!}       
                            {!!Form::text('time_out','',['class'=>'form-control','placeholder'=>'Time Out','required'=>'required'])  !!} 
                        </div>       
                        <div class="col-lg-6">
                            {!!Form::label('time_in','Time In')!!}       
                            {!!Form::text('time_in','',['class'=>'form-control','placeholder'=>'Time In','required'=>'required'])  !!} 
                        </div>                        
                    </div>
                    <div class="row" style="padding-top:5px;">                                                      
                        <div class="col-lg-6">
                            <div>                                    
                                <label>Approved Official Business <input type="checkbox" class="i-checks" name="appr_obp" value="1"></label>                                    
                            </div>
                            
                        </div>
                    </div>
                    <div class="row" style="padding-top:5px;">                                                      
                        <div class="col-lg-6">
                            <div>                                    
                                <label>Approved Leave <input type="checkbox" class="i-checks" name="appr_leave" value="1"></label>                                    
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top:5px;">                                                      
                        <div class="col-lg-6">
                            <div>                                    
                                <label>Others <input type="checkbox" class="i-checks" name="others" value="1"></label>                                    
                            </div>
                        </div>
                    </div>                                        
                    <div class="row">
                        <div class="form-group pull-right">                               
                                {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                            </div>    
                    </div>
                    {!! Form::close() !!}
                </div>                   
            </div>                                      
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">            
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Created Exit Pass <small></small></h5>
                </div> 
                <div class="ibox-content">
                    <div class="panel blank-panel">                    
                        <div class="panel-body">                                                                      
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>        
                                            <th>NO#</th>
                                            <th>Status</th>                                                
                                            <th>DATE CREATED</th>
                                            
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($exit_pass as $exit)
                                            <tr>
                                                <td>{!! Html::decode(link_to_route('emp_exit_pass.details', $exit->exit_no,$exit->id, array())) !!}</td>
                                                <td>{!! $exit->created_at !!}</td>
                                                <td>
                                                    @if($exit->hrd_action < 1)
                                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                                    @elseif($exit->hrd_action === 2)
                                                    <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                                    @elseif($exit->hrd_action === 3)
                                                    <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                                    @else
                                                    <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
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
</div>    
@stop
@section('page-script')

$('#message_filer_inputs').filer({

    showThumbs:true,
    addMore:true
});

$("#date").datepicker({
    dateFormat: "yy-mm-dd",   
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true
});


@stop