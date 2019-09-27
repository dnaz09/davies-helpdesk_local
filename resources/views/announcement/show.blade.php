@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> ANNOUNCEMENTS</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12 animated flash">
		    <?php if (session('is_success')): ?>
		        <div class="alert alert-success alert-dismissible fade in" role="alert">
		            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		        </button>
		            <center><h4>Announcement was successfully edited!<i class="fa fa-check"></i></h4></center>                
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
	                <h5 style="color:white"><i class="fa fa-futbol-o"></i> ANNOUNCEMENTS</h5>	                	
	            </div>
	            <div class="ibox-content">
	            	<div class="table-responsive">
		            	<table class="table table-striped table-bordered table-hover dataTables-example" >
			            <thead>
				            <tr>
				                <th>Subject</th>
				                <th>Message</th>               
				                <th>Created By</th>
				                <th>Created At</th>			                
				                <th>Action</th>			                
				            </tr>
			            </thead>
			            <tbody>
				           	@foreach($anncs as $annc)
				           	<tr>
				           		<td>{!! $annc->subject !!}</td>
				           		<td>{!! $annc->message !!}</td>
				           		<td>{!! strtoupper($annc->uploader->first_name.' '.$annc->uploader->last_name) !!}</td>
				           		<td>{!! $annc->created_at !!}</td>
				           		<td>
				           			{!! Html::decode(link_to_Route('announcements.depts','<i class="fa fa-pencil"></i> Edit', $annc->id, array('class' => 'btn btn-info btn-xs')))!!}
				           			<button type="button" class="btn btn-xs btn-danger btndelete" name="deleteButton" value="{{$annc->id}}" onclick="functionDeleteMemo(this)"><i class="fa fa-trash"></i> Delete</button>
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
@stop
@section('page-javascript')
function functionDeleteMemo(elem){
    swal({
        title: "Are you sure?",
        text: "This Announcement will be deleted!",
        icon: "warning",
        dangerMode: true,
        showCancelButton: true,
        confirmButtonText: "Yes, i am sure!"
    }, function (willDelete) {
    	var id = elem.value
        if(willDelete) {
            $.ajax({
                type: "post",
                url: "{{url('announcements/delete')}}",
                data: {
                    id: id,
                },
                success: function () {
                    swal({
                        title: "Please Wait!",
                        buttons: false,
                        timer: 10000,
                    });
                    window.location.reload()
                },
                failed: function(data){
                    alert("Error in Deleting, Kindly reload the page");
                }
            });
        }
        else {
            swal("Deletion aborted!");
        }
    });
}
@endsection