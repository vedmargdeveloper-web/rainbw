@extends(_app())

@section('title', $title ?? '')

@section('content')

    <div class="main-container">

        <div class="content-wrapper">

            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">
            <style type="text/css">
                  .billing-info tr td>div.field-group {
        width: unset !important;
        /*width: 53% !important;
        text-align: center !important;
        background: #e2efda;*/
    }

    *{
        margin: 0px; !important;
        padding: unset; !important;

    }
    input{
        border-bottom: unset;
    }
    .invoice-box-{
          margin: 10px 10px;
    }
    .green{
        background: unset;
    }
    .margin-top-tr-info{
        top: -10px; position: relative;
    }
    .billing-information{
        /*border-left: 2px solid black;
        border-top: 2px solid black;
        border-right: 2px solid black;*/
    }
    table.invoice-header {
    /* border-top: 2px solid #333; */
    /* border-left: 2px solid #333; */
    /* border-right: 2px solid #333; */
    border: unset;
}
.invoce-table-bord{
border: 2px solid #333;
}
.billing-info{
  border: unset;
}
    #main-table thead tr td:nth-child(1){
      border-left: 0!important;
    }
    #main-table tr td:last-child{
      border-right: 0;
    }
    #main-table tr td:nth-child(1){
      border-left: 0;
    }
    #main-table thead tr td:last-child{
      border-right: 0!important;
    }
    
    .billing-information tr td:nth-child(1){
      font-weight: 600;
        text-align: right;
        width: 13%;
           
    }
    .billing-information tr td:nth-child(3){
         font-weight: 600;
        text-align: right;
       
    }
    .billing-information tr td:nth-child(2){
        background-color: unset;
   
        border-bottom: 1px solid #000;
        width: unset;
          
    }
     .billing-information tr td:nth-child(4){
        background-color: unset;
       border-bottom: 1px solid #000;
      
    }
    .billing-information tr td:nth-child(6){
        background-color: unset;
   
        border-bottom: 1px solid #000;

    }
     .billing-information tr td:nth-child(5){
        text-align: right;
         font-weight: 600;
     }
     .billing-information tr td:nth-child(7){
        text-align: right;
         font-weight: 600;
     }
     .billing-information tr td:nth-child(8){
        background-color: unset;
       border-bottom: 1px solid #000;
    }
    .billing-information tr td{
        padding: 2px 5px;
    }
    .billing-information td{
        height: 10px;
    }
    #main-table tr td {
    padding: 2px 4px;
    text-align: center;
    border-bottom: unset;
    font-size: 12px;
}
.td-item-table tbody.main-td tr td {
    border-bottom: : 0px;
    border-top: 0px;
}
.border-right {
    border-right: 2px solid #000;
}
thead tr td{
  border: 1px solid!important;
}
.bank-detail{}
.bank-detail tr{}
.bank-detail tr td.border{
  border-bottom: 2px solid #000;
}
.bank-detail tr td{
      padding: 3px 5px;
      
}
            </style>

            <?php
        	       $customer_type =  App\Models\CustomerTypeMaster::all();
                   $delivery_address =  App\Models\Address::where('type','delivery')->get();
                   $supply_address =  App\Models\Address::where('type','supply')->get();
                 //  $booking->bookingItem =  App\Models\QuotationsItem::where('invoice_id',$invoice->id)->get();
                   
                   $customers =  App\Models\Customer::where('customer_type',$invoice->customer_type)->get();
                   $edit_customer_type =  $customer_type->where('id',$invoice->customer_type)->first()  ;
                  // dd($supply_address);
                   $meta =  App\Models\Meta::all();
                   $gstMaster =  App\Models\GstMaster::all();
                   
                   $term_and_conditions = $meta->where('meta_name', 'term')->first();

                   $gst  = $meta->where('meta_name','gst')->first()->meta_value;
                   $udyam_reg  = $meta->where('meta_name','udyam_reg')->first()->meta_value;
                   $head_office  = $meta->where('meta_name','head_office')->first()->meta_value;
                   $branch_office  = $meta->where('meta_name','branch_office')->first()->meta_value;
                   $email  = $meta->where('meta_name','email')->first()->meta_value;
                   $phone  = $meta->where('meta_name','mobile')->first()->meta_value;
                   // dd();
                   //dd($delivery_address);
                   $customers_details = json_decode($invoice->customer_details,true);
                   
                   $delivery_details = json_decode($invoice->delivery_details,true);
                   //dd($delivery_details);
                   $state = App\Models\State::get();
                   $city = App\Models\City::get();
                   $leads =  App\Models\Lead::get();
                   $inquiry =  App\Models\Inquiry::get(['unique_id','id']);
            ?>
        
             <span id="get_pre_city" style="display: none;">
                @foreach($city as $st)
                    <option value="{{ $st->city }}">{{ $st->city }} </option>
                @endforeach
             </span>
             <span id="get_pre_state" style="display: none;">
                @foreach($state as $st)
                    <option value="{{ $st->state }}">{{ $st->state }} </option>
                @endforeach
             </span>

            <form action="{{ route('booking.update',['booking'=>$invoice->id]) }}" method="post" id="invoice-submit">
                
                @csrf
                {{ method_field('PATCH') }}

                <div class="invoice-box">
                    <table >
                        <tr>
                            <td class="left-grid text-center" style="width: 40%; border-right: unset;" colspan="2">
                                <b>Lead Status</b>
                                <select name="lead_status">
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" {{ ($invoice->lead_status == $lead->id) ? 'selected' : '' }}>  {{ $lead->lead }}</option>
                                    @endforeach
                                </select> 
                            </td>
                        </tr>
                    </table>
                    <div class="invoce-table-bord">
                    
                    
                    <table cellpadding="0" class="invoice-header" cellspacing="0" width="100%" style="border-bottom: 2px solid">
                       
                        <tr class="top">
                            <td class="left-grid" style="width: 40%;">
                                <table >
                                    <tr>
                                        <td style="text-align: right; padding-right: 0; ">
                                          <strong>  GSTIN : </strong>    
                                        </td>
                                        <td style="text-align: left; ">
                                            <select class="select-2 main-gst-selection" name="gst_id" >
                                                <option value="">Please Select</option>
                                                @foreach($gstMaster as $key => $gm)
                                                    <option {{ ($invoice->gst_id == $gm->id) ? 'selected' : '' }} data-state="{{ $gm->state }}"  value="{{ $gm->id }}"> {{ strtoupper($gm->gstin) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td style="text-align: right; padding-right: 0; padding-top: 0;"><strong id="temp">Udyam Reg. No. :</strong></td>
                                        <td id="udyam_no" style=" padding-top: 0;">{{ $udyam_reg }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="" style="font-size: 10px; padding-top: 12px;">
                                            <ul class="gst-head-ul">
                                               
                                            </ul>
                                        </td >
                                    </tr>

                                </table>
                            </td>

                            <td>
                                <table>
                                    <tr>
                                        <td class="center" colspan="2">
                                          {{--   <b>Invoice</b> --}}
                                            {{-- <select name="invoice_type" id="invoice_type" >
                                                <option value="invoice" {{ ($invoice->invoice_type == 'invoice') ? 'selected=""' : ''  }}  >Invoice</option>
                                                <option value="challan" {{ ($invoice->invoice_type== 'challan') ? 'selected=""' : ''  }}  >Challan</option>
                                                <option value="quotation" {{ ($invoice->invoice_type== 'quotation') ? 'selected=""' : ''  }}>Quotation</option>
                                            </select> --}}
                                            <h4>Booking</h4>
                                           <input type="hidden" name="invoice_type" value="booking">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" colspan="2">
                                            <h3 style="margin: 0;">RAINBOW</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" style="font-size: 9px;" colspan="2">
                                            Head Office: <span id="head_office">{{ $head_office }} </span> <br />
                                            Branch Office:<span id="branch_office"> {{ $branch_office }}</span> <br />
                                            <span id="temp_address"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Mobile : <span id="head_mobile">{{ $phone }}</span></b> <br />
                                        </td>
                                        <td style="text-align: right;">
                                            <b>Email: <span id="head_email">{{ $email }}</span></b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="billing-information" style="width: 100%; table-layout: fixed;">
                        <tbody>
                            <tr>
                                <td>UID:</td>
                                <td colspan="2">
                                    <div class="filed-group">
                                         <select required name="uid">
                                         <option value="">Please Select </option>
                                             @foreach($inquiry as $inq)
                                                <option value="{{ $inq->id }}"  {{ ($invoice->enquire_id == $inq->id) ? 'selected=""' : ''  }}>  {{ $inq->unique_id }}</option>
                                             @endforeach
                                        </select> 
                                     </div>
                                </td>
                                <td colspan="3"></td>
                                <td style="border-bottom: unset; text-align: right; ">Billing Date :</td>
                                <td style="background: unset; border-bottom:1px solid black ; text-align: center;"><input type="date" name="billing_date" value="<?=  $invoice->billing_date ?>"></td>
                            </tr>
                            <tr>
                                @php
                                $invoice_last_y = date('y')+1;
                                $totalInvoice =  App\Models\Invoice::count()+1;
                                
                            @endphp
                                <span style="display:none ;" id="default-invoice-no">
                                    <?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInvoice" ?>
                                </span>

                                <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/INV/$totalInvoice"; ?> 
                                <td>Serial No.: </td>
                                <td colspan="2">
                                    <div class="field-group">
                                        <input type="hidden" name="invoice_no" value="<?=  $invoice->invoice_no ?>"> 
                                        <b id="invoice_no"><?=  $invoice->invoice_no ?></b>
                                    </div>
                                </td>
                                <td colspan="3"></td>
                                <td style="border-bottom: unset; text-align: right; ">Event Date :</td>
                                <td style="background: unset; border-bottom:1px solid black ; text-align: center;"><input type="date" name="event_date" value="{{ $invoice->event_date }}"></td>
                            </tr>
                            <tr>
                                <td>Customer Type:  </td>
                                <td colspan="4" style="border-bottom: unset;">
                                    <div class="field-group">
                                        <span id="cp_type">{{ $edit_customer_type->code ?? '' }}</span>
                                        
                                    @foreach($customer_type as $ct)
                                        <input type="radio"  id="{{ $ct->code }}" name="customer_type" {{ ($invoice->customer_type ==  $ct->id) ? 'checked="checked"' : '' }} value="{{ $ct->id }}">
                                        <label for="{{ $ct->code }}">{{ $ct->type }} </label>
                                    @endforeach
                                    Booking Type
                                        <select name="booking_type" id="booking_type" >
                                            <option value="1" {{ ($invoice->booking_type == 1) ? 'selected' : '' }}>No 1</option>
                                            <option value="2" {{ ($invoice->booking_type == 2) ? 'selected' : '' }}>No 2</option>
                                        </select>
                                </div>
                                </td>

                                  <td colspan="3" style="background: unset;text-align: left;  font-weight: 600; border: 0;"> <p style="border-bottom: 1px solid; display: inline-block;">
                                    Delivery Address:
                                  </p> </td>
                            </tr>
                            <tr>
                                <td>Client Name :</td>
                                <td colspan="3">
                                    <div class="field-group">
                                                    <select class="select-2 invoice-customer-type" > 
                                                        @foreach($customers   as $customer)
                                                            <option value="{{ $customer->id }}"  {{ ($customer->id == $invoice->customer_id) ? 'selected=""' : ''  }}>{{ $customer->company_name }}</option>
                                                        @endforeach     
                                                    </select>
                                                    <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;">
                                    </div>
                                </td>
                                <td>Venue :</td>
                                <td colspan="3">
                                    <div class="field-group td-city-width">
                                        <select class="select-2 invoice-delivery-address" name="delivery_id" >
                                            <option value=""> Select Delivery Address</option>
                                                @foreach($delivery_address as $da)
                                                    <option value="{{ $da->id }}" {{  ($da->id == $invoice->delivery_id ) ? 'selected=""' : '' }} >{{ $da->venue }}</option>
                                                            @endforeach   
                                                <option value="other">Other</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Address :</td>
                                <td colspan="3">
                                    <div class="field-group">
                                        <input type="text" class="form-control- w-100" name="caddress" value="{{ $customers_details['ccaddress'] }}" >
                                    </div>
                                </td>
                                <td>Venue Name : </td>
                                 @if(isset($delivery_details['dvenue_name']))
                                <td colspan="3">
                                    <div class="field-group td-city-width">
                                        <input type="text" name="venue_name" placeholder="Venue Name" value="{{ $delivery_details['dvenue_name']  }}" class="w-100 mt-2" id="venue_name" style="{{ $delivery_details['dvenue_name'] == null  ? 'display: none' : ''}} ;">
                                    </div>
                                </td>
                                @endif
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <div class="field-group">
                                        <input type="text" class="form-control- w-100" name="caddress1" value="{{ $customers_details['ccaddress1'] ?? '' }}" >
                                    </div>
                                </td>
                                <td>Address :</td>
                                <td colspan="3">
                                    <div class="field-group">
                                            <input type="text" class="form-control- w-100" name="daddress" value="{{ $delivery_details['daddress'] }}" >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>City :</td>
                                <td>
                                    <div class="field-group ml-2">
                                        <div class="ccity-div"><input type="text" name="ccity" class="custom-pincode" value="{{ $customers_details['ccity'] }}" ></div>
                                        </div>
                                    </td>
                                    <td>State :</td>
                                    <td><div class="field-group state-select">
                                                                <div class="cstate-div" > <input type="text" name="cstate" value="{{ $customers_details['cstate'] }}" >  </div>
                                                            </div></td>
                                    <td></td>
                                    <td colspan="3">
                                    
                                    </td>
                            </tr>
                            <tr class="pincode-inner-tr">
                                <td>Pincode :</td>
                                <td><div class="field-group">
                                        <input type="text" name="cpincode" value="{{ $customers_details['cpincode'] }}" class="custom-pincode">
                                    </div>
                                </td>
                                <td>Landmark :</td>
                                <td>
                                    <div class="field-group">
                                       <input type="text" class="ml-2" name="clandmark" value="{{ $customers_details['clandmark'] ?? '' }}" class="w-100">
                                     </div>
                                </td>
                                <td>Landmark:</td>
                                <td colspan="3">
                                    <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="dlandmark" value="{{ $delivery_details['dlandmark'] }}" >
                                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Contact person :</td>
                                <td colspan="3">
                                    <div class="field-group width-full contact-person" >
                                                    <input type="text" class="w-100" name="contact_person_c" value="{{ $customers_details['contact_person_c'] }}" >

                                                </div>
                                                <input type="hidden"  name="select_two_name" id="select_two_name"> 
                                </td>
                                <td>City :</td>
                                <td>
                                    <div class="field-group">
                                        <input type="text" class="w-75" name="dcity" value="{{ $delivery_details['dcity'] }}" > 
                                    </div>
                                </td>
                                <td>State :</td>
                                <td>
                                    <div class="field-group">
                                    <input style="width: 100%;" type="text" name="dstate" value="{{ $delivery_details['dstate'] }}" > 
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Mobile :</td>
                                <td colspan="3">
                                    <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="dmobile" value="{{ $delivery_details['dmobile'] }}" >
                                                </div>
                                </td>
                                <td>Contact Person :</td>
                                <td colspan="3">
                                    <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="dperson" value="{{ $delivery_details['dperson'] }}" >
                                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td>GSTIN :</td>
                                <td colspan="3">
                                    <div class="field-group width-full">


                                                    <input type="text" class="w-100" name="cgstin" value="{{ $customers_details['cgstin'] }}" >
                                                </div>
                                </td>
                                <td >Pincode :</td>
                                <td ><div class="field-group">
                                        <input type="text" class="w-75" name="dpincode" value="{{ $delivery_details['dpincode'] }}" > 
                                    </div>
                                </td>
                                <td>Readyness :</td>
                                <td>
                                    <div class="field-group">
                                        <input style="width: 100%; margin: 0;" type="text" name="readyness" value="{{ $invoice->readyness ?? '' }}" > 
                                    </div>
                                </td>
                            </tr>
                            <tr class="td-no-padding">
                                
                                {{-- <td rowspan="" class="td-no-padding" style="display: flex;">
                                   <div class="label">UID: </div>
                                     <div class="filed-group">
                                         <select required name="uid">
                                         <option value="">Please Select </option>
                                             @foreach($inquiry as $inq)
                                                <option value="{{ $inq->id }}"  {{ ($invoice->enquire_id == $inq->id) ? 'selected=""' : ''  }}>  {{ $inq->unique_id }}</option>
                                             @endforeach
                                        </select> 
                                     </div>
                                </td>
                                <td class="text-right td-no-padding" >
                                    <div class="label"></div>
                                    <div class="field-group" style="    padding-right: 37px;">
                                        
                                        <b><span id="change_billing_type">Billing</span> Date :</b>
                                        <input type="date" name="billing_date" value="<?=  $invoice->billing_date ?>">
                                    </div>
                                </td> --}}
                            </tr>
                        </tbody>
                       


                    



                        <!-- <tr>
                            <td>Address: </td>
                            <td> </td>
                            <td>Address: </td>
                            <td><input type="text" name="daddress" value="" ></td>
                            </tr>

                        <tr>
                            <td>Pin Code:  <input type="text" name="cpincode" value="" >   City: </td>
                            <td class="ccity-div"><input type="text" name="ccity" value="" > </td>
                            
                        </tr>
                        <tr>
                            <td>State: </td>
                            <td class="cstate-div"> <input type="text" name="cstate" value="" >  </td>
                            <td><label for="cars">City:</label></td>
                            <td>   <input type="text" name="dcity" value="" >     </td>

                        </tr>
                        <tr>
                            <td>Contact Person: </td>
                            <td class="contact-person"> <input type="text" name="contact_person_c" value="" >  </td>
                            <td> Landmark: </td>
                            <td> <input type="text" name="dlandmark" value="" >  </td>
                        </tr>

                        <tr>
                            <td>Mobile: </td>
                            <td><input type="text" name="cmobile" value="" > </td>
                            <td> Contact Person </td>
                            <td> <input type="text" name="dperson" value="" >  </td>
                        </tr>

                        <tr>
                            <td>Email: </td>
                            <td> <input type="text" name="cemail" value="" > </td>
                            <td> Mobile:  </td>
                            <td> <input type="text" name="dperson" value="" >  </td>
                        </tr>

                        <tr>
                            <td>GSTIN: </td>
                            <td> <input type="text" name="cgstin" value="" > </td>
                            <td> Pin Code :  <input type="text" name="dpincode" value="" > </td>
                            <td> State : <input type="text" name="dstate" value="" > </td>
                        </tr> -->

                    </table>

                    @php $item = App\Models\Item::get(); @endphp
                    
                    <table class="td-item-table no-border-top- m-width" id="main-table"  cellspacing="0" width="100%"   style=" ">
                        <thead>
                        <br>
                            {{-- style="background: #ffa5d740;"  --}}
                            <tr class="sub-heading-item" >
                                <td rowspan="2" >S.No</td>
                                <td rowspan="2" style="width: 75px;">SAC Code</td>
                                <td rowspan="2" style="width: 75px;">HSN Code</td>
                                <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                <td rowspan="2">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> <select name="invoice_dayormonth">
                                    <option value="day"> Days</option>
                                    <option value="month">Months</option>
                                </select></td>
                                <td rowspan="2">Gross Amount</td>
                                <td rowspan="2">Discount</td>
                                <td colspan="3" style="text-align: center;">Tax Rate</td>
                                <td rowspan="2">Tax Amount</td>
                                <td rowspan="2">Total Amount</td>
                            </tr>

                            <tr class="heading">
                                <td>CGST</td>
                                <td>SGST</td>
                                <td>IGST</td>
                            </tr>

                            
                        </thead>
                             @foreach($invoice->bookingItem as $invoice_item)
                             <tbody class="main-td">
                                <tr class="center item">
                                    <td class="space"><span class="remove-btn">X</span></td>
                                    <td class="sac">{{ $invoice_item->sac_code ?? '' }}</td>
                                    <td class="hsn">{{ $invoice_item->hsn_code ?? '' }}</td>
                                    <input type="hidden" class="phsn" name="phsn[]" value="{{ $invoice_item->hsn_code ?? '' }}" />
                                    <td class="item-display">{{ $invoice_item->description ?? '' }}</td>
                                    <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $invoice_item->description ?? '' }}"   />
                                    <input type="hidden" class="pname" name="pname[]" value="{{ $invoice_item->item ?? '' }}"/>
                                  
                                    <td class="item">
                                        <select class="form-control select-2 select-item-product" name="item_id[]" >
                                                <option value="">Please Select Product</option>
                                                @foreach($item as $it)
                                                    <option value="{{ $it->id }}"  {{ ($invoice_item->item_id==$it->id) ? 'selected' : ''  }} >{{ $it->name }}</option>
                                                @endforeach
                                        </select>
                                    </td>
                                   
                                    <td class="item_rate">
                                        <input class="td-input-width item-gross-total"  type="number" name="prate[]" value="{{ $invoice_item->rate  ?? '' }}"  value=""  />
                                    </td>
                                    <td class="item_qty"><input class="td-input-width item-gross-total"  type="number"   name="pqty[]"  value="{{ $invoice_item->quantity  ?? '' }}" /></td>
                                    <td class="item_pday"> <input class="td-input-width item-gross-total"  type="number"   name="pday[]" value="{{ $invoice_item->days ?? '' }}" />
                                    </td>
                                    <td class="gross-amount">{{ $invoice_item->gross_amount }}</td>
                                    <td><input class="td-input-width item-discount"  type="number" name="pdiscount[]"  value="{{ $invoice_item->discount }}"/></td>
                                    <td class="cgst">{{ $invoice_item->cgst }}</td>
                                    <input type="hidden" class="cgst" name="cgst[]" value="{{ $invoice_item->cgst }}" />
                                    <td class="sgst">{{ $invoice_item->sgst }}</td>
                                    <input type="hidden" class="sgst" name="sgst[]" value="{{ $invoice_item->sgst }}" />
                                    <td class="igst">{{ $invoice_item->igst }}</td>
                                    <input type="hidden" class="igst" name="igst[]" value="{{ $invoice_item->igst }}" />
                                    <td class="tax-amount">{{ $invoice_item->tax_amount }}</td>
                                    <td class="total-amount" style="border-bottom: 1px solid">{{ $invoice_item->total_amount }}</td>
                                    
                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $invoice_item->gross_amount }}" />
                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $invoice_item->tax_amount }}" />
                                    <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $invoice_item->total_amount }}" />
                                    <input type="hidden" class="invoice_product_id" name="invoice_product_id[]" value="{{ $invoice_item->id }}" />
                        </tr>
                    </tbody>
                        @endforeach

                            <tr class="inser-div-before">
                                <td colspan="15">
                                    <center>
                                        <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">ADD ITEM</a>
                                    </center>
                                </td>
                            </tr>

                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="4">Tax Payable on Rev. Charge Basis: NO</td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $invoice->net_amount }}
                                </td>
                                <td></td>
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $invoice->total_tax }}</td>

                                    
                                <td id="display-grand-amount">
                                   {{ $invoice->total_amount }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Amount in words :</td>
                                <td colspan="13"><span id="amountinword"><input name="amount_in_words" id="amount_in_words" type="text" value="{{ $invoice->amount_in_words }}" class="w-100" ></span></td>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Remark </td>
                                    <td colspan="13"><input name="remark" id="remark" type="text" value="{{ $invoice->remark }}" class="w-100" ></td>
                                </tr>
                            </tr>
                        
                        </tbody>
                    </table>
                                    <input name="total_gross_sum" id="total_gross_sum" type="hidden" value="{{ $invoice->net_amount }}" >
                                    <input name="total_tax_amount" id="total_tax_amount" type="hidden" value="{{ $invoice->total_tax }}" >
                                    <input name="total_grand_amount" id="total_grand_amount" type="hidden" value="{{ $invoice->total_amount }}" >
                                    <input name="total_net_discount" id="total_net_discount" type="hidden" value="{{ $invoice->net_discount }}" >
                                   {{--  <input name="amount_in_words" id="amount_in_words" type="hidden" value="{{ $invoice->amount_in_words }}" > --}}
                                    <input name="customer_id" id="customer_id" type="hidden" value="{{ $invoice->customer_id }}" >

                    <table class="bank-detail" width="100%" style="border-top: 1px solid #000!important; border-bottom:  1px solid #000!important;">
                        <tr class="bottom">
                            <td class="border-right">
                                <table>
                                    <tr>
                                        <td class="title center">
                                            <h3>Supply Address</h3>

                                             <select class="select-2 invoice-supply-address" name="supply_id" >
                                                <option>Select Supply Address</option>
                                                @foreach($supply_address as $da)
                                                    <option value="{{ $da->id }}" {{ ($invoice->supply_id ==  $da->id) ? 'selected=""' : '' }} >{{ $da->venue }} {{ $da->address }}</option>
                                                @endforeach    
                                            </select>
                                            <p id="supplyaddress"></p>
                                            <input type="hidden" name="sstate" value="">
                                            <input type="hidden" name="sperson" value="">
                                            <input type="hidden" name="slandmark" value="">
                                            <input type="hidden" name="spincode" value="">
                                            <input type="hidden" name="smobile" value="">
                                            <input type="hidden" name="scity" value="">
                                            <input type="hidden" name="supply_id" value="">
                                            <input type="hidden" name="saddress" value="">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                 @php
                                               $bank_name  = $meta->where('meta_name','bank_name')->first()->meta_value;
                                               $bank_holder_name  = $meta->where('meta_name','bank_holder_name')->first()->meta_value;
                                               $account_no  = $meta->where('meta_name','account_no')->first()->meta_value;
                                               $ifsc  = $meta->where('meta_name','ifsc')->first()->meta_value;
                                               $bank_address  = $meta->where('meta_name','bank_address')->first()->meta_value;
                                    @endphp
                                    <tr>
                                        <td class="center">
                                            <h3>BANK DETAILS</h3>
                                        </td>
                                    </tr>
                                    <tr></tr>

                                    <tr class="flex-td">
                                        <td>
                                            <b>Name : {{ $bank_name }}</b> <br />
                                            <b> Bank : {{ $bank_holder_name }}</b>
                                        </td>
                                    </tr>
                                    <tr class="flex-td">
                                        <td>
                                            <b>A/c No. : {{ $account_no }}</b> <br />
                                            <b> IFSC Code: {{ $ifsc }}</b>
                                        </td>
                                    </tr>
                                    <tr class="flex-td">
                                        <td class="center"><b>Address : {{ $bank_address }}</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                   
                    <table>
                        <tr>
                            <td>
                               {!! $term_and_conditions->meta_value !!}

                                <p class="center">This is a system generated {{ $invoice->invoice_type }} and does not require a signature.</p>
                            </td>
                        </tr>
                    </table>

                    <table class="billing-info- center">
                        <tr>
                            <td><a href="{{ route('quotation.email',['id'=>$invoice->id]) }}" class="btn-print-edit">Email</a></td>
                            <td><a href="{{ route('quotation.print',['id'=>$invoice->id]) }}" class="btn-print-edit">Print</a></td>
                            <td style="float: right;"><button  class="send btn-submit">Update</button></td>
                            {{-- <td><button  typ class="send btn-submit" >Submit</button></td> --}}
                        </tr>
                    </table>
                </div>
                </div>
            </form>

            <script>
        
                $("#add-more-btn").click(function(){
                    //alert('xd');
                             var myvar = '<tr class="center item">'+
                '                                    <td class="space"><span class="remove-btn">X</span></td>'+
                '                                    <td class="hsn"></td>'+
                '                                    <input type="hidden" class="phsn" name="phsn[]" value="" />'+
                '                                    <td class="item-display"></td>'+
                '                                    <input type="hidden" class="pdescription"  name="pdescription[]" value="" />'+
                '                                    <input type="hidden" class="pname" name="pname[]" value="product name" />'+
                '                                  '+
                '                                    <td class="item">'+
                '                                        <select class="form-control select-2 select-item-product" name="item_id[]" >'+
                '                                                <option value="">Please Select Product</option>'+
                '                                                @foreach($item as $key => $it)'+
                '                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>'+
                '                                                @endforeach'+
                '                                        </select>'+
                '                                    </td>'+
                '                                   '+
                '                                    <td class="item_rate">'+
                '                                        <input class="td-input-width item-gross-total"  type="number" name="prate[]" value="" />'+
                '                                    </td>'+
                '                                    <td class="item_qty"><input class="td-input-width item-gross-total"  type="number" name="pqty[]"  value="" /></td>'+
                '                                    <td class="item_pday"> <input class="td-input-width item-gross-total"   type="number" name="pday[]" value="" /></td>'+
                '                                    <td class="gross-amount"></td>'+
                '                                    <td><input class="td-input-width item-discount" type="number" name="pdiscount[]" value="0"/></td>'+
                '                                    <td class="cgst">0</td>'+
                '                                    <input type="hidden" class="cgst" name="cgst[]" value="" />'+
                '                                    <td class="sgst">0</td>'+
                '                                    <input type="hidden" class="sgst" name="sgst[]" value="" />'+
                '                                    <td class="igst">0</td>'+
                '                                    <input type="hidden" class="igst" name="igst[]" value="" />'+
                '                                    <td class="tax-amount"></td>'+
                '                                    <td class="total-amount"></td>'+
                '                                    '+
                '                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="" />'+
                '                                    <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="" />'+
                '                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="" />'+
                '                        </tr>';

                    //get_item_sum_with_tax();
                    $( myvar ).insertBefore(".inser-div-before");
                    $('.select-item-product').select2();
                    

                });
            </script>

            <script type="text/javascript" src="{{ asset('resources/js/booking.js?v='.time()) }}"></script>

        </div>

    </div>
<script>
     $(function(){
    $('.main-gst-selection').change();
    
    $('.invoice-supply-address').find('option[value={{ $invoice->supply_id }}]').attr("selected",true);


    $('.invoice-supply-address').change();
   // $('input[name="customer_type"]').change();
        setTimeout(function() {
                @if( $invoice->customer_id != 0)
                    $('.invoice-customer-type').find('option[value={{ $invoice->customer_id }}]').attr("selected",true);
                    $(".invoice-customer-type").select2();
                    //$(".invoice-customer-type").change();  
                @endif
        }, 1000);
        
        if($('input[name="daddress"]').val()==''){  
        //alert('xd');  
          //  $('.invoice-delivery-address').find('option[value="{{ $invoice->delivery_id }}"]').attr("selected",true);
            $(".invoice-delivery-address").select2();
            $(".invoice-delivery-address").change();
        } 
        @php
            $index =  $customers_details['contact_person_c'];
        @endphp
        


        setTimeout(function() {
                $('.select-two-name').find('option[value="{{ $index }}"]').attr("selected",true);
                $(".select-two-name").select2();
                $('.select-two-name').change();
                // alert('xd{{ $index }}');
        }, 5000);
        
   });
</script>

@endsection