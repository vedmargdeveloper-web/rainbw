@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')

	{{-- @include( _template('master.sections.password') )	 --}}
	@include( _template('master.sections.state') )	
	@include( _template('master.sections.source') )	
	@include( _template('master.sections.occasion') )	
	@include( _template('master.sections.vehicleHead') );
	@include( _template('master.sections.idgenration') );
	@include( _template('master.sections.transport') );
	@include( _template('master.sections.item') )	
	@include( _template('master.sections.dealer') )	
	@include( _template('master.sections.gst') )	
	@include( _template('master.sections.address') )	
	{{-- @include( _template('master.sections.challan') ) --}}
	@include(_template('master.sections.challan'), ['challanTypes' => $challanTypes])

	
	<style type="text/css">
		.buttons-csv,.buttons-print{
			display: none !important;
		}
	</style>

@endsection