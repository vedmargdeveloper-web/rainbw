@extends(_app())

@section('title', $title ?? 'Fresh Quoation')

@section('content')

	<div class="main-container">
				<!-- Page header end -->
				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<h4 class="p-4">Select Inquiry for create Proforma</h4>
								<div class="table-container">								
									<div class="table-responsive">
										<table id="copy-print-csv" class="table custom-table">
											<thead>
												<tr>
												  <th>Unique Id</th>
												  <th>Client Name</th>
												  <th class="tn-width-increase">Contact Person</th>
												  <th>Mobile</th>
												  <th>WhatsApp</th>
												  <th>Occasion</th>
												  <th>Readyness</th>
												  <th>Venue</th>
												  <th>City</th>
												  <th>Item</th>
												  <th colspan="2">Action</th>
												</tr>
											</thead>
											<tbody>
												
												@if($fresh_inquires)
													@foreach($fresh_inquires as $inv)
													@php
														$customer_details 	= json_decode($inv->customer_details,true);
														$venue_details 		= json_decode($inv->venue_details,true);
                                                        $contact_person 	= $inv->customer ?  json_decode($inv->customer->contact_person_name,true) : false;	
                                                        $contact_person_mobile  = $inv->customer ?  json_decode($inv->customer->mobile,true) : false;
													@endphp
													@if($inv->quotation_count == 0)
														<tr>
															<td>{{ $inv->unique_id}}</td>
														 	<td>{{ $inv->customer->company_name ?? '' }}</td>
														 	<td>
														 		{{ $contact_person ? $contact_person[$inv->contact_person_c] ?? $contact_person[0] : 'Something Wrong' }}
														 	</td>

														 	<td>{{ $contact_person ? $contact_person_mobile[$inv->contact_person_c] ?? $contact_person_mobile[0] : 'Something Wrong' }}</td>
														 	<td>{{ $customer_details['cwhatsapp'] ?? '' }}
														 		{{ $inv->customer->cwhatsapp ?? '' }}</td>
														 	<td>{{ $inv->occassion->occasion ?? '' }}</td>
														 	<td>{{ $customer_details['creadyness'] ?? '' }}</td>
														 	<td>{{ $venue_details['venue_name'] ?? '' }}</td>
														 	<td>{{ $venue_details['dcity'] ?? '' }}</td>
														 	<td> 
														 		@foreach($inv->inquiryItems  as $sinitem)
														 				{{ $sinitem->item->name ?? '' }},
														 		@endforeach
														 	</td>
														 	<td> 
														 		<a href="{{ route('quotation.show',['quotation'=>$inv->id]) }}" class="badge badge-success"> Create Proforma
															 	</a> 
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