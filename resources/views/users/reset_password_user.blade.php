@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> RESET PASSWORD</h2>        
    </div>
</div>        


 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">    
        <div class="col-lg-12 animated flash">
            <?php if (session('is_reset')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>User password was successfully updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('con_pass_error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Password and Confirm Password do not match!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('password_old_error')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Incorrect old password!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-9 animated flash">
            @if(count($errors) > 0)
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Reset Password Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'users.reset_password_update_user','method'=>'POST','files'=>true))!!}                                                                       
                                <div class="form-group">
                                    {!!Form::label('password','New Password')!!}              
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password"></input>                      
                                    @if ($errors->has('password')) <p class="help-block" style="color:red;">{{ $errors->first('password') }}</p> @endif              
                                </div>
                                <div class="form-group">
                                    {!!Form::label('password','Confirm Password')!!}              
                                    <input type="password" name="con_password" class="form-control" placeholder="Confirm Password"></input>                      
                                    @if ($errors->has('con_password')) <p class="help-block" style="color:red;">{{ $errors->first('con_password') }}</p> @endif              
                                </div>
								<div class="form-group pull-right">
									{!! Html::decode(link_to_Route('dashboard.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                                    <button class="btn btn-primary" id="approvebtn" type="button"><i class="fa fa-save"></i> Submit</button>
								</div>
                                    {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'submit', 'id' => 'submitbtn', 'class' => 'btn btn-primary hidden')) !!}
                        	{!! Form::close() !!}
                        </div>                        
                    </div>
                </div>                   
            </div>             	                        
        </div>              
    </div>    
</div>    
@stop
@section('page-script')
    $('#approvebtn').click(function () {
        swal({
            title: "Are you sure?",
            text: "Your password will be changed!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#submitbtn').click();
        });
    });
@stop