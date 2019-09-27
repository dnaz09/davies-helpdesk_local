@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-play-circle-o"></i> Roles List</h2>
    </div>        
</div>      
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Role was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_update')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Role was successfully updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Create New Role</h5>
                </div>
                <div class="ibox-content">                    
                {!! Form::open(array('route'=>'roles.store','methd'=>'POST')) !!}
                    <div class="form-group">
                        {!! Form::label('role','Role') !!}
                        {!! Form::text('role','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Role Here']) !!} 
                    </div>
                    <div class="form-group">
                        {!! Form::label('description','Description') !!}
                        {!! Form::textarea('description','',['class'=>'form-control','required'=>'required','placeholder'=>'Enter Dscription Here']) !!} 
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
                    <h5 style="color:white"><i class="fa fa-play-circle-o"></i> Roles Table</h5>                    
                </div>
                <div class="ibox-content"> 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>                  
                                    <th>ROLE</th>  
                                    <th>DESCRIPTION</th>                                      
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>  
                                    <td>{!! $role->id !!}</td>                                
                                    <td>{!! $role->role !!}</td>
                                    <td>{!! $role->description !!}</td>
                                    <td>
                                    <button name="rbtn" class="rolebuttn btn btn-info btn-xs" id="{{$role->id}}" value="{{$role->id}}" onclick="rolesEditFunction(this)">
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
<div id="editRoleModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        {!! Form::open(array('route'=>'roles.updates','method'=>'POST')) !!}
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                {!!Form::label('name','Edit Role')!!}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!!Form::label('role','Edit Role')!!}                       
                    {!!Form::text('role','',['class'=>'form-control','placeholder'=>'Enter Name of Role','id'=>'rolename'])!!}                                              
                    @if ($errors->has('role')) <p class="help-block" style="color:red;">{{ $errors->first('role') }}</p> @endif
                </div>               
                <div class="form-group">
                    {!!Form::label('description','Description')!!}                        
                    {!!Form::text('description','',['class'=>'form-control','placeholder'=>'Enter Role Description','id'=>'roledesc'])!!}                                               
                    @if ($errors->has('description')) <p class="help-block" style="color:red;">{{ $errors->first('description') }}</p> @endif
                </div>            
            </div>
            <div class="modal-footer">
                {!! Form::hidden('role_id','',['id'=>'roleID']) !!}
                {!! Form::button('<i class="fa fa-save"></i> Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection
<script type="text/javascript">

    function rolesEditFunction(elem){

        var x = elem.id;

        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {roleid: x},
            url: "../getRoleDetails",
            success: function(data){            
            
                $('#rolename').val(data['role']);
                $('#roledesc').val(data['description']);
                $('#roleID').val(data['id']);

                $('#editRoleModal').modal('show');
            }    
        });
    }
</script>