
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">Source | Lead Status </h4></center>
							<div class="card">
							
									<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-2">
												<form action="{{ route('source.store') }}" id="source-store-ajax" method="post">
														@csrf
												<div class="row gutters">
												
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Source *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="source" placeholder="source">
														</div>
													</div>
											
										
													<button type="submit" style="margin: 10px;" id="submit" name="submit" class="btn btn-add-source btn-primary btn-block float-right mb-3">Add Source </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-source btn-block float-right mb-3">Update  Source </button>
													<span class="add-more-source d-none">Do you want to add Source ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-source" class="table custom-table">
															<thead>
																<tr>
																{{--   <th>Id</th> --}}
																  <th >Source</th>
																  {{-- <th>Date & Time</th> --}}
																  <th style="width: 10px;"></th>
																  <th style="width: 10px;"></th>
																</tr>
															</thead>
															<tbody>
																
															</tbody>
											    		</table>
													</div>
												</div>
											</div>
											<div class="col-md-1"></div>
											<div class="col-md-2">
												<form action="{{ route('lead.store') }}" id="lead-store-ajax" method="post">
												@csrf
												<div class="row gutters">
													@php
														$leadHeads = App\Models\LeadHead::get();
													@endphp
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">

															<label for="inputEmail">Select *</label>

															<select class="form-control" name="lead_heads_id">
																<option value="">Select</option>
																@foreach($leadHeads as $leadhead  )
																	<option value="{{ $leadhead->id }}">{{ $leadhead->lead }}</option>
																@endforeach
																{{-- <option>Booking</option> --}}
															</select>
														</div>
														<div class="form-group">
															<label for="inputEmail">Lead *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="lead" placeholder="Lead">
														</div>
													</div>
											
										
													<button style="margin: 10px;" type="submit" id="submit" name="submit" class="btn btn-add-lead btn-primary btn-block float-right mb-3">Add Lead </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-lead btn-block float-right mb-3">Update  lead </button>
													<span class="add-more-lead d-none">Do you want to add item ? <a href="">Click Here</a> </span>
												</div>
												</form>
											
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-lead" class="table custom-table">
															<thead>
																<tr>
																{{--   <th>Id</th> --}}
																  <th>lead</th>
																  
																  <th style="width: 10px;"></th>
																  <th style="width: 10px;"></th>
																</tr>
															</thead>
															<tbody>
																
															</tbody>
											    		</table>
													</div>
												</div>
											</div>

										</div>

										
									</div>
								
							</div>
								
							</div>
						</div>
					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
				<script type="text/javascript" src="{{ asset('resources/js/master/source.js?v='.time()) }}"></script>
				<script type="text/javascript" src="{{ asset('resources/js/master/lead.js?v='.time()) }}"></script>
			</div>
