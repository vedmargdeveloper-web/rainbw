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
								@if($errors->any())
								    <div class="alert alert-danger">
								        <p><strong>Opps Something went wrong</strong></p>
								        <ul>
								        @foreach ($errors->all() as $error)
								            <li>{{ $error }}</li>
								        @endforeach
								        </ul>
								    </div>
								@endif
								<form action="{{ route('users.update',['user'=>$user->id]) }}" method="post" enctype="multipart/form-data">
									@csrf
									{{ method_field('PATCH') }}
									<div class="card-body">
										<div class="row gutters">
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Name *</label>
													<input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" id="" placeholder="name">
													@error('name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Mobile *</label>
													<input type="number" class="form-control" name="mobile" value="{{ old('mobile') ? old('mobile') : $user->mobile }}" id="" placeholder="Mobile">
													@error('mobile')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Password *</label>
													<input type="text" class="form-control" name="password" value="{{ old('password') ? old('password') : $user->s_password }}" id="" placeholder="password">
													@error('password')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
									
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Aadhar *</label>
													<input type="text" class="form-control" name="aadhar" value="{{ old('aadhar') ? old('aadhar') : $user->aadhar }}" id="" placeholder="aadhar">
													@error('aadhar')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Photo *</label>
													<input type="file" name="photo" class="form-control" width="50px">
													<a href="{{ _image($user->photo) }}" target="_blank"><img src="{{ _image($user->photo) }}" width="50px"></a>
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
													<input type="hidden" name="sn" value="{{ $user->sn }}" id="sn">
													<select name="business_type" id="business_type" data-sn="{{ $user->sn }}"  class="form-control">
													<option value="">Please Select type *</option>
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
													<label for="inputEmail">Employee Code *</label>
													<input type="text" class="form-control" name="employee_code" id="employee_code"  value="{{ old('employee_code') ? old('employee_code') : $user->employee_code }}"  placeholder="Employee Code" readonly="">
													@error('employee_code')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Business Short code *</label>
													<input type="text" class="form-control" name="business_short_code" value="{{ old('business_short_code') ? old('business_short_code') : $user->business_short_code }}" id="" placeholder="business short code">
													@error('Business Short code')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Status *</label>
													<select class="form-control" name="status">
														<option value="">Please select Status </option>
														<option value="active" {{ ($user->status == 'active') ? 'selected' : '' }}> Active </option>
														<option value="inactive" {{ ($user->status == 'inactive') ? 'selected' : '' }}> Inactive </option>
													</select>
													@error('status')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" id="submit" name="submit" class="btn btn-primary float-right mb-3">update Users</button>
										</div>
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