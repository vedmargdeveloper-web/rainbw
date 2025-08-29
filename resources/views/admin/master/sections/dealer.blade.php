<div class="main-container">
    <!-- Content wrapper start -->
    <div class="content-wrapper">
        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <center>
                    <h4 id="">CUSTOMERS  </h4>
                </center>
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            @php $customer_type = App\Models\CustomerTypeMaster::get(); @endphp
                            <div class="col-md-4">
                                <form action="{{ route('customers.store') }}" id="dealer-store-ajax" method="post">
                                    @csrf
                                    <div class="row gutters">

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Customer Type *</label>
                                                <select name="customer_type" class="form-control">
														<option value="">Please select</option>
														@foreach($customer_type as $ct)
														<option value="{{ $ct->id }}" {{ (old('customer_type') =='active') ? 'selected' :''  }}>{{ $ct->type }} - {{ $ct->code }}</option>
														@endforeach
													</select> @error('customer_type')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>

                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Client Name </label>
                                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}"  maxlength="48" id="" placeholder="Company Name"> @error('company_name')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Address 1</label>
                                                <input type="text" min="0" value="{{ old('address') }}" class="form-control" maxlength="48" id="" name="address" placeholder="address"> @error('address')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Address 2</label>
                                                <input type="text" min="0" value="{{ old('address') }}" class="form-control" maxlength="48" id="" name="address1" placeholder="address"> @error('address')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Pincode </label>
                                                <input type="number" min="0" name="pincode" id="pincode" value="{{ old('pincode') }}" class="form-control" id="" placeholder="pincode"> @error('pincode')
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
                                                <label for="inputEmail">GST *</label>
                                                <input type="text" name="gstin" value="{{ old('gstin') }}" class="form-control" id="" placeholder="gst" placeholder="gst"> @error('gstin')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>
                                       <div class="field_wrapper p-2 ">
                                       		<div class="row">
			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">
			                                            <div class="form-group">
			                                                <label for="inputEmail">Contact Persion Name *</label>
			                                                <input type="text" name="contact_person_name[]" value="" class="form-control contact-person-name" id="" placeholder="Contact person name">
			                                            </div>
			                                        </div>

			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">
			                                            <div class="form-group">
			                                                <label for="inputEmail">Phone No *</label>
			                                                <input type="number" name="mobile[]" value="" class="form-control contact-person-phone" id="" placeholder="Mobile"> 
			                                            </div>
			                                        </div>
			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">
			                                            <div class="form-group">
			                                                <label for="inputEmail">Designation *</label>
			                                                <input type="text" name="designation[]" value="" class="form-control contact-person-designation" id="" placeholder="Designation">
			                                            </div>
			                                        </div>
			                                </div>
                            
	                                    </div>
                                    	
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
	                                            <div class="form-group">
	                                            	<label>&nbsp;</label>
	                                                <span class="btn btn-info add_button">Add More</span>
	                                            </div>
	                                    </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Email *</label>
                                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="" placeholder="email" placeholder="Please enter email"> @error('email')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Whatsapp *</label>
                                                <input type="number"  name="cwhatsapp" value="{{ old('cwhatsapp') }}" class="form-control" id="" placeholder="Whatsapp no"  required=""> @error('cwhatsapp')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail"> <input type="checkbox" name="allocation" value="1"  id="" placeholder="allocation" placeholder="Please enter allocation" value="1">  Compition </label>
                                                @error('allocation')
                                                <span class="text-warning">{{ $message }}</span> @endError
                                            </div>
                                        </div>
                                        

                                        <button type="submit" id="submit" name="submit" class="btn btn-add-dealer btn-primary btn-block float-right mb-3">Add Customer</button>
                                        <button type="submit" name="submit" class="btn btn-primary d-none btn-update-dealer btn-block float-right mb-3">Update  Customer</button>
                                        <span class="add-more-dealer d-none">Do you want to add item ? <a href="">Click Here</a> </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <div class="table-container">
                                    <center>
                                        <h5>All CUSTOMERS</h5>
                                    </center>
                                    <div class="table-responsive">
	                                       <table id="copy-print-csv-dealer" class="table custom-table">
											<thead>
												<tr>
												  <th>S. No</th>
												  <th>Type</th>
												  <th>Company Name</th>
												  <th>Address </th>
												  <th>City</th>
												  <th>State</th>
												  <th>Pincode</th>
												  <th>GST</th>
												  <th>Contact Persion Name</th>
												  <th>Mobile</th>
                                                  <th>Whatsapp</th>
												  <th>Designation</th>
												  <th>Email</th>
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
    <script type="text/javascript" src="{{ asset('resources/js/master/dealer.js?v='.time()) }}"></script>
</div>