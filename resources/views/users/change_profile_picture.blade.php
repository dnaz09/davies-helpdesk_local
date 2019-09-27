@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> CHANGE PROFILE PICTURE</h2>        
    </div>
</div>        


 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">    
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Profile picture was successfully updated! <i class="fa fa-check"></i></h4></center>                
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> Change Profile Picture Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">  
                            <table class="table table-stripped table-hover" id="mydata">
                              <tr>
                                  <td class="bold">Profile Picture</td>
                                  <td class="gray">
                                  <?php $user = Auth::user(); ?>
                                  <?php $imgURL = (!$user->image ? '/uploads/users/default.jpg' : '/uploads/users/'.$user->employee_number.'/'.$user->image); ?>  
                                  <span id="picture_echo" class=""><img class="img-circle pull-left" style="width:50px; height:50px;" alt="" src="{{ $imgURL  }}"></span>
                                      <div class="col-md-10 hidden" id="div_picture">
                                          <legend><strong>Upload your profile picture</strong></legend>
                                        {!!Form::open(array('id' => 'picture_form', 'route'=>'users.change_profile_picture','method'=>'POST','files'=> true))!!}
                                              <div class="form-group">  
                                              <div id="dvPreview"></div><br>                 
                                              <label for="Image">Upload Image</label>   
                                              <span><input id="fileupload" accept="gif|jpg|png|jpeg|bmp" name="image" type="file"></span>                               
                                              </div>

                                              <br>
                                              <input type="submit" value="Save Changes" class="btn btn-primary"> <button type="button" class="btn btn-default" id="user_cancel0">Cancel</button>
                                        {!! Form::close() !!}
                                      </div>
                              </td>
                                  <td style="text-align: right"><button type="button" class="btn btn-link" id="picture_button">Edit</button></td>
                                  <td>                                   

                              </tr>
                            </table>                          
                        	{{-- {!!Form::open(array('route'=>'users.reset_password_update_user','method'=>'POST','files'=>true))!!}                                                                       
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
                        	{!! Form::close() !!} --}}
                        </div>                        
                    </div>
                </div>                   
            </div>             	                        
        </div>              
    </div>    
</div>    
@stop
@section('page-script')
$("#picture_button").click(function(){
  $("#div_picture").addClass("hidden");
  $("#div_picture").removeClass("hidden");
});

$("#user_cancel0").click(function(){
  $("#div_picture").addClass("hidden");
  $("#picture_echo").removeClass("hidden");
});
@stop