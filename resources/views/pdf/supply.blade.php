<!DOCTYPE html>
<html><head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{!! $company !!} MRS FORM</title>
		<style>
			
				body{
					color: #000000;
					font-family: Arial,Helvetica Neue,Helvetica,sans-serif; 
				}
				table.tablestyle, th, td {
				    border: 1px solid #000000;
				    border-collapse: collapse;
				}
				.tablestyle, .inviborder{
					width: 100%;
					height: auto;
				}
				.tablefont{
					text-align: center;
					padding-top: 15px;
					margin-left:auto; 
   			 	margin-right:auto;
				}

				table.inviborder tr td{
					border: none;
				}
			</style>  
</head><body>
		<center>
			<div class="ibox-title">
				<h5>
						<h2>{!! $company !!}</h2> 
						<h4>MATERIAL REQUEST SLIP</h4>
				</h5>          
			</div> 
			<table class="inviborder">
					<tr>
						<td><strong>REQUESTOR: </strong></td>
						<td>{!! $employee_name !!}</td>
						<td><strong>MRS NO: </strong></td>
						<td>{!! $supp->req_no !!}</td>
					</tr>
					<tr>
						<td><strong>COMPANY: </strong></td>
						<td>{!! $company !!}</td>
						<td><strong>DATE: </strong></td>
						<td>{!! date('Y/m/d',strtotime($supp->created_at)) !!}</td>
					</tr>
					<tr>
						<td><strong>DEPARTMENT: </strong></td>
						<td>{!! $department !!}</td>
					</tr>
					<tr>
						<td><strong>PURPOSE: </strong></td>
						<td>{!! $supp->details !!}</td>
					</tr>
					<tr>
						<td><strong>ADDRESS: </strong></td>
						<td>{!! $supp->deliver !!}</td>
					</tr>
					<tr>
						<td><strong>VIA: </strong> </td>
						<td>{!! $supp->via !!}</td>
						<td><strong>DECLARED VALUE: </strong></td>
						<td> {!! $supp->value !!}</td>
					</tr>

				</table>
				<br>
				<div>
					<table class="tablestyle">
							<tr>
								<th>QTY</th>
								<th>U/M</th>
								<th>CATEGORY</th>
								<th>ITEM DESCRIPTION</th>
								<th>STATUS</th>
							</tr>
							@foreach($details as $detail)
							<div class="hidden">
								<?php
								
								$item = $detail->item;
								$category = explode(' ',$item) 
								?>
							</div>
							<tr class="tablefont">
								<td>{!! $detail->status == 3 ? " - " : ($detail->status == 1 ? $detail->qty : $detail->qty_r) !!}</td>
								<td>{!! $detail->measurement !!}</td>
								<td>{!! $category[0] !!}</td>
								<td>{!! $detail->item !!}</td>
								<td>
									@if($detail->status < 2)
										Pending
									@elseif($detail->status == 2)
										Served
									@elseif($detail->status == 3)
										Out of Stock
									@elseif($detail->status == 5)
										Canceled
									@endif
								</td>
							</tr>
							@endforeach
					</table>
			</div>
			</center>
			<br>
			<br>
			<strong>RECEIVED BY: </strong><br><br><br>
			<div style="width: 50%; margin-left: -9%;">
				<center>
					@if(!empty($supp->received_by))
						{!! $supp->received_by !!}
					@else 
						{!! $employee_name !!}
					@endif
					@if($supp->status == 2){!! date('Y/m/d',strtotime($supp->created_at)) !!}@endif<br><br>
					<hr style="margin: -2% 20% 2% 20% ;">
					<strong>Signature Over Printed Name/ Date</strong>
				</center>
			</div>
</body></html>