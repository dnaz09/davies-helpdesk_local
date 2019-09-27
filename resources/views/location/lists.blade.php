@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-building"></i> Locations List</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Location was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_update')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Location was successfully updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Create New Location</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'locations.store','methd'=>'POST')) !!}
                    <div class="form-group">
                        {!! Form::label('location','Location') !!}
                        {!! Form::text('location','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Location Here']) !!} 
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
                    <h5 style="color:white"><i class="fa fa-building"></i> Location Table</h5>                    
                </div>
                <div class="ibox-content"> 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>                                  
                                    <th>LOCATION</th>                                                   
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($locations as $location)
                                <tr>
                                    <td>{!! $location->id !!}</td>                                   
                                    <td>{!! $location->location !!}</td>                                        
                                    <td>
                                        <button name="rbtn" class="deptbuttn btn btn-info btn-xs" id="{{$location->id}}" value="{{$location->id}}" onclick="locsEditFunction(this)">
                                                <i class="fa fa-pencil"></i> Edit
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
<div id="editLocModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(array('route'=>'locations.updates','method'=>'POST')) !!}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!!Form::label('location','Edit Location')!!}                       
                    {!!Form::text('location','',['class'=>'form-control','placeholder'=>'Enter Name of Location','id'=>'locname'])!!}                                              
                    @if ($errors->has('location')) <p class="help-block" style="color:red;">{{ $errors->first('location') }}</p> @endif
                </div>                             
            </div>
            <div class="modal-footer">
                {!! Form::hidden('location_id','',['id'=>'locID']) !!}
                {!! Form::button('<i class="fa fa-save"></i> Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection
<script type="text/javascript">
    function locsEditFunction(elem){

        var x = elem.id;

        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {locationid: x},
            url: "../getLocDetails",
            success: function(data){            
            
                $('#locname').val(data['location']);
                
                $('#locID').val(data['id']);

                $('#editLocModal').modal('show');
            }    
        });
    }
</script>