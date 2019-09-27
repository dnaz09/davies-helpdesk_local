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
    </div>  
	<div class="row">
        <div class="ibox-content">
            <table class="table table-striped table-bordered table-hover dataTables-announcement" >
                <thead>
                    <tr>
                        <th>ANNOUNCEMENTS</th>
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
        <div class="col-lg-6" id="noteflow">
            <ul class="notes">
                @foreach($notes as $note)
                <li>
                    <div>
                        <small>{!! $note->created_at !!}</small>
                        <h4>{!! $note->title !!}</h4>                        
                            <p id="noteflows">{!! $note->notes !!}</p>
                        
                        
                        <a href="#">
                        {!! Form::open(array('route'=>'sticky_notes.delt','method'=>'POST')) !!}
                            {!!Form::hidden('noted',$note->id) !!}
                            {!! Form::button('<i class="fa fa-trash-o"></i>', array('type' => 'submit', 'class' => 'btn')) !!}
                        {!! Form::close() !!}
                        </a>       
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
	</div>    
    <div class="row" id="notification_id">
        <asdash
            :assetp="assetp"
            :supplyp="supplyp"
            :jop="jop"
            :totalsupply="totalsupply"
            :totalasset="totalasset"
            :totaljo="totaljo"
        ></asdash>
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
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Close</button>
            </div>
        </div>        
    </div>
</div>
<!-- Modal -->
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
<script type="text/javascript">
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
</script>
@endsection

