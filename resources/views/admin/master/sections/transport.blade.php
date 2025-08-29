
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">Transport</h4></center>
							<div class="card">
							
									<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-2">
												<form action="{{ route('transport.store') }}" id="transport-store-ajax" method="post">
												@csrf
												<div class="row gutters">
												
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Transport *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="transport" placeholder="transport">
														</div>
													</div>
											
										
													<button type="submit" style="margin: 10px;" id="submit" name="submit" class="btn btn-add-transport btn-primary btn-block float-right mb-3">Add </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-transport btn-block float-right mb-3">Update  </button>
													<span class="add-more-transport d-none">Do you want to add  ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-transport" class="table custom-table">
															<thead>
																<tr>
																  <th>Name</th>
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
												
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
															{{-- <table id="copy-print-csv-minor-transport" class="table custom-table">
																<thead>
																	<tr>
																	  <th>transport</th>		  
																	  <th>Parent</th>
																	  <th></th>
																	</tr>
																</thead>
																<tbody>	
																</tbody>
											    			</table> --}}
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
				<script type="text/javascript" src="{{ asset('resources/js/master/transport.js?v='.time()) }}"></script>
			</div>
