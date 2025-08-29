
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4>Vehicle Id Generation </h4> </center>
							<div class="card">
									
									<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-2">
												<form action="{{ route('vehicle-id-genration.store') }}" id="vechicleGenration-store-ajax" method="post">
													@csrf
													<div class="row gutters">
													
														<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<label for="inputEmail">Item : *</label>
															<div class="form-group">
																@php
																	$items = App\Models\Item::get(['name','id']);
																	$colors = App\Models\Color::get(['color','id']);
																@endphp
																<select required name="items_id" class="form-control" >
																	<option value="">Select</option>
																	@foreach($items as $item)
																		<option value="{{ $item->id }}">{{ $item->name  }}</option>
																	@endforeach
																</select>
															</div>
															<label for="inputEmail">Color : *</label>
															<div class="form-group">
																<select name="colors_id" class="form-control"  required>
																	<option value="">Select</option>
																	@foreach($colors as $color)
																		<option value="{{ $color->id }}">{{ $color->color  }}</option>
																	@endforeach
																</select>
															</div>
															<label for="inputEmail">Vehicle ID : *</label>
															<div class="form-group">
																	<input type="text"  name="vechicle_id" class="form-control">
															</div>
															<label for="inputEmail">Value</label>
															<div class="form-group">
																<input type="number"  name="value" class="form-control">
															</div>
														</div>
												
											
														<button type="submit" style="margin: 10px;" id="submit" name="submit" class="btn btn-add-vechicleGenration btn-primary btn-block float-right mb-3">Add  </button>
														<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-vechicleGenration btn-block float-right mb-3">Update</button>
														<span class="add-more-vechicleGenration d-none">Do you want to add  ? <a href="">Click Here</a> </span>
													</div>
												</form>
											</div>
											<div class="col-md-4">
												<div class="table-container">
												
													<div class="table-responsive">
														<table id="copy-print-csv-vechicleGenration" class="table custom-table">
															<thead>
																<tr>
																  <th>Item</th>
																  <th style="width: 10px;">Color</th>
																  <th style="width: 10px;">Vehicle I2D</th>
																  <th style="width: 10px;">Value</th>
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
				<script type="text/javascript" src="{{ asset('resources/js/master/vechicleGenration.js?v='.time()) }}"></script>
				{{-- <script type="text/javascript" src="{{ asset('revechicleGenrations/js/master/lead.js?v='.time()) }}"></script> --}}
			</div>
