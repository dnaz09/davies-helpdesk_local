<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{!! $company !!} OFFICIAL BUSINESS FORM</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">    
<link rel="stylesheet" type="text/css" href="assets/ins/style.css">
<link href="/assets/css/animate.css" rel="stylesheet">
<style>
table, th, td {
    border: 2px solid #000000;
    border-collapse: collapse;
}
</style> 
</head><body class="white-bg">
<canvas>
<div class="wrapper wrapper-content p-xl">
<div class="row">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5><i class="fa fa-pencil"></i><center>
<h2>{!! $company !!}</h2>
<h4>OFFICIAL BUSINESS FORM</h4>
</center></h5>          
</div> 
<div class="ibox-content p-xl">                                    
<div class="row">
<div class="col-lg-12">
<p>
<strong>EMPLOYEE'S NAME:</strong> {!! $employee_name !!}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>DATE FILED:</strong> {!! $obp->created_at !!}
</p>
</div>
<div class="col-lg-12">
<p>
<strong>POSITION:</strong> {!! $position !!}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>DEPARTMENT: </strong> {!! $department !!}
</p>                            
</div>
</div>                        
<p style="padding-top: 10px;"><strong>PURPOSE:</strong></p>
<p>{!! $obp->purpose !!}</p>
<p style="padding-top: 15px;"><strong>ITENERARY</strong></p>
<div class="table-responsive col-lg-12">
<table>
<tr>
<th>#</th>
<th>DESTINATION</th>
<th>NAME OF PERSON VISITED</th>
<th>DATE</th>
<th>TIME OF ARRIVAL</th>
<th>TIME OF DEPARTURE</th>
<th>ACKNOWLEDGED BY PERSON VISITED</th>
</tr>


<tr style="padding-top: 15px;">
<td>1.)</td>
<td>{!! $obp_details->destination !!}</td>
<td>{!! $obp_details->person_visited !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

@if(!empty($obp_details->destination2))
<tr style="padding-top: 15px;">
<td>2.)</td>
<td>{!! $obp_details->destination2 !!}</td>
<td>{!! $obp_details->person_visited2 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif

@if(!empty($obp_details->destination3))
<tr style="padding-top: 15px;">
<td>3.)</td>
<td>{!! $obp_details->destination3 !!}</td>
<td>{!! $obp_details->person_visited3 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif

@if(!empty($obp_details->destination4))
<tr style="padding-top: 15px;">
<td>4.)</td>
<td>{!! $obp_details->destination4 !!}</td>
<td>{!! $obp_details->person_visited4 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif

@if(!empty($obp_details->destination5))
<tr style="padding-top: 15px;">
<td>5.)</td>
<td>{!! $obp_details->destination5 !!}</td>
<td>{!! $obp_details->person_visited5 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif


</table>           
</div>       
<div class="row" style="padding-top: 20px;">
<div class="col-lg-12">
<p>
<strong>DATE NEEDED: </strong> {!! $obp->date !!} <strong> - </strong> {!! $obp->date2 !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br><br>
<strong>TIME OF DEPARTURE: __________</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>TIME OF ARRIVAL: __________</strong>
</p>
</div>
</div> 
<div class="row" style="padding-top: 15px;">
<div class="col-lg-12">
<p>
<strong>APPROVED BY: </strong> 
	@if($obp->manager_action == 2)
		{!! strtoupper($obp->apvr->first_name.' '.$obp->apvr->last_name) !!} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	@else
	@endif
<strong>
		NOTED BY:
</strong> 
		@if($obp->hr_action == 1)
			@if(!empty($obp->hrd))
			{!! strtoupper($obp->hrds->first_name.' '.$obp->hrds->last_name) !!}
			@endif
		@else
		@endif

</p>
</div>
</div>                                                 
</div>
</div>
</div>
</canvas>
</div>
<script src="/assets/js/bootstrap.min.js"></script>        
<script type="text/javascript">
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>    
</body></html>

{{-- <!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{!! $company !!} OFFICIAL BUSINESS FORM</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">    
<link rel="stylesheet" type="text/css" href="assets/ins/style.css">
<link href="/assets/css/animate.css" rel="stylesheet">
<style>
table, th, td {
    border: 2px solid #000000;
    border-collapse: collapse;
}
</style> 
</head><body class="white-bg">
<canvas>
<div class="wrapper wrapper-content p-xl">
<div class="row">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5><i class="fa fa-pencil"></i><center>
<h2>{!! $company !!}</h2>
<h4>OFFICIAL BUSINESS FORM</h4>
</center></h5>          
</div> 
<div class="ibox-content p-xl">                                    
<div class="row">
<div class="col-lg-12">
<p>
<strong>EMPLOYEE'S NAME:</strong> {!! $employee_name !!}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>DATE FILED:</strong> {!! $obp->created_at !!}
</p>
</div>
<div class="col-lg-12">
<p>
<strong>POSITION:</strong> {!! $position !!}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>DEPARTMENT: </strong> {!! $department !!}
</p>                            
</div>
</div>                        
<p style="padding-top: 10px;"><strong>PURPOSE:</strong></p>
<p>{!! $obp->purpose !!}</p>
<p style="padding-top: 15px;"><strong>ITENERARY</strong></p>
<div class="table-responsive col-lg-12">
<table>
<tr>
<th>#</th>
<th>DESTINATION</th>
<th>NAME OF PERSON VISITED</th>
<th>DATE</th>
<th>TIME OF ARRIVAL</th>
<th>TIME OF DEPARTURE</th>
<th>ACKNOWLEDGED BY PERSON VISITED</th>
</tr>


<tr style="padding-top: 15px;">
<td>1.)</td>
<td></td>
<td></td>
<td>{!! $obp_details->destination !!}</td>
<td>{!! $obp_details->person_visited !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

@if(!empty($obp_details->destination2))
<tr style="padding-top: 15px;">
<td>2.)</td>
<td>{!! $obp_details->destination2 !!}</td>
<td>{!! $obp_details->person_visited2 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif

@if(!empty($obp_details->destination3))
<tr style="padding-top: 15px;">
<td>3.)</td>
<td>{!! $obp_details->destination3 !!}</td>
<td>{!! $obp_details->person_visited3 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif

@if(!empty($obp_details->destination4))
<tr style="padding-top: 15px;">
<td>4.)</td>
<td>{!! $obp_details->destination4 !!}</td>
<td>{!! $obp_details->person_visited4 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif

@if(!empty($obp_details->destination5))
<tr style="padding-top: 15px;">
<td>5.)</td>
<td>{!! $obp_details->destination5 !!}</td>
<td>{!! $obp_details->person_visited5 !!}</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endif


</table>           
</div>       
<div class="row" style="padding-top: 20px;">
<div class="col-lg-12">
<p>
<strong>DATE NEEDED: </strong> {!! $obp->date !!} <strong> - </strong> {!! $obp->date2 !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br><br>
<strong>TIME OF DEPARTURE: __________</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>TIME OF ARRIVAL: __________</strong>
</p>
</div>
</div> 
<div class="row" style="padding-top: 15px;">
<div class="col-lg-12">
<p>
<strong>APPROVED BY: </strong> 
	@if($obp->manager_action == 2)
		{!! strtoupper($obp->apvr->first_name.' '.$obp->apvr->last_name) !!} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	@else
	@endif
<strong>
		NOTED BY:
</strong> 
		@if($obp->hr_action == 1)
			@if(!empty($obp->hrd))
			{!! strtoupper($obp->hrds->first_name.' '.$obp->hrds->last_name) !!}
			@endif
		@else
		@endif

</p>
</div>
</div>                                                 
</div>
</div>
</div>
</canvas>
</div>
<script src="/assets/js/bootstrap.min.js"></script>        
<script type="text/javascript">
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>    
</body></html>
 --}}