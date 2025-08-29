@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">
<!-- Content wrapper start -->
	@php
		$meta = App\Models\Meta::all();
	@endphp

				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								
								<form action="{{ route('meta.store') }}" method="post">
									@csrf
									<div class="card-body">
										
										<div class="row gutters">
											
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Company Name </label>

													<input type="text" class="form-control" name="company_name" value="{{$meta->where('meta_name','company_name')->first()->meta_value }}" id="" placeholder="Company Name">
													@error('company_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Head Office </label>
													<textarea class="form-control"  placeholder="Head Office" name="head_office">{{$meta->where('meta_name','head_office')->first()->meta_value }}</textarea>

													
													@error('company_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Branch Office </label>
														<textarea class="form-control"  placeholder="Branch office" name="branch_office">{{$meta->where('meta_name','branch_office')->first()->meta_value }}</textarea>

												
													@error('branch_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Mobile </label>
													<input type="number" class="form-control" name="mobile" value="{{$meta->where('meta_name','mobile')->first()->meta_value }}" id="" placeholder="Mobile office">
													@error('mobile')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Email </label>
													<input type="text" class="form-control" name="email" value="{{$meta->where('meta_name','email')->first()->meta_value }}" id="" placeholder="Email">
													@error('email')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">GST </label>
													<input type="text" class="form-control" name="gst" value="{{$meta->where('meta_name','gst')->first()->meta_value }}" id="" placeholder="Email">
													@error('gst')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Udyam Reg </label>
													<input type="text" class="form-control" name="udyam_reg" value="{{$meta->where('meta_name','udyam_reg')->first()->meta_value }}" id="" placeholder="Udyam Reg">
													@error('udyam_reg')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										{{-- 	<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Udyam Reg </label>
													<input type="text" class="form-control" name="udyam_reg" value="{{$meta->where('meta_name','udyam_reg')->first()->meta_value }}" id="" placeholder="Udyam Reg">
													@error('udyam_reg')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div> --}}
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Bank Name</label>
													<input type="text" class="form-control" name="bank_name" value="{{$meta->where('meta_name','bank_name')->first()->meta_value }}" id="" placeholder="Udyam Reg">
													@error('bank_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Bank Holder Name</label>
													<input type="text" class="form-control" name="bank_holder_name" value="{{$meta->where('meta_name','bank_holder_name')->first()->meta_value }}" id="" placeholder="Udyam Reg">
													@error('bank_holder_name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Account No</label>
													<input type="text" class="form-control" name="account_no" value="{{$meta->where('meta_name','account_no')->first()->meta_value }}" id="" placeholder="Udyam Reg">
													@error('account_no')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>

											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">IFSC</label>
													<input type="text" class="form-control" name="ifsc" value="{{$meta->where('meta_name','ifsc')->first()->meta_value }}" id="" placeholder="Udyam Reg">
													@error('ifsc')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Bank Address</label>
													<textarea class="form-control"  placeholder="Term & conditions" name="bank_address">{{$meta->where('meta_name','bank_address')->first()->meta_value }}</textarea>

													
													@error('bank_address')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Term & conditions</label>
													<textarea class="form-control"  placeholder="Term & conditions" name="term">{{$meta->where('meta_name','term')->first()->meta_value }}</textarea>
													@error('term')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											
										</div>
										<div class="col-md-12">
											<button type="submit" id="submit" name="submit" class="btn btn-primary float-right mb-3">Update Setting</button>
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