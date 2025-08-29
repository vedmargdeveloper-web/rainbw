@extends(_app())
@section('title', $title)
@section('content')
<style type="text/css">
    span.select2-selection.select2-selection--single {
            border: unset;
            background: unset;
        }
    .field-group.td-city-width.bg-t {
        margin: 0;
        padding: 0;
    }
</style>
    <div class="main-container">
        <style type="text/css">
            .dstate-div input{
                    width: 164px;
            }
            .width-70{
                width: 70% !important;
            }
            table.billing-info.main td{
                padding: 0!important;
            }
            .bg-t{
                    height: 22px;
                background: #fde9d9;
                padding-left: 10px!important;
                border-bottom: 2px solid;
            }
            .td-state-pin .field-group{
                width: 125px!important;
            }
            .field-group.width-full.margin{
                width: 70%!important;
            }
        </style>
        <div class="content-wrapper">
            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">
            <?php
               $customer_type =  App\Models\CustomerTypeMaster::get();
               $delivery_address =  App\Models\Address::where('type','delivery')->get();
               $supply_address =  App\Models\Address::where('type','supply')->get();
               $customers =  App\Models\Customer::where('customer_type',$inquiry->customer_type)->get();
               $meta =  App\Models\Meta::all();
               $leads =  App\Models\Lead::where('lead_heads_id',3)->get();
               $sources =  App\Models\Source::get();
               
               //dd($source);
               $gstMaster =  App\Models\GstMaster::all();
               $term_and_conditions = $meta->where('meta_name', 'term')->first();
               // $gstMaster->where('gstin', $gstNo->)
               $gst  = $meta->where('meta_name','gst')->first()->meta_value;
               $udyam_reg  = $meta->where('meta_name','udyam_reg')->first()->meta_value;
               $head_office  = $meta->where('meta_name','head_office')->first()->meta_value;
               $branch_office  = $meta->where('meta_name','branch_office')->first()->meta_value;
               $email  = $meta->where('meta_name','email')->first()->meta_value;
               $phone  = $meta->where('meta_name','mobile')->first()->meta_value;
               $state = App\Models\State::get();
               $city = App\Models\City::get();
               $inquiry_all =  App\Models\Inquiry::get(['unique_id','id']);
            ?>
            @php
                $invoice_last_y = date('y')+1;
                $totalInquiry =  App\Models\Inquiry::count()+1;
                $customer = json_decode($inquiry->customer_details,true);
                $venue_details = json_decode($inquiry->venue_details,true);
               // dd($venue_details);
            @endphp
            <form action="{{ route('booking.store') }}" method="post" id="invoice-submit"> 
                @csrf
                <div class="invoice-box"> 
                   <table>
                     <tr class="top">
                            <td class="left-grid text-center" style="width: 100%;" colspan="2">
                                <b>Lead Status </b>
                                <span id="dynamic_lead_status">{{ $inquiry->leadstatus->status }}</span>
                            </td>                          
                        </tr>
                        </table>
                        
                      <table cellpadding="0" class="invoice-header" cellspacing="0">
                       
                        <tr class="top">
                            <td class="left-grid" style="width: 50%;">
                                <table>
                                    <tr>
                                        <td class="title text-right" >
                                            GSTIN :
                                        </td>
                                        <td colspan="2">
                                            <select class="select-2 main-gst-selection" name="gst_id">
                                                <option value="">Please Select</option>
                                                @foreach($gstMaster as $key => $gm)
                                                    <option {{ $gm->id == $_GET['gstid'] ? 'selected' : '' }}   data-state="{{ $gm->state }}" value="{{ $gm->id }}"> 
                                                        {{ strtoupper($gm->gstin) }} 
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="text-right" ><strong id="temp" > Udyam Reg. No. :</strong></td>
                                        <td id="udyam_no">{{ $udyam_reg }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="pt-20" style="font-size: 10px;">
                                            <ul class="gst-head-ul">
                                               
                                            </ul>
                                        </td >
                                    </tr>

                                </table>
                            </td>

                            <td>
                                <table>
                                    <tr>
                                        <td class="center">
                                          {{--   <b>Invoice</b> --}}
                                            <h4>Booking</h4>
                                            <input type="hidden" name="invoice_type" value="booking">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">
                                            <h3 style="margin: 0;">RAINBOW</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" >
                                            Head Office: <span id="head_office">{{ $head_office }} </span> <br />
                                            Branch Office:<span id="branch_office"> {{ $branch_office }}</span> <br />
                                            <span id="temp_address"></span>
                                        </td>
                                    </tr>
                                    <tr class="flex-td">
                                        <td>
                                            <b>Mobile : <span id="head_mobile">{{ $phone }}</span></b> <br />
                                            <b>Email: <span id="head_email">{{ $email }}</span></b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="billing-info main">
                       
                        <tr class="td-no-padding">  
                            <span style="display:none ;" id="default-invoice-no">
                                <?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInquiry" ?>
                            </span>
                            <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/INV/$totalInquiry"; ?> 
                            <td>
                                <div class="label">Unique ID: </div>
                                <div class="field-group bg-t" >
                                     @php
                                        $uid = 0;
                                        $id = $quotation->enquire_id;
                                    @endphp
                                    @foreach($inquiry_all as $inq)
                                            {{ ($id == $inq->id)  ? $inq->unique_id  : '' }}
                                            @php
                                                 ($id == $inq->id)  ? $uid = $inq->id  : 0;
                                            @endphp
                                    @endforeach
                                    <input type="hidden" name="uid" value="{{ $uid }}"> 
                                </div>
                            </td>
                            <td class="text-right td-no-padding" >
                                <div class="label"><span id="change_billing_type">Booking </span> Date :</div>
                                <div class="field-group bg-t" style="width: 30%;    padding-right: 37px;">
                                    {{-- <b>{{ date('d.m.Y') }}</b> --}}
                                    
                                    <input type="date" name="billing_date" value="{{ date('d.m.Y') }}">
                                </div>
                            </td>  
                        </tr>
                        <tr class="td-no-padding">
                            <tr class="td-no-padding">
                            @php
                                $invoice_last_y = date('y')+1;
                                $totalInvoice =  App\Models\Booking::count()+1;
                            @endphp
                            <span style="display:none ;" id="default-invoice-no">
                                <?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInvoice" ?>
                            </span>

                            <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/BK/$totalInvoice"; ?> 
 
                            <td rowspan="" class="td-no-padding">
                                <div class="label ">Serial No.: </div>
                                <div class="field-group bg-t">
                                    <input type="hidden" name="invoice_no" value="<?= $invoice_no ?>"> 
                                    <b id="invoice_no"><?=  $invoice_no ?></b>
                                </div>
                            </td>

                            <td class="text-right td-no-padding">
                                <div class="label">Event Date :</div>
                                <div class="field-group bg-t" style="    padding-right: 37px; width: 30%;">
                                   {{--  <b>{{ date('d.m.Y') }}</b> --}}
                                   
                                    {{ $inquiry->event_date ?? '' }}
                                    <input type="hidden" name="event_date" value="{{ $inquiry->event_date ?? '' }}">
                                </div>
                            </td>
                        </tr>
                        </tr>
                        <tr class="">
                            <td class="td-no-padding">
                                <div class="label">Customer Type:  </div>
                                <div class="field-group bg-t">
                                    <span id="cp_type"></span>
                                    @foreach($customer_type as $ct)
                                        <label for="{{ $ct->code }}"><input type="radio"  id="{{ $ct->code }}" {{ ($inquiry->customer_type == $ct->id )  ? 'checked=""' : '' }} name="customer_type" value="{{ $ct->id }}"> {{ $ct->type }}</label>
                                    @endforeach
                                    Booking Type
                                    <select name="booking_type" id="booking_type" required="">
                                        <option value="">Select</option>
                                        <option value="1">No 1</option>
                                        <option value="2">No 2</option>
                                    </select>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="td-no-padding">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="td-no-padding">
                                                <div class="label "> Client : </div> 
                                                <div class="field-group bg-t">
                                                    {{-- <select class="select-2 invoice-customer-type" >  --}}
                                                        @foreach($customers   as $customer1)
                                                          {{--   <option value="{{ $customer1->id }}"  {{ ($customer1->id == $inquiry->customer_id) ? 'selected=""' : ''  }}>{{ $customer1->company_name }}</option> --}}
                                                            @if($customer1->id == $inquiry->customer_id)
                                                                {{ $customer1->company_name }}
                                                                <input type="hidden" name="company_name"  value="{{ $customer1->company_name }}" class="w-100 mt-2" id="company_name" style="display: none;">
                                                            @endif
                                                        @endforeach     
                                                    {{-- </select> --}}
                                                    
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="td-no-padding">
                                                <div class="label">Address :</div> 
                                                <div class="field-group bg-t">
                                                    {{ $customer['caddress'] ?? '' }}
                                                    <input type="hidden" class="form-control- w-100"  name="caddress" value="{{ $customer['caddress'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-no-padding">
                                                <div class="label"></div> 
                                                <div class="field-group bg-t">
                                                    {{ $customer['caddress1'] ?? '' }}
                                                    <input type="hidden" class="form-control- w-100"  name="caddress1" value="{{ $customer['caddress1'] ?? '' }}">
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>

                            <td class="td-no-padding">
                                <table>
                                    <tbody>
                                        <tr class="venue_name">
                                            <td class="td-no-padding">
                                                <div class="label">Venue Name :</div> 
                                                <div class="field-group td-city-width bg-t">
                                                     {{-- <select class="select-2 invoice-delivery-address" name="delivery_id" > --}}
                                                       {{--  <option value="">Select Delivery Address</option> --}}
                                                            @foreach($delivery_address as $da)
                                                                    @if($da->id == $inquiry->delivery_id)
                                                                            {{ $da->venue }}
                                                                    <input type="hidden" value="{{ $da->id  }}" name="delivery_id">
                                                                    @endif
                                                                    {{-- <option value="{{ $da->id }}" {{  ($da->id == $inquiry->delivery_id ) ? 'selected=""' : '' }} >{{ $da->venue }}</option> --}}
                                                            @endforeach   
                                                            @if($inquiry->delivery_id == 'other')
                                                                <input type="hidden" value="other" name="delivery_id">
                                                            @endif
                                                    {{-- </select> --}}
                                                    <input type="hidden" name="venue_name" value="{{ $venue_details['venue_name'] }}"  class="w-100 mt-2" id="venue_name" required="" >
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-no-padding">
                                                <div class="label">Address :</div> 
                                                <div class="field-group bg-t">
                                                    {{ $venue_details['daddress'] ?? '' }}
                                                    <input type="hidden" class="form-control- w-100" name="daddress" value="{{ $venue_details['daddress'] ?? '' }}" required="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-no-padding"> 
                                                <div class="label"></div> 
                                                <div class="field-group bg-t">
                                                    {{ $venue_details['daddress1']  ?? '' }}
                                                    <input type="hidden" class="form-control- w-100" name="daddress1" value="{{ $venue_details['daddress1']  ?? '' }}" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr  class="td-state-pin td-no-padding">
                            <td class="td-no-padding">
                                <table>
                                    <tbody>
                                        <tr class="pincode-inner-tr"  >
                                            <td colspan="2" class="td-no-padding">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">City :
                                                             
                                                            </div> 
                                                            <div class="field-group bg-t">
                                                                <div class="ccity-div-"  style=" margin-left: -6px;">
                                                                    {{-- <input type="hidden" name="ccity" class="custom-pincode" value="" > --}}
                                                                    {{-- <select class="form-control" name="ccity">
                                                                        @foreach($city as $st)
                                                                                <option value="{{ $st->id }}" {{ ( $customer['ccity'] ==  $st->id ) ? 'selected' : ''   }}>{{ $st->city }} </option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    {{-- @foreach($city as $st)
                                                                            @php  if( $customer['ccity'] ==  $st->id ){
                                                                                    $cstate =  $st->city;
                                                                                } 
                                                                            @endphp
                                                                    @endforeach --}}
                                                                    {{  $customer['ccity'] ?? ''  }}
                                                                    <input type="hidden" name="ccity" value="{{  $customer['ccity'] ?? ''  }}">
                                                                </div>
                                                                 <input type="hidden" name="ccity" value="{{  $customer['ccity'] ?? ''  }}">
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state-">State :</div> 
                                                            <div class="field-group state-select- bg-t">
                                                                {{-- @foreach($state as $st)
                                                                            @php  if( $customer['cstate'] ==  $st->id ){
                                                                                    $cstate =  $st->state;
                                                                                } 
                                                                            @endphp
                                                                @endforeach --}}
                                                                {{  $customer['cstate']  ?? '' }}
                                                                <input type="hidden" name="cstate" value="{{  $customer['cstate']  ?? '' }}">                  
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                          <tr class="pincode-inner-tr"  >
                                            <td colspan="2" class="td-no-padding">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Pincode :</div> 
                                                            <div class="field-group bg-t">
                                                                {{ $customer['cpincode'] ?? '' }}
                                                                <input type="hidden" name="cpincode"   value="{{ $customer['cpincode'] ?? '' }}" class="custom-pincode">
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state-">Landmark</div> 
                                                            <div class="field-group bg-t">
                                                                {{ $customer['clandmark'] ?? '' }}
                                                                <input type="hidden" class="ml-2" name="clandmark" value="{{ $customer['clandmark'] ?? '' }}"  class="w-100">
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td-no-padding">
                                                <div class="label">Contact person :</div> 
                                                <div class="field-group width-full margin contact-person bg-t" >
                                                    {{ $customer['contact_person_c'] ?? '' }}
                                                    <input type="hidden" class="w-100" name="contact_person_c" value="{{ $customer['contact_person_c'] ?? '' }}" required >
                                                </div>
                                            </td>
                                        </tr>
                                         <tr class="pincode-inner-tr"  >
                                            <td colspan="2" class="td-no-padding">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Mobile:</div> 
                                                            <div class="field-group bg-t">
                                                                    {{ $customer['cmobile'] ?? '' }}
                                                                  <input type="hidden" class="w-100" name="cmobile" value="{{ $customer['cmobile'] ?? '' }}"  required=''>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state- label-whatsappp">WhatsApp</div> 
                                                            <div class="field-group td-whatsappp bg-t">
                                                                {{ $customer['cwhatsapp'] ?? '' }}
                                                                <input type="hidden" class="w-100 " name="cwhatsapp" value="{{ $customer['cwhatsapp'] ?? '' }}"  required=''>
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td-no-padding">
                                                <div class="label">Email :</div> 
                                                <div class="field-group width-full margin bg-t">
                                                    {{ $customer['cemail'] ?? '' }}
                                                    <input type="hidden" class="w-100" name="cemail" value="{{ $customer['cemail'] ?? '' }}" required >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td-no-padding">
                                                <div class="label">GSTIN :</div> 
                                                <div class="field-group width-full margin bg-t">
                                                    {{ $customer['cgstin'] ?? '' }}
                                                    <input type="hidden" class="w-100" name="cgstin" value="{{ $customer['cgstin'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
                            </td>
                                
                            <td class="td-no-padding">
                                <table>
                                    <tbody>
                                       <tr>
                                            <td class="td-no-padding">
                                               <table>
                                                    <tbody>
                                                            <tr>
                                                                <td colspan="2" class="td-no-padding">
                                                                    <div class="label">Landmark :</div> 
                                                                    <div class="field-group width-full margin bg-t">
                                                                        {{ $venue_details['dlandmark'] ?? '' }}
                                                                        <input type="hidden" class="w-100" name="dlandmark" value="{{ $venue_details['dlandmark'] ?? '' }}" style="margin-left: -8px;" >
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <tr class="pincode-inner-tr"  >
                                                            <td colspan="2" class="td-no-padding">
                                                               <table>
                                                                  <tbody>
                                                                    <tr>
                                                                        <td style="width: 50%;" class="td-no-padding" >
                                                                            <div class="label">City :</div> 
                                                                            <div class="field-group bg-t">
                                                                                {{-- <input type="hidden" class="w-75" name="dcity" value="" >  --}}
                                                                                <div class="dcity-div">
                                                                                   {{--  
                                                                                    <select class="form-control" name="dcity">
                                                                                        @foreach($city as $st)
                                                                                                <option value="{{ $st->id }}" {{ ($venue_details['dcity'] == $st->id ) ? 'selected=""'  : '' }} >{{ $st->city }} </option>
                                                                                        @endforeach
                                                                                    </select>  --}}
                                                                                    {{ $venue_details['dcity'] }}
                                                                                    <input type="hidden" name="dcity" value="{{ $venue_details['dcity'] }}" > 
                                                                                </div>

                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state-">State :</div> 
                                                                            <div class="field-group state-select- bg-t">
                                                                               <div class="dstate-div"> 
                                                                                {{ $venue_details['dstate'] }}
                                                                                    <input type="hidden" name="dstate" value="{{ $venue_details['dstate'] }}" > 
                                                                               </div>
                                                                                
                                                                            </div>
                                                                        </td>
                                                                    <tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                       </tr>
                                        <tr>
                                            <td colspan="2" class="td-no-padding">
                                                <div class="label">Contact Person :</div> 
                                                <div class="field-group width-full margin bg-t">
                                                    {{ $venue_details['dperson'] ?? '' }}
                                                    <input type="hidden" class="w-100" name="dperson" value="{{ $venue_details['dperson'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td-no-padding">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group width-full margin bg-t">
                                                    {{ $venue_details['dmobile'] ?? '' }}
                                                    <input type="hidden" class="w-100" name="dmobile" value="{{ $venue_details['dmobile'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                          <tr>
                                            <td class="td-no-padding">
                                               <table>
                                                    <tbody>
                                                        <tr class="pincode-inner-tr"  >
                                                            <td colspan="2" class="td-no-padding">
                                                               <table>
                                                                  <tbody>
                                                                    <tr>
                                                                        <td style="width: 50%;" class="td-no-padding" >
                                                                            <div class="label">Pincode :</div> 
                                                                            <div class="field-group bg-t">
                                                                                {{ $venue_details['dpincode'] ?? '' }}
                                                                                <input type="hidden" class="w-75" name="dpincode" value="{{ $venue_details['dpincode'] ?? '' }}" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state- label-whatsapp" style="width: 28%!important; margin: 0!important;">Readyness:</div> 
                                                                            <div class="field-group td-whatsapp bg-t">
                                                                                {{ $venue_details['readyness'] ?? '' }}
                                                                                <input type="hidden" name="dreadyness" value="{{ $venue_details['readyness'] ?? '' }}" > 
                                                                            </div>
                                                                        </td>
                                                                    <tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="td-no-padding">
                                                <div class="label">Remark : </div> 
                                                <div class="field-group bg-t">
                                                    {{ $venue_details['remark'] ?? '' }}
                                                    <input type="hidden" name="remark"  value="{{ $venue_details['remark'] ?? '' }}" class="" >
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                    

                   @php 
                        $item_list = App\Models\Item::get();
                        $inquiry_items =  $inquiry->inquiryItems;
                        //dd($quotation);
                    @endphp
                    @php $item = App\Models\Item::get(); @endphp
                    <table class="table-grid td-item-table no-border-top" cellspacing="0">
                        <tbody>   
                            <tr class="sub-heading-item" >
                                
                                <td rowspan="2" style="width: 75px;">HSN Code</td>
                                <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                <td rowspan="2">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> 

                                {{ $quotation->dayormonth ?? '' }}

                            </td>
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

                            @php
                                $count = 0;
                                $inquiry_items  =  $quotation->quotationItem;
                                $edit_gross_amount = 0;
                                // echo 'dd';
                                // dd($inquiry_items);
                            @endphp
                         

                                @foreach($inquiry_items as $invoice_item)
                                <tr class="center item">
                                             {{-- <td class="space"><span class="remove-btn">X</span></td> --}}
                                            <td class="hsn">{{ $invoice_item->hsn_code ?? '' }}</td> 
                                            <input type="hidden" class="phsn" name="phsn[]" value="{{ $invoice_item->hsn_code ?? '' }}" />
                                            <td class="item-display">{{ $invoice_item->description ?? '' }}</td>
                                            <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $invoice_item->description ?? '' }}"   />
                                            <input type="hidden" class="pname" name="pname[]" value="{{ $invoice_item->description ?? '' }}"/>
                                            <td class="item">
                                            <select class="select-item-product" name="item_id[]">
                                                @foreach($item_list as $it)
                                                        <option readonly="readonly" value="{{ $it->id }}"  {{ ($invoice_item->item_id==$it->id) ? 'selected=""' : '' }}>{{ $it->name }}</option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="item_rate">
                                                <input class="td-input-width item-gross-total mandatory" readonly="" required  type="number" name="prate[]" value="{{ $invoice_item->rate  ?? 0 }}"  value=""  />
                                            </td>
                                            <td class="item_qty"><input class="td-input-width item-gross-total mandatory" readonly=""  type="number"   name="pqty[]"  value="{{ $invoice_item->quantity ?? 0 }}" /> </td>
                                            <td class="item_pday"> <input class="td-input-width item-gross-total mandatory"  readonly="" type="number"   name="pday[]" value="{{ $invoice_item->days ?? 0 }}" />
                                            </td>
                                            <td class="gross-amount">{{ $invoice_item->gross_amount }}
                                                <?php
                                                    $edit_gross_amount += $invoice_item->gross_amount;
                                                ?>
                                            </td>
                                            <td class="my-discount"><input class="td-input-width item-discount"  type="number" readonly="" name="pdiscount[]"  value="0"/></td>

                                            <td class="cgst">{{ $invoice_item->cgst }}</td>
                                            <input type="hidden" class="cgst" name="cgst[]" value="{{ $invoice_item->cgst }}" />
                                            <td class="sgst">{{ $invoice_item->sgst }}</td>
                                            <input type="hidden" class="sgst" name="sgst[]" value="{{ $invoice_item->sgst }}" />
                                            <td class="igst">{{ $invoice_item->igst }}</td>
                                            <input type="hidden" class="igst" name="igst[]" value="{{ $invoice_item->igst }}" />
                                            <td class="tax-amount">{{ $invoice_item->tax_amount  }}</td>
                                            <td class="total-amount">{{ $invoice_item->total_amount }}</td>

                                            <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $invoice_item->gross_amount }}" />
                                            <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $invoice_item->tax_amount }}" />
                                            <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $invoice_item->total_amount }}" />
                                            <input type="hidden" class="invoice_product_id" name="product_id[]" value="{{ $invoice_item->id }}" />
                                </tr>

                            @endforeach    
                            <tr class="center bottom-footer-tr">
                                
                                <td colspan="3"></td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">
                                    {{ $edit_gross_amount ?? 0 }}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $quotation->total_tax ?? 0 }}</td>
                                <td id="display-grand-amount">
                                    {{ $quotation->total_amount ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;">Amount in words :</td>
                                <td colspan="11"><input name="amount_in_words" id="amount_in_words" type="text" value="" class="w-100" ></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;">Remark </td>
                                <td colspan="11"><input name="remark" id="remark" type="text" value="" class="w-100" ></td>
                            </tr>
                        </tbody>
                    </table>

                    <input name="total_gross_sum" id="total_gross_sum" type="hidden" value="" >
                    
                    <input name="total_gross_sum" id="total_gross_sum" type="hidden" value="{{ $edit_gross_amount ?? 0 }}" >
                    <input name="total_tax_amount" id="total_tax_amount" type="hidden" value="{{ $quotation->total_tax ?? 0 }}" >
                    <input name="total_grand_amount" id="total_grand_amount" type="hidden" value="{{ $quotation->total_amount ?? 0 }}" >
                    <input name="total_net_discount" id="total_net_discount" type="hidden" value="{{ $quotation->net_discount ?? 0 }}" >

                    <input name="customer_id" id="customer_id" type="hidden" value="{{ $inquiry->customer_id }}" >
                    <table class="billing-info no-border-top">
                        <tr class="bottom">
                            <td class="border-right">
                                <table>
                                    <tr>
                                        <td class="title center">
                                            <h3>Supply Address</h3>
                                             <select class="select-2 invoice-supply-address" name="supply_id" >
                                                <option>Select Supply Address</option>
                                                @foreach($supply_address as $da)
                                                    <option value="{{ $da->id }}">{{ $da->venue }} {{ $da->address }}</option>
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

                                <p class="center">This is a system generated  and does not require a signature.</p>

                            </td>
                        </tr>
                    </table>

                    <table class="billing-info- center">
                        <tr>
                            {{-- <td><button onclick="javascript:alert('we are working ')" class="email">Email</button></td>
                            <td><button onclick="javascript:alert('we are working ')" class="whatapp">Whatapp</button></td> --}}
                            <td>  
                                Lead Status
                                <select name="lead_status" required="">
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }} " {{ ($inquiry->leadstatus->status ==  $lead->lead) ? 'selected=""' : '' }}>{{ $lead->lead }}</option>
                                    @endforeach
                                </select> 
                                <input type="hidden" name="select_two_name" id="select_two_name" value="{{ $customer['contact_person_c'] ?? '' }}">
                                <button  class="send btn-submit">Save </button></td>
                            {{-- <td><button  typ class="send btn-submit" >Submit</button></td> --}}
                        </tr>
                    </table>
                </div>     
             </form>
            <script>
                $(function(){
                    $('.select-item-product').change();
                })
                $("#add-more-btn").click(function(){

                    let error = 0;

                    $("input[name='prate[]']").each(function(index,val){
                         if($(this).val()==''){
                             swal("Rate !", "Rate is required", "error", {
                                    button: "Ok!",
                                });
                             error = 1;
                            return false;
                         }
                    });



                    $("input[name='pqty[]']").each(function(index,val){
                         if($(this).val()==''){
                             swal("Quantity !", "Quantity is required", "error", {
                                    button: "Ok!",
                                });
                            error = 1;
                            return false;
                         }
                    });
                    $("input[name='pday[]']").each(function(index,val){
                         if($(this).val()==''){
                             swal("Day/Month !", "Day/Month is required", "error", {
                                    button: "Ok!",
                                });
                            error = 1;
                            return false;
                         }
                    });

                    if(error > 0){
                        return;
                    }

                var myvar =  '<tr class="center item">'+
                    ''+
                    '                                    <td class="space"><span class="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></span></td>'+
                    '                                    <td class="item">'+
                    '                                        <select class="form-control select-2 select-item-product" name="item_id[]" >'+
                    '                                                <option value="">Please Select Product</option>'+
                    '                                                @foreach($item_list as $it)'+
                    '                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>'+
                    '                                                @endforeach'+
                    '                                        </select>'+
                    '                                    </td>'+
                    '                                    <td ><input type="number"  class="w-100" name="qty[]" value="" /></td>'+
                    '                                    <td ><input type="number"  class="w-100" name="days[]" value="" /></td>'+
                    '                                    <td ><input type="date"  class="w-100" name="date[]" value="" /></td>'+
                    '                                    <td ><input type="time"  class="w-100" name="time[]" value="" /></td>'+
                    '                                    <td ><input type="time"  class="w-100" name="time_two[]" value="" /></td>'+
                    '                                    <td ><input type="text"  class="w-100" name="venue[]" value="" /></td>'+
                    '                            </tr>';
                    //get_item_sum_with_tax();
                    $( myvar ).insertBefore(".inser-div-before");
                    $('.select-item-product').select2();
                    

                });
            </script>

            <script>
                 $(function(){
                $('.main-gst-selection').change();
            //    $('.item-discount').focusout();
                
                $('.invoice-supply-address').find('option[value={{ $quotation->supply_id ?? 0 }}]').attr("selected",true);


                $('.invoice-supply-address').change();
               // $('input[name="customer_type"]').change();
                    setTimeout(function() {
                            @if( $inquiry->customer_id != 0)
                                $('.invoice-customer-type').find('option[value={{ $inquiry->customer_id }}]').attr("selected",true);
                                $(".invoice-customer-type").select2();
                                $(".invoice-customer-type").change();  
                            @endif
                    }, 1000);
                    
                    if($('input[name="daddress"]').val()==''){  
                    //alert('xd');  
                      //  $('.invoice-delivery-address').find('option[value="{{ $inquiry->delivery_id }}"]').attr("selected",true);
                        $(".invoice-delivery-address").select2();
                        $(".invoice-delivery-address").change();
                    } 
                    @php
                        $index =  $customer['contact_person_c'];
                    @endphp
                    


                    setTimeout(function() {
                            $('.select-two-name').find('option[value="{{ $index }}"]').attr("selected",true);
                            $(".select-two-name").select2();
                            $('.select-two-name').change();
                         
                    }, 5000);
                    
               });


            </script>

            <script type="text/javascript" src="{{ asset('resources/js/booking.js?v='.time()) }}"></script>
        </div>
    </div>
@endsection