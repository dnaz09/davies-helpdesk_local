@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> CREATE MAINTENANCE</h2>        
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
        </div>    
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Maintenance Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            {!!Form::open(array('route'=>'job_order_m.store','method'=>'POST'))!!}
                                <div class="form-group">
                                    {!!Form::label('category','New Location')!!} 
                                    {!!Form::text('new','',['class'=>'form-control','placeholder'=>'Enter New Maintenance'])!!}                                             
                                    @if ($errors->has('new')) <p class="help-block" style="color:red;">{{ $errors->first('category') }}</p> @endif
                                </div>
                                <input type="hidden" name="type" value="1">                             
                                <div class="form-group pull-right">
                                    {!! Html::decode(link_to_Route('job_order_m.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                                    {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                                </div>                  
                            {!! Form::close() !!}
                        </div>                        
                    </div>
                </div>                   
            </div>                                      
        </div>              
    </div>    
</div>    
@stop