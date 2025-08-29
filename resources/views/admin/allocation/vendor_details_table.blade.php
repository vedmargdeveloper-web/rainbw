 <div class="bottom-tables">
            <div class="left" style="width: 100%;">
                <h3 style="text-align: center; padding: 10px 0;">{{ $vendor1[0]->vendorfetch->company_name ?? '' }} ( NO 1 )</h3>
               <table class="allocation-table2" style="width: 100%;" >
                    <thead>
                        <tr>
                            
                            <th>S.No.</th>
                            <th>Booking Date</th>
                            <th>Item</th>
                            <th>Booking Qty</th>
                            <th>Days</th>
                            <th>Readyness</th>
                            <th>Venue</th>
                            <th>Address</th>
                            <th>Rental</th>
                            <th>Transport</th>
                            <th>Driver</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@php
                    		$count=0; 
                    		$total_amount = 0;
                    		$total_qty = 0;
                    	@endphp
                    	@foreach($vendor1 as $v)
                    	{{-- {{ dd($v) }} --}}
                            @if($v->allocation_qty >0 )
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $v->allocation ? $v->allocation->billing_date : ''  }}</td>
                                <td>{{ $v->allocation ? $v->allocation->item : ''  }}</td>
                                <td>{{ $v->allocation_qty ?? '' }} <?php $total_qty += $v->allocation_qty; ?></td>
                                <td>{{ $v->allocation->day ?? '' }}</td>
                                <td>{{ $v->allocation->readyness ?? '' }}</td>
                                <td>{{ $v->allocation->venue_name ?? '' }}</td>
                                <td>{{ $v->allocation->address ?? 'aaddress' }}</td>
                                <td>{{ $v->rental ?? 0 }}</td>
                                <td>{{ $v->transport ?? 0 }}</td>
                                <td>{{ $v->driver ?? 0 }}</td>
                                <td>{{ ($v->transport*$v->allocation_qty*$v->allocation->day)+($v->rental*$v->allocation_qty*$v->allocation->day)+($v->driver*$v->allocation_qty*$v->allocation->day) }}
                                	<?php
                                		$total_amount +=($v->transport*$v->allocation_qty*$v->allocation->day)+($v->rental*$v->allocation_qty*$v->allocation->day)+($v->driver*$v->allocation_qty*$v->allocation->day); 
                                	?>
                                </td>
                            </tr>
                            @endif()
                        @endforeach
                        <tr>
                        	<td colspan="2"></td>
                        	<td >Total</td>
                        	<td >{{ $total_qty }}</td>
                        	<td colspan="6">{{ $total_qty }}</td>
                        	<td >Total</td>
                        	<td >{{ $total_amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="right-bottom" style="width: 100%;">
                <h3 style="text-align: center; padding: 10px 0;">{{ $vendor2[0]->vendorfetch->company_name ?? '' }} ( NO 2 )</h3>

               <table class="allocation-table2" style="width: 100%;" >
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Booking Date</th>
                            <th>Item</th>
                            <th>Booking Qty</th>
                            <th>Days</th>
                            <th>Readyness</th>
                            <th>Venue</th>
                            <th>Address</th>
                            <th>Rental</th>
                            <th>Transport</th>
                            <th>Driver</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count=0; 
                            $total_amount = 0;
                            $total_qty = 0;
                        @endphp
                        @foreach($vendor2 as $v)
                        {{-- {{ dd($v) }} --}}
                            @if($v->allocation_qty >0 )
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $v->allocation ? $v->allocation->billing_date : ''  }}</td>
                                <td>{{ $v->allocation ? $v->allocation->item : ''  }}</td>
                                <td>{{ $v->allocation_qty ?? '' }} <?php $total_qty += $v->allocation_qty; ?></td>
                                <td>{{ $v->allocation->day ?? '' }}</td>
                                <td>{{ $v->allocation->readyness ?? '' }}</td>
                                <td>{{ $v->allocation->venue_name ?? '' }}</td>
                                <td>{{ $v->allocation->address ?? 'aaddress' }}</td>
                                <td>{{ $v->rental ?? 0 }}</td>
                                <td>{{ $v->transport ?? 0 }}</td>
                                <td>{{ $v->driver ?? 0 }}</td>
                                <td>{{ ($v->transport*$v->allocation_qty*$v->allocation->day)+($v->rental*$v->allocation_qty*$v->allocation->day)+($v->driver*$v->allocation_qty*$v->allocation->day) }}
                                    <?php
                                        $total_amount +=($v->transport*$v->allocation_qty*$v->allocation->day)+($v->rental*$v->allocation_qty*$v->allocation->day)+($v->driver*$v->allocation_qty*$v->allocation->day); 
                                    ?>
                                </td>
                            </tr>
                            @endif()
                        @endforeach
                        <tr>
                            <td colspan="2"></td>
                            <td >Total</td>
                            <td >{{ $total_qty }}</td>
                            <td colspan="6">{{ $total_qty }}</td>
                            <td >Total</td>
                            <td >{{ $total_amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
</div>