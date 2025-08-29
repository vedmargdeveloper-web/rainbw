
	<div class="main-container">
				<div class="content-wrapper">
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">GSTIN Master</h4></center>
							<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-4">
												<form action="{{ route('gst.store') }}" id="gst-store-ajax" method="post">
														@csrf
												<div class="row gutters">
														
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputName">Company Name : *</label>
															<input type="text" name="company_name" class="form-control" value="" id="" placeholder="Company Name">
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Head Office : *</label>
															<input type="text" class="form-control" name="head_office" value="" id="" placeholder="Head Office">
															
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Branch Office : *</label>
															<input type="text" min="0" value="" class="form-control" id=""  name="branch_office" placeholder="branch office">
															
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Temp. Address : </label>
															<input type="text" min="0" name="temp_address" value="{{ old('sgst') }}" class="form-control" id="" placeholder="Temp Address">
														
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">GSTIN : *</label>
															<input type="text" min="0" class="form-control" value=""  id="" placeholder="GSTIN" name="gstin">
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Udyam Reg. No. : *</label>
															<input type="text" min="0" class="form-control" value=""  id="" placeholder="Udyam Reg No" name="udyam_reg_no">
														</div>
													</div>

													<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
														<div class="form-group">
															<label for="inputEmail">Pincode: *</label>
															<input type="number" min="0" class="form-control" value=""  id="" placeholder="pincode" name="pincode">
															
														</div>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
														 <div class="form-group">
				                                                <label for="inputEmail">State *</label>
				                                                @php
				                                                    $state  = App\Models\State::get();
				                                                @endphp
				                                                <select class="form-control" name="state" >
				                                                    <option value="">Please Select State</option>
				                                                    @foreach($state as $cit)
				                                                        <option value="{{ $cit->id }}">{{ $cit->state ?? '' }}</option>
				                                                    @endforeach
				                                                </select>
				                                                 @error('state')
				                                                <span class="text-warning">{{ $message }}</span> @endError
				                                            </div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															   <div class="form-group">
					                                                <label for="inputEmail">City *</label>
					                                                @php
					                                                    $cites  = App\Models\City::get();
					                                                @endphp
					                                                <select class="form-control" name="city" >
					                                                    <option value="">Please Select City</option>
					                                                    @foreach($cites as $cit)
					                                                        <option value="{{ $cit->id }}">{{ $cit->city ?? '' }}</option>
					                                                    @endforeach
					                                                </select>
					                                                @error('city')
					                                                    <span class="text-warning">{{ $message }}</span> 
					                                                @endError
					                                            </div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Type: *</label>
																<select value="" class="form-control" name="type">
																	<option value=""> Please Select type</option>
																	<option value="permanent">Permanent</option>
																	<option value="temporary">Temporary</option>
																</select>
																
															</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Issue Date : </label>
																<input type="date" min="0" class="form-control" value=""  id="" placeholder="Issue date" name="issue_date">
															</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Expiry Date : </label>
																<input type="date" min="0" class="form-control" value=""  id="" placeholder="Expiry Date" name="expiry_date">
																
															</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Mobile : *</label>
																<input type="number" min="0" class="form-control" value=""  id="" placeholder="Mobile" name="mobile">
																
															</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Email : *</label>
																<input type="email" min="0" class="form-control" value=""  id="" placeholder="Email" name="email">
																
															</div>
													</div>
													<div class="row field_wrapper_gst">
														<div class="col-xl-12 gst col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="inputEmail">Head : *</label>
																<textarea class="form-control gst_head" name="head[]" ></textarea>
															</div>

														</div>	
													</div>
													<div class="col-md-12 p-0 mb-2 mt-2">	
														<span class="add_button_gst btn btn-info">Add More Head </span>
													</div>

													
													
													<button type="submit" id="submit" name="submit" class="btn btn-add-gst btn-primary btn-block float-right mb-3">Add Gst </button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-gst btn-block float-right mb-3">Update  Gst </button>
													<span class="add-more-gst d-none">Do you want to add item ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-8">
												<div class="table-container">
													<center><h5> GSTIN Master </h5></center>
													<div class="table-responsive">
														<table id="copy-print-csv-gst" class="table custom-table">
															<thead>
																<tr>
																  <th>Company name</th>
																  <th>Head Office</th>
																  <th>Branch Office</th>
																  <th>Type</th>
																  <th>Temp. Address Unique</th>
																  <th>GSTIN</th>
																  <th>Udyam Reg. No.</th>
																  <th>Pincode</th>
																  <th>State</th>
																  <th>City</th>
																  <th>Issue Date</th>
																  <th>Expiry Date</th>
																  <th>Mobile</th>
																  <th>Email</th>
																  <th>Head</th>
																  <th>Date & Time</th>
																  <th></th>
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
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
				<script type="text/javascript" src="{{ asset('resources/js/master/gst.js?v='.time()) }}"></script>
			</div>
