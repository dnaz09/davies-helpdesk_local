@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> SERVICE REQUEST FORM</h2>
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>            
            <li><a href="#">IT Support</a></li>            
            <li><a href="#">Request</a></li>   
            <li class="active"><strong>Service Request</strong></li>
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
                    <h5 style="color:white"><i class="fa fa-plus"></i> Service Request Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'it_helpdesk.service_request_store','method'=>'POST','files'=>true))!!}
								<div class="form-group">
									{!!Form::label('category','Category')!!}						
									{!!Form::select('category',$s_acess,null,['class'=>'form-control','placeholder'=>'Select Category','id'=>'category_id','required'])!!}                                      
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
                                    {!!Form::label('asset_no','Asset Number (Leave blank if none)')!!}  
                                    <!-- <select class="form-control" name="asset_no">
                                        <option value=""></option>
                                        @foreach($assets as $asset)
                                        <option value="{{$asset->barcode}}">{!! $asset->item_name !!}</option>
                                        @endforeach
                                    </select> -->                  
                                    {!!Form::text('asset_no','',['class'=>'form-control','placeholder'=>'Enter Asset Number'])!!}
                                </div>
                                <!-- <div class="form-group">
                                    {!!Form::label('details','Details')!!}                        
                                    {!!Form::textarea('details','',['class'=>'form-control','placeholder'=>'Enter Details','required'=>'required'])!!}                                               
                                    @if ($errors->has('details')) <p class="help-block" style="color:red;">{{ $errors->first('details') }}</p> @endif
                                </div>  -->     
                                <!-- <div class="row" style="padding-top:5px;">
                                    <div class="col-lg-12">                  
                                        {!! Form::label('attached','Attached File')!!}
                                        {!! Form::file('attached[]', array('id' => 'filer_inputs_u_access', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                                    </div>
                                </div> -->
								<div class="form-group pull-right">
                                    <button class="btn btn-primary" id="servicesentbtn" type="button"> Submit</button>
                                    <button class="btn btn-primary hidden" value="Submit" id="servicesendbtn">Submit</button>
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

    $('#category_id').on("change", function(){
        var x = $('#category_id').val();        
        $.ajax({
            type:"POST",
            data: {category_id: x},
            url: "../../it_helpdesk/service_request_sub_category",
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
            url: "../../it_helpdesk/service_request_error_category",
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

    $('#servicesentbtn').click(function () {
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
                $('#servicesendbtn').click();
            }else{
                alert('Please Select A Sub Category');
            }
        });
    }); 
@stop