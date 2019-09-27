@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> RESET PASSWORD</h2>
        <ol class="breadcrumb">
            <li><a href="index.html">Dashboard</a></li>            
            <li><a href="index.html">Users List</a></li>            
            <li class="active"><strong>Reset Password</strong></li>
        </ol>
    </div>
</div>        


 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">    
        <div class="col-md-9 animated flash">
            @if ( count( $errors ) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> User Reset Password Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'users.reset_password_update','method'=>'POST','files'=>true))!!}                               
                                <div class="form-group">
                                    {!!Form::label('user_id','Users')!!}                        
                                    {!!Form::select('user_id',$users,'',['class'=>'form-control','id'=>'user_id', 'required'])!!}
                                </div>                                                                  
                                <div class="form-group">
                                    {!!Form::label('password','Password')!!}              
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password"></input>                      
                                    @if ($errors->has('password')) <p class="help-block" style="color:red;">{{ $errors->first('password') }}</p> 
                                    @endif              
                                </div>
								<div class="form-group pull-right">
									{!! Html::decode(link_to_Route('users.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
									{!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
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
