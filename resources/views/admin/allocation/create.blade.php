<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="{{ asset('resources/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('resources/css/main.css') }}">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
           <style>
             * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: sans-serif;
            }
            body{
                background: #fff!important;
            }
            .custom-navbar ul.navbar-nav li.nav-item:hover, .custom-navbar ul.navbar-nav li.nav-item.show{
                z-index: 9999999;
            }
            th{
                text-align: center!important;
            }
            .dropdown-menu{
                z-index: 999999;
            }
            img.main-logo{
                width: 27%;
            }
            .light{
                background-color:  #e2efd9!important;
            }
            .dark{
                background-color:  #d8d8d8!important;
            }
            .yellow{
                background-color:  #ffd965!important;
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
                table-layout: fixed;
                width: max-content;
                margin: 1px;
            }
            table.allocation-table td,
            table.allocation-table th {
                padding: 5px 5px;
                border: unset;
                outline: 1px solid;
            }
            table.allocation-table td:first-child {
                border: unset;
                text-align: right;
                width: 120px;
                outline: unset;
            }
            table.allocation-table th:first-child {
                border: unset;
                text-align: right;
                width: 90px;
                outline: unset;
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
                padding: 3px 2px;
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
                padding: 1px 0px;
            }
            th {
                font-size: 10px;
                padding: 0;
            }
            /*table tbody tr td:nth-child(18) {
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
            }*/
            /*table tbody tr td:nth-child(21) {
                background: #e2efda;
            }*/
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
           
          /*  table tbody tr td:nth-child(16) {
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
            }*/
            
            /*  table tbody tr td:nth-child(6) {
            }

            table tbody tr td:nth-child(5) {
            }*/

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
               /* width: 49%;*/
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
                border-top: 2px solid red!important;
                border-bottom: 2px solid red!important;
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
                align-items:
                unset;
                justify-content: left;
                width: 100%;
            }
            .bottom-tables .right {
                display: flex;
                align-items: baseline;
               
            }
            .bottom-tables .left,
            .bottom-tables .right {
               /* width: 49%;*/
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
            width: 25px;
            left: 1px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
            .fix2{
            position: sticky;
            left: 26px;
            overflow: hidden;
            width: 30px;
            width: 25px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
            .fix3{
                position: sticky;
                left: 50px;
                z-index: 2;
                width: 110px;
                background-color: white;
                outline: 1px solid #000;
            }
            .fix4{
            position: sticky;
            left: 160px;
            width: 57px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix5{
            position: sticky;
            white-space: nowrap;
            left: 218px;
            width: 55px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix6{
            position: sticky;
            white-space: nowrap;
            left: 319px;
            width: 48px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix7{
            position: sticky;
            left: 553px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix8{
            position: sticky;
            white-space: nowrap;
            left: 506px;
            width: 30px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix9{
            position: sticky;
            white-space: nowrap;
            left: 537px;
            width: 60px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix10{
            position: sticky;
            left: 597px;
            width: 120px;
            z-index: 2;
            background-color: white;
            outline: 1px solid #000;
            }
             .fix11{
            position: sticky;
            left: 714px;
            width: 56px;
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
            .change-status{
                text-decoration: none;
                background: green;
                color: white;
                padding: 1px;
            }
            .fix7{
                position: sticky;
                left: 455px;
                width: 50px;
                z-index: 2;
                background-color: white;
                outline: 1px solid #000;
            }
            .allocation-table2{
                table-layout: fixed;
                width: max-content!important;
                margin: auto;
            }
            .bggray{
                background: #ddd4d4;
            }
            #lead_status{
               width: 50%;
            }
            .allocation-table2 thead{}
            .allocation-table2 thead td{}
            .allocation-table2 thead th{    padding: 5px 5px;}
            .allocation-table2 tbody td{    padding: 5px 5px;}
        </style>
    </head>

    <body>
    @include('admin.app.inner')
        <div class="main-table">
            <table style="table-layout: fixed; margin: auto; width: max-content; overflow: auto;">
                <thead>
                    <tr>
                        <th rowspan="4" class="fixbg fix"></th>
                        <th rowspan="4" class="fixbg fix2">S. No.</th>
                        <th rowspan="4" width="100px" class="fixbg fix3">Booking ID</th>
                        <th rowspan="4" width="100px" class="fixbg fix4">Booking Date</th>
                        <th rowspan="4" class="fixbg fix5">Client</th>
                        <th rowspan="4" class="fixbg fix6">Item</th>
                        <th rowspan="3" class="fixbg fix7 totalgranHeadbooking">0</th>
                        <th rowspan="4" class="fixbg fix8">Days</th>
                        <th rowspan="4" class="fixbg fix9">Readyness</th>
                        <th rowspan="4" class="fixbg fix10">Venue</th>
                        <th rowspan="4" class="fixbg fix11">Allocation Date</th>
                        <th colspan="{{ 3+$customers->count() }}">Inventory</th>
                        <th colspan="3">Booking Statistics</th>
                    </tr>
                    <tr>
                        <th colspan="3" rowspan="2">Rainbow</th>
                        <th rowspan="2" colspan="{{ $customers->count() }}">Dealer's Inventory</th>
                        <th rowspan="2" class="th-total-dealer-booked">0 - </th>
                        <th rowspan="2" class="th-total-booked">0 - </th>
                        <th rowspan="2" class="th-unallocated-booked">0 -</th>
                    </tr>
                    <tr>
                        {{-- <th colspan="8">X</th> --}}
                    	{{-- @if($customers->count() > 0 )
	                        @foreach($customers as $customer)
	                        	<th  class="grandsome{{ $customer->id }}">X</th>
	                        @endforeach
	                    @endif --}}
                    </tr>
                    <tr>
                        <th class="fix7">Booking Qty</th>
                        <th>TT Count</th>
                        <th>Damaged</th>
                        <th>Available</th>
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
                        <th colspan="3"></th>
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
                        
                        @if($booking->leadstatus->status == 'Proceed for Allocation')  	
                            @php
                          		$customer_details =  json_decode($booking->customer_details,true);
                          		$delivery_details =  json_decode($booking->delivery_details,true);
                                $unique_color  =  (($key % 2)==0) ?  "#99ff66" : '#00ffff';
                                $total_tr_unlocated_sum = 0;

                          	@endphp

                      		@foreach($booking->bookingItem as $item)
                                <?php 
                                    $booking_original_date = $booking->billing_date; 
                                    $no_of_days = ($item->item_id == 41 ) ? 2 : $item->days; // transport condition
                                    $rainbow_booking = 0;
                                    $tran_form  = ['Going','Return'];
                                ?>
                      			@for($ia =0; $ia < $no_of_days; $ia++)
                      				@php
                                        $uniq_tr = 'tr_'.md5($booking->invoice_no.'_day'.$ia.'_item'.$item->id);
                                        $temp_day  = ($ia==0) ? 0 : 1;
                                        $temp_day_old_db  = ($ia==0) ? 1 : 1;
                                        $booking_original_date =  date('Y-m-d', strtotime("+$temp_day day", strtotime($booking_original_date)));
                                        $booking_original_date_for_db =  date('Y-m-d', strtotime("+$temp_day_old_db day", strtotime($booking_original_date)));
                                        // echo $booking_original_date_for_db;
                                        // echo 'TESTING--';
                                        // echo '<br/>';
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
                                        // var_dump($delivery_details);
                      					$allocation         = App\Models\Allocation::with('allocationVendor')->where('unique_tr_id',$uniq_tr)->first();
                                        
                                        $rainbow_allocation = App\Models\VendorAllocation::whereDate('booking_date',$booking_original_date)->where('vendor_id', Config::get('app.rainbow_id'))->sum('allocation_qty');
                                        //var_dump($booking_original_date);
                                        //if($rainbow_allocation):

                                            //$rainbow_booking = $rainbow_allocation->allocationVendor->sum('allocation_qty');
                                             //var_dump($rainbow_booking);
                                             // echo '<---------';
                                              // echo $rainbow_allocation;
                                              // echo '---------';
                                              // echo $booking_original_date;
                                              // echo '<br/>';
                                             
                                        //endif;
                                        //die();
                                        //dd($allocation->toArray());
                      					$allocation_array = $allocation ? $allocation->toArray() : [];
                                        $allocation_db_value =  0;
                                        if($allocation):
                                              $allocation_db_value =  $allocation->grand_unallocated_booking;
                                            else:
                                              $allocation_db_value =  $item->quantity;
                                        endif;
                                              $total_tr_unlocated_sum +=$allocation_db_value; 
                      			   @endphp

    			                       <tr data-unlocated="{{ $total_tr_unlocated_sum }}"   id="tr_<?= md5($booking->invoice_no.'_day'.$ia.'_item'.$item->id) ?>" class="{{ ($allocation_db_value > 0 ) ? 'color-red' : 'allocated'   }}">

                                        <td class="fixbg fix "><input type="radio" name="select_booking" data-amount="{{ $item->rate }}" data-allocationdate="{{ $allocation ? $allocation->allocation_date : ''   }}" data-row="tr_<?= md5($booking->invoice_no.'_day'.$ia.'_item'.$item->id) ?>" data-resp="{{ json_encode($retrive) }}" class="select_booking"></td>
                                        <td class="fixbg fix2 {{ ($allocation_db_value > 0 ) ? 'color-red' : 'allocated'   }}">{{ ++$count }}</td>
                                        <td class="booking_id fix3" style="background:{{ $unique_color }}">No {{ $booking->booking_type }} {{ $booking->invoice_no ?? 'Somthing wrong' }} </td>
                                        <td class="billing_date fix4">{{ $booking_original_date }} </td>
                                        <td class="company_name fix5">{{ $customer_details['company_name'] ?? 'Somthing Wrong' }}</td>
                                        <td class="item_id fix6" data-bookings_table_id="{{ $booking->id }}" data-item="{{ $item->item_id }}"> {{ ($item->item_id == Config::get('app.transport_config_id') ) ? $tran_form[$ia] : '' }}  {{ $item->item }} 
                                        </td>
                                        <td class="required_qty fix7" > {{ $item->quantity }}</td>
                                        <td class="day fix8" >1</td>
                                        <td class="readyness fix9">{{ $booking->readyness ?? '' }}</td>
                                        <td class="venue_name fix10">{{ $delivery_details['dvenue_name'] ?? 'Something wrong' }}</td>
                                        <td class="allocation_date fix11 light">{{ $allocation ? $allocation->allocation_date : 0 }}</td>
                                        <td class="dark">{{ ($item->vechicle_genration_count) ?? 'Wrong' }}</td>
                                        <td class="yellow">0</td>
                                        @php
                                            $final_rainbow_booking = $item->vechicle_genration_count-$rainbow_allocation;
                                        @endphp
                                        <td class="total_availablity  dark" data-finalrainbowbooking="{{$final_rainbow_booking}}">{{ ($final_rainbow_booking > 0) ? $final_rainbow_booking : 0  ?? 0 }}</td>
                                        {{-- <td><input type="number" name="booking_rainbow" class="booking_input" value="0" style="width: 50px;"></td> --}}
                                        {{-- <td class="bal_avaliblity">0</td> --}}
                                        {{-- <td class="unallocated_booking_rainbow">{{ $allocation ? $allocation->rainobw_unallocated : 0 }}</td> --}}
                                        @php
                                            $sum = 0;
                                            $rainbow_booking = 0;
                                        @endphp
                                        @foreach($customers as $customer)
                                            <td class='background-dynamic-td  td_{{$customer->id}} light'>
                                                @php
                                                    if(isset($allocation)):
                                                        foreach($allocation->allocationVendor as $all_val):
                                                            if($all_val->vendor_id == $customer->id):
                                                                echo ($all_val->allocation_qty > 0) ? $all_val->allocation_qty : '' ;
                                                                $sum += $all_val->allocation_qty;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                @endphp
                                            </td>
                                        @endforeach
                                        <td class="td-background-gray total_dealer_booked dark">{{ $allocation ? $allocation->total_dealer_booked : 0 }}</td>
                                        <td class="td-background-gray grand_total_booked dark">{{ $allocation ? $allocation->grand_total_booked : 0 }}</td>
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
                        @endif
                    @endforeach
                    <span class="calculation" data-calculation="{{json_encode($booking_allocation_total)}}"></span>
                 
            </table>
        </div>
        {{-- <div class="middle-table"></div> --}}
        <div class="bottom-tables" >
            <div class="left" style="
    display: flex;
    align-items: baseline;"> 
                <table class="allocation-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th class="bggray" id="retrive_booking_id"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Booking Date</th>
                            <td class="bggray" id="retrive_booking_date"></td>
                        </tr>
                        <tr>
                            <th>Allocation Date</th>
                            <td ><input type="date" id="datepicker" value="<?= date("Y-m-d"); ?>"  name="booking_allocation_date"></td>
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
                            <td class="bggray" id="retrive_client"></td>
                        </tr>
                        <tr>
                            <th>Item</th>
                            <td class="bggray" id="retrive_item"></td>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <td class="bggray" id="retrive_qty"></td>
                        </tr>
                        <tr>
                            <th>Days</th>
                            <td class="bggray" id="retrive_day"></td>
                        </tr>
                        <tr>
                            <th>Readyness</th>
                            <td class="bggray" id="retrive_readyness"></td>
                        </tr>
                        <tr>
                            <th>Venue</th>
                            <td class="bggray" id="retrive_venue"></td>
                        </tr>
                    </tbody>
                </table>
                <div id="form-inner-div" style="width: 100%;"></div>
            </div>
            <div class="right" style="display: inline-block; width: auto; overflow: auto;">
                 <h3 style="text-align: center; padding:0 0 10px 0;">Allocation Details</h3>
            @php
                $items = App\Models\Item::get();
                $count_th = 0;
            @endphp
            <table class="allocation-table">
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
                                    $rate_sum = 0;
                                    foreach($a as $sum){
                                        $rate_sum += ($sum->rental*$sum->allocation_qty);
                                    }
                                @endphp
                                <td class="innertd-item" data-itemid="{{ $itemn->id }}" data-vendorid="{{ $customer->id }}" >{{ ($a->sum('allocation_qty') > 0 )  ? $a->sum('allocation_qty') : '' }}</td>
                                <td class="innertd-item" data-itemid="{{ $itemn->id }}" data-vendorid="{{ $customer->id }}">{{ ($a->sum('rental') > 0 ) ? $rate_sum : '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @endif 
              </tbody>
            </table>
            </div>
           
        </div>
        <div id="allocation-vendor-div"></div>
        <script type="text/javascript">
        	let global_get_requred_qty = 0;
            let global_get_requred_qty_new = 0;
        	let global_get_requred_input_value = 0;
        	let global_get_total_availablity = 0;
        	let global_input_value_sum = 0
            var dynamic_td_input = 0;
            var qty = 0;
            var th_total_dealer_booked_qty = 0;
            var th_total_booked = 0;
            var th_unallocated_booked = 0;
            var global_list_item_name = "";
            var global_grand_unallocated_booking = 0;
            var global_item_name = "";
            

            $('.required_qty').each(function(index,val){
                let num = parseInt($(this).text());
                qty += num;
            });

            $('.total_dealer_booked').each(function(index,val){
                let num = parseInt($(this).text());
                th_total_dealer_booked_qty += num;
            });

            $('.grand_total_booked').each(function(index,val){
                let num = parseInt($(this).text());
                th_total_booked += num;
            });

            $('.grand_unallocated_booking').each(function(index,val){
                let num = parseInt($(this).text());
                th_unallocated_booked += num;
            });

            $('.th-total-dealer-booked').text(th_total_dealer_booked_qty);
            $('.th-total-booked').text(th_total_booked);
            $('.th-unallocated-booked').text(th_unallocated_booked);
            $('.totalgranHeadbooking').text(qty);

        
        	$('input[name="select_booking"]').click(function(){

                    //console.log('calculation',JSON.parse(calculation));
			        var fetch_data = JSON.parse($(this).attr('data-resp'));
			        var fetch_data_row = $(this).attr('data-row');
                    var data_allocation_date = $(this).attr('data-allocationdate');
                    var data_amount = $(this).attr('data-amount');
                    let grand_unallocated_booking = $(this).parents('tr').children('td.grand_unallocated_booking');
                    global_grand_unallocated_booking = parseInt($(this).parents('tr').children('td.grand_unallocated_booking').text());
                    console.log(data_allocation_date);
			        $('tr').removeClass('tr-box-shadow');
			        $(this).parents('tr').find('input[name="booking_rainbow"]').focusout();
			        $(this).parents('tr').addClass('tr-box-shadow');
			         //debugger;
                    global_get_requred_qty = parseInt($('#'+fetch_data_row+' .required_qty').text());
                    global_get_requred_qty_new = parseInt($('#'+fetch_data_row+' .required_qty').text());

			        global_get_total_availablity = parseInt($('#'+fetch_data_row+' .total_availablity').text());
                    data_finalrainbowbooking = parseInt($('#'+fetch_data_row+' .total_availablity').attr('data-finalrainbowbooking'));
                    //debugger;
                    //alert();
                    $('#'+fetch_data_row+' .background-dynamic-td' ).each(function(index, el) {
                        //console.log('sdfs',$(this).text().trim());
                        dynamic_td_input += parseInt( ($(this).text().trim() == "") ? 0 : $(this).text() );
                    });

                    var show_status = false;
                    var calculation = JSON.parse($('.calculation').attr('data-calculation'));
                    console.log(calculation);
                    $.each(calculation,function(index,val){
                        if(val.booking_id==fetch_data.booking_id){
                            if(val.allocated == 0 ){
                                //alert('Ready to Logistic');
                                show_status = true;    
                            } 
                        }
                    });
                    //console.log(show_status);
                    //debugger;
                    let inserInTD = global_get_requred_qty - parseInt(isNaN(dynamic_td_input) ? 0 : dynamic_td_input);
                    $(grand_unallocated_booking).text( isNaN(inserInTD) ? 0 : inserInTD );

			        if(fetch_data){
			        	$("#retrive_booking_id").text(fetch_data.booking_id);
			        	$("#retrive_booking_date").text(fetch_data.booking_date);
			        	$("#retrive_client").text(fetch_data.client_name);
			        	$("#retrive_item").text(fetch_data.item);
			        	$("#retrive_qty").text(fetch_data.qty);
			        	$("#retrive_day").text(fetch_data.days);
			        	$("#retrive_readyness").text(fetch_data.readyness);
			        	$("#retrive_venue").text(fetch_data.venue);
                        // let date = new Date(data_allocation_date).toLocaleDateString('en-CA');
                        // $("#datepicker" ).val(date);
			        }


                    global_item_name =  fetch_data.item.toLowerCase().trim();
                    allocation_table_fetch(fetch_data_row,show_status,data_amount,data_finalrainbowbooking,global_item_name);
                    $('#btn-allocation').attr('dynamic_row',fetch_data_row);
                    dynamic_td_input = 0;  
                    //console.log(fetch_data.item.toLowerCase());
                    

			});

            $('body').on('focusin','input',function(){
                this.select();
            });

            $('body').on('focusout','input',function(){
                if($(this).val() ==''){
                    $(this).val(0);
                }
            });
            
            // $('body').on('focusout','.td-allocation-input',function(){
            //     let current_input = $(this).val();
            //     if(current_input > 0 ){
            //         let current_tr_rate = parseInt($(this).parents('tr').find('input[name="rental"]').val());
            //         if(current_tr_rate == 0 ){
            //             swal("Rate  !", "Rate is Required !", "error");
            //             return false;
            //         }
            //     }
            // });

			$("body").on('click','.innertd-item',function(event){
                let num =  $(this).attr('data-itemid');
                let vendorid =  $(this).attr('data-vendorid');
                vendor_item_table_fetch(vendorid,num);
                //alert(num);
            });

            $('body').on('click','.change-status',function(){
                $("#btn-allocation").click();
            })

            $("body").on('click','#btn-allocation',function(event){
                    event.preventDefault();
                    var error_in_allocation = 0;
                    var error_in_rate = 0;
                    //global_grand_unallocated_booking = 0;
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
                        var rainbow = $(this).attr('max');
                        var mode = $(this).attr('mode');
                        
                        if(mode != 'edit'){
                            if(rainbow != 'no'){
                                if( $('#'+get_class).find('td.item_id').attr('data-item') == 39 ){
                                    if(input_value > parseInt(rainbow) ){
                                        error_in_allocation = 1;
                                        // debugger;
                                        swal("Quantity  !", "Allocation Quantity is less then or equal to Availability!", "error");
                                        return false;
                                    }
                                }
                            }
                        }

                        // console.log('MYBCD', parseInt($(this).parents('tr').find('input[name="rental"]').val() ) );
                        // console.log('td-allocation-input', parseInt($(this).parents('tr').find('.td-allocation-input').val()) );
                        // alert();
                        // debugger;
                        if( parseInt($(this).parents('tr').find('.td-allocation-input').val()) > 0 ){
                            if(parseInt($(this).parents('tr').find('input[name="rental"]').val()) == 0){
                                error_in_rate = 1;    
                            }  
                        }
                        // if(rainbow != undefined){
                        //     console.log('rainbowx',rainbow);
                        // }

                      // debugger;
						if(input_value > 0 ){
                            if(mode != 'edit')
                            {                               
                                if(global_get_requred_input_value > global_grand_unallocated_booking){
    								swal("Quantity !", "Qty is not Greater then Unallocated Qty!", "error");
    								error_in_allocation =1; 
                                    global_get_requred_input_value = 0;
                                    return;
    							}
                                
                            }else{

                                if(global_get_requred_input_value > global_get_requred_qty_new){
                                    // debugger;
                                    swal("Quantity !", "Qty is not Greater then  Qty!", "error");
                                    error_in_allocation =1; 
                                    global_get_requred_input_value = 0;
                                    return;
                                }
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
                            //global_get_requred_input_value = 0;
					});
                    //return;
                    //console.log('item --id',$('#'+get_class).find('td.item_id').attr('data-item'));
                    
                    if(error_in_allocation == 1){
                        console.log('error');
                        global_get_requred_input_value = 0;
                        return;
                    }
                    if(error_in_rate == 1){
                        swal("Rate !", "Rate is required!", "error");
                        global_get_requred_input_value = 0;
                        console.log('error in rate');
                        return;
                    }
                    //return;
                    //console.log('xxxdd',global_grand_unallocated_booking);
                    //return;
                    //debugger;
					let total_grand_booking = parseInt( isNaN(input_rainbow_booking_value) ? 0 : input_rainbow_booking_value  ) + global_get_requred_input_value;
					$('#'+get_class).find('td.grand_total_booked').text(total_grand_booking);
                    // debugger;
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
									'rainbow_booking':0,
									'readyness':$('#'+get_class).find('td.readyness').text(),
									'day':$('#'+get_class).find('td.day').text(),
									'venue_name':$('#'+get_class).find('td.venue_name').text(),
									//'rainobw_unallocated':$('#'+get_class).find('td.unallocated_booking_rainbow').text(),
                                    'rainobw_unallocated':0,
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

                global_get_requred_qty_new = parseInt($(this).parents('tr').children('td.required_qty').text());

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
            function allocation_table_fetch(unique_tr,show_status,data_amount,data_finalrainbowbooking,global_item_name){
                console.log('data_finalrainbowbooking',data_finalrainbowbooking);
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
                    data: {unique_tr,data_amount,data_finalrainbowbooking},
                })
                .done(function(response) {
                    if(response.success){
                       //console.log(response.html)
                        $('#form-inner-div').html(response.html);
                        if(show_status){
                            $("#leadstatus").show();    
                            $(".change-status").show();    
                        }
                        if(global_item_name != 'golf cart'){
                            $('.myrainbow').val(0);
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
                       console.log(response.html)
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
            function vendor_item_table_fetch(vendorid,item_id){
                // alert(vendorid);
                // alert(item_id);
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
                    data: {vendorid,item_id},
                })
                .done(function(response) {
                    if(response.success){
                       console.log(response.html)
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


