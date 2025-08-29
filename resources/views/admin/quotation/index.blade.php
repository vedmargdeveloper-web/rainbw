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
									<div class="table-responsive">
							    		<table id="copy-print-csv" class="table custom-table">
											<thead>
												<tr>
												  <th>Quotation Id</th>
												  <th>Client Name</th>
												  <th>Contact Person</th>
												  <th>Mobile</th>
												 {{--  <th>WhatsApp</th> --}}
												  <th>Occasion</th>
												  <th>Readyness</th>
												  <th>Venue</th>
												  {{-- <th>City</th> --}}
												  <th>Item</th>
												  <th colspan="2">Action</th>
												</tr>
											</thead>
											<tbody>
												
												@if($invoices)
													@foreach($invoices as $inv)
													@php
														$customer_details 	= json_decode($inv->customer_details,true);
														$venue_details 		= json_decode($inv->delivery_details,true);
														//print_r($customer_details);
													@endphp
														@if($inv->leadstatus && is_object($inv->leadstatus) && $inv->leadstatus->status == 'Update: Pending for Confirmation')
															<tr>
																<td>{{ $inv->invoice_no}}.{{ $inv->pitch_count }}</td>
															 	<td>{{ $customer_details['company_name'] ?? '' }}</td>
															 	<td>{{ is_numeric( $customer_details['contact_person_c'] ) ?  $customer_details['select_two_name'] ?? '' : $customer_details['contact_person_c'] }}</td>
															{{--  	<td>{{  == 0 ?  'name' : $customer_details['contact_person_c'] }}</td> --}}
															 	<td>{{ $customer_details['cmobile'] ?? '' }}</td>
															 {{-- 	<td>{{ $customer_details['cwhatsapp'] ?? '' }}</td> --}}
															 	<td>{{ $inv->occasion->occasion ?? '' }}</td>
															 	<td>{{ $customer_details['creadyness'] ?? '' }}</td>
															 	<td>{{ $venue_details['dvenue_name'] ?? '' }}</td>
															 	{{-- <td>{{ $venue_details['dcity'] ?? '' }}</td> --}}
															 	<td> 
															 		@foreach($inv->quotationItem  as $sinitem)
															 				{{ $sinitem->item ?? '' }},
															 		@endforeach
															 	</td>
															 	<td colspan="3" class="td-flex tn-buttons-table">
															 		<a href="{{ route('quotation.edit',['quotation'=>$inv->id]) }}?&gstid={{$inv->id}}" class="badge badge-success"> Edit
																 	</a>
																@if($inv->pitch_count <= 0 )
																 	{{-- <a href="{{ route('quotation.edit',['quotation'=>$inv->id]) }}?&gstid={{$inv->id}}" class="badge badge-success"> Edit
																 	</a> --}}
																@endif
														 		<a href="{{ route('quotation.print',['id'=>$inv->id]) }}?type={{ ($inv->pitch_count > 0 ) ? 'print-pitch' : 'quotation-print'   }}&tax=0" class="badge badge-info"> Print
														 		</a>
														 		<a href="{{ route('quotation.print',['id'=>$inv->id]) }}?type={{ ($inv->pitch_count > 0 ) ? 'print-pitch' : 'quotation-print'   }}&tax=1" class="badge badge-info"> Tax Print
														 		</a>
														 		<a href="{{ route('pitch.show',['pitch'=>$inv->enquire_id]) }}?type=" class="badge badge-primary">Pitch 
														 		</a>

																{{-- <a href="{{ route('challanOne.print',['id'=>$inv->id]) }}"  class="badge badge-primary">Ch.
														 		</a> --}}
																{{-- <a href="{{ route('returnchallan.print',['id'=>$inv->id]) }}" class="badge badge-info">Rt. Ch 
														 		</a> --}}
																<a href="javascript:void(0);" class="badge badge-primary open-print-modal" data-id="{{ $inv->id }}" data-type="challan">Ch.</a>
                                                                <a href="javascript:void(0);" class="badge badge-info open-print-modal" data-id="{{ $inv->id }}" data-type="return-challan">Rt. Ch</a>
														 	    </td>
															</tr>
														@endif
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

			<!-- Modal -->
				<div class="modal fade" id="printTypeModal" tabindex="-1" role="dialog" aria-labelledby="printTypeModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<form id="printTypeForm" target="_blank" method="GET">
					<div class="modal-content">
						<div class="modal-header">
						<h5 class="modal-title">Select Print Type</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						</div>
						<div class="modal-body">
						<input type="hidden" name="id" id="print_invoice_id">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="print_type" id="original" value="Original" checked>
							<label class="form-check-label" for="original">Original</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="print_type" id="duplicate" value="Duplicate">
							<label class="form-check-label" for="duplicate">Duplicate</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="print_type" id="triplicate" value="Triplicate">
							<label class="form-check-label" for="triplicate">Triplicate</label>
						</div>
						</div>
						<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Print</button>
						</div>
					</div>
					</form>
				</div>
				</div>

			<script>
    $(document).on('click', '.open-print-modal', function () {
        var id = $(this).data('id');
        var type = $(this).data('type');

        // Set form action based on type
        let action = type === 'challan'
            ? "{{ url('admin/quotation/challan/print') }}/" + id
            : "{{ url('admin/quotation/return-challan/print') }}/" + id;

        $('#printTypeForm').attr('action', action);
        $('#print_invoice_id').val(id);
        $('#printTypeModal').modal('show');
    });
</script>

		
@endsection