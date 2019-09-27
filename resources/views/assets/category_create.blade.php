@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> NEW CATEGORY</h2> 
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
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-plus"></i> Category Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>'item_categories.add','method'=>'POST'))!!}	
                                <div class="form-group">
                                    {!!Form::label('categoryname','Category Name')!!}                      
                                    {!!Form::text('category_name','',['class'=>'form-control','placeholder'=>'Enter Category Name'])!!}                                             
                                    @if ($errors->has('item_name')) <p class="help-block" style="color:red;">{{ $errors->first('item_name') }}</p> @endif
                                </div>
								<div class="form-group pull-right">
									{!! Html::decode(link_to_Route('item_categories.list', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
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