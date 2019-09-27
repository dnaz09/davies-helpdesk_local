@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> CREATE USER ACCESS REQUEST SUB CATEGORY</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>            
            <li><a href="#">User Access Request List</a></li>            
            <li class="active"><strong>Create Sub Category</strong></li>
        </ol>
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> User Access Request Sub Category Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            {!!Form::open(array('route'=>'user_access_request.store_sub','method'=>'POST'))!!}
                                <div class="form-group">
                                    {!!Form::label('category','Category')!!}                       
                                    {!!Form::select('category',$category,null,['class'=>'form-control'])!!}                                     
                                    @if ($errors->has('category')) <p class="help-block" style="color:red;">{{ $errors->first('category') }}</p> @endif
                                </div>                                      
                                <div class="form-group">
                                    {!!Form::label('sub_category','Category')!!}                       
                                    {!!Form::text('sub_category','',['class'=>'form-control','placeholder'=>'Enter Sub Category'])!!}                                             
                                    @if ($errors->has('sub_category')) <p class="help-block" style="color:red;">{{ $errors->first('sub_category') }}</p> @endif
                                </div>                                      
                                <div class="form-group pull-right">
                                    {!! Html::decode(link_to_Route('user_access_request.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
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