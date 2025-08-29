@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
		<!-- Container fluid start -->
		@php
			$invoice = App\Models\Invoice::count();
			$booking = App\Models\Booking::count();
			$quotation = App\Models\Quotation::count();
			$pitch = App\Models\Pitch::count();

		@endphp

		<div class="container-fluid">

				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row starts -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Summery</div>
								</div>
								<div class="card-body">
									
									<!-- Row starts -->
									<div class="row gutters">
										
											<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
												<a href="{{ route('invoice.index') }}">
												<div class="goal-card">
													<h5>Bill</h5>
													
													<div class="progress progress-dot">
														<div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
													<h4>{{ $invoice }}</h4>
												</div>
												</a>
											</div>
											<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
												<a href="{{ route('booking.index') }}">
												<div class="goal-card">
													<h5>Booking</h5>
													<div class="progress progress-dot">
														<div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
													<h4>{{ $booking }}</h4>
												</div>
												</a>
											</div>
											<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
												<a href="{{ route('quotation.index') }}">
												<div class="goal-card">
													<h5>Quotation</h5>
													<div class="progress progress-dot">
														<div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
													<h4>{{ $quotation }}</h4>
												</div>
												</a>
											</div>
											<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
												<a href="{{ route('pitch.index') }}">
												<div class="goal-card">
													<h5>Pitch</h5>
													<div class="progress progress-dot">
														<div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
													<h4>{{ $pitch }}</h4>
												</div>
												</a>
											</div>
										
									</div>
									<!-- Row ends -->

								</div>
							</div>
						</div>
					</div>
					<!-- Row ends -->

					<!-- Row starts -->
					
					<!-- Row ends -->

					<!-- Row starts -->
					
					<!-- Row ends -->

				</div>
				<!-- Content wrapper end -->

			</div>
			<!-- *************
				************ Main container end *************
			************* -->
@endsection('content')