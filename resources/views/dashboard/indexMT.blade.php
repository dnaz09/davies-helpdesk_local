@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>HOME</h2>        
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <button class="btn btn-warning btn-md" onclick="taskFunction()"><i class="fa fa-plus"> Notes</i> </button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">     
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_notes')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>New Notes Has Been Added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_approved')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been approved!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been approved!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_deny')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been denied!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
            <?php if (session('is_denied')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request has been denied!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-bullhorn"></i> Announcement</h5>                    
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                        
                    </div>
                </div>
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-envelope-o"></i> Recent Announcements</h3>
                    <small><i class="fa fa-tim"></i> There are {!! $ann_cntr !!} Announcements</small>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-announcement" >
                        <thead>
                            <tr>
                                <td><strong>ANNOUNCEMENTS</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcements as $announcement)
                            <tr>
                                <td>
                                   <div class="feed-activity-list">
                                        <div class="feed-element">
                                            <div>
                                                <small class="pull-right text-navy">{!! $announcement->created_at->diffForHumans() !!}</small>
                                                <strong><a href="/memo/{{$announcement->id}}/details" id="{{$announcement->id}}" value="{{$announcement->id}}">{!! $announcement->subject !!}</a></strong>
                                                <div>
                                                    <small class="text-muted">{!! $announcement->created_at->format('m/d/Y h:i a') !!}</small>
                                                </div>                           
                                            </div>
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6" id="noteflow">
            <ul class="notes">
                @foreach($notes as $note)
                <li>
                    <div>
                        <small>{!! $note->created_at !!}</small>
                        <h4>{!! $note->title !!}</h4>
                        <p id="noteflows">{!! $note->notes !!}</p> 
                        <a href="#">
                            <button class="btn" style="margin-top: 7.5%" onclick="funtionDeleteNote(this)" value="{{ $note->id }}"><i class="fa fa-trash-o"></i></button>
                            <button class="btn" style="margin-top: 7.5%" onclick="funtionGetNoteContent(this)" value="{{ $note->id }}"><i class="fa fa-pencil"></i></button>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row" id="notification_id">        
        <mtdash :mtog="mtog"></mtdash>
    </div>    
</div>
<!-- Modal -->
<div id="memoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header" style="background-color:#009688">                
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
                <center><h2 id="titlememo" style="color: white;"></h2></center>
            </div>
            <div class="modal-body">
                <p id="memobody">
                    
                </p>
                <p>Files:</p>
                {!! Form::open(array('route'=>'memo.download')) !!}
                    <div id="filememo">
                    
                    </div>
                {!! Form::close() !!}                
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>        
    </div>
</div>
<div id="taskModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header" style="background-color:#009688">                
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
                <center><h2 style="color: white;">Sticky Notes</h2></center>
            </div>
            {!! Form::open(array('route'=>'sticky_notes.store','method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('title','Title') !!}
                    {!! Form::text('title','',['class'=>'form-control','placeholder'=>'your title','required'=>'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('notes','Notes') !!}
                    {!! Form::textarea('notes','',['class'=>'form-control','placeholder'=>'text here...','required'=>'required']) !!}
                </div>
            </div>
            <div class="modal-footer">          
                {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}      
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
            {!! Form::close() !!}
        </div>        
    </div>
</div>
<div id="edittaskModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header" style="background-color:#009688">                
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
                <center><h2 style="color: white;">Update My Sticky Notes</h2></center>
            </div>
            {!! Form::open(array('route'=>'sticky_notes.updating','method'=>'POST')) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('title','Title') !!}
                    {!! Form::text('title','',['class'=>'form-control','placeholder'=>'your title','required'=>'required','id'=>'title_id']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('notes','Notes') !!}
                    {!! Form::textarea('notes','',['class'=>'form-control','placeholder'=>'text here...','required'=>'required','id'=>'body_id']) !!}
                </div>
                <input type="hidden" name="id" id="note_id">
            </div>
            <div class="modal-footer">          
                {!! Form::button('<i class="fa fa-save"></i> Submit', array('type' => 'button', 'class' => 'btn btn-primary','id'=>'editBtn')) !!} 
                <button class="hidden" id="editBtnPressed"></button>     
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
            {!! Form::close() !!}
        </div>        
    </div>
</div>
@endsection
@section('page-javascript')
    $('#editBtn').click(function () {
        swal({
            title: "Are you sure?",
            text: "Your Note will be edited!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            $('#editBtnPressed').click();
        });
    });
    function taskFunction(){
        $('#taskModal').modal('show');
    }
    function rolesEditFunction(elem){

        var x = elem.id;
     
        $.ajax({

            type:"POST",
            dataType: 'json',
            data: {memoid: x},
            url: "../getMemoDetails",
            success: function(data){            
                
                document.getElementById("titlememo").innerHTML = data['subject'].toUpperCase();
                document.getElementById("memobody").innerHTML = data['message'];
                

                $('#memoModal').modal('show');
            }    
        });
    }
    function funtionGetNoteContent(elem){
        var id = elem.value;
        $.ajax({
            type:"POST",
            dataType: 'json',
            data: {
                id: id
            },
            url: "{{ route('sticky_notes.details') }}",
            success: function(data){
                $('#title_id').val(data['title']);
                $('#body_id').val(data['notes']);
                $('#note_id').val(data['id']);

                $('#edittaskModal').modal('show');
            }
        });
    }
    function funtionDeleteNote(elem){
        swal({
            title: "Are you sure?",
            text: "Your note will be deleted!",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Yes, i am sure!"
        },function(){
            var id = elem.value;
            $.ajax({
                type:"POST",
                dataType: 'json',
                data: {
                    id: id
                },
                url: "{{ route('sticky_notes.delt') }}",
                success: function(data){
                    if(data == 1){
                        location.reload();
                    }
                    if(data == 2){
                        swal('Error in deleting Note!');
                    }
                }
            }); 
        });
    }
@endsection
