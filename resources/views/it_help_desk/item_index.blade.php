@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> ITEM REQUEST FORM</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>            
            <li><a href="#">IT Support</a></li>            
            <li><a href="#">Request</a></li>   
            <li class="active"><strong>Item Request</strong></li>
        </ol>
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-7 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            @if($errors->has())
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> IT Request Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'it_helpdesk.item_request_store','method'=>'POST','files'=>true))!!}
								<div class="form-group">
									{!!Form::label('item','Item')!!}						
									{!!Form::select('item',$i_acess,null,['class'=>'form-control','placeholder'=>'Select Item','id'=>'item'])!!}                                      
								</div>                                
                                <div class="form-group">
                                    {!!Form::label('details','Details')!!}                        
                                    {!!Form::textarea('details','',['class'=>'form-control','placeholder'=>'Enter Details','required'=>'required'])!!}                                               
                                    @if ($errors->has('details')) <p class="help-block" style="color:red;">{{ $errors->first('details') }}</p> @endif
                                </div>      
                                <div class="row" style="padding-top:5px;">
                                    <div class="col-lg-12">                  
                                        {!! Form::label('attached','Attached File')!!}
                                        {!! Form::file('attached[]', array('id' => 'filer_inputs_u_access', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                                    </div>
                                </div>
								<div class="form-group pull-right">									
                                    <button class="btn btn-primary" value="Submit">Submit</button>
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
@section('page-script')

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });   
@stop