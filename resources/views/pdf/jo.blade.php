<!DOCTYPE html>
<html><head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{!! $company !!} JOB ORDER FORM</title>
		<link rel="stylesheet" type="text/css" href="assets/ins/style.css">
		<style>
			body{
				color: #000000;
			}
			hr{
				border: 1px solid #000000;
			}
			table, th, td {
			    border: 1px solid #000000;
			    border-collapse: collapse;
			    font-size: 15px;
			}
		</style>  
</head><body class="white-bg">
	<canvas>
		<div class="wrapper wrapper-content p-xl">
			<div class="row">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
					<center>
					<h2>{!! $company !!}</h2> 
					<h4>JOB ORDER SLIP</h4>
					</center>         
					</div> 

					<div class="ibox-content p-xl">                                    
						<p style="padding-top: 20px;">
						<strong>DATE FILED: </strong> {!! $jo->created_at !!}
						<strong class="pull-right" style="margin-left: 30%">JO NO: </strong> {!! $jo->jo_no !!}
						</p>

						<strong>REPORTED BY:</strong><span style="padding-left: 55px"> {!! $employee_name !!}</span>
						<br>
						<strong>COMPANY:</strong><span style="padding-left: 82.5px">{!! $company !!}</span>
						<br>
						<strong>DEPARTMENT:</strong><span style="padding-left: 59px">{!! $department !!}</span>
						<br>
						<strong>LOCATION OF WORK:</strong><span style="padding-left: 15px">{!! $jo->section !!}</span>  

						<p style="padding-top: 10px;">
						<strong>REQUESTED WORK:</strong> <span style="padding-left: 20px">{!! $jo->req_work !!}</span><br>
						<strong>WORK FOR:</strong><span style="padding-left: 77.5px"> {!! $jo->work_for !!}</span><br>
						<strong>ASSET NUMBER:</strong><span style="padding-left: 46px">{!! $jo->asset_no !!}</span><br>
						<strong>ITEM NAME:</strong><span style="padding-left: 77.5px">{!! $jo->other_info.' '.$jo->item_class !!}</span>
						</p>
						<p style="padding-top: 10px;"><strong>DESCRIPTION OF WORK: </strong></p>
						<p style="text-align:justify;margin-left:10em;margin-right:5em">{!! $jo->description !!}</p>

						<div class="row" style="padding-top: 15px;">
							<div class="col-lg-12">
								<p><strong>APPROVED BY: </strong><span style="padding-left: 30px"> {!! strtoupper($jo->supname->first_name.' '.$jo->supname->last_name) !!}</span></p>
							</div>
							<div class="row" style="padding-top: 15px;">
								<br>
								<div class="ibox-title">
									<i>To be filled out by Admin</i><br><br>
									<strong>ENDORSED TO:</strong><span style="padding-left: 20px">{!! $jo->served_by !!}</span><br><br>
									<div class="col-md-12">
										<div class="col-md-6">
											<strong>FINDINGS: </strong><br>
											<p style="text-align:justify;margin-left:5em;margin-right:3em">{!! $jo->work_done !!}</p>
										</div>
										<div class="col-md-6">
											<strong>RECOMMENDATION: </strong><br>
											<p style="text-align:justify;margin-left:5em;margin-right:3em">{!! $jo->reco !!}</p>
										</div>
									</div>
									<div class="col-md-12">
										<p>
											<br><br><br>
											<span class="pull-right" style="margin-left: 75%">{!! $employee_name !!}</span>
											<br>
											<strong style="margin-left: 10%">SERVICED BY</strong>
											<strong class="pull-right" style="margin-left: 52%">VERIFIED BY</strong>
											<br>
											<span style="margin-left: 2%">(Printed Name, Signature and Date)</span>
										</p>
										<br>
										<br>
										<hr>
										<i>To be filled out by Service Provider</i><br><br>
										<strong>DATE STARTED: </strong><span style="padding-left: 40px">{!! $jo->date_started !!}</span><br><br>
										<strong>DATE FINISHED: </strong><span style="padding-left: 40px">{!! $jo->date_finished !!}</span><br><br>
										<strong>TOTAL COST: </strong><span style="padding-left: 55px">{!! $jo->total_cost !!}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>  
	</canvas>
</body></html>
