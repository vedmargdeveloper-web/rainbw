@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">PASSWORD REST</h4></center>
							<div class="card">
							
									<div class="card-body">
										<div class="row">
											<div class="col-md-4 offset-4">
												<form action="{{ route('master.update.password') }}" id="password-ajax" method="post">
														@csrf
												<div class="row gutters">
														
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputName">Name *</label>
															@php
																$users = App\models\User::get();
															@endphp
															<select name="username" class="select-2 form-control change-password-user-select">
																<option value="">Please Select any one</option>
																@foreach($users as $user)
																	<option value="{{ $user->id }}">{{ $user->name }}</option>
																@endforeach
															</select>
															
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">User ID *</label>
															<input type="text" class="form-control" name="user_id" value="{{ old('hsn') }}" id="" placeholder="User id">
															
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">New Password *</label>
															<input type="text" class="form-control" name="password" value="{{ old('hsn') }}" id="" placeholder="New Password">
															
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Confirm Password *</label>
															<input type="text" class="form-control" name="password_confirmation" value="{{ old('hsn') }}" id="" placeholder="Confirm Password">
															
														</div>
													</div>
													
													<button type="submit"  name="submit" class="btn btn-primary  btn-update-password btn-block float-right mb-3">Update  Password</button>
												</div>
												</form>
											</div>
										
										</div>

										
									</div>
								
							</div>
						</div>
					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
				<script type="text/javascript" src="{{ asset('resources/js/master/password.js?v='.time()) }}"></script>
			</div>

	@endsection
