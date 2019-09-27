@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> New User</h2>        
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> User Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            {!!Form::open(array('route'=>'users.store','method'=>'POST','files'=>true))!!}
                                <div class="form-group">  
                                    <div id="dvPreview"></div></br>                 
                                    {!!Form::label('Image','Upload Image')!!}   
                                    <span>{{ Form::file('image', array('id' => 'fileupload' ,'accept' => 'gif|jpg|png|jpeg|bmp')) }}</span>                               
                                </div>      
                                <div class="form-group">
                                    {!!Form::label('first_name','First Name')!!}                        
                                    {!!Form::text('first_name','',['class'=>'form-control','placeholder'=>'Enter First Name','required'=>'required'])!!}                                               
                                    @if ($errors->has('first_name')) <p class="help-block" style="color:red;">{{ $errors->first('first_name') }}</p> @endif
                                </div>      
                                <div class="form-group">
                                    {!!Form::label('last_name','Last Name')!!}                        
                                    {!!Form::text('last_name','',['class'=>'form-control','placeholder'=>'Enter Last Name','required'=>'required'])!!}                                               
                                    @if ($errors->has('last_name')) <p class="help-block" style="color:red;">{{ $errors->first('last_name') }}</p> @endif
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('middle_initial','Middle Initial')!!}                        
                                    {!!Form::text('middle_initial','',['class'=>'form-control','placeholder'=>'Enter Middle Initial','required'=>'required'])!!}                  
                                    @if ($errors->has('middle_initial')) <p class="help-block" style="color:red;">{{ $errors->first('middle_initial') }}</p> @endif                             
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('employee_number','Employee Number')!!}                        
                                    {!!Form::text('employee_number','',['class'=>'form-control','placeholder'=>'Enter Employee Number','required'=>'required'])!!}                
                                    @if ($errors->has('employee_number')) <p class="help-block" style="color:red;">{{ $errors->first('employee_number') }}</p> @endif                               
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('email','Email')!!}                        
                                    {!!Form::text('email','',['class'=>'form-control','placeholder'=>'Enter Email'])!!}                                    
                                    @if ($errors->has('email')) <p class="help-block" style="color:red;">{{ $errors->first('email') }}</p> @endif           
                                </div>
                                <div class="form-group">
                                    {!!Form::label('role_id','Role')!!}                        
                                    {!!Form::select('role_id',$roles,null,['class'=>'form-control','required'=>'required'])!!}     
                                </div>                                  
                                <div class="form-group">
                                    {!!Form::label('dept_id','Department')!!}                        
                                    {!!Form::select('dept_id',$departments,null,['class'=>'form-control','required'=>'required'])!!}
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('superior_id','Superior')!!}                        
                                    {!!Form::select('superior_id',$superiors,null,['class'=>'form-control','required'=>'required'])!!}
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('company','Company')!!}                        
                                    {!!Form::select('company',$companies,null,['class'=>'form-control','required'=>'required'])!!}
                                    @if ($errors->has('company')) <p class="help-block" style="color:red;">{{ $errors->first('company') }}</p> @endif                 
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('location_id','Location')!!}                        
                                    {!!Form::select('location_id',$locations,null,['class'=>'form-control'])!!}
                                </div>                                                                  
                                <div class="form-group">
                                    {!!Form::label('cellno','Cell #')!!}                        
                                    {!!Form::text('cellno','',['class'=>'form-control','placeholder'=>'Enter Cell #'])!!}                                    
                                    @if ($errors->has('cellno')) <p class="help-block" style="color:red;">{{ $errors->first('cellno') }}</p> @endif                 
                                </div>  
                                <div class="form-group">
                                    {!!Form::label('localno','Local #')!!}                        
                                    {!!Form::text('localno','',['class'=>'form-control','placeholder'=>'Enter Local #'])!!}                                    
                                    @if ($errors->has('localno')) <p class="help-block" style="color:red;">{{ $errors->first('localno') }}</p> @endif                 
                                </div>                                  
                                <div class="form-group">
                                    {!!Form::label('password','Password')!!}              
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required=""></input>                                   
                                    @if ($errors->has('password')) <p class="help-block" style="color:red;">{{ $errors->first('password') }}</p> @endif                                        
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
@endsection
