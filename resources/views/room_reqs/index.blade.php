@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> MY RESERVATIONS</h2> 
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_transfered')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request Has Been Transfered to Next Level!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            <?php if (session('is_returned')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request Has Been Returned!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0)
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
                     
    </div>    
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">            
            <div class="ibox-content">
                <div class="panel blank-panel">
                    <div class="ibox-title"style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-futbol-o"></i> CALENDAR</h5>
                    </div>               
                    <div class="panel-body">                   
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                {!! $calendar->calendar() !!}
                            </div>
                        </div>                                                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">            
            <div class="ibox-content">
                <div class="panel blank-panel">
                    <div class="ibox-title"style="background-color:#009688">
                        <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY RESERVATIONS LIST</h5>                  
                        {!! Html::decode(link_to_Route('room_reqs.create', '<i class="fa fa-plus"></i> Add', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
                    </div>               
                    <div class="panel-body">                   
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-room">
                                    <thead>
                                        <tr>        
                                            <th>CONTROL#</th>    
                                            <th>ROOM</th>      
                                            <th>APPROVAL</th>                                                              
                                            <th>APPROVED BY</th>                                                    
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                        @foreach($rooms as $room)
                                        <tr>
                                            <td>{!! $room->req_no !!}</td>
                                            <td>{!! $room->room !!}</td>
                                            <td>
                                                @if($room->approval < 2)
                                                    <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                                @elseif($room->approval == 5)
                                                    <span class="label label-info"> <i class="fa fa-check"></i> Canceled</span>
                                                @elseif($room->approval == 2)
                                                    <span class="label label-success"> <i class="fa fa-check"></i> Approved</span>
                                                @elseif($room->approval == 3)
                                                    <span class="label label-danger"> <i class="fa fa-check"></i> Denied</span>
                                                @else
                                                @endif
                                            </td>
                                            <td>
                                                @if($room->approval != 5)
                                                @if(!empty($room->approver))
                                                    {!! strtoupper($room->aprvr->first_name.' '.$room->aprvr->last_name) !!}
                                                @else
                                                    <span class="label label-warning"> <i class="fa fa-clock-o"></i> Pending</span>
                                                @endif
                                                @else
                                                    <span class="label label-info"> <i class="fa fa-check"></i> Canceled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($room->status != 5)
                                                {!! Html::decode(link_to_route('room_reqs.show', 'Details',$room->id, array('class'=>'btn btn-primary btn-xs'))) !!}
                                                @if($room->approval < 2)
                                                <button class="btn btn-xs btn-danger" onclick="functionCancelRoomReq(this)" value="{{$room->id}}">Cancel</button>
                                                @endif
                                                @else
                                                CANCELED
                                                @endif
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
    </div>
</div>
@endsection
@section('calendar')
{!! $calendar->script() !!}
@endsection
@section('page-javascript')
function functionCancelRoomReq(elem){
    var id = elem.value;
    swal({
        title: "Are you sure?",
        text: "Your request will be canceled!",
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
                "id": id,
            },
            url: "{{url('room_reqs/cancel')}}",
            success: function(data){            
                var type = data;
                if(type == 'S'){
                    swal('You have canceled your request!');
                    location.reload();
                }
               // if(type == 2){
                    // swal('Sorry but your request was already approved!');
                    // location.reload();
                // }
               // if(type == 3){
                    // swal('Sorry cannot process your request right now');
                    // location.reload();
                // } 
                
                else{
                    swal('Sorry cannot process your request right now');
                    location.reload();
                }
            }    
        });
    });
}
@endsection
