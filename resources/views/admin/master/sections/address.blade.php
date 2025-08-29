<div class="main-container">
    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <center>
                    <h4 id="">Address ( Delivery / Supply )</h4>
                </center>
                <div class="card">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <form action="{{ route('address.store') }}" id="address-store-ajax" method="post">
                                    @csrf
                                    <div class="row gutters">

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Type *</label>
                                                <select class="form-control" id="address-type" name="type">
                                                    <option value="">Please select</option>
                                                    <option value="delivery">Delivery</option>
                                                    <option value="supply">Supply</option>
                                                    option>
                                                </select>
                                            </div>
                                            <div class="form-group venue">
                                                <label for="inputEmail">Venue *</label>
                                                <input type="text" class="form-control" name="venue"
                                                    value="{{ old('venue') }}" maxlength="48" id=""
                                                    placeholder="Venue">
                                                @error('venue')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>

                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Address *</label>
                                                <input type="text" min="0" value="{{ old('address') }}"
                                                    class="form-control" id="" maxlength="48" name="address"
                                                    placeholder="address">
                                                @error('address')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">Address 2</label>
                                                <input type="text" value="{{ old('address') }}" class="form-control"
                                                    id="" maxlength="48" name="address1" placeholder="address">
                                                @error('address')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                {{-- <span class="tag-pincode">*</span>  --}}
                                                <label for="inputEmail">Pincode </label>
                                                <input type="number" min="0" name="pincode" id="pincode"
                                                    value="{{ old('pincode') }}" class="form-control" id=""
                                                    placeholder="pincode">
                                                @error('pincode')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">State *</label>
                                                @php
                                                    $state = App\Models\State::get();
                                                @endphp
                                                <select class="form-control" name="state">
                                                    <option value="">Please Select State</option>
                                                    @foreach ($state as $cit)
                                                        <option value="{{ $cit->id }}">{{ $cit->state ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('state')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="inputEmail">City *</label>
                                                @php
                                                    $cites = App\Models\City::get();
                                                @endphp
                                                <select class="form-control" name="city">
                                                    <option value="">Please Select City</option>
                                                    @foreach ($cites as $cit)
                                                        <option value="{{ $cit->id }}">{{ $cit->city ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('city')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="form-group landmark">
                                                <label for="inputEmail">landmark </label>
                                                <input type="text" name="landmark" value="{{ old('landmark') }}"
                                                    maxlength="48" class="form-control" id=""
                                                    placeholder="landmark" placeholder="gst">
                                                @error('landmark')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group contact-person">
                                                <label for="inputEmail">Contact Person Name </label>
                                                <input type="text" name="contact_person_name"
                                                    value="{{ old('contact_person_name') }}" class="form-control"
                                                    id="" placeholder="Contact person name">
                                                @error('contact_person_name')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group mobile">
                                                <label for="inputEmail">Mobile </label>
                                                <input type="number" name="mobile" value="{{ old('mobile') }}"
                                                    class="form-control" id="" placeholder="mobile"
                                                    placeholder="Please Enter Mobile">
                                                @error('mobile')
                                                    <span class="text-warning">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>

                                        <button type="submit" id="submit" name="submit"
                                            class="btn btn-add-address btn-primary btn-block float-right mb-3">Add
                                            Address </button>
                                        <button type="submit" name="submit"
                                            class="btn btn-primary d-none btn-update-address btn-block float-right mb-3">Update
                                            Address </button>
                                        <span class="add-more-address d-none">Do you want to add item ? <a
                                                href="">Click Here</a> </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <div class="table-container">

                                    <div class="table-responsive">
                                        <table id="copy-print-csv-address" class="table custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Venue</th>
                                                    <th>Address</th>
                                                    <th>Type</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Pincode</th>
                                                    <th>Landmark</th>
                                                    <th>Contact Person</th>
                                                    <th>Mobile</th>

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
    <script type="text/javascript" src="{{ asset('resources/js/master/address.js?v=' . time()) }}"></script>
</div>
