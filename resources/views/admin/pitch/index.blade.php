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
													
													@foreach($invoices as $key=> $inv)
													@php
														$customer_details 	= json_decode($inv->quotation->customer_details,true);
														$venue_details 		= json_decode($inv->quotation->delivery_details,true);			
														$pname 				= json_decode($inv->pname,true);			

														//print_r($customer_details);
													@endphp
														<tr>

															<td>{{ $inv->quotation->invoice_no ?? ''}}</td>
														 	<td>{{ $customer_details['company_name'] ?? '' }}</td>
														 	<td>{{ $customer_details['contact_person_c'] ?? '' }}</td>
														{{--  	<td>{{  == 0 ?  'name' : $customer_details['contact_person_c'] }}</td> --}}
														 	<td>{{ $customer_details['cmobile'] ?? '' }}</td>
														 {{-- 	<td>{{ $customer_details['cwhatsapp'] ?? '' }}</td> --}}
														 	<td>{{ $inv->quotation->occasion->occasion ?? '' }}</td>
														 	<td>{{ $customer_details['creadyness'] ?? '' }}</td>
														 	<td>{{ $venue_details['dvenue_name'] ?? '' }}</td>
														 	{{-- <td>{{ $venue_details['dcity'] ?? '' }}</td> --}}
														 	<td> 
														 		{{ $pname[$key] ?? '' }}	
														 	</td>
														 	<td colspan="3">
															 	<a href="{{ route('pitch.edit',['pitch'=>$inv->id]) }}" class="badge badge-success">Edit
															 	</a>
															 	<a href="{{ route('pitch.print',['id'=>$inv->id]) }}" class="badge badge-info">Print
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