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
								<h5 class="p-2">Select Quotation ready for booking</h5>
								<div class="table-container">								
									<div class="table-responsive">
							    		<table id="copy-print-csv" class="table custom-table">
											<thead>
												<tr>
												  <th>Quotation Id</th>
												  <th>Client Name</th>
												  <th>Contact Person</th>
												  <th>Mobile</th>
												 {{--  <th>WhatsApp</th> --}}
												  <th>Occasion</th>
												  <th>Readyness</th>
												  <th>Venue</th>
												  {{-- <th>City</th> --}}
												  <th>Item</th>
												  <th colspan="2">Action</th>
												</tr>
											</thead>
											<tbody>
												
												@if($invoices)
													
													@foreach($invoices as $inv)
													@php
														$customer_details 	= json_decode($inv->customer_details,true);
														$venue_details 		= json_decode($inv->delivery_details,true);
														//print_r($customer_details);
														// dd($status);

														$status = $inv->leadstatus->status ?? '';
													@endphp
													
													@if($status == 'Proceed for Booking' || $status == 'Update: Confirmed & Booked' || $status == 'Update: Confirmed & Booked.' )
														<tr>
															<td>{{ $inv->invoice_no}}.{{ $inv->pitch_count }}</td>
														 	<td>{{ $customer_details['company_name'] ?? '' }}</td>
														 	<td>{{ is_numeric( $customer_details['contact_person_c'] ) ?  $customer_details['select_two_name'] ?? '' : $customer_details['contact_person_c'] }}</td>
														{{--  	<td>{{  == 0 ?  'name' : $customer_details['contact_person_c'] }}</td> --}}
														 	<td>{{ $customer_details['cmobile'] ?? '' }}</td>
														 {{-- 	<td>{{ $customer_details['cwhatsapp'] ?? '' }}</td> --}}
														 	<td>{{ $inv->occasion->occasion ?? '' }}</td>
														 	<td>{{ $customer_details['creadyness'] ?? '' }}</td>
														 	<td>{{ $venue_details['dvenue_name'] ?? '' }}</td>
														 	{{-- <td>{{ $venue_details['dcity'] ?? '' }}</td> --}}
														 	<td> 
														 		@foreach($inv->quotationItem  as $sinitem)
														 				{{ $sinitem->item ?? '' }},
														 		@endforeach
														 	</td>
														 	<td colspan="3" class="td-flex">
															{{-- @if($inv->pitch_count <= 0 )
															 	<a href="{{ route('quotation.edit',['quotation'=>$inv->id]) }}" class="badge badge-success">Edit
															 	</a>
															@endif --}}
													 		<a href="{{ route('booking.show',['booking'=>$inv->id]) }}?&gstid={{$inv->gst_id ?? ''}}" class="badge badge-success">Create Booking 
														 	</a>
													 		{{-- <a href="{{ route('quotation.email',['id'=>$inv->id]) }}" class="badge badge-success mt-2">Email Quotation
													 		</a> --}}
													 	</td>
														</tr>
													@endif
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