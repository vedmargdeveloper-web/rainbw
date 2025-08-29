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
												  <th>Booking No</th>
												  <th>Quotation Id</th>
												  <th>Client Name</th>
												  <th>Contact Person Name</th>
												  <th>Mobile</th>
												  <th>Booking Date</th>
												 	<th>Readyness</th>
												  <th>Venue</th>
												  <th>Occassion</th>
												  
												  <th>Total Amount</th>
												  <th>Items</th>
												  <th colspan="2">Action</th>
												</tr>
											</thead>
											<tbody>
												@if($invoices && count($invoices) > 0)
													@foreach($invoices as $inv)
														@php
															$customer_details 	= json_decode($inv->customer_details,true);
															$venue_details 		= json_decode($inv->delivery_details,true);
															//dd($venue_details);
														@endphp
													<tr>
													 	<td>{{ $inv->invoice_no  }}</td>
													 	<td>{{ $inv->quotaiton->invoice_no ?? '' }}</td>
												 		<td>{{ $customer_details['company_name'] ?? '' }}</td>
													 	<td>{{ is_numeric( $customer_details['contact_person_c'] ) ?  $customer_details['select_two_name'] ?? '' : $customer_details['contact_person_c'] }}</td>
													 	<td>
													 		
													 	{{ $customer_details['cmobile'] ?? '' }}</td>
													 	<td>{{ date('d-m-Y',strtotime($inv->billing_date))}}</td>
													 	<td>{{ $customer_details['creadyness'] ?? '' }}</td>
													 	<td>{{ $venue_details['dvenue_name'] ?? '' }}</td>
													 	<td>{{ $inv->quotaiton->occasion->occasion ?? '' }}</td>
													 	
													 
													 	<td>{{ $inv->total_amount  }}</td>
												 		<td> 
													 		@foreach($inv->bookingItem  as $sinitem)
													 				{{ $sinitem->item ?? '' }},
													 		@endforeach
													 	</td>
													 	<td colspan="3">
														{{--  	<a href="{{ route('booking.show',['booking'=>$inv->id]) }}" class="badge badge-success">Create Booking
														 	</a>
													 	 --}}
													 		<a href="{{ route('booking.print',['id'=>$inv->id]) }}" class="badge badge-info">Print
													 		</a>
													 		<a href="{{ route('booking.email',['id'=>$inv->id]) }}" class="badge badge-success">Email Booking
													 		</a>
													 		<a href="{{ route('booking.edit',['booking'=>$inv->id]) }}" class="badge badge-primary">Edit
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