@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> EDIT LEAVE</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Undertime has been Created!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0)
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
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Leave Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>array('undertime.update',$undertime->id),'method'=>'PUT','files'=>true))!!}          
                                    
                    <div class="row">
                        <div class="col-sm-4"> 
                            <div class="form-group">                                                                            
                                {!! Form::label('user_id','Name') !!}
                                {!! Form::text('user_id',strtoupper($user->first_name.' '.$user->last_name),['class'=>'form-control','id'=>'users_id','readonly'=>'readonly']) !!}
                            </div>       
                        </div>                 
                    </div>                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('sched','Schedule of Leave') !!}
                                {!! Form::text('sched',$undertime->sched,['class'=>'form-control','placeholder'=>'Enter Schedule','required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="col-sm-12">                                                                                
                            <div class="form-group">
                                {!!Form::label('reason','Reason')!!}                       
                                {!!Form::textarea('reason',$undertime->reason,['class'=>'form-control','placeholder'=>'Enter Reason','required'=>'required'])!!}                                             
                                @if ($errors->has('reason')) <p class="help-block" style="color:red;">{{ $errors->first('reason') }}</p> @endif
                            </div>                                                                                                            
                        </div>                                        
                    </div>                            
                    <div class="row">
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('undertime.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <button class="btn btn-primary" type="button" id="undertimeedit"> Update</button>
                            {!! Form::button('<i class="fa fa-save"></i> Update', array('id'=>'undertimeokay','type' => 'submit', 'class' => 'btn btn-primary hidden')) !!}
                        </div>    
                    </div>
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    {!! Form::close() !!}
                </div>                   
            </div>                                      
        </div>                    
    </div>    
</div>    
@stop
@section('page-script')
$('#undertimeedit').click(function () {
    swal({
        title: "Are you sure?",
        text: "Changes will be saved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#undertimeokay').click();
    });
});
@stop
