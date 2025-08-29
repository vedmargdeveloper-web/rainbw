@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">

				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<form action="{{ route('item.update',['item'=>$item->id]) }}" method="post">
									@csrf
									{{ method_field('PATCH') }}
									<div class="card-body">
										
										<div class="row gutters">
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputName">Name *</label>
													<input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $item->name  }}" id="" placeholder="Product Name">
													@error('name')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">HSN *</label>
													<input type="text" class="form-control" name="hsn" value="{{ old('hsn') ? old('hsn') : $item->hsn }}" id="" placeholder="HSN CODE">
													@error('hsn')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">CSGT *</label>
													<input type="number" min="0" value="{{ old('cgst') ? old('cgst') : $item->cgst  }}" class="form-control" id=""  name="cgst" placeholder="CGST">
													@error('cgst')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">SGST *</label>
													<input type="number" min="0" name="sgst" value="{{ old('sgst') ? old('sgst') : $item->sgst }}" class="form-control" id="" placeholder="SGST">
													@error('sgst')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">IGST *</label>
													<input type="number" min="0" class="form-control" value="{{ old('igst') ? old('igst') : $item->igst }}"  id="" placeholder="IGST" name="igst">
													@error('igst')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Status *</label>
													<select placeholder="Status" name="status"   class="form-control">
														<option value="active" {{ (old('status') ? old('status') : $item->status =='active') ? 'selected' :''  }}>Active</option>
														<option value="inactive" {{ (old('status') ? old('status') : $item->status =='inactive') ? 'selected' :''  }}>Inactive</option>
													</select>
													@error('status')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
												<div class="form-group">
													<label for="inputEmail">Description *</label>
													<input type="text" name="description" value="{{ old('description')  ? old('status') : $item->description }}" class="form-control" id="" placeholder="Description" placeholder="CGST">
													@error('description')
															<span class="text-warning">{{ $message }}</span>
													@endError
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<button type="submit" id="submit" name="submit" class="btn btn-primary float-right mb-3">Update Product</button>
										</div>
									</div>
								</form>
							</div>
						</div>

					
							

						
					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
			</div>

		
		
		
@endsection