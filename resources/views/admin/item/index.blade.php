@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
<div class="main-container">


				
				<!-- Page header end -->


				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row start -->
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
							<div class="table-container">
								<div class="t-header"> <a class="btn btn-primary" href="{{ route('item.create') }}">Create Item</a> </div>
								<div class="table-responsive">
									<table id="copy-print-csv" class="table custom-table">
										<thead>
											<tr>
											  <th>Name</th>
											  <th>HSN</th>
											  <th>Status</th>
											  <th>CGST</th>
											  <th>SGST</th>
											  <th>IGST</th>
											  <th>Description</th>
											  <th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if($items && count($items) > 0)
												@foreach($items as $item)
												<tr>
												  <td>{{ $item->name }}</td>
												  <td>{{ $item->hsn }}</td>
												  <td><span class="badge {{ $item->status=='inactive' ? 'badge-danger' : 'badge-success' }} ">{{ ucfirst($item->status) }} </span></td>
												  <td>{{ $item->cgst }}</td>
												  <td>{{ $item->sgst }}</td>
												  <td>{{ $item->igst }}</td>
												  <td>{{ $item->description }}</td>
												  <th>
												  	<div class="action-btn">
													<a class="badge badge-info td-btn" href="{{ route('item.edit',['item'=>$item->id]) }}" >Edit</a>
													<form action="{{ route('item.destroy',$item->id) }}" method="POST">
													    @method('DELETE')
													    @csrf
													    <button class="badge badge-danger td-btn td-btn-delete" onclick="return confirm('are you sure want to delete ?')" >Delete</button>
													</form>
													</div>
												  </th>
												</tr>
												@endforeach
											@endif
										</tbody>
						    	</table>
								</div>
							</div>
							</div>
						</div>

					
							

						
					</div>
					<!-- Row end -->

				</div>
				<!-- Content wrapper end -->
			</div>

		
		
		
@endsection