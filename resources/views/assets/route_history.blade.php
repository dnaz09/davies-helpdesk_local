@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> BORROWED ITEM CURRENT STATUS</h2>       
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Success! <i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_pass')): ?>
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Password Doesn't Match!</h4></center>   
                </div>
           <?php endif;?>
        </div>    
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
                   
    </div>    
</div>    

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">        
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> ASSET DETAILS <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <table class="table table-hover table-bordered">
                                        
                        <tr>
                            <td style="width:30%"><i><strong>BARCODE #:</strong></i></td><td>{!! $asset->barcode !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>ITEM NAME #:</strong></i></td><td>{!! $asset->item_name !!}</td>
                        </tr>                                                                                                                      
                        <tr>
                            <td style="width:30%"><i><strong>STATUS:</strong></i></td>
                            <td>
                                @if($asset->io > 0)
                                    <span class="label label-warning">IN</span>
                                @else
                                    <span class="label label-primary">OUT</span>
                                @endif
                            </td>
                        </tr>                        
                        <tr>
                            <td style="width:30%"><i><strong>DETAILS:</strong></i></td><td>{!! strtoupper($asset->remarks) !!}</td>
                        </tr>   
                        <tr>
                            <td style="width:30%"><i><strong>HOLDER:</strong></i></td><td>
                                @if($asset->io != 1)
                                {!! strtoupper($asset->user->first_name.' '.$asset->user->last_name) !!}</td>
                                @endif
                                {!! strtoupper('currently on hand') !!}
                        </tr>                                                    
                    </table>                                         
                </div>                   
            </div>                                      
        </div> 
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> ADD REMARKS <small></small></h5>          
                </div> 
                {!! Form::open(array('route'=>'asset_trackings.route_history_update','method'=>'POST','files'=>true)) !!}
                @if($asset->io > 0)                 
                <div class="ibox-content">
                    <div class="form-group">
                        {!! Form::label('user_id','Employee Name') !!}
                        {!! Form::select('user_id',$users,'',['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>
                    <div class="form-group">                                    
                        {!!Form::label('date','Item/s must be return on this date')!!}                 
                        <span>{!! Form::text('date', '', array('class' => 'form-control date_input', 'id' => 'date', 'data-date-format' => 'yyyy/mm/dd', 'placeholder' => 'yyyy/mm/dd','required'=>'required')) !!}</span>
                        @if ($errors->has('date')) <p class="help-block" style="color:red;">{{ $errors->first('date') }}</p> @endif                                    
                    </div>     
                    <div class="form-group">                          
                        {!! Form::hidden('barcode',$asset->barcode) !!}  
                        {!! Form::hidden('type','1')!!}<br>     
                        <button class="btn btn-warning" name ="sub" value="1" this.form.submit()>Release</button>                                                
                    </div>                      
                </div>                               
                @else
                <div class="ibox-content">                    
                    <div class="form-group" >
                        {!! Form::label('remarks','Add Your Remarks') !!}
                        {!! Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'You Remarks Here...','required'=>'required']) !!}                       
                    </div>
                    <div class="form-group" style="margin-top:5px;">  
                        {!! Form::hidden('barcode',$asset->barcode,['class'=>'form-control']) !!}                                                       
                        {!! Form::hidden('type','0')!!}     
                        {!! Form::hidden('user_id',$asset->holder) !!}
                        <button class="btn btn-warning" name ="sub" value="1" this.form.submit();>Recieve</button>                                                
                    </div>                      
                </div>         
                @endif
                {!! Form::close() !!}   
               
            </div> 
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                 <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white">Remarks</h5>                    
                </div>

                <div class="ibox-content inspinia-timeline" id="flow2">
                @forelse($routings as $remark)
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-briefcase"></i>
                                {!! $remark->created_at->format('M-d-Y h:i a') !!}
                                <br/>
                                <small class="text-navy">{!! $remark->created_at->diffForHumans() !!}</small>
                            </div>
                            <div class="col-xs-7 content no-top-border">
                                <p class="m-b-xs"><strong>{!! strtoupper($remark->user->first_name.' '.$remark->user->last_name ) !!}</strong></p>
                                <p><strong>{!! $remark->remarks2 !!}</strong></p>
                                <div style="margin-top: 10px;">                      
                                <p>{!! $remark->remarks !!}</p>              
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    ....No Remarks Found
                @endforelse   
                </div>
            </div>
        </div>    
                   
    </div>    
</div>   

@stop
@section('page-script')
$("#date").datepicker({
    dateFormat: "yy-mm-dd",   
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true
});

@endsection