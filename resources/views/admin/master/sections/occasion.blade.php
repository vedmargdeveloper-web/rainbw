
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">Occasion | Color Name</h4></center>
							<div class="card">
							
									<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-2">
												<form action="{{ route('occasion.store') }}" id="occasion-store-ajax" method="post">
														@csrf
												<div class="row gutters">
												
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Occasion *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="occasion" placeholder="occasion">
															
														</div>
													</div>
											
										
													<button type="submit" style="margin: 10px;" id="submit" name="submit" class="btn btn-add-occasion btn-primary btn-block float-right mb-3">Add occasion </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-occasion btn-block float-right mb-3">Update  occasion </button>
													<span class="add-more-occasion d-none">Do you want to add occasion ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-occasion" class="table custom-table">
															<thead>
																<tr>
																{{--   <th>Id</th> --}}
																  <th>Occasion</th>
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
												<form action="{{ route('color.store') }}" id="color-store-ajax" method="post">
												@csrf
												<div class="row gutters">
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Color Name *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="color" placeholder="color">
														</div>
													</div>
													<button type="submit" id="submit" name="submit" class="btn btn-add-color btn-primary btn-block float-right mb-3">Add color </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-color btn-block float-right mb-3">Update  color </button>
													<span class="add-more-color d-none">Do you want to add color ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
															<table id="copy-print-csv-color" class="table custom-table">
																<thead>
																	<tr>
																	{{--   <th>Id</th> --}}
																	  <th>color</th>
																	  {{-- <th>Date & Time</th> --}}
																	  <th></th>
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
				<script type="text/javascript" src="{{ asset('resources/js/master/occasion.js?v='.time()) }}"></script>
				<script type="text/javascript" src="{{ asset('resources/js/master/color.js?v='.time()) }}"></script>
				{{-- <script type="text/javascript" src="{{ asset('reoccasions/js/master/lead.js?v='.time()) }}"></script> --}}
			</div>
