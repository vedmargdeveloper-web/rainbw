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
											  <th>Name</th>
											  <th>Mobile</th>
											  <th>Aadhar</th>
											  <th>Employee Code</th>
											  <th>Business Type</th>
											  <th>Business short code</th>
											  <th>Status</th>
											  <th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if($users && count($users) > 0)
												@foreach($users as $user)
												<tr>
												  <td>{{ $user->name }}</td>
												  <td>{{ $user->mobile }}</td>
												  <td>{{ $user->aadhar }}</td>
												  <td>{{ $user->employee_code }}</td>
												  <td>{{ $user->business ?  $user->business->business_name : '' }}</td>
												  <td>{{ $user->business_short_code }}</td>
												  <td>{{ $user->status }}</td>
												  <th>
												  	<div class="action-btn">
													<a  href="{{ route('user.permissions.create',['uid'=>$user->id]) }}" class="badge badge-primary td-btn mr-1" href="" >Permission</a>
													<a class="badge badge-info td-btn" href="{{ route('users.edit',['user'=>$user->id]) }}" >Edit</a>
													<form action="{{ route('users.destroy',$user->id) }}" method="POST">
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