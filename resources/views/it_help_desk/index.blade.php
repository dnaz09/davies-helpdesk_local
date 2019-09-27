@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> USER ACCESS REQUEST FORM</h2>        
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
            @if( count ($errors) > 0)
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> User Access Request Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'it_helpdesk.user_access_request_store','method'=>'POST','files'=>true))!!}
								<div class="form-group">
									{!!Form::label('category','Category')!!}				
									{!!Form::select('category',$u_acess,null,['class'=>'form-control','placeholder'=>'Select Category','id'=>'category_id','required'])!!}                                      
								</div>
                                <div class="form-group">
                                    {!!Form::label('sub_category','Sub Category')!!}                        
                                    {!!Form::select('sub_category',[],null,['class'=>'form-control','id'=>'sub_category_id','required'])!!}                                      
                                </div>
                                <div class="form-group">
                                    {!!Form::label('errs','Problem')!!}                        
                                    {!!Form::select('error',[],null,['class'=>'form-control','id'=>'error_list','required'])!!}
                                </div>
                                <div class="form-group">                                                               
                                    {!! Form::label('purpose','Purpose')  !!}
                                    <div class="i-checks"><label> <input type="radio" checked="" value="1" name="old"> <i></i> ADDITIONAL ACCESS </label>
                                        <label> <input type="radio" value="2" name="old"> <i></i> NEW USER </label>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    {!!Form::label('details','Details')!!}                        
                                    {!!Form::textarea('details','',['class'=>'form-control','placeholder'=>'Enter Details','required'])!!}                                               
                                    @if ($errors->has('details')) <p class="help-block" style="color:red;">{{ $errors->first('details') }}</p> @endif
                                </div>      
                                <div class="row" style="padding-top:5px;">
                                    <div class="col-lg-12">                  
                                        {!! Form::label('attached','Attached File')!!}
                                        {!! Form::file('attached[]', array('id' => 'filer_inputs_u_access', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                                    </div>
                                </div> -->
								<div class="form-group pull-right">									
                                    <button class="btn btn-primary" id="sendbtn" type="button">Submit</button>
                                    {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'submit', 'id' => 'sentbtn', 'class' => 'btn btn-primary hidden')) !!}
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
@section('page-script')
    $('#filer_inputs_u_access').filer({
        showThumbs:true,
        addMore:true
    });

    $('#category_id').on("change", function(){
        var x = $('#category_id').val();        
        $.ajax({
            type:"POST",
            data: {category_id: x},
            url: "../../it_helpdesk/u_access_sub_category",
            success: function(data){
                $('select#sub_category_id').empty();
                $('<option/>',{value: "", text: 'PLEASE SELECT SUB CATEGORY'}).appendTo($('select#sub_category_id'));
                $.each(data, function(i, text) {
                    $('<option />',{value: i, text: text}).appendTo($('select#sub_category_id'));
                });
            }
        });
    });

    $('#sub_category_id').on("change", function(){
        var x = $('#sub_category_id').val(); 
        $.ajax({
            type:"POST",
            data: {sub_category: x},
            url: "../../it_helpdesk/u_access_error_category",
            success: function(data){
                $('select#error_list').empty();
                if(data == ""){
                $('<option/>',{value: '-',text: '-'}).appendTo($('select#error_list'));
                }else{
                $.each(data, function(i, text) {
                    $('<option />',{value: i, text: text}).appendTo($('select#error_list'));
                });
                }
            }
        });
    }); 

    $('#sendbtn').click(function () {
        swal({
            title: "Are you sure?",
            text: "Your request will be sent!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            var x = $('#sub_category_id').val();
            if(x != ""){
                $('#sentbtn').click();
            }else{
                alert('Please Select A Sub Category');
            }
        });
    });
@endsection