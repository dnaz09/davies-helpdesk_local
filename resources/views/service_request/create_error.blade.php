@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> CREATE SERVICE REQUEST ERROR</h2>        
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Service Request Error Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            {!!Form::open(array('route'=>'service_request.store_error','method'=>'POST'))!!}
                                <div class="form-group">
                                    {!!Form::label('sub_category','Sub Category')!!}                       
                                    {!!Form::select('sub_category',$subs,null,['class'=>'form-control'])!!}                                     
                                    @if ($errors->has('sub_category')) <p class="help-block" style="color:red;">{{ $errors->first('sub_category') }}</p> @endif
                                </div>                                      
                                <div class="form-group">
                                    {!!Form::label('error','Error Name')!!}                       
                                    {!!Form::text('sub_sub_category','',['class'=>'form-control','placeholder'=>'Enter Name of Error'])!!}                                             
                                    @if ($errors->has('sub_sub_category')) <p class="help-block" style="color:red;">{{ $errors->first('sub_sub_category') }}</p> @endif
                                </div>                                      
                                <div class="form-group pull-right">
                                    {!! Html::decode(link_to_Route('service_request.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
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