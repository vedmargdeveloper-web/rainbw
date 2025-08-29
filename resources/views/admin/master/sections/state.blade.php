
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							{{-- <center><h4 id="">State</h4></center> --}}
							<div class="card">
							
									<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-2">
												<form action="{{ route('state.store') }}" id="state-store-ajax" method="post">
														@csrf
												<div class="row gutters">
												
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">State *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="state" placeholder="state">
															
														</div>
													</div>
											
										
													<button type="submit" style="margin: 10px;" id="submit" name="submit" class="btn btn-add-state btn-primary btn-block float-right mb-3">Add State </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-state btn-block float-right mb-3">Update  State </button>
													<span class="add-more-state d-none">Do you want to add item ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-state" class="table custom-table">
															<thead>
																<tr>
																{{--   <th>Id</th> --}}
																  <th >State</th>
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
												<form action="{{ route('city.store') }}" id="city-store-ajax" method="post">
														@csrf
												<div class="row gutters">
												
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">City *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="city" placeholder="city">
															
														</div>
													</div>
											
										
													<button style="margin: 10px;" type="submit" id="submit" name="submit" class="btn btn-add-city btn-primary btn-block float-right mb-3">Add city </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-city btn-block float-right mb-3">Update  city </button>
													<span class="add-more-city d-none">Do you want to add item ? <a href="">Click Here</a> </span>
												</div>
												</form>
											
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-city" class="table custom-table">
															<thead>
																<tr>
																{{--   <th>Id</th> --}}
																  <th>City</th>
																  
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
				<script type="text/javascript" src="{{ asset('resources/js/master/state.js?v='.time()) }}"></script>
				<script type="text/javascript" src="{{ asset('resources/js/master/city.js?v='.time()) }}"></script>
			</div>
