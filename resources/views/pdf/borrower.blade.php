<!DOCTYPE html>
<html><head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{!! $company !!} BORROWER'S SLIP</title>
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
								<h2>{!! $company !!}</h2> 
								<h4>BORROWER'S SLIP</h4>
						</div> 
					</center>          
						<table class="inviborder">
							<tr>
								<td>
									<strong>Borrower's Slip No: </strong>
								</td>
								<td>
									{!! $req->req_no !!}
								</td>
								<td>
									<strong>Date Filed: </strong>
								</td>
								<td>
									{!! date('Y/m/d',strtotime($req->created_at)) !!}
								</td>
							</tr>
							<tr>
								<td>
									<strong>Borrower's Code: </strong>
								</td>
								<td>
										{!! $bcode !!}
								</td>
								<td>
									<strong>Date Needed: </strong>
								</td>
								<td>
									@if($req->slip->date_needed == "")
										N/A
									@else
										{!! date('Y/m/d',strtotime($req->slip->date_needed)) !!}
									@endif
								</td>
							</tr>
							<tr>
								<td>
									<strong>Company: </strong>
								</td>
								<td>
										{!! $company !!}
								</td>
								<td>
									<strong>Date Return: </strong>
								</td>
								<td>
									{!! date('Y/m/d',strtotime($req->slip->must_date)) !!}
								</td>
							</tr>
							<tr>
								<td>
									<strong>Department: </strong>
								</td>
								<td>
										{!! $department !!}
								</td>
								<td>
									<strong>Borrowed By: </strong>
								</td>
								<td>
									{!! $req->borrower_name !!}
								</td>
							</tr>
							<tr>
								<td><strong>Purpose: </strong></td>
								<td colspan="4">{!! $req->details !!}</td>
							</tr>
						</table>
						<br>
						<div>
							<table class="tablestyle">
								<tr class="tablefont">
									<th>QTY RELEASED</th>
									<th>ASSET NO.</th>
									<th>ITEM NAME</th>
									<th>ACCESSORIES</th>
								</tr>
								@foreach($slips as $slip)
								<tr class="tablefont">
									<td>{!! $slip->qty_r !!}</td>
									<td>{!! $slip->asset_barcode !!}</td>
									<td>{!! strtoupper($slip->item) !!}</td>
									<td>{!! strtoupper($slip->accs) !!}</td>
								</tr>
								@endforeach
							</table>           
						</div>
							<br>
							<p><strong>Pick up by: </strong> {!! $req->slip->get_by !!}</p>

							<br>
							<br>
	
							<strong>__________________________</strong>
							<br>
							<i style="margin-left: 5%;">Signature and Date </i>
							<br>
							<br>
							<strong>Note: </strong> (The name given to pick up the items upon creation of request should be the one appear in the print out.)

</body></html>
