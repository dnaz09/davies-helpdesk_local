@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-reply"></i> SUPPLIES LIST</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Supply was successfully added!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		    <?php if (session('is_update')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Supply was successfully updated!<i class="fa fa-check"></i></h4></center>                
		        </div>
		    <?php endif;?>
		</div>
	</div>	
    <div class="row">
        <div class="col-lg-12">
	        <div class="ibox float-e-margins">
	            <div class="ibox-title" style="background-color:#009688">
	                <h5 style="color:white"><i class="fa fa-tags"></i> LIST OF SUPPLIES</h5>
	                {!! Html::decode(link_to_Route('rooms.create', '<i class="fa fa-plus"></i> New Supply', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
	                <button type="button" class="btn btn-white btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Import</button>
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>#</th>
				                <th>Material Code</th>
				                <th>Description</th>
				                <th>Category</th>
				                <th>Action</th>			               
				            </tr>
			            </thead>
			            <tbody>
				           @forelse($supplies as $supply)
				           		<tr>
				           			<td>{!! $supply->id !!}</td>
				           			<td>{!! $supply->material_code !!}</td>
				           			<td>{!! $supply->description !!}</td>
				           			<td>{!! $supply->category !!}</td>
				           			<td>{!! Html::decode(link_to_Route('rooms.edit','<i class="fa fa-pencil"></i> Edit', $supply->id, array('class' => 'btn btn-info btn-xs')))!!}</td>
				           		</tr>
				           	@empty
				           	@endforelse
			            </tbody>			            
		            	</table>
		            </div>
	            </div>
	        </div>
	    </div>
    </div>
</div>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-envelope modal-icon"></i>
                <h4 class="modal-title">Import Supplies</h4>                    
            </div>              
            {!! Form::open(array('route'=>'supply_m.import','method'=>'POST','files'=>true)) !!}
                <div class="modal-body">                                                                                
                    <div class="row" style="padding-top:5px;">
                        <div class="col-lg-12">                  
                            {!! Form::label('attached','Attached File')!!}
                            <input type="file" required="" name="supplyfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                                              
                    {!! Form::button('Close', array('type' => 'submit', 'class' => 'btn btn-white','data-dismiss'=>'modal')) !!}
                    <button class="btn btn-primary" value="Submit">Submit</button>
                </div>                  
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop