@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">
				<!-- Content wrapper start -->
				<div class="content-wrapper">
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<form action="{{ route('customers.store') }}" method="post">
									@csrf
									@php
										$customer_type =  App\Models\CustomerTypeMaster::get();
										//dd($customer_type);
									@endphp
									<div class="card-body">
										
										<div class="row gutters">
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Customer Type *</label>
													<select  name="customer_type"   class="form-control">
														<option value="">Please select</option>
														@foreach($customer_type as $ct)
														<option value="{{ $ct->id }}" {{ (old('customer_type') =='active') ? 'selected' :''  }}>{{ $ct->type }} - {{ $ct->code }}</option>
														@endforeach
													</select>
													@error('customer_type')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>

											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Company Name </label>
													<input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" id="" placeholder="Company Name">
													@error('company_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Address *</label>
													<input type="text" min="0" value="{{ old('address') }}" class="form-control" id=""  name="address" placeholder="address">
													@error('address')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Pincode *</label>
													<input type="number" min="0" name="pincode" id="pincode" value="{{ old('pincode') }}" class="form-control" id="" placeholder="pincode">
													@error('pincode')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">City *</label>
													<input type="text" readonly="" class="form-control" readonly="" value="{{ old('city') }}"  id="" placeholder="city" name="city"> 
													@error('city')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">State *</label>
													<input type="text" readonly="" class="form-control" value="{{ old('state') }}"  id="" placeholder="state" name="state">
													@error('state')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">GST *</label>
													<input type="text" name="gstin" value="{{ old('gstin') }}" class="form-control" id="" placeholder="gst" placeholder="gst">
													@error('gstin')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Contact Persion Name *</label>
													<input type="text" name="contact_person_name" value="{{ old('contact_person_name') }}" class="form-control" id=""  placeholder="Contact person name">
													@error('contact_person_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Mobile *</label>
													<input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" id="" placeholder="mobile" placeholder="Please Enter Mobile">
													@error('mobile')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Email *</label>
													<input type="email" name="email" value="{{ old('email') }}" class="form-control" id="" placeholder="email" placeholder="Please enter email">
													@error('email')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" id="submit" name="submit" class="btn btn-primary float-right mb-3">Add Customers</button>
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