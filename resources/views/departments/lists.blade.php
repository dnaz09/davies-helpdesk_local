@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-building"></i> Department List</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Department was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_update')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Department was successfully updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Create New Department</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'departments.store','methd'=>'POST')) !!}
                    <div class="form-group">
                        {!! Form::label('department','Department') !!}
                        {!! Form::text('department','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Department Here']) !!} 
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
                    <h5 style="color:white"><i class="fa fa-building"></i> Department Table</h5>                    
                </div>
                <div class="ibox-content"> 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>           
                                    <th>DEPARTMENT</th>                                                   
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $department)
                                <tr>
                                    <td>{!! $department->id !!}</td>                   
                                    <td>{!! $department->department !!}</td>                                        
                                    <td>
                                        <button name="rbtn" class="deptbuttn btn btn-info btn-xs" id="{{$department->id}}" value="{{$department->id}}" onclick="deptsEditFunction(this)">
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
<div id="editDeptModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(array('route'=>'departments.updates','method'=>'POST')) !!}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!!Form::label('department','Edit Department')!!}                       
                    {!!Form::text('department','',['class'=>'form-control','placeholder'=>'Enter Name of Department','id'=>'deptname'])!!}                                              
                    @if ($errors->has('department')) <p class="help-block" style="color:red;">{{ $errors->first('department') }}</p> @endif
                </div>                             
            </div>
            <div class="modal-footer">
                {!! Form::hidden('dept_id','',['id'=>'deptID']) !!}
                {!! Form::button('<i class="fa fa-save"></i> Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection
<script type="text/javascript">
    function deptsEditFunction(elem){

        var x = elem.id;

        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {deptid: x},
            url: "../getDeptDetails",
            success: function(data){            
            
                $('#deptname').val(data['department']);
                
                $('#deptID').val(data['id']);

                $('#editDeptModal').modal('show');
            }    
        });
    }
</script>