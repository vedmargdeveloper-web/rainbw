@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">



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
								<form action="{{ route('address.update',['address'=>$address->id]) }}" method="post">
									@csrf
									{{ method_field('PATCH') }}
									@php
										$customer_type =  App\Models\CustomerTypeMaster::get();
										//dd($customer_type);
									@endphp
									<div class="card-body">
										<input type="hidden" name="type" value="delivery">
										<div class="row gutters">
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Venue</label>
													<input type="text" class="form-control" name="venue" value="{{ old('venue') ? old('venue')  : $address->venue  }}" id="" placeholder="Venue">
													@error('venue')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Address *</label>
													<input type="text" min="0" value="{{ old('address') ? old('address')  : $address->address  }}" class="form-control" id=""  name="address" placeholder="address">
													@error('address')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Pincode *</label>
													<input type="number" min="0" name="pincode" id="pincode" value="{{ old('pincode') ? old('pincode')  : $address->pincode  }}" class="form-control" id="" placeholder="pincode">
													@error('pincode')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">City *</label>
													<input type="text" readonly="" class="form-control" readonly="" value="{{ old('city') ? old('city')  : $address->city  }}"  id="" placeholder="city" name="city"> 
													@error('city')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">State *</label>
													<input type="text" readonly="" class="form-control" value="{{ old('state') ? old('state')  : $address->state  }}"  id="" placeholder="state" name="state">
													@error('state')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">landmark *</label>
													<input type="text" name="landmark"  value="{{ old('landmark') ? old('landmark')  : $address->landmark  }}" class="form-control" id="" placeholder="landmark" placeholder="gst">
													@error('landmark')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>

											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Contact Persion Name *</label>
													<input type="text" name="contact_person_name"  value="{{ old('contact_person_name') ? old('contact_person_name')  : $address->contact_person_name  }}" class="form-control" id=""  placeholder="Contact person name">
													@error('contact_person_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Mobile *</label>
													<input type="number" name="mobile" value="{{ old('mobile') ? old('mobile')  : $address->mobile  }}"  class="form-control" id="" placeholder="mobile" placeholder="Please Enter Mobile">
													@error('mobile')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Email *</label>
													<input type="email" name="email" value="{{ old('email') ? old('email')  : $address->email  }}" class="form-control" id="" placeholder="email" placeholder="Please enter email">
													@error('email')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" id="submit" name="submit" class="btn btn-primary float-right mb-3">Update Customers</button>
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