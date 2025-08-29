@extends(_app())

@section('title', $title ?? 'Dashboard')

@section('content')

	<div class="main-container">
				<!-- Page header end -->
				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="table-container">								
									<div class="table-responsive">
										<table id="copy-print-csv" class="table custom-table">
											<thead>
												<tr>
												  <th>Invoice Type</th>
												  <th>Invoice No</th>
												  <th>Billing Date</th>
												  <th>Customer Type</th>
												  <th>Net Amount</th>
												  <th>Net Discount</th>
												  <th>Total Tax</th>
												  <th>Total Amount</th>
												  <th colspan="2">Action</th>
												</tr>
											</thead>
											<tbody>
												@if($invoices && count($invoices) > 0)
													@foreach($invoices as $inv)
													<tr>
													 	<td>{{ ucfirst($inv->invoice_type)  }}</td>
													 	<td>{{ $inv->invoice_no  }}</td>
													 	<td>{{ date('d-m-Y',strtotime($inv->billing_date))}}</td>
													 	<td>{{ $inv->customerType ? $inv->customerType->type : ''   }}</td>
													 	<td>{{ $inv->net_amount  }}</td>
													 	<td>{{ $inv->net_discount  }}</td>
													 	<td>{{ $inv->total_tax  }}</td>
													 	<td>{{ $inv->total_amount  }}</td>
													 	<td colspan="3">
														 	<a href="{{ route('invoice.edit',['invoice'=>$inv->id]) }}" class="badge badge-success">Edit
														 	</a>
													 	
													 		<a href="{{ route('invoice.print',['id'=>$inv->id]) }}" class="badge badge-info">Print
													 		</a>
													 		<a href="{{ route('invoice.email',['id'=>$inv->id]) }}" class="badge badge-success">Email Invoice
													 		</a>
													 	</td>
													</tr>
													@endforeach
												@endif
											</tbody>
							    		</table>
									</div>
								</div>
							</div>
						</div>		
					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
			</div>
		
@endsection