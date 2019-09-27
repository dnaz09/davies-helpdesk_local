@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> ANNOUNCEMENTS/ MEMO</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Announcement was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('is_updated')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Announcement was successfully Updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> DEPARTMENTS INCLUDED</h5>                       
                </div>
                {{Form::open(array('route'=>'announcements.deptsave','method'=>'POST'))}}
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Department</th>                     
                                <th>Action</th>                         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($depts as $dept)
                            <tr>
                                <td>{!! $dept->department !!}</td>
                                @if(in_array($dept->id, $members))
                                    <td><input type="checkbox" name="dept_id[]" value="{!! $dept->id !!}" checked></td>                                             
                                @else
                                    <td><input type="checkbox" name="dept_id[]" value="{!! $dept->id !!}"></td>                                             
                                @endif  
                            </tr>
                            @endforeach
                        </tbody>                        
                        </table>
                        <input type="hidden" name="id" value="{{$memo->id}}">
                        <button class="btn btn-primary pull-right" type="button" id="saveclick"> Save</button>
                        <button class="hidden" id="clicksave" type="submit"></button>  
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MEMO DETAILS</h5>
                </div>
                {!! Form::open(array('route'=>'announcements.editsave','method'=>'POST')) !!}
                <div class="ibox-content">
                    <div class="table-responsive">
                        <div class="form-group">
                            {!!Form::label('subj','Announcement Subject')!!}
                            {!!Form::text('subj',$memo->subject,['class'=>'form-control','required'])!!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('message','Announcement Message')!!}
                            {!!Form::textarea('message',$string,['class'=>'form-control','required'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::hidden('ann_id',$memo->id) !!}
                            <button class="btn btn-primary" id="editclick" type="button"> Save</button>                   
                            <button class="hidden" id="clickededit" type="submit"></button>    
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>  

@endsection
@section('page-script')
    $('#message_filer_inputs').filer({

        showThumbs:true,
        addMore:true
    });

    $('#saveclick').click(function () {
        swal({
            title: "Are you sure?",
            text: "The recipient of this announcement will be changed!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#clicksave').click();
        });
    });

    $('#editclick').click(function () {
        swal({
            title: "Are you sure?",
            text: "This announcement will be changed!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#clickededit').click();
        });
    });  
@endsection