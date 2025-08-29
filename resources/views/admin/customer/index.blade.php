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
											  <th>Type</th>
											  <th>Company Name</th>
											  <th>Address </th>
											  <th>City</th>
											  <th>State</th>
											  <th>Pincode</th>
											  <th>GST</th>
											  <th>Contact Persion Name</th>
											  <th>Mobile</th>
											  <th>Email</th>
											  <th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if($customers && count($customers) > 0)
												@foreach($customers as $customer)
												<tr>
												  <td>{{ $customer->customer_type }}</td>
												  <td>{{ $customer->company_name }}</td>
												  <td>{{ $customer->address }}</td>
												  <td>{{ $customer->city }}</td>
												  <td>{{ $customer->state }}</td>
												  <td>{{ $customer->pincode }}</td>
												  <td>{{ $customer->gstin }}</td>
												  <td>{{ $customer->contact_person_name }}</td>
												  <td>{{ $customer->mobile }}</td>
												  <td>{{ $customer->email }}</td>
												  <th>
												  	<div class="action-btn">
													<a class="badge badge-info td-btn" href="{{ route('customers.edit',['customer'=>$customer->id]) }}" >Edit</a>
													<form action="{{ route('customers.destroy',$customer->id) }}" method="POST">
													    @method('DELETE')
													    @csrf
													    <button class="badge badge-danger td-btn td-btn-delete" onclick="return confirm('are you sure want to delete ?')" >Delete</button>
													</form>
													</div>
												  </th>
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