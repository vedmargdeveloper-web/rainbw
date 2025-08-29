@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">
				@php
			    	$alluser = App\Models\User::count()
			    @endphp
				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
									@csrf
									<div class="card-body">
										<div class="row gutters">
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Name *</label>
													<input type="text" class="form-control" name="name" value="{{ old('name') }}" id="" placeholder="name">
													@error('name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Mobile</label>
													<input type="number" class="form-control" name="mobile" value="{{ old('mobile') }}" id="" placeholder="Mobile">
													@error('mobile')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Password *</label>
													<input type="password" class="form-control" name="password" value="{{ old('password') }}" id="" placeholder="password">
													@error('password')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
									
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Aadhar *</label>
													<input type="text" class="form-control" name="aadhar" value="{{ old('aadhar') }}" id="" placeholder="aadhar">
													@error('aadhar')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>

											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Photo *</label>
													<input type="file" name="photo" class="form-control" >
													@error('photo')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Business Type *</label>
													
													@php
														$bussiness = App\Models\Business::get();  

													@endphp
													<input type="hidden" name="sn" value="{{ $alluser+1 }}" id="sn">
													<select name="business_type" id="business_type" data-sn= "{{ $alluser+1 }}"  class="form-control">
													<option value="">Please Select type</option>
														@foreach($bussiness as $bus)
															<option value="{{ $bus->short_name }}" {{ (old('business_type') == $bus->short_name) ? 'selected' : '' }}>{{ $bus->business_name }}</option>
														@endforeach
													</select>
													@error('business_type')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Business Short code *</label>
													<input type="text" class="form-control" readonly="" name="business_short_code" value="{{ old('business_short_code') }}" id="" placeholder="business short code">
													@error('Business Short code')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Employee Code *</label>
													<input type="text" class="form-control" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" id="" placeholder="Employee Code" readonly="">
													@error('employee_code')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>

											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Status *</label>
													<select class="form-control" name="status">
														<option value="">Please select Status </option>
														<option value="active" {{ (old('status') == 'active') ? 'selected' : '' }}> Active </option>
														<option value="inactive" {{ (old('status') == 'inactive') ? 'selected' : '' }}> Inactive </option>
													</select>
													@error('status')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" id="submit" name="submit" class="btn btn-primary float-right mb-3">Add Users</button>
										</div>
									</div>
								</form>
							</div>
						</div>

					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
			</div>

		
@endsection