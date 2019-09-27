@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> HR ANNOUNCEMENT / MEMO</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Announcement was Successfuly Sent!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('empty_id')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>No Department Selected! Please Choose a department</h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Announcement / Memo Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        {!! Form::open(array('route'=>'announcements.store','method'=>'POST','files'=>true)) !!}
                        <div class="col-sm-6">
                            <div class="row" style="padding-top:10px;">
                                <div class="col-lg-12">
                                    {!!Form::label('subject','Subject')!!}
                                    {!! Form::text('subject','',['class'=>'form-control','required'=>'required']) !!}
                                    @if ($errors->has('subject')) <p class="help-block" style="color:red;">{{ $errors->first('subject') }}</p> @endif
                                </div>
                            </div>   
                            <div class="row" style="padding-top:5px;">
                                <div class="col-lg-12">
                                    {!!Form::label('message','Message')!!}
                                    {!! Form::textarea('message','',['class'=>'form-control']) !!}
                                    @if ($errors->has('message')) <p class="help-block" style="color:red;">{{ $errors->first('message') }}</p> @endif
                                </div>
                            </div>                                    
                            <div class="row" style="padding-top:5px;">
                                <div class="col-lg-12">                  
                                    {!! Form::label('attached','Attached File')!!}
                                    {!! Form::file('attached[]', array('id' => 'message_filer_inputs', 'class' => 'photo_files', 'accept' => 'pdf|docx')) !!}                   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered table-hover" id="dept_tb">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>ID</th>
                                            <th>DEPARTMENT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($depts as $dept)
                                        <tr>
                                            <td><input type="checkbox" name="dept_id[]" value="{{ $dept->id }}" class="checkboxes"></td>
                                            <td>{!!$dept->id!!}</td>
                                            <td>{!!$dept->department!!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">                                             
                                <button class="btn btn-primary" value="Submit" type="submit">Submit</button>
                            </div> 
                        </div>                 
                        {!! Form::close() !!}                                            
                    </div>
                </div>                   
            </div>             	                        
        </div>              
    </div>    
</div>    
@endsection
@section('page-script')
    $('#dept_tb').DataTable({
        paging: false,
        responsive: true,
        filtering: true,                                        
    });
    $('#message_filer_inputs').filer({

        showThumbs:true,
        addMore:true
    })

    $('#deptID').multiselect({
        maxHeight: 200,
        includeSelectAllOption: true,
        enableCaseInsensitiveFiltering: true,
        enableFiltering: true,
        buttonWidth: '100%',
        buttonClass: 'form-control',
    });

$('#checkAll').click(function (event) {
    if (this.checked) {
        $('.checkboxes').each(function () { //loop through each checkbox
            $(this).prop('checked', true); //check 
        });
    } else {
        $('.checkboxes').each(function () { //loop through each checkbox
            $(this).prop('checked', false); //uncheck              
        });
    }
});
@endsection