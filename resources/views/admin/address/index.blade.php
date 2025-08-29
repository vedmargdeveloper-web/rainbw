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
											  <th>Venue</th>
											  <th>Address</th>
											  <th>City</th>
											  <th>State</th>
											  <th>Pincode</th>
											  <th>Landmark</th>
											  <th>Contact Persion Name</th>
											  <th>Mobile</th>
											  <th>Email</th>
											  <th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if($addresss && count($addresss) > 0)
												@foreach($addresss as $addres)
												<tr>
												  <td>{{ $addres->venue }}</td>
												  <td>{{ $addres->address }}</td>
												  <td>{{ $addres->city }}</td>
												  <td>{{ $addres->state }}</td>
												  <td>{{ $addres->pincode }}</td>
												  <td>{{ $addres->landmark }}</td>
												  <td>{{ $addres->contact_person_name }}</td>
												  <td>{{ $addres->mobile }}</td>
												  <td>{{ $addres->email }}</td>
												  <th>
												  	<div class="action-btn">
													<a class="badge badge-info td-btn" href="{{ route('address.edit',['address'=>$addres->id]) }}" >Edit</a>
													<form action="{{ route('address.destroy',$addres->id) }}" method="POST">
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