@extends(_app())

@section('title', 'Update Challan')

@section('content')

    <div class="main-container">

        <div class="content-wrapper">

            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">

            <?php
        	       $customer_type =  App\Models\CustomerTypeMaster::all();
                   $delivery_address =  App\Models\Address::where('type','delivery')->get();
                   $supply_address =  App\Models\Address::get();
                   $challan_items =  App\Models\PerformaInvoiceChallanItem::where('challan_id',$challan->id)->get();
                //    $performaInvoice = App\Models\Quotation::all();
                   $challanTypes  = App\Models\ChallanTypeMaster::all();

                    $performaInvoice = App\Models\Quotation::orderBy('created_at', 'desc')->get();
                   
                   $customers =  App\Models\Customer::where('customer_type',$challan->customer_type)->get();
                   $edit_customer_type =  $customer_type->where('id',$challan->customer_type)->first()  ;
                  // dd($supply_address);
                   $meta =  App\Models\Meta::all();
                   $occasion =  App\Models\Occasion::get();
                   
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
                   $customers_details = json_decode($challan->customer_details,true);
                   
                   $delivery_details = json_decode($challan->delivery_details,true);
                   //dd($delivery_details);
                   $state = App\Models\State::get();
                   $city = App\Models\City::get();
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

          <form action="{{ route('challan.update', ['id' => $challan->id]) }}" method="post" id="challan-submit">
                @csrf
                {{-- {{ method_field('PATCH') }} --}}

                <div class="invoice-box">
                    <table cellpadding="0" class="invoice-header" cellspacing="0">
                        <tr class="top">
                            <td class="left-grid" style="width: 40%;">
                                <table>
                                    <tr>
                                        {{-- <td class="title text-right" style="width: 120px;">
                                            <strong>GSTIN : </strong> 
                                        </td> --}}
                                         <td class="text-right" style="width: 120px;"><strong id="temp">GSTIN :</strong></td>
                                        
                                        <td colspan="2">
                                            <select class="select-2 main-gst-selection" name="gst_id">
                                                <option value="">Please Select</option>
                                                @foreach($gstMaster as $key => $gm)
                                                    <option {{ ($challan->gst_id == $gm->id) ? 'selected' : '' }} data-state="{{ $gm->state }}" value="{{ $gm->id }}"> {{ strtoupper($gm->gstin) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="text-right" style="width: 120px;"><strong id="temp">Udyam Reg. No. :</strong></td>
                                        <td id="udyam_no">{{ $udyam_reg }} </td>
                                    </tr>
                                    
                                    <tr class="mt-4"> 
                                        <td class="text-right" style="width: 120px;"><strong id="temp">PAN :</strong></td>
                                        <td id="udyam_no"><strong>AAXFR1185Q</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" style="width: 120px;"><strong id="temp">TAN :</strong></td>
                                        <td id="udyam_no"><strong>MRTR10927A</strong></td>
                                    </tr>
                                    {{-- <tr>
                                      <td style="text-align: right; padding-right: 0; "><strong> PAN :  </strong></td>
                                        <td  style="text-align: left; padding-left: 0;">
                                            <strong>AAXFR1185Q</strong>
                                        </td>
                                    </tr>
                                     <tr>
                                      <td style="text-align: right; padding-right: 0; "><strong> TAN : </strong></td>
                                        <td  style="text-align: left; padding-left: 0;">
                                            <strong>MRTR10927A</strong>
                                        </td>
                                    </tr>  --}}
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
                                        <td>
                                            <div style="display: flex; justify-content: center; position: relative;">
                                                <strong><u>Delivery Challan</u></strong>
                                                <small style="position: absolute; right: 0;">Original / Duplicate / Triplicate</small>
                                            </div>
                                            {{-- <input type="hidden" name="challan_type" value="challan"> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">
                                            <h3 style="margin: 0;">RAINBOW</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" style="font-size:12px;">
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

                    <table class="billing-info">
                        <tr class="td-no-padding">
                            <td ></td> <td ></td>
                        </tr>
                        <tr class="td-no-padding mt-4">
                            @php
                                $challan_last_y = date('y')+1;
                                $totalChallan =  App\Models\Invoice::count()+1;
                                
                            @endphp
                            <span style="display:none ;" id="default-challan-no">
                                <?= "FY".date('y')."-".$challan_last_y."/GC/X/$totalChallan" ?>
                            </span>

                            <?php $challan_no = "FY".date('y')."-".$challan_last_y."/GC/CH/$totalChallan"; ?> 

                            <td class="td-no-padding">
                                <div class="label">Serial No.: </div>
                                <div class="field-group">
                                    <input type="hidden" name="challan_no" value="<?=  $challan->challan_no ?>"> 
                                    <b id="challan_no"><?=  $challan->challan_no ?></b>
                                </div>
                            </td>
                             <td class="text-right td-no-padding" >
                                <div class="label"></div>
                                <div class="field-group" style="    padding-right: 37px;">
                                    {{-- <b>{{ date('d.m.Y') }}</b> --}}
                                    <b><span id="change_billing_type">Billing</span> Date :</b>
                                    {{-- <input type="date" name="billing_date" value="<?=  $challan->billing_date ?>"> --}}
                                    <input type="date" name="billing_date"
                                       value="{{ $challan->billing_date ? \Carbon\Carbon::parse($challan->billing_date)->format('Y-m-d') : '' }}">

                                </div>
                            </td>
                           
                        </tr>

                        <tr class="td-no-padding">
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Ref. PI No.: </div>
                                <div class="field-group">
                                    <select name="ref_pi_no" class="field-group select-2" style="width: 150px;">
                                        <option value="">Select PI No.</option>
                                        @foreach($performaInvoice as $pi)
                                            <option value="{{ $pi->invoice_no }}" 
                                                {{ isset($challan) && $challan->ref_pi_no == $pi->invoice_no ? 'selected' : '' }}>
                                                {{ $pi->invoice_no }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>


                            <td class="text-right td-no-padding" >
                                <div class="field-group" style="    padding-right: 59px;">
                                    <b><span id="change_billing_type">Challan</span> Time :</b>
                                    <?php 
                                        $currentTime =now()->setTimezone('Asia/Kolkata')->format('h:i');
                                    ?>
                                     {{-- <input type="time" name="event_time" 
                                        value="{{ \Carbon\Carbon::createFromFormat('h:i A', $challan->event_time)->format('H:i') ?? '' }}"> --}}
                                        <input type="time" name="event_time"
                                         value="{{ $challan->event_time ? \Carbon\Carbon::parse($challan->event_time)->format('H:i') : '' }}">

                                </div>
                            </td>

                            
                        </tr>
                        <tr class="td-no-padding">
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Challan Type: </div>
                                <div class="field-group">
                                    <select name="challan_type" class="field-group select-2" style="width: 150px;" required>
                                        {{-- <option value="">Select Type</option>
                                        <option value="challan" {{ (isset($challan) && $challan->challan_type == 'challan') ? 'selected' : '' }}>Delivery Challan</option>
                                        <option value="return-challan" {{ (isset($challan) && $challan->challan_type == 'return-challan') ? 'selected' : '' }}>Return Challan</option> --}}
                                         @foreach($challanTypes as $type)
                                       <option value="{{ $type->type_name }}" 
                                            {{ (!empty($challan) && $challan->challan_type == $type->type_name) ? 'selected' : '' }}>
                                            {{ $type->type_name }}
                                        </option>

                                    @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                         <tr class="td-no-padding">
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Rental Start Date :  </div>
                                {{-- <input type="date" name="start_date" value="{{ $challan->start_date ?? '' }}" />  --}}
                                 <input type="date" name="start_date"
                                      value="{{ $challan->start_date ? \Carbon\Carbon::parse($challan->start_date)->format('Y-m-d') : '' }}">
                            </td>
                             <td class="text-right td-no-padding">
                            </td>
                            
                        </tr>
                        <tr class="td-no-padding">
                          <td class="td-no-padding"> 
                            <div class="label">Rental End Date : </div>
                            
                          <input type="date" name="end_date"
                                 value="{{ $challan->end_date ? \Carbon\Carbon::parse($challan->end_date)->format('Y-m-d') : '' }}">
                          {{-- <input type="date" name="end_date"  value="{{ $challan->end_date ?? '' }}" /></td> --}}
                             <td class="text-right td-no-padding">
                            </td>
                            
                           

                        </tr>

                       {{--  <tr class="td-no-padding">
                            <td></td>
                           
                        </tr> --}}
                        <tr class="">
                            <td class="">
                                {{-- <label for="compition">
                                    <input type="checkbox" name="compition" {{ ($challan->customer_type==1) ? 'checked' : '' }} value="1" id="compition" >
                                    Compition
                                </label>
                                <br/> --}}
                                <div class="label">Customer Type:  </div>
                                <div class="field-group">
                                    <span id="cp_type">{{ $edit_customer_type->code ?? '' }}</span>
                                @foreach($customer_type as $ct)
                                    <input type="radio"  id="{{ $ct->code }}" name="customer_type" {{ ($challan->customer_type ==  $ct->id) ? 'checked="checked"' : '' }} value="{{ $ct->id }}">
                                    <label for="{{ $ct->code }}">{{ $ct->type }} </label>
                                @endforeach
                                </div>
                            </td>
                            <td class="text-center"><b>Delivery Address</b></td>
                        </tr>

                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="label">Client Name :</div> 
                                                <div class="field-group">
                                                    <select class="select-2 invoice-customer-type" > 
                                                        @foreach($customers   as $customer)
                                                            <option value="{{ $customer->id }}"  {{ ($customer->id == $challan->customer_id) ? 'selected=""' : ''  }}>{{ $customer->company_name }}</option>
                                                        @endforeach     
                                                    </select>
                                                    <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="caddress" value="{{ $customers_details['ccaddress'] }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="caddress1" value="{{ $customers_details['ccaddress1'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>

                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="label">Venue :</div> 
                                                <div class="field-group td-city-width">
                                                    <select class="select-2 invoice-delivery-address" name="delivery_id" >
                                                        <option value=""> Select Delivery Address</option>
                                                            @foreach($delivery_address as $da)
                                                                    <option value="{{ $da->id }}" {{  ($da->id == $challan->delivery_id ) ? 'selected=""' : '' }} >{{ $da->venue }}</option>
                                                            @endforeach   
                                                            <option value="other">Other</option>
                                                    </select>
                                                </div>

                                            </td>
                                        </tr>
                                        {{-- @if(isset($delivery_details['dvenue_name']))
                                        <tr class="venue_name" style="{{ $delivery_details['dvenue_name'] == null  ? 'display: none' : ''}} ;">
                                            <td>
                                                <div class="label">Venue Name : </div> 

                                                <div class="field-group td-city-width">
                                                     <input type="text" name="venue_name" placeholder="Venue Name" value="{{ $delivery_details['dvenue_name']  }}" class="w-100 mt-2" id="venue_name" style="{{ $delivery_details['dvenue_name'] == null  ? 'display: none' : ''}} ;">
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        @endif --}}
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress" value="{{ $delivery_details['daddress'] }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress1" value="{{ $delivery_details['daddress1']  ?? ''}}" >
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
                                                        <td style="width: 50%;" >
                                                            <div class="label">City :</div> 
                                                            <div class="field-group ml-2">
                                                                <div class="ccity-div"><input type="text" name="ccity" class="custom-pincode" value="{{ $customers_details['ccity'] }}" ></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="label label-state">State :</div> 
                                                            <div class="field-group state-select">
                                                                <div class="cstate-div" > <input type="text" name="cstate" value="{{ $customers_details['cstate'] }}" >  </div>
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
                                
                            <td class="td-no-padding">
                                <table>
                                    <tbody>
                                       {{--  <tr>
                                            <td>
                                                <div class="label">Venue :</div> 
                                                <div class="field-group">
                                                    <select class="select-2 invoice-delivery-address" name="delivery_id" >
                                                        <option value=""> Select Delivery Address</option>
                                                            @foreach($delivery_address as $da)
                                                                <option value="{{ $da->id }}">{{ $da->venue }}</option>
                                                            @endforeach    
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control" name="daddress" value="" >
                                                </div> 
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                         <tr  class="td-state-pin">
                            <td>
                                <table>
                                    <tbody>
                                        <tr class="pincode-inner-tr"  >
                                            <td colspan="2">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Pincode :</div> 
                                                            <div class="field-group">
                                                                <input type="text" name="cpincode" value="{{ $customers_details['cpincode'] }}" class="custom-pincode">
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">Landmark</div> 
                                                            <div class="field-group">
                                                                <input type="text" class="ml-2" name="clandmark" value="{{ $customers_details['clandmark'] ?? '' }}" class="w-100">
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            {{-- <td>
                                              
                                            </td> --}}
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">Contact person :</div> 
                                                <div class="field-group width-full contact-person" >
                                                    <input type="text" class="w-100" name="contact_person_c" value="{{ $customers_details['contact_person_c'] ?? '' }}" >

                                                </div>
                                                <input type="hidden"  name="select_two_name" id="select_two_name"> 
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="2">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="cmobile" value="{{ $customers_details['cmobile'] }}" >
                                                </div>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td>
                                               <table>
                                                    <tbody>
                                                        <tr class="pincode-inner-tr"  >
                                                            <td colspan="2" class="td-no-padding">
                                                               <table>
                                                                  <tbody>
                                                                    <tr>
                                                                        <td style="width: 50%;" class="td-no-padding" >
                                                                            <div class="label">Mobile :</div> 
                                                                            <div class="field-group">
                                                                                <input type="number" class="custom-pincode" name="cmobile"  value="{{ $customers_details['cmobile'] ?? '' }}" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">Whatsapp:</div> 
                                                                            <div class="field-group">
                                                                                <input type="number" name="cwhatsappmobile"  value="{{ $customers_details['cwhatsappmobile' ] ?? '' }}" class="w-95 ml-2" > 
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
                                            <td colspan="2">
                                                <div class="label">Email :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="cemail" value="{{ $customers_details['cemail'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">GSTIN :</div> 
                                                <div class="field-group width-full">


                                                    <input type="text" class="w-100" name="cgstin" value="{{ $customers_details['cgstin']  ?? ''}}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="pincode-inner-tr"  >
                                            <td colspan="2">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Occasion:</div> 
                                                         
                                                            <div class="field-group ">
                                                                <div class="field-group">
                                                              @php
                                                                    $customerDetails = json_decode($challan->customer_details, true);
                                                                    $selectedOccasion = $customerDetails['occasion_id'] ?? null;
                                                                @endphp

                                                                <select class="form-control select-2" name="occasion_id" style="height: 20px !important;">
                                                                    @foreach($occasion as $st)
                                                                        <option value="{{ $st->id }}" {{ $selectedOccasion == $st->id ? 'selected' : '' }}>
                                                                            {{ $st->occasion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state label-whatsapp" style="margin-left: 13px;">Readyness</div> 
                                                            <div class="field-group td-whatsapp">
                                                                <input type="text"  name="creadyness" value="{{ $customers_details['creadyness'] ?? '' }}" class="w-100" required="">
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
                                
                            <td>
                                <table>
                                    <tbody>
                                          <tr>
                                            <td colspan="2">
                                                <div class="label">Landmark:</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="dlandmark" value="{{ $delivery_details['dlandmark'] }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <table>
                                                    <tbody>
                                                        <tr class="pincode-inner-tr"  >
                                                            <td colspan="2" class="td-no-padding">
                                                               <table>
                                                                  <tbody>
                                                                    <tr>
                                                                        <td style="width: 50%;" class="td-no-padding" >
                                                                            <div class="label">City :</div> 
                                                                            <div class="field-group">
                                                                                <input type="text" class="w-75" name="dcity" value="{{ $delivery_details['dcity'] }}" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">State :</div> 
                                                                            <div class="field-group">
                                                                                <input type="text" name="dstate" value="{{ $delivery_details['dstate'] }}" > 
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
                                            <td colspan="2">
                                                <div class="label">Contact Person :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="dperson" value="{{ $delivery_details['dperson'] }}" >
                                                </div>
                                            </td>
                                        </tr>
                                      
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="dmobile" value="{{ $delivery_details['dmobile'] }}" >
                                                </div>
                                            </td>
                                        </tr>
                                          <tr>
                                            <td>
                                               <table>
                                                    <tbody>
                                                        <tr class="pincode-inner-tr"  >
                                                            <td colspan="2" class="td-no-padding">
                                                               <table>
                                                                  <tbody>
                                                                    <tr>
                                                                        <td style="width: 50%;" class="td-no-padding" >
                                                                            <div class="label">Pincode :</div> 
                                                                            <div class="field-group">
                                                                                <input type="text" class="w-75" name="dpincode" value="{{ $delivery_details['dpincode'] }}" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">Readyness:</div> 
                                                                            <div class="field-group">


                                                                                <input type="text" name="readyness" value="{{ $challan->readyness ?? '' }}" > 
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
                                    </tbody>
                                </table>
                            </td>
                        </tr>


                    </table>

                    @php $item = App\Models\Item::get(); @endphp
                    
                    <table class="table-grid td-item-table no-border-top" cellspacing="0">

                        <tbody>
                            {{-- style="background: #ffa5d740;"  --}}
                            <tr class="sub-heading-item" >
                                <td rowspan="2" >S.No</td>
                                <td rowspan="2" style="width: 50px;">SAC Code</td>
                                <td rowspan="2" style="width: 50px;">HSN Code</td>
                                <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                <td rowspan="2" style=" width: 150px;">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> <select name="invoice_dayormonth">
                                    <option value="day"> Days</option>
                                    <option value="month">Months</option>
                                </select></td>
                                <td rowspan="2">Taxable Amount</td>
                                {{-- <td rowspan="2">Discount</td> --}}
                                <td colspan="3" style="text-align: center;">Tax Rate</td>
                                <td rowspan="2">Tax Amount</td>
                                <td rowspan="2">Total Amount</td>
                            </tr>

                            <tr class="heading">
                                <td>CGST</td>
                                <td>SGST</td>
                                <td>IGST</td>
                            </tr>
                             @foreach($challan_items as $challan_item)
                        <tr class="center item">
                                    <td class="space"><span class="remove-btn">X</span></td>
                                    <td class="sac">{{ $challan_item->sac_code ?? '' }}</td>
                                    <input type="hidden" class="psac" name="psac[]" value="{{ $challan_item->sac_code ?? '' }}" />
                                    <td class="hsn">{{ $challan_item->hsn_code ?? '' }}</td>
                                    <input type="hidden" class="phsn" name="phsn[]" value="{{ $challan_item->hsn_code ?? '' }}" />
                                    <td class="item-display">
                                        {{ $challan_item->description ?? '' }} 
                                        <input type="hidden" class="pfrom_date_hidden" value="{{ $challan_item->from_date}}" />
                                        <input type="hidden" class="pto_date_hidden" value="{{ $challan_item->to_date }}" />
                                       
                                    </td>
                                    <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $challan_item->description ?? '' }}"   />
                                    
                                    <input type="hidden" class="pname" name="pname[]" value="{{ $challan_item->item ?? '' }}"/>
                                    <td class="item" style="white-space: normal; word-wrap: break-word; max-width: 150px;">
                                        <select class="form-control select-2 select-item-product" name="item_id[]"
                                            style="width: 150px; white-space: normal; word-wrap: break-word;">
                                            <option value="">Please Select Product</option>
                                            @foreach($item as $it)
                                                <option value="{{ $it->id }}"
                                                    title="{{ $it->name }}"
                                                    {{ ($challan_item->item_id == $it->id) ? 'selected' : '' }}>
                                                    {{ $it->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="item_rate">
                                        <input class="td-input-width item-gross-total"  type="number" name="prate[]" value="{{ $challan_item->rate  ?? '' }}"  value=""  />
                                    </td>
                                    <td class="item_qty"><input class="td-input-width item-gross-total"  type="number"   name="pqty[]"  value="{{ $challan_item->quantity  ?? '' }}" /></td>
                                    <td class="item_pday"> <input class="td-input-width item-gross-total"  type="number"   name="pday[]" value="{{ $challan_item->days ?? '' }}" />
                                    </td>
                                    <td class="gross-amount">{{ $challan_item->gross_amount }}</td>
                                    {{-- <td class="my-discount"><input class="td-input-width item-discount"  type="number" name="pdiscount[]"  value="{{ $challan_item->discount }}"/></td> --}}
                                    <td class="cgst">{{ $challan_item->cgst }}</td>
                                    <input type="hidden" class="cgst" name="cgst[]" value="{{ $challan_item->cgst }}" />
                                    <td class="sgst">{{ $challan_item->sgst }}</td>
                                    <input type="hidden" class="sgst" name="sgst[]" value="{{ $challan_item->sgst }}" />
                                    <td class="igst">{{ $challan_item->igst }}</td>
                                    <input type="hidden" class="igst" name="igst[]" value="{{ $challan_item->igst }}" />
                                    <td class="tax-amount">{{ $challan_item->tax_amount }}</td>
                                    <td class="total-amount">{{ $challan_item->total_amount }}</td>
                                    
                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $challan_item->gross_amount }}" />
                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $challan_item->tax_amount }}" />
                                    <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $challan_item->total_amount }}" />
                                    <input type="hidden" class="invoice_product_id" name="invoice_product_id[]" value="{{ $challan_item->id }}" />
                        </tr>

                        @endforeach
                            <tr class="inser-div-before">
                                <td colspan="13">
                                    <center>
                                        <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">ADD ITEM</a>
                                    </center>
                                </td>
                            </tr>

                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td></td>
                                <td colspan="3">Tax Payable on Rev. Charge Basis: NO</td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $challan->net_amount }}
                                </td>
                                <td></td>
                                <td></td>
                                
                                {{-- <td></td> --}}
                                <td></td>
                                <td id="display-total-tax-amount">{{ $challan->total_tax }}</td>

                                    
                                <td id="display-grand-amount">
                                   {{ $challan->total_amount }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Amount in words :</td>
                                <td colspan="10">
                                 <input name="amount_in_words" id="amount_in_words" type="text" value="{{ $challan->amount_in_words }}" class="w-100" ></td>
                            </tr>
                        
                        </tbody>
                    </table>
                    <input name="total_gross_sum" id="total_gross_sum" type="hidden" value="{{ $challan->net_amount }}" >
                    <input name="total_tax_amount" id="total_tax_amount" type="hidden" value="{{ $challan->total_tax }}" >
                    <input name="total_grand_amount" id="total_grand_amount" type="hidden" value="{{ $challan->total_amount }}" >
                    <input name="total_net_discount" id="total_net_discount" type="hidden" value="{{ $challan->net_discount }}" >
                    <input name="customer_id" id="customer_id" type="hidden" value="{{ $challan->customer_id }}" >

                    <table class="billing-info no-border-top">
                        <tr class="bottom">
                            <td class="border-right">
                                <table>
                                    <tr>
                                        <td class="title center">
                                            <h3>Supply Address</h3>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                               <td class="border-right">
                                <table>
                                    <tr>
                                        <td class="title center">
                                        
                                             <select class="select-2 invoice-supply-address" name="supply_id" >
                                                <option>Select Supply Address</option>
                                                @foreach($supply_address as $da)
                                                    <option value="{{ $da->id }}" {{ ($challan->supply_id ==  $da->id) ? 'selected=""' : '' }} >{{ $da->venue }} {{ $da->address }}</option>
                                                @endforeach    
                                            </select>
                                            <p id="supplyaddress"></p>
                                            <input type="hidden" name="sstate" value="">
                                            <input type="hidden" name="svenue" value="">
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
                          
                        </tr>
                    </table>
                    <table>
                         <table class="conditions" style="width: 100%">
                        <thead>
                            <tr>
                                <th colspan="4">Terms & Conditions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.) E.&.O.E.</td>
                            </tr>
                            <tr>
                                <td>2.) Delhi courts shall be the only jurisdiction for any disputes.</td>
                            </tr>
                            
                        </tbody>
                    </table>
                        {{-- <tr>
                            <td>Start Date : <input type="date" name="start_date"  value="{{ $challan->start_date }}" /> End Date :<input type="date" value="{{ $challan->end_date }}" name="end_date" /></td>
                        </tr> --}}
                         <center>
                        <p class="center" style="padding-bottom: 10px;">This is a system generated challan
                             and does not require a signature.</p>
                    </center>
                    </table>

                    <table class="billing-info- center">
                        <tr>
                            {{-- <td><a href="{{ route('challan.email',['id'=>$challan->id]) }}" class="btn-print-edit">Email</a></td> --}}
                            {{-- <td><a href="{{ route('challan.print',['id'=>$challan->id]) }}" class="btn-print-edit">Print</a> --}}
                               <td>
                                <!-- Print Button -->
                                <a href="javascript:void(0);" 
                                class="btn-print-edit btn btn-primary" 
                                data-challan-id="{{ $challan->id }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#printChallanModal">
                                Print
                                </a>
                            </td>
                            {{-- <td><a href="{{ route('return.challan.print',['id'=>$challan->id]) }}" class="btn-print-edit">R. Cha. Print</a></td> --}}
                            
                            <td style="float: right;"><button  class="send btn-submit">Update</button>
                            </td>

                            @php
                                $returnChallan = \App\Models\PerformaInvoiceChallan::where('original_challan_id', $challan->id)->first();
                            @endphp

                            {{-- <td style="float: right;">
                                @if(!$returnChallan)
                                    <button type="button" 
                                            class="btn btn-primary btn-print-edit"
                                            onclick="window.location.href='{{ route('return.challan', ['id' => $challan->id]) }}'">
                                       Add R.Ch
                                    </button>
                                @else
                                    <button type="button" 
                                            class="btn btn-primary btn-print-edit"
                                            onclick="window.location.href='{{ route('challan.edit', ['id' => $returnChallan->id]) }}'" style="display:inline;">
                                           Edit R.Ch
                                    </button>
                                @endif
                            </td> --}}
                        </tr>
                    </table>
                </div>
                
            </form>

            <div class="modal fade" id="printChallanModal" tabindex="-1" aria-labelledby="printChallanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="printChallanForm" method="GET" action="{{ route('challan.print') }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="printChallanModalLabel">Print Challan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $copyLabels = ['Original', 'Duplicate', 'Triplicate'];
                                @endphp
                                @foreach ($copyLabels as $index => $copyLabel)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="copies[]" value="{{ $copyLabel }}" id="copy_{{ $index }}">
                                        <label class="form-check-label" for="copy_{{ $index }}">
                                            {{ $copyLabel }}
                                        </label>
                                    </div>
                                @endforeach

                                <!-- Hidden input for challan id -->
                                <input type="hidden" name="id" id="modalChallanId" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Print</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>

            <script>
        
                $("#add-more-btn").click(function(){
                    //alert('xd');
                             var myvar = '<tr class="center item">'+
                '                                    <td class="space"><span class="remove-btn">X</span></td>'+
                '                                    <td class="sac"></td>'+
                '                                    <input type="hidden" class="phsn" name="psac[]" value="" />'+
                '                                    <td class="hsn"></td>'+
                '                                    <input type="hidden" class="phsn" name="phsn[]" value="" />'+
                '                                    <td class="item-display"></td>'+
                '                                    <input type="hidden" class="pdescription"  name="pdescription[]" value="" />'+
                '                                    <input type="hidden" class="pfrom_date" name="pfrom_date[]" value="" />'+
                '                                    <input type="hidden" class="pto_date" name="pto_date[]" value="" />'+
                '                                    <input type="hidden" class="pname" name="pname[]" value="product name" />'+
                '                                  '+
                '                                    <td class="item" style="white-space: normal; word-wrap: break-word; max-width: 150px;">'+
                '                                        <select class="form-control select-2 select-item-product" name="item_id[]" style="width: 150px; white-space: normal; word-wrap: break-word;">'+
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
                // '                                    <td><input class="td-input-width item-discount" type="number" name="pdiscount[]" value="0"/></td>'+
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
                '                                    <input type="hidden" class="invoice_product_id" name="invoice_product_id[]" value="" />'+
                '                        </tr>';

                    //get_item_sum_with_tax();
                    $( myvar ).insertBefore(".inser-div-before");
                    $('.select-item-product').select2();
                    
                });
            </script>

            <script type="text/javascript" src="{{ asset('resources/js/challan.js?v='.time()) }}"></script>
        </div>
    </div>


   

<!-- Bootstrap CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
     $(function(){
    $('.main-gst-selection').change();
    
    $('.invoice-supply-address').find('option[value={{ $challan->supply_id }}]').attr("selected",true);


    $('.invoice-supply-address').change();
   // $('input[name="customer_type"]').change();
        setTimeout(function() {
                @if( $challan->customer_id != 0)
                    $('.invoice-customer-type').find('option[value={{ $challan->customer_id }}]').attr("selected",true);
                    $(".invoice-customer-type").select2();
                    $(".invoice-customer-type").change();  
                @endif
        }, 1000);
        
        if($('input[name="daddress"]').val()==''){  
        //alert('xd');  
          //  $('.invoice-delivery-address').find('option[value="{{ $challan->delivery_id }}"]').attr("selected",true);
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

<script>
   $(document).ready(function() {
    $('.btn-print-edit').on('click', function() {
        var challanId = $(this).data('challan-id');
        $('#modalChallanId').val(challanId);
    });
});

</script>

@endsection