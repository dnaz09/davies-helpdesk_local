@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> MODULE DETAILS</h2> 
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-7 animated flash">
            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>  
        <div class="col-md-7 animated flash">
            <?php if (session('is_barcode')): ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Barcode Already Exists!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Success!</h4></center>   
                </div>
            <?php endif;?>
        </div>   
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-plus"></i> Module Details <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'modules.edit','method'=>'POST'))!!}
                                <div class="form-group">
                                    {!!Form::label('id','Module ID')!!}                        
                                    {!!Form::text('module_id',$module->id,['class'=>'form-control','readonly'])!!}                                               
                                    @if ($errors->has('module_id')) <p class="help-block" style="color:red;">{{ $errors->first('module_id') }}</p> @endif
                                </div>
								<div class="form-group">
                                    {!!Form::label('name','Module Name')!!}                     
                                    {!!Form::text('module',$module->module,['class'=>'form-control'])!!}                                                
                                    @if ($errors->has('module')) <p class="help-block" style="color:red;">{{ $errors->first('module') }}</p> @endif
                                </div>
                                <div class="form-group">
									{!!Form::label('dept','Department')!!}						
									{!!Form::text('department',$module->department,['class'=>'form-control'])!!}												
                                    @if ($errors->has('department')) <p class="help-block" style="color:red;">{{ $errors->first('department') }}</p> @endif
								</div>		
                                <div class="form-group">
                                    {!!Form::label('detail','Description')!!}                      
                                    {!!Form::text('description',$module->description,['class'=>'form-control'])!!}                                             
                                    @if ($errors->has('description')) <p class="help-block" style="color:red;">{{ $errors->first('description') }}</p> @endif
                                </div>
                                <div class="form-group">
                                    {!!Form::label('route','Route')!!}                      
                                    {!!Form::text('routeUri',$module->routeUri,['class'=>'form-control'])!!}                                             
                                    @if ($errors->has('routeUri')) <p class="help-block" style="color:red;">{{ $errors->first('routeUri') }}</p> @endif
                                </div>
                                <div class="form-group">
                                    {!!Form::label('URL','URL')!!}                      
                                    {!!Form::text('default_url',$module->default_url,['class'=>'form-control'])!!}                                             
                                    @if ($errors->has('default_url')) <p class="help-block" style="color:red;">{{ $errors->first('default_url') }}</p> @endif
                                </div>
                                <div class="form-group">
                                    {!!Form::label('Icon','Icon')!!}                      
                                    {!!Form::text('icon',$module->icon,['class'=>'form-control'])!!}                                             
                                    @if ($errors->has('icon')) <p class="help-block" style="color:red;">{{ $errors->first('icon') }}</p> @endif
                                </div>
								<div class="form-group pull-right">
									{!! Html::decode(link_to_Route('modules.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
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