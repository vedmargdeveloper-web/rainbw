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
							@php
								$leads =  App\Models\Lead::get();
							@endphp
							<form action="{{ route('inquiry.index') }}" method="get">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<select class="form-control" name="filter">
												@foreach($leads as $lead)
													<option value="{{ $lead->id }}">{{ $lead->lead }}</option>
												@endforeach									
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<button type="submit" class="btn btn-primary" >Filter</button>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="table-container">								
									<div class="table-responsive">
										<table id="copy-print-csv" class="table custom-table">
											<thead>
												<tr>
												  <th>Unique Id</th>
												  <th>Client Name</th>
												  <th>Unique id</th>
												  <th>Phone No</th>
												  <th>Email</th>
												  <th>Whatsapp</th>
												  <th>Lead Status</th>
												  <th colspan="2">Action</th>
												</tr>
											</thead>
											<tbody>
												@if($inquiry && count($inquiry) > 0)
													@foreach($inquiry as $inv)
													@php
														$customer =  json_decode($inv->customer_details,true);
														
                                                        $contact_person 		= $inv->customer ?  json_decode($inv->customer->contact_person_name,true) : false;	
                                                        $contact_person_mobile  = $inv->customer ?  json_decode($inv->customer->mobile,true) : false;
 
													@endphp
													<tr>
													 	<td>{{ $inv->unique_id ?? '' }} </td>
													 	<td>{{ $inv->customer->company_name ?? '' }}</td>
													 	<td>{{ $inv->unique_id }}</td>
													 	<td>{{ $contact_person ? $contact_person_mobile[$inv->contact_person_c] ?? $contact_person_mobile[0] : 'Something Wrong' }}</td>
													 	<td>{{ $inv->customer ? $inv->customer->email : 'Something Wrong' }}</td>
													 	<td>{{ $inv->customer->cwhatsapp ?? '' }}</td>
													 	<td>{{ $inv->leadstatus ? $inv->leadstatus->status : '' }}</td>
													 	<td colspan="3">
														 	<a href="{{ route('inquiry.edit',['inquiry'=>$inv->id]) }}" class="badge badge-success">Edit
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