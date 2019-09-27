@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> EDIT ITEM DETAILS</h2> 
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
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-plus"></i> Item Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                        	{!!Form::open(array('route'=>array('asset_trackings.update',$asset->id),'method'=>'PUT'))!!}
								<div class="form-group">
									{!!Form::label('barcode','Item Code')!!}						
									{!!Form::text('barcode',$asset->barcode,['class'=>'form-control','placeholder'=>'Enter Barcode','required'])!!}												
                                    @if ($errors->has('barcode')) <p class="help-block" style="color:red;">{{ $errors->first('barcode') }}</p> @endif
								</div>		
                                <div class="form-group">
                                    {!!Form::label('item_name','Item Name')!!}                      
                                    {!!Form::text('item_name',$asset->item_name,['class'=>'form-control','placeholder'=>'Enter Item Name','required'])!!}                                             
                                    @if ($errors->has('item_name')) <p class="help-block" style="color:red;">{{ $errors->first('item_name') }}</p> @endif
                                </div>
                                <div class="form-group">
                                    {!!Form::label('category', 'Category')!!}
                                    <select class="form-control" name="category">
                                        <option value="{{$asset->category}}">{!!strtoupper($asset->category)!!}</option>
                                        @foreach($categs as $categ)
                                        <option value="{{strtoupper($categ->category_name)}}">{!!strtoupper($categ->category_name)!!}</option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="form-group">
                                    {!!Form::label('brand', 'Brand')!!}
                                    {!!Form::text('brand',$asset->brand,['class'=>'form-control','placeholder'=>'Enter Asset Brand','required'])!!}
                                    @if ($errors->has('brand')) <p class="help-block" style="color:red;">{{ $errors->first('brand') }}</p> @endif
                                </div>                                    
                                <div class="form-group">
                                    {!!Form::label('remarks','Remarks')!!}                      
                                    {!!Form::textarea('remarks',$asset->remarks,['class'=>'form-control','placeholder'=>'Enter Remarks','required'])!!}                                             
                                    @if ($errors->has('remarks')) <p class="help-block" style="color:red;">{{ $errors->first('remarks') }}</p> @endif
                                </div>                                      
								<div class="form-group pull-right">
									{!! Html::decode(link_to_Route('asset_trackings.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                                    <button class="btn btn-primary" type="button" id="edititem"> Save</button>
                                    {!! Form::button('<i class="fa fa-save"></i> Save', array('id'=> 'editeditem', 'type' => 'submit', 'class' => 'btn btn-primary hidden')) !!}
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
$('#edititem').click(function () {
    swal({
        title: "Are you sure?",
        text: "Changes will be saved!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    },function(){
        $('#editeditem').click();
    });
});
@stop