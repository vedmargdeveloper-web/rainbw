
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">Vehicle Major | Minor Head</h4></center>
							<div class="card">
							
									<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-2">
												<form action="{{ route('heads.store') }}" id="heads-store-ajax" method="post">
														@csrf
												<div class="row gutters">
												
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Vehicle Major Head *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="heads" placeholder="heads">
														</div>
													</div>
											
										
													<button type="submit" style="margin: 10px;" id="submit" name="submit" class="btn btn-add-heads btn-primary btn-block float-right mb-3">Add heads </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-heads btn-block float-right mb-3">Update  heads </button>
													<span class="add-more-heads d-none">Do you want to add  ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-heads" class="table custom-table">
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
												<form action="{{ route('minorstore.store') }}" id="heads-minor-store-ajax" method="post">
												@csrf
													<div class="row gutters">
														<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Vehicle Major Heads *</label>
																@php
													                $vechicle_major_head = App\Models\VehicleMajorHead::where('major',0)->get();
													            @endphp
																<select name="major" class="form-control">
																	@foreach($vechicle_major_head as $vechicle_major)
																		<option value="{{ $vechicle_major->id }}">{{ $vechicle_major->name }}</option>
																	@endforeach
																</select>
															</div>
														</div>
														<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Vehicle Minor Heads *</label>
																<input type="text" min="0" value="" class="form-control" id=""  name="heads" placeholder="Heads">
															</div>
														</div>
														<button type="submit" id="submit" name="submit" class="btn btn-add-minor-heads btn-primary btn-block float-right mb-3">Add Sub heads </button>
														<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-minior-heads btn-block float-right mb-3">Update sub heads </button>
														<span class="add-more-minior-heads d-none">Do you want to add heads ? <a href="">Click Here</a> </span>
													</div>
												</form>
											</div>
											<div class="col-md-3">
												<div class="table-container">
												
													<div class="table-responsive">
															<table id="copy-print-csv-minor-heads" class="table custom-table">
																<thead>
																	<tr>
																	  <th>Heads</th>		  
																	  <th>Parent</th>
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
				<script type="text/javascript" src="{{ asset('resources/js/master/minorheads.js?v='.time()) }}"></script>
				<script type="text/javascript" src="{{ asset('resources/js/master/Heads.js?v='.time()) }}"></script>
			</div>
