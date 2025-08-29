<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        {{-- <title>Table</title> --}}
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <?php

            function getRandomColor()
                    {
                        $letters = '0123456789ABCDEF';
                        $color = '';
                        $color = "hsl(".rand(0, 100005).", 100%, 75%)";
                        return $color;
                    }
        ?>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: sans-serif;
            }
            input[type="number"]::-webkit-outer-spin-button, 
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            input[type="number"] {
                -moz-appearance: textfield;
            }
            .td-allocation-input{
                width: 40px;
            }
            .main-table {
                margin: 10px;
                height: 340px;
            }
            .main-table {
                
                overflow: auto; 
            }
            .main-table table thead{
                    /*width: 1600px;*/
                    position: sticky;
                    top: 1px;
                    width: 100%;
                    background: #fff;
                    z-index: 9999
            }
            table {
                width: 100%;
            }
            table.allocation-table {
                border: unset;
            }
            table.allocation-table td,
            table.allocation-table th {
                padding: 5px 0;
            }
            table.allocation-table td:first-child {
                border: unset;
            }
            table.allocation-table th:first-child {
                border: unset;
            }
            table.allocation-table tbody tr td:nth-child(5) {
                width: unset;
            }
            table,
            th,
            td {
                border:  1px solid;
                border-collapse: collapse;
            }
            .main-table table,
            .main-table th,
            .main-table td {
                outline:   1px solid;
                border-collapse: collapse;
                border: unset!important;
            }
          
            .middle-table th,
            .middle-table td{
                outline:   1px solid;
                border-collapse: unset;
                border: unset!important;
            }
            .middle-table{
                padding: 10px;
            }
            tbody td {
                font-size: 10px;
                padding: 0 5px;
            }
            th {
                font-size: 10px;
                padding: 3px 5px;
            }
            table tbody tr td:nth-child(18) {
                background: #e2efda;
            }
            table tbody tr td:nth-child(19) {
                background: #e2efda;
            }
            .background-dynamic-td{
                background: #e2efda;    
            }
            table tbody tr td:nth-child(20) {
                background: #e2efda;
            }
            table tbody tr td:nth-child(21) {
                background: #e2efda;
            }
            /*table tbody tr td:nth-child(23) {
                background: #d9d9d9;
            }*/
            .td-background-gray{
                background: #d9d9d9;
            }
           /* table tbody tr td:nth-child(24) {
                background: #d9d9d9;
            }*/
          /*  table tbody tr td:nth-child(22) {
                background: #e2efda;
            }
            .
*/
           
            table tbody tr td:nth-child(16) {
                background: #d9d9d9;
            }
            table tbody tr td:nth-child(17) {
                background: #d9d9d9;
            }
            table tbody tr td:nth-child(15) {
                background: #e2efda;
            }
            table tbody tr td:nth-child(14) {
                background: #d9d9d9;
            }
            table tbody tr td:nth-child(12) {
                background: #d9d9d9;
            }
            table tbody tr td:nth-child(13) {
                background: #ffd966;
            }
            table tbody tr td:nth-child(11) {
                background: #e2efda;
            }
            table tbody tr td:nth-child(6) {
                width: 5%;
            }
            table tbody tr td:nth-child(5) {
                width: 5%;
            }
            table tbody tr td {
                text-align: center;
            }
            .bottom-tables {
                display: flex;
                align-items: center;
                justify-content: space-around;
            }
            tr.current-vendor-tr-details {
                cursor: pointer;
            }
            .bottom-tables .right {
                display: flex;
                align-items: baseline;
                justify-content: space-around;
            }
            .bottom-tables .left,
            .bottom-tables .right {
                width: 49%;
            }
            #btn-allocation{
                background: #07a87c;
                color: white;
                border: 0;
                padding: 10px;
                text-transform: uppercase;
                border-radius: 6px;
            }
            .tr-box-shadow{
                /*box-shadow: 0 0 20px 9px #ccc;*/
                position: relative;
                z-index: 99;
                /*background: unset !important;*/
            }
            .tr-box-shadow td{
                /*font-weight: 600;*/
               height: 40px;
            }
            .tr-box-shadow td{
                /*box-shadow: 0 0 20px 9px #ccc;*/
                /*background: unset !important;*/
            }
            .select_booking{
                cursor: pointer;
            }
            input.min-width-20 {
                width: 36px;
            }
            .color-red{
                background: red !important;
            }




             .bottom-tables {
                display: flex;
                align-items:unset;
                justify-content: space-around;
            }
            .bottom-tables .right {
                display: flex;
                align-items: baseline;
               
            }
            .bottom-tables .left,
            .bottom-tables .right {
                width: 49%;
                /*margin-top: 4%;*/

            }
            #btn-allocation {
                background: #07a87c;
                color: white;
                border: 0;
                padding: 10px;
                text-transform: uppercase;
                border-radius: 6px;
            }
            .tr-box-shadow {
                /*box-shadow: 0 0 20px 9px #ccc;*/
                /*background: unset !important;*/
            }
            .tr-box-shadow td {
                /*box-shadow: 0 0 20px 9px #ccc;*/
                /*background: unset !important;*/
            }
            .select_booking {
                cursor: pointer;
            }
            input.min-width-20 {
                width: 36px;
            }
            .fixbg{
                background color: red!important; 
            }
            .fix{
            position: sticky;
                white-space: nowrap;
            left: 1px;
            z-index: 2;
            background-color: white;
                outline: 1px solid #000;
            }
            .fix2{
            position: sticky;
            white-space: nowrap;
            left: 24px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
            .fix3{
                position: sticky;
                white-space: nowrap;
                left: 60px;
                min-width: 159px;
                z-index: 2;
                width: 140px;
                background-color: white;
                outline: 1px solid #000;
            }
            .fix4{
            position: sticky;
            white-space: nowrap;
            left: 220px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix5{
            position: sticky;
                white-space: nowrap;
            left: 293px;
            min-width: 130px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix6{
            position: sticky;
                white-space: nowrap;
            left: 423px;
            min-width: 130px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix7{
            position: sticky;
                white-space: nowrap;
            left: 553px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix8{
            position: sticky;
            white-space: nowrap;
            left: 624px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix9{
            position: sticky;
            white-space: nowrap;
            left: 658px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix10{
            position: sticky;
            white-space: nowrap;
            left: 721px;
            min-width: 140px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix11{
            position: sticky;
            white-space: nowrap;
            left: 859px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
            input[name="remark"]{
                width: 60px;
            }
            .table-select-center{
                text-align: center;
                margin-bottom: 10px;
            }
            .fix7{
                position: sticky;
                left: 553px;
                z-index: 2;
                background-color: white;
                outline: 1px solid #000;
            }
        </style>
    </head>

    <body>
        <div class="main-table">
            <table>
                <thead>
                    <tr>
                        <th rowspan="4" class="fixbg fix"></th>
                        <th rowspan="4" class="fixbg fix2">S.No.</th>
                        <th rowspan="4" width="100px" class="fixbg fix3">Booking ID</th>
                        <th rowspan="4" width="100px" class="fixbg fix4">Booking Date</th>
                        <th rowspan="4" class="fixbg fix5">Client</th>
                        <th rowspan="4" class="fixbg fix6">Item</th>
                        <th rowspan="3" class="fixbg fix7">0</th>
                        <th rowspan="4" class="fixbg fix8">Days</th>
                        <th rowspan="4" class="fixbg fix9">Readyness</th>
                        <th rowspan="4" class="fixbg fix10">Venue</th>
                        <th rowspan="4" class="fixbg fix11">Allocation Date</th>
                        <th colspan="{{ 6+$customers->count() }}">Inventory</th>
                        <th colspan="3">Booking Statistics</th>
                    </tr>
                    <tr>
                        <th colspan="6" rowspan="2">Rainbow</th>
                        <th colspan="{{ $customers->count() }}">Dealer's Inventory</th>
                        <th rowspan="2">0</th>
                        <th rowspan="2">0</th>
                        <th rowspan="2">0</th>
                    </tr>
                    <tr>
                    	@if($customers->count() > 0 )
	                        @foreach($customers as $customer)
	                        	<th class="grandsome{{ $customer->id }}">0</th>
	                        @endforeach
	                    @endif
                    </tr>
                    <tr>
                        <th class="fix7">Booking Qty</th>
                        <th>TT Count</th>
                        <th>Damaged</th>
                        <th>TT Available</th>
                        <th>Booked</th>
                        <th>Bal. Available</th>
                        <th>Unallocated Bookings in Rainbow</th>
                        @php
                        	$qty_th = "";
                        	$value_td = "";
                        @endphp
                        @if($customers->count() > 0 )
	                        @foreach($customers as $customer)
	                        	<th>{{ $customer->company_name }}</th>
	                        	<?php 
	                        		$qty_th .="<th>Qty</th>";
	                        		$value_td .="<td dataclass='td_".$customer->id."' class='background-dynamic-td  td_".$customer->id."' >0</td>";
	                        	?> 
	                        @endforeach
	                    @endif
                        <th>TT Dealer Booked</th>
                        <th>TT Booked</th>
                        <th>Unallocated Booking</th>
                    </tr>
                    <tr>
                        {{-- <th class="fixbg fix"></th>
                        <th class="fixbg fix2"></th>
                        <th class="fixbg fix3"></th>
                        <th class="fixbg fix4"></th>
                        <th class="fixbg fix5"></th>
                        <th class="fixbg fix6"></th>
                        <th class="fixbg fix7"></th>
                        <th class="fixbg fix8"></th>
                        <th class="fixbg fix9"></th>
                        <th class="fixbg fix10"></th>
                        <th class="fixbg fix11"></th> --}}
                        
                        <th class="fix" colspan="11"></th>
                        <th colspan="6"></th>
                        {!! $qty_th !!}
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                	@php
                		$count = 0;
                        $booking_allocation_total = [];
                        $all_vendor_id = [];
                       // dd($bookings);
                	@endphp
                  @foreach($bookings as $key => $booking)
                      	@php
                      		$customer_details =  json_decode($booking->customer_details,true);
                      		$delivery_details =  json_decode($booking->delivery_details,true);
                            $unique_color  =  (($key % 2)==0) ?  "#99ff66" : '#00ffff';
                            $total_tr_unlocated_sum = 0;
                      	@endphp
                      {{--   @if($booking->leadstatus->status == 'Proceed for Booking') --}}
                      		@foreach($booking->bookingItem as $item)
                                
                      			@for($ia =0; $ia < $item->days; $ia++)
                      				@php
                                        $uniq_tr = 'tr_'.md5($booking->invoice_no.'_day'.$ia.'_item'.$item->id);
                      					$retrive =  [
                      						'client_name'=>$customer_details['company_name'] ?? 'Somthing Wrong',
                      						'days'=>1,
                      						'booking_date'=>$booking->billing_date,
                      						'item'=>$item->item,
                      						'qty'=>$item->quantity,
                      						'readyness'=>$booking->readyness ?? '',
                      						'booking_id'=>$booking->invoice_no ?? 'Somthing wrong',
                                            'bookings_table_id'=>$booking->id ?? 0,
                      						'venue'=>$delivery_details['dvenue_name'] ?? 'Something wrong',
                      					];
                      					$allocation = App\Models\Allocation::with('allocationVendor')->where('unique_tr_id',$uniq_tr)->first();

                      					$allocation_array = $allocation ? $allocation->toArray() : [];
                      					//dd($allocation);
                      					// echo '<pre>';
                      					// 	print_r($allocation_array);
                      					// echo '</pre>';
                                        $allocation_db_value =  0;
                                        if($allocation):
                                              $allocation_db_value =  $allocation->grand_unallocated_booking;
                                            else:
                                              $allocation_db_value =  $item->quantity;
                                        endif;
                                              $total_tr_unlocated_sum +=$allocation_db_value; 
                      				@endphp

    			                       <tr data-unlocated="{{ $total_tr_unlocated_sum }}"  id="tr_<?= md5($booking->invoice_no.'_day'.$ia.'_item'.$item->id) ?>" class="{{ ($allocation_db_value > 0 ) ? 'color-red' : 'allocated'   }}">

                                        <td class="fixbg fix"><input type="radio" name="select_booking" data-allocationdate="{{ $allocation ? $allocation->allocation_date : ''   }}" data-row="tr_<?= md5($booking->invoice_no.'_day'.$ia.'_item'.$item->id) ?>" data-resp="{{ json_encode($retrive) }}" class="select_booking"></td>
                                        <td class="fixbg fix2">{{ ++$count }}</td>
                                        <td class="booking_id fix3" style="background:{{ $unique_color }}">No {{ $booking->booking_type }} {{ $booking->invoice_no ?? 'Somthing wrong' }} </td>
                                        <td class="billing_date fix4">{{ date('d-m-Y',strtotime($booking->billing_date))  }}</td>
                                        <td class="company_name fix5">{{ $customer_details['company_name'] ?? 'Somthing Wrong' }}</td>
                                        <td class="item_id fix6" data-bookings_table_id="{{ $booking->id }}" data-item="{{ $item->item_id }}">{{ $item->item }}</td>
                                        <td class="required_qty fix7" >{{ $item->quantity }}</td>
                                        <td class="day fix8" >1</td>
                                        <td class="readyness fix9">{{ $booking->readyness ?? '' }}</td>
                                        <td class="venue_name fix10">{{ $delivery_details['dvenue_name'] ?? 'Something wrong' }}</td>
                                        <td class="allocation_date fix11">{{ $allocation ? $allocation->allocation_date : 0 }}</td>
                                        <td>{{ $item->vechicle_genration_count ?? 'Wrong' }}</td>
                                        <td>0</td>
                                        <td class="total_availablity">{{ $item->vechicle_genration_count ?? 0 }}</td>
                                        <td><input type="number" name="booking_rainbow" class="booking_input" value="0" style="width: 50px;"></td>
                                        <td class="bal_avaliblity">0</td>
                                        <td class="unallocated_booking_rainbow">{{ $allocation ? $allocation->rainobw_unallocated : 0 }}</td>
                                        @php
                                            $sum = 0;
                                        @endphp
                                        @foreach($customers as $customer)
                                            <td class='background-dynamic-td  td_{{$customer->id}}'>
                                                @php
                                                    
                                                    if(isset($allocation)):
                                                        
                                                        foreach($allocation->allocationVendor as $all_val):
                                                            if($all_val->vendor_id == $customer->id):
                                                                echo $all_val->allocation_qty;
                                                                $sum += $all_val->allocation_qty;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                @endphp
                                            </td>
                                        @endforeach
                                        <td class="td-background-gray total_dealer_booked">{{ $allocation ? $allocation->total_dealer_booked : 0 }}</td>
                                        <td class="td-background-gray grand_total_booked">{{ $allocation ? $allocation->grand_total_booked : 0 }}</td>
                                 <td class="grand_unallocated_booking">{{ $allocation_db_value  }}</td>
                                    </tr>
                                    @php
                                        $old_inovice ='';
                                    @endphp
    			                 @endfor
    	                    @endforeach
                            @php
                                $booking_allocation_total[] = ['booking_id'=>$booking->invoice_no,'allocated'=>$total_tr_unlocated_sum];
                            @endphp
                        {{-- @endif --}}
                    @endforeach
                    <span class="calculation" data-calculation="{{json_encode($booking_allocation_total)}}"></span>
                 
            </table>
        </div>
        <div class="middle-table">
            <h3 style="text-align: center; padding: 10px 0;">Allocation Details</h3>
            @php
                $items = App\Models\Item::get();
                $count_th = 0;
            @endphp
            <table class="allocation-table" style="width: 100%">
                <thead>
                <tr>
                  <th></th>
                    @foreach($items as $item)
                        <th colspan="2">{{ $item->name }}</th>
                        @php
                            $count_th++;
                        @endphp
                    @endforeach
                  {{--  --}}
                </tr>
              </thead>
              <thead>
                <tr >
                  <th></th>
                    @for($i=1; $i <= $count_th; $i++ )    
                      <th>Qty</th>
                      <th>Amount</th>
                    @endfor
                </tr>
              </thead>
              <tbody>
                @if($customers->count() > 0 )
                    @foreach($customers as $customer)
                        <tr data-vendor="{{ $customer->id }}" class="current-vendor-tr-details">
                          <td>{{ $customer->company_name }}</td>
                            @foreach($items as $itemn)
                                @php
                                    $a = $customer->VendorAllocation->where('item_id',$itemn->id);
                                @endphp
                                <td>{{ $a->sum('allocation_qty') }}</td>
                                <td>{{ $a->sum('rental') }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @endif 
              </tbody>
            </table>
        </div>
        <div class="bottom-tables" >
            <div class="left" style="width: 39%;">
                {{-- <h3 style="text-align: center; padding: 10px 0;">Allocation Details</h3> --}}
                <table class="allocation-table" style="display: none;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Qty</th>
                            <th>Rental</th>
                            <th>Transport</th>
                            <th>Driver</th>
                            <th>Food</th>
                            <th>Accomodation</th>
                            <th>Conveyance</th>
                            <th>Security</th>
                            <th>Other</th>
                            <th>Tax</th>
                            {{-- <th>Remark</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                     @if($customers->count() > 0 )

                    @foreach($customers as $customer)
                        <tr data-vendor="{{ $customer->id }}" class="current-vendor-tr-details">
                                <td>{{ ucfirst($customer->company_name) }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('allocation_qty')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('rental')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('transport')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('driver')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('food')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('accomodation')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('conveyance')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('security')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('other')  : 0 }}</td>
                                <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('tax')  : 0 }}</td>
                             {{--    <td>{{ $customer->VendorAllocation ?  $customer->VendorAllocation->sum('tax')  : 0 }}</td> --}}
                        </tr>
                    @endforeach
                    <tr>
                       
                        <td colspan="5"></td>
                    </tr>
                @endif
                    </tbody>
                </table>
                 <div class=" show-vendor-details" id="allocation-vendor-div"> </div>
            </div>
            <div class="right" style="width: 59%; justify-content: left;"> 
                <table class="allocation-table" style="width: 320px; margin: 42px 0 0 0;">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th id="retrive_booking_id">Retrieve</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Booking Date</th>
                            <td id="retrive_booking_date">Retrieve</td>
                        </tr>
                        <tr>
                            <th>Allocation Date</th>
                            <td ><input type="date" id="datepicker"  name="booking_allocation_date"></td>
                        </tr>
                        <tr>
                            <th>Allocate In</th>
                            <td>
                                <select name="booking_allocation_in">
                                    <option value="1">No 1</option>
                                    <option value="2">No 2</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td id="retrive_client">Retrieve</td>
                        </tr>
                        <tr>
                            <th>Item</th>
                            <td id="retrive_item">Retrieve</td>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <td id="retrive_qty">Retrieve</td>
                        </tr>
                        <tr>
                            <th>Days</th>
                            <td id="retrive_day">Retrieve</td>
                        </tr>
                        <tr>
                            <th>Readyness</th>
                            <td id="retrive_readyness">Retrieve</td>
                        </tr>
                        <tr>
                            <th>Venue</th>
                            <td id="retrive_venue">Retrieve</td>
                        </tr>
                    </tbody>
                </table>
                <div id="form-inner-div" style="width: 100%;"></div>
            </div>
        </div>
       
        <script type="text/javascript">
        	let global_get_requred_qty = 0;
        	let global_get_requred_input_value = 0;
        	let global_get_total_availablity = 0;
        	let global_input_value_sum = 0
            var dynamic_td_input = 0;
        
        	$('input[name="select_booking"]').click(function(){

                    //console.log('calculation',JSON.parse(calculation));
			        var fetch_data = JSON.parse($(this).attr('data-resp'));
			        var fetch_data_row = $(this).attr('data-row');
                    var data_allocation_date = $(this).attr('data-allocationdate');
                    let grand_unallocated_booking = $(this).parents('tr').children('td.grand_unallocated_booking');
                    console.log(data_allocation_date);
			        $('tr').removeClass('tr-box-shadow');
			        $(this).parents('tr').find('input[name="booking_rainbow"]').focusout();
			        $(this).parents('tr').addClass('tr-box-shadow');
			        global_get_requred_qty = parseInt($('#'+fetch_data_row+' .required_qty').text());
			        global_get_total_availablity = parseInt($('#'+fetch_data_row+' .total_availablity').text());
			        
                    $('#'+fetch_data_row+' .background-dynamic-td' ).each(function(index, el) {
                        dynamic_td_input += parseInt($(this).text());
                    });
                    var show_status = false;
                    var calculation = JSON.parse($('.calculation').attr('data-calculation'));
                    console.log(calculation);
                    $.each(calculation,function(index,val){
                        if(val.booking_id==fetch_data.booking_id){
                            //console.log(fetch_data.booking_id);
                            if(val.allocated == 0 ){
                                show_status = true;    
                            } 
                        }
                    });

                    console.log(show_status);
                   // return;
                   //debugger;
                   let inserInTD = global_get_requred_qty-dynamic_td_input;
                    $(grand_unallocated_booking).text( isNaN(inserInTD) ? 0 : inserInTD );


                    //console.log('dynamic_td_input',dynamic_td_input);
			        if(fetch_data){
			        	$("#retrive_booking_id").text(fetch_data.booking_id);
			        	$("#retrive_booking_date").text(fetch_data.booking_date);
			        	$("#retrive_client").text(fetch_data.client_name);
			        	$("#retrive_item").text(fetch_data.item);
			        	$("#retrive_qty").text(fetch_data.qty);
			        	$("#retrive_day").text(fetch_data.days);
			        	$("#retrive_readyness").text(fetch_data.readyness);
			        	$("#retrive_venue").text(fetch_data.venue);
                        //debugger;
                        let date = new Date(data_allocation_date).toLocaleDateString('en-CA');
                        // console.log(date);
                        $("#datepicker" ).val(date);
                        //$("#datepicker" ).data("date", new Date(data_allocation_date) );
                        //$( "#datepicker" ).datepicker();
                        //$("input[name='booking_allocation_date']").val(data_allocation_date);
			        }
			        //debugger;
                    allocation_table_fetch(fetch_data_row,show_status);
                    $('#btn-allocation').attr('dynamic_row',fetch_data_row);
                    
			        //$('table.allocation-table input').val(0);
                    dynamic_td_input = 0;
                    
			});


			$("body").on('click','#btn-allocation',function(event){
                    event.preventDefault();

					let get_class= $(this).attr('dynamic_row');
                    
                    // console.log(current_td_class);
                    // return false;
                    let leadstatus_btn_allocation  =  $('#leadstatus').val();
                    // console.log('alloce',leadstatus_btn_allocation);
                    // return; 
					let get_allocation_entries = new Array();
					let unallocated_booking_rainbow = parseInt($('#'+get_class+' .unallocated_booking_rainbow').text());
					let input_rainbow_booking_value = parseInt($('#'+get_class).find('input.booking_input').val());
					let required_qty = parseInt($('#'+get_class).find('td.required_qty').text());

					//let input_rainbow_booking = .val();

					var booking_allocation_date = $('input[name="booking_allocation_date"]').val();
                    var booking_allocation_in = $('select[name="booking_allocation_in"]').val();

					if(booking_allocation_date ==''){
						swal("Allocation Date  !", "Allocation date is Required!", "error");
						return false;
					}
                    if(booking_allocation_in ==''){
                        swal("Allocation In  !", "Allocation In is Required!", "error");
                        return false;
                    }
					$.each($('.td-allocation-input'), function(index, val) {
						var input_value = parseInt($(this).val());
						global_get_requred_input_value += input_value;
					});
					$.each($('.td-allocation-input'), function(index, val) {
						var input_value = parseInt($(this).val());
                        var current_td_class=$(this).attr('data-td');
						if(input_value > 0 ){
							
                            if(global_get_requred_input_value > unallocated_booking_rainbow){
								swal("Quantity !", "Qty is not Greater then Unallocated Qty!", "error");
								return false;
							}

							global_get_requred_qty = global_get_requred_qty-global_get_requred_input_value;
							$('#'+get_class+' .'+current_td_class).text(input_value);
							$('#'+get_class+' .allocation_date').text(booking_allocation_date);
							$('#'+get_class+' .total_dealer_booked').text(global_get_requred_input_value);
						}
                        
					
						get_allocation_entries[index] = {
							'vendor_id':$(this).attr('data-vendorId'),
							'allocation_qty':input_value,
							'rental':$(this).parents('tr').find('input[name="rental"]').val(),
							// 'transport':$(this).parents('tr').find('input[name="transport"]').val(),
							// 'driver':$(this).parents('tr').find('input[name="driver"]').val(),
							// 'food':$(this).parents('tr').find('input[name="food"]').val(),
							// 'accomodation':$(this).parents('tr').find('input[name="accomodation"]').val(),
							// 'conveyance':$(this).parents('tr').find('input[name="conveyance"]').val(),
							// 'security':$(this).parents('tr').find('input[name="security"]').val(),
							// 'other':$(this).parents('tr').find('input[name="other"]').val(),
							// 'tax':$(this).parents('tr').find('input[name="tax"]').val(),	
							'remark':$(this).parents('tr').find('input[name="remark"]').val(),	
						}
                            let dynamictd_class = $(this).attr('data-td');
                            let dynamictd_vendorid = $(this).attr('data-vendorid');
                            let td_sum = 0;
                            $.each($('.'+dynamictd_class),function(index,val){
                                td_sum += parseInt($(this).text());
                            });
                            $('.grandsome'+dynamictd_vendorid).text(td_sum);
                            // console.log('claschek',dynamictd_class);
                            // console.log(td_sum);

					});
					let total_grand_booking = input_rainbow_booking_value+global_get_requred_input_value;
					$('#'+get_class).find('td.grand_total_booked').text(total_grand_booking);
					$('#'+get_class).find('td.grand_unallocated_booking').text(required_qty-total_grand_booking);
					global_get_requred_input_value = 0;

					// Fetch Value;
					let allocation_store_obj = {
									'unique_tr_id':get_class,
									'booking_id':$('#'+get_class).find('td.booking_id').text(),
                                    'allocation_in':booking_allocation_in,
									'item':$('#'+get_class).find('td.item_id').text(),
									'item_id':$('#'+get_class).find('td.item_id').attr('data-item'),
                                    'bookings_table_id':$('#'+get_class).find('td.item_id').attr('data-bookings_table_id'),
									'allocation_date':$('#'+get_class).find('td.allocation_date').text(),
									'rainbow_booking':input_rainbow_booking_value,
									'readyness':$('#'+get_class).find('td.readyness').text(),
									'day':$('#'+get_class).find('td.day').text(),
									'venue_name':$('#'+get_class).find('td.venue_name').text(),
									'rainobw_unallocated':$('#'+get_class).find('td.unallocated_booking_rainbow').text(),
									'total_dealer_booked':$('#'+get_class).find('td.total_dealer_booked').text(),
									'grand_total_booked':$('#'+get_class).find('td.grand_total_booked').text(),
									'billing_date':$('#'+get_class).find('td.billing_date').text(),
									'grand_unallocated_booking':$('#'+get_class).find('td.grand_unallocated_booking').text(),
									'required_qty':required_qty,
                                    'leadstatus_btn_allocation':leadstatus_btn_allocation,
					}
                     // console.log(allocation_store_obj);
                     // return false;

					store_allocation(allocation_store_obj,get_allocation_entries)
					
			});	

			$('input[name="booking_rainbow"]').focusout(function(){
				global_get_total_availablity = parseInt($(this).parents('tr').children('td.total_availablity').text());
				global_get_requred_qty = parseInt($(this).parents('tr').children('td.required_qty').text());
				total_dealer_booked = parseInt($(this).parents('tr').children('td.total_dealer_booked').text());
				let div_total_grand_booking = $(this).parents('tr').children('td.grand_total_booked');
				let unallocated_booking_rainbow = $(this).parents('tr').children('td.unallocated_booking_rainbow');
				let bal_avaliblity = $(this).parents('tr').children('td.bal_avaliblity');
				let input_booking_value =  parseInt($(this).val());
				if(input_booking_value > global_get_requred_qty){
				 	swal("Quantity !", "Qty is not Greater then Required Qty!", "error");
					return false;
				}
				if(input_booking_value > global_get_total_availablity){
				 	swal("Availability !", "No Availability!", "error");
					return false;
				}
				$(this).parents('tr').children('td.grand_unallocated_booking').text(global_get_requred_qty-input_booking_value);
				$(div_total_grand_booking).text(total_dealer_booked+input_booking_value);
				$(unallocated_booking_rainbow).text(global_get_requred_qty-input_booking_value);
				$(bal_avaliblity).text(global_get_total_availablity-input_booking_value);

			});
            $('.current-vendor-tr-details').click(function(){
                vendorid  = $(this).attr('data-vendor');
                // alert(vendorid);
                vendor_table_fetch(vendorid);
            });
            $(function(){
                vendorid =  $(this).attr('data-vendor');
                vendor_table_fetch(vendorid);
            });
			function store_allocation(allocation_store_obj,get_allocation_entries){
				//console.log(allocation_store_obj);
				let base_url_new = $('meta[name="base_url"]').attr('content');
				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});
				$.ajax({
					url: '{{ route('allocation.store') }}',
					type: 'POST',
					dataType: 'json',
					data: {allocation_store_obj,get_allocation_entries},
				})
				.done(function(response) {
					console.log("success",response);
                    location.reload();
				})
				.fail(function(errors) {
					console.log("error",errors);
				})
				.always(function() {
					console.log("complete");
				});
			}
            function allocation_table_fetch(unique_tr,show_status){
                //console.log('sssabcd',show_status);
                let base_url_new = $('meta[name="base_url"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('allocation.table.fetch') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {unique_tr},
                })
                .done(function(response) {
                    if(response.success){
                       console.log(response.html)
                        $('#form-inner-div').html(response.html);
                        if(show_status){
                            $("#leadstatus").show();    
                        }

                    }
                    //console.log("success",response.success);
                })
                .fail(function(errors) {
                    console.log("error",errors);
                })
                .always(function() {
                    console.log("complete");
                });
            }

            function vendor_table_fetch(){
                console.log('sssabcd','dd');
                let base_url_new = $('meta[name="base_url"]').attr('content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('allocation.vendor.table.fetch') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {vendorid},
                })
                .done(function(response) {
                    if(response.success){
                      //  console.log(response.html)
                        $('#allocation-vendor-div').html(response.html);

                    }
                    //console.log("success",response.success);
                })
                .fail(function(errors) {
                    console.log("error",errors);
                })
                .always(function() {
                    console.log("complete");
                });
            }
        </script>
        
    </body>
</html>


