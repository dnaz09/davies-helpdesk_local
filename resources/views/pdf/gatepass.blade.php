<!DOCTYPE html>
<html><head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{!! $company !!} GATEPASS</title>
		<style>
			table.tablestyle, th, td {
				border: 1px solid #000000;
				border-collapse: collapse;
			}
			.tablestyle, .inviborder, .footertable{
				width: 100%;
				height: auto;
			}
			.tablefont{
				text-align: center;
				padding-top: 15px;
			}
			table.footertable tr td, table.inviborder tr td{
				border: none;
			}
			body{
				color: #000000;
				font-family: Arial,Helvetica Neue,Helvetica,sans-serif; 
			}

			.footertable {
				margin-top: 5%;
			}

			
		</style>  
</head><body class="white-bg">
		<canvas>
			<div class="wrapper wrapper-content p-xl">
				<div class="row">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<center>
								<h2>PLANT LOGISTIC GATEPASS</h2> 
								<h4>(NON-TRADE - {!! $company !!})</h4>
							</center>          
						</div> 
						<div class="ibox-content p-xl">
							<table class="inviborder">
								<tr>
									<td><strong>ASSIGNEE: </strong></td>
									<td>{!! $gatepass->requested_by !!}</td>
									<td><strong>CONTROL NO: </strong></td>
									<td>{!! $gatepass->control_no !!}</td>
								</tr>
								<tr>
									<td><strong>FILED BY: </strong></td>
									<td>{!! $employee_name !!}</td>
									<td><strong>DATE: </strong></td>
									<td>{!! date('Y/m/d',strtotime($gatepass->created_at)) !!}</td>
								</tr>
								<tr>
									<td><strong>COMPANY: </strong></td>
									<td>{!! $gatepass->company !!}</td>
									<td><strong>EXIT IN GATE NO: </strong></td>
									<td>
										<?php 
										$exit_gate_no = '';
											switch ($gatepass->exit_gate_no) {
												case '0':
													$exit_gate_no = "GATE 1";
													break;
												case '1':
													$exit_gate_no = "GATE 2";
													break;
												case '2':
													$exit_gate_no = "GATE 3";
													break;
												case '3':
													$exit_gate_no = "GATE 4";
													break;
												default:
													$exit_gate_no = "N/A";
													break;
											}
										?>
										{{$exit_gate_no}}
									</td>
								</tr>
								<tr>
									<td><strong>DEPARTMENT: </strong></td>
									<td>{!! $department !!}</td>
								</tr>
								<tr>
									<td><strong>REF. NO: </strong> </td>
									<td>{!! $gatepass->ref_no !!}</td>
								</tr>
								<tr>
										<td><strong>REMARKS: </strong> </td>
										<td>{!! $gatepass->purpose !!}</td>
								</tr>
							</table>                                    

							<div style="margin-top: 4%;">
								<table class="tablestyle">
									<tr>
										<th>ITEM NO.</th>
										<th>QTY</th>
										<th>U/M</th>
										<th>ASSET NO./SERIAL NO./REF NO.</th>
										<th>PARTICULARS/DESCRIPTION</th>
										<th>PURPOSE</th>
									</tr>
									<?php $count = 0;?>
									@foreach($details as $detail)
									<?php $count++;?>
									<tr class="tablefont">
										<td>{!! $count."." !!}</td>
										<td>{!! $detail->item_qty !!}</td>
										<td>{!! $detail->item_measure !!}</td>
										<td>{!! $detail->description !!}</td>
										<td>{!! $detail->description2 !!}</td>
										<td>{!! $detail->remarks !!}</td>
									</tr>
									@endforeach
								</table>
								<table class="tablestyle" style="margin-top:-2.5px">									
									<tr style="line-height: 50px" align="center">
										<td colspan="1" valign="top" width = "100" style="border-bottom: 0px solid #FFFFFF">Requested by</td>
										<td colspan="2" valign="top" style="border-bottom: 0px solid #FFFFFF">Noted by</td>
										<td colspan="4" valign="top" style="border-bottom: 0px solid #FFFFFF">Approved for Release</td>
										<td colspan="2" valign="top" style="border-bottom: 0px solid #FFFFFF">Checked by</td>
										<td colspan="2" valign="top" style="border-bottom: 0px solid #FFFFFF">Recevied by</td>
									</tr>
									<tr align="center">
											<td colspan="1" valign="bottom" style="border-top: 0px solid #FFFFFF">{!!  $employee_name !!}</td>
											<td colspan="2" valign="bottom" style="border-top: 0px solid #FFFFFF">{!! $gatepass->approver->first_name.' '.$gatepass->approver->last_name !!}</td>
											<td colspan="4" valign="bottom" style="border-top: 0px solid #FFFFFF">@if(!empty($gatepass->issue))
													{!! strtoupper($gatepass->issue->first_name.' '.$gatepass->issue->last_name) !!}
													@else
													<strong>-</strong>
													@endif</td>
											<td colspan="2" valign="bottom" style="border-top: 0px solid #FFFFFF"></td>
											<td colspan="2" valign="bottom" style="border-top: 0px solid #FFFFFF">{!!$gatepass->requested_by!!}</td>
									</tr>
									<tr align="center">
											<td colspan="1" valign="top"></td>
											<td colspan="2" valign="top">GSD</td>
											<td colspan="4" valign="top">Manager</td>
											<td colspan="2" valign="top">Guard on Duty</td>
											<td colspan="2" valign="top">Assignee</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</canvas>
</body></html>
