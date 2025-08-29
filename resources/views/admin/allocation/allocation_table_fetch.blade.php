<form action="" method="post" id="form-inner-div">
    @csrf
	<table class="allocation-table" >
            <thead>
                <tr>
                    <th></th>
                    <th>Qty</th>
                    <th>Rate</th>
                    {{-- <th>Transport</th>
                    <th>Driver</th>
                    <th>Food</th>
                    <th>Accomodation</th>
                    <th>Conveyance</th>
                    <th>Security</th>
                    <th>Other</th>
                    <th>Tax</th>--}}
                    <th>Remark</th> 
                </tr>
            </thead>
            <tbody>
            	@php
            		$all_id = [];
            		$old_id = [];
            		$edit 	= false;
            	@endphp
            	@if($customers->count() > 0 )
                    @foreach($customers as $customer)
                    	@php
                    		$all_id[] = $customer->id;
                    	@endphp
                    	<tr>
                    		@if($allocation && $allocation->allocationVendor)
                        		@foreach($allocation->allocationVendor as $all_val)
                        			@if($all_val->vendor_id == $customer->id)
                        			@php
			                    		$old_id[] = $customer->id;
			                    		$edit = true;
			                    	@endphp
                        					<td>{{ ucfirst($customer->company_name) }}</td>
				                            <td><input type="number"  class="td-allocation-input" data-vendorId="{{ $customer->id }}" data-td="td_{{ $customer->id }}"  value="{{ $all_val->allocation_qty }}" name="allocation_qty" max="{{ ($customer->id == 49) ? $data_finalrainbowbooking  :  'no'}}" mode="edit"></td>
				                            <td><input type="number" class="min-width-20 {{ ($customer->id == 49) ?  'myrainbow' :  0}}"  value="{{ $all_val->rental }}" name="rental"></td>
				                            {{-- <td><input type="number" class="min-width-20"  value="{{ $all_val->transport }}" name="transport"></td>
				                            <td><input type="number" class="min-width-20"   value="{{ $all_val->driver }}" name="driver"></td>
				                            <td><input type="number" class="min-width-20"   value="{{ $all_val->food }}" name="food"></td>
				                            <td><input type="number" class="min-width-20"   value="{{ $all_val->accomodation }}" name="accomodation"></td>	
				                            <td><input type="number" class="min-width-20"   value="{{ $all_val->conveyance }}" name="conveyance"></td>	
				                            <td><input type="number" class="min-width-20"   value="{{ $all_val->security }}" name="security"></td>	
				                            <td><input type="number" class="min-width-20"   value="{{ $all_val->other }}" name="other"></td>	
				                            <td><input type="number" class="min-width-20" value="{{ $all_val->tax }}" name="tax"></td>	--}}
				                            <td><input type="text"   class="" value="{{ ($all_val->remark == "0") ?  '' : ''   }}" name="remark"></td>		 
                        			@endif
                        		@endforeach
		                    @else

		                    	<td>{{ ucfirst($customer->company_name) }}</td>
	                            <td><input type="number"  class="td-allocation-input" data-vendorId="{{ $customer->id }}" data-td="td_{{ $customer->id }}"  value="0" name="allocation_qty" max="{{ ($customer->id == 49) ?  $data_finalrainbowbooking  :  'no'}}" mode="add"></td>
	                            <td><input type="number" class="min-width-20  {{ ($customer->id == 49) ?  'myrainbow' :  0}}"  value="{{ ($customer->id == 49) ?  $data_amount  :  0}}"   name="rental"></td>
	                            {{-- <td><input type="number" class="min-width-20"  value="0" name="transport"></td>
	                            <td><input type="number" class="min-width-20"  value="0" name="driver"></td>
	                            <td><input type="number" class="min-width-20"  value="0" name="food"></td>
	                            <td><input type="number" class="min-width-20"  value="0" name="accomodation"></td>	
	                            <td><input type="number" class="min-width-20"  value="0" name="conveyance"></td>	
	                            <td><input type="number" class="min-width-20"  value="0" name="security"></td>	
	                            <td><input type="number" class="min-width-20"  value="0" name="other"></td>	
	                            <td><input type="number" class="min-width-20"  value="0" name="tax"></td>	--}}
	                            <td><input type="text"   class="" value=" " name="remark"></td>	 
		                    @endif
                           
                        </tr>
                    @endforeach
                    @php
                    	$diff = array_diff($all_id, $old_id);
                    	$unique_customer = $customers->whereIn('id',$diff);
                    @endphp
                    @if($edit)
	                    @foreach($unique_customer as $unique)
	                    			<tr>
	                    			<td>{{ ucfirst($unique->company_name) }}</td>
		                            <td><input type="number"  class="td-allocation-input " data-vendorId="{{ $unique->id }}" data-td="td_{{ $unique->id }}"  value="0" name="allocation_qty" max="{{ ($unique->id == 49) ?  $data_finalrainbowbooking  :  'no'}}" mode="add"></td>
		                            <td><input type="number" class="min-width-20 {{ ($unique->id == 49) ?  'myrainbow' :  ''}}"  value="{{ ($unique->id == 49) ?  $data_amount  :  0}}"   name="rental"></td>
		                            {{-- <td><input type="number" class="min-width-20"  value="0" name="transport"></td>
		                            <td><input type="number" class="min-width-20"  value="0" name="driver"></td>
		                            <td><input type="number" class="min-width-20"  value="0" name="food"></td>
		                            <td><input type="number" class="min-width-20"  value="0" name="accomodation"></td>	
		                            <td><input type="number" class="min-width-20"  value="0" name="conveyance"></td>	
		                            <td><input type="number" class="min-width-20"  value="0" name="security"></td>	
		                            <td><input type="number" class="min-width-20"  value="0" name="other"></td>	
		                            <td><input type="number" class="min-width-20"  value="0" name="tax"></td>	--}}
		                            <td><input type="text"   class="" value=" " name="remark"></td>	 
		                        	</tr>			                    		
	                    @endforeach
                    @endif
                    <tr>
                    	<div class="form-group  table-select-center">
							<select name="lead_status" required="" id="leadstatus" style="display: none;">
								<option value="" >Select</option>
					            @foreach($leads as $lead)
					                <option value="{{ $lead->id }}"  >{{ $lead->lead }}</option>
					            @endforeach
					        </select> 
					        <a href="javascript:void(0)" class="btn btn-primary change-status" style="display: none;" >Change Status</a>
						</div>	
						<td></td>
                    	<td colspan="11" style="border: unset;"><button id="btn-allocation" dynamic_row="{{ $unique_tr ?? '' }}">Allocation</button></td>
                    </tr>
                @endif
            </tbody>
	</table>
</form>