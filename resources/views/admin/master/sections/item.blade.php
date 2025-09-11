
	<div class="main-container">
<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">ITEMS</h4></center>
							<div class="card">
							
									<div class="card-body">
										<div class="row">

											<div class="col-md-4">
												<form action="{{ route('item.store') }}" id="item-store-ajax" method="post">
														@csrf
												<div class="row gutters">
														
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputName">Name *</label>
															<input type="text" name="name" class="form-control" value="{{ old('name') }}" id="" placeholder="Product Name">
															@error('name')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">SAC </label>
															<input type="text" class="form-control" name="hsn" value="{{ old('hsn') }}" id="" placeholder="SAC CODE">
															@error('hsn')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">HSN *</label>
															<input type="text" class="form-control" name="sac" value="{{ old('sac') }}" id="" placeholder="HSN CODE">
															@error('sac')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">CSGT *</label>
															<input type="number" min="0" value="{{ old('cgst') }}" class="form-control" id=""  name="cgst" placeholder="CGST">
															@error('cgst')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">SGST *</label>
															<input type="number" min="0" name="sgst" value="{{ old('sgst') }}" class="form-control" id="" placeholder="SGST">
															@error('sgst')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">IGST *</label>
															<input type="number" min="0" class="form-control" value="{{ old('igst') }}"  id="" placeholder="IGST" name="igst">
															@error('igst')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Profit Margin(%) *</label>
															<input type="number" min="0" class="form-control" value="{{ old('profit_margin') }}"  id="" placeholder="Profit Margin" name="profit_margin">
															@error('profit_margin')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Status *</label>
															<select placeholder="Status" name="status"   class="form-control">
																<option value="active" {{ (old('status') =='active') ? 'selected' :''  }}>Active</option>
																<option value="inactive" {{ (old('status') =='inactive') ? 'selected' :''  }}>Inactive</option>
															</select>
															@error('status')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="inputEmail">Description *</label>
															<input type="text" name="description" value="{{ old('description') }}" class="form-control" id="" placeholder="Description" placeholder="CGST">
															@error('description')
																	<span class="text-warning">{{ $message }}</span>
															@endError
														</div>
													</div>
													<button type="submit" id="submit" name="submit" class="btn btn-add-item btn-primary btn-block float-right mb-3">Add Item</button>
													<button type="submit"  name="submit" class="btn btn-primary d-none btn-update-item btn-block float-right mb-3">Update  Item</button>
													<span class="add-more-item d-none">Do you want to add item ? <a href="">Click Here</a> </span>
												</div>
												</form>
											</div>
											<div class="col-md-8">
												<div class="table-container">
													<center><h5>All items</h5></center>
													<div class="table-responsive">
														<table id="copy-print-csv-data" class="table custom-table">
															<thead>
																<tr>
																  <th>Name</th>
																  <th>SAC</th>
																  <th>HSN</th>
																  <th>Status</th>
																  <th>CGST</th>
																  <th>SGST</th>
																  <th>IGST</th>
																  <th>Profit Margin</th>
																  <th>Description</th>
																  <th>Date & time</th>
																  <th ></th>
																  <th ></th>
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
				<script type="text/javascript" src="{{ asset('resources/js/master/item.js?v='.time()) }}"></script>
			</div>
