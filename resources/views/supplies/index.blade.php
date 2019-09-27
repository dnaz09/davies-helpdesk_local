@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> Supplies List</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Supplies was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_update')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Supplies was successfully updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> Add New Supply</h5>
                    {!! Html::decode(link_to_Route('supplies.import', '<i class="fa fa-upload"></i> Upload', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'supplies.store','methd'=>'POST')) !!}
                    <div class="form-group">
                        {!! Form::label('category','Category') !!}
                        {!! Form::text('category','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Category']) !!} 
                    </div>
                    <div class="form-group">
                        {!! Form::label('material_code','Material Code') !!}
                        {!! Form::text('material_code','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Material Code']) !!} 
                    </div>
                    <div class="form-group">
                        {!! Form::label('description','Description') !!}
                        {!! Form::textarea('description','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Description Here']) !!} 
                    </div>
                    <div class="form-group">                        
                        {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                    </div>                          
                </div>                
                {!! Form::close() !!}                
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> Supplies Table</h5>                    
                </div>
                <div class="ibox-content"> 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>                   
                                    <th>CATEGORY</th>                     
                                    <th>MATERIAL CODE</th>  
                                    <th>DESCRIPTION</th>                                      
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplies as $supply)
                                <tr>            
                                    <td>{!! $supply->category !!}</td>                            
                                    <td>{!! $supply->material_code !!}</td>
                                    <td>{!! $supply->description !!}</td>
                                    <td>
                                    <button name="rbtn" class="supbuttn btn btn-info btn-xs" id="{{$supply->id}}" value="{{$supply->id}}" onclick="supEditFunction(this)">
                                            <i class="fa fa-pencil"></i>
                                    </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>   
                    </div>                    
                </div>                                    
            </div>
        </div>
    </div>
</div>
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="editSupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(array('route'=>'supplies.updates','method'=>'POST')) !!}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                {!!Form::label('name','Edit Role')!!}
            </div>
            <div class="modal-body">
                <div class="form-group">
                        {!! Form::label('category','Category') !!}
                        {!! Form::text('category','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter material code here','id'=>'catname']) !!} 
                </div>
                <div class="form-group">
                    {!! Form::label('material','Material Code') !!}
                    {!! Form::text('material_code','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter material code here','id'=>'matname']) !!} 
                </div>
                <div class="form-group">
                    {!! Form::label('description','Description') !!}
                    {!! Form::textarea('description','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter description here','id'=>'matdesc']) !!} 
                </div>             
            </div>
            <div class="modal-footer">
                {!! Form::hidden('sup_id','',['id'=>'supID']) !!}
                {!! Form::button('<i class="fa fa-save"></i> Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection
<script type="text/javascript">
    function supEditFunction(elem){

        var x = elem.id;

        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {supid: x},
            url: "../getSupplyDetails",
            success: function(data){            
                $('#catname').val(data['category']);
                $('#matname').val(data['material_code']);
                $('#matdesc').val(data['description']);
                $('#supID').val(data['id']);

                $('#editSupModal').modal('show');
            }    
        });
    }
</script>