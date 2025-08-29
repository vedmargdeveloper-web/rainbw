@extends(_app())

@section('title', 'Edit Pitch')

@section('content')

    <div class="main-container">
        <style type="text/css">
            .dstate-div input{
                    width: 164px;
            }
            .width-70{
                width: 69% !important;
            }
        </style>
        <div class="content-wrapper">

            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">

            <?php
               $customer_type =  App\Models\CustomerTypeMaster::get();
               $delivery_address =  App\Models\Address::where('type','delivery')->get();
               $supply_address =  App\Models\Address::where('type','supply')->get();
               $meta =  App\Models\Meta::all();
               $leads =  App\Models\Lead::get();
               $sources =  App\Models\Source::get();
               $occasion =  App\Models\Occasion::get();
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
        
             

           

                <div class="invoice-box">
                   

                    <table class="billing-info">
                      
                    
                    
                        <tr class="td-no-padding">
                           
                            <span style="display:none ;" id="default-invoice-no">
                                <?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInquiry" ?>
                            </span>

                            <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/INV/$totalInquiry"; ?> 
 
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Unique ID: </div>
                                <div class="field-group">
                                   
                                    <select name="unique_id" id="unique_id">
                                        @foreach($inquiry_all as $inq)
                                            <option value="{{ $inq->id }}"> {{ $inq->unique_id }}</option>
                                         @endforeach
                                    </select> 
                                </div>
                            </td>

                             <td class="text-right td-no-padding" >
                                <div class="label"></div>
                                <div class="field-group" >
                                    Lead Status
                                    <b>
                                    @foreach($leads as $lead)
                                        @if($inquiry->leads_id == $lead->id)
                                            {{ $lead->lead }}
                                        @endif
                                    @endforeach
                                    </b>
                                     |
                                    Source
                                    <b>@foreach($sources as $source)
                                        @if($inquiry->sources_id == $source->id)
                                            {{ $source->source }}
                                        @endif
                                    @endforeach
                                    </b>
                                
                                </div>
                            </td>
                            
                        </tr>
                        <tr class="td-no-padding">
                            <td></td>
                            <td class="text-right td-no-padding">
                               {{--  --}}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="">
                                <div class="label">Customer Type:  </div>
                                <div class="field-group">
                                    <span id="cp_type"></span>
                                    @foreach($customer_type as $ct)
                                        <label for="{{ $ct->code }}"><input type="radio"  id="{{ $ct->code }}" {{ ($inquiry->customer_type == $ct->id )  ? 'checked=""' : '' }} name="customer_type" value="{{ $ct->id }}"> {{ $ct->type }}</label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                {{-- <b>Delivery Address</b> --}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="label">Client:</div> 
                                                <div class="field-group">
                                                    <input type="text" name="client_name" value="{{ $customer['client_name'] ?? '' }}" class="w-100" >
                                                    {{-- <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;"> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100"  name="caddress" value="{{ $customer['caddress'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100"  name="caddress1" value="{{ $customer['caddress1'] ?? '' }}">
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>

                            <td>
                                <table>
                                    <tbody>
                                        
                                        <tr class="venue_name" >
                                            <td>
                                                <div class="label">Venue Name :</div> 
                                                <div class="field-group td-city-width">
                                                     <input type="text" name="venue_name" value="{{ $venue_details['venue_name'] }}"  class="w-100 mt-2" id="venue_name" required="" >
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress" value="{{ $venue_details['daddress'] ?? '' }}" required="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress1" value="{{ $venue_details['daddress1']  ?? '' }}" value="" >
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
                                                                <div class="ccity-div"  style=" margin-left: -6px;">
                                                                    {{-- <input type="text" name="ccity" class="custom-pincode" value="" > --}}
                                                                    <select class="form-control" name="ccity">
                                                                        @foreach($city as $st)
                                                                                <option value="{{ $st->id }}" {{ ( $customer['ccity'] ==  $st->id ) ? 'selected' : ''   }}>{{ $st->city }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="label label-state">State :</div> 
                                                            <div class="field-group state-select">
                                                                <div class="cstate-div" >
                                                                     <select class="form-control" name="cstate">
                                                                        @foreach($state as $st)
                                                                                <option value="{{ $st->id }}" {{ ( $customer['cstate'] ==  $st->id ) ? 'selected' : ''   }}>{{ $st->state }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                          <tr class="pincode-inner-tr"  >
                                            <td colspan="2">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Pincode :</div> 
                                                            <div class="field-group">
                                                                <input type="number" name="cpincode"   value="{{ $customer['cpincode'] ?? '' }}" class="custom-pincode">
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">Landmark</div> 
                                                            <div class="field-group">
                                                                <input type="text" class="ml-2" name="clandmark" value="{{ $customer['clandmark'] ?? '' }}"  class="w-100">
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
                                            <td colspan="2">
                                                <div class="label">Contact person :</div> 
                                                <div class="field-group width-full contact-person" >
                                                    <input type="text" class="w-100" name="contact_person_c" value="{{ $customer['contact_person_c'] ?? '' }}" required >
                                                </div>
                                            </td>
                                        </tr>
                                         <tr class="pincode-inner-tr"  >
                                            <td colspan="2">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Mobile:</div> 
                                                            <div class="field-group">
                                                                  <input type="number" class="w-100" name="cmobile" value="{{ $customer['cmobile'] ?? '' }}"  required=''>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">WhatsApp</div> 
                                                            <div class="field-group">
                                                                <input type="number" class="w-100" name="cwhatsapp" value="{{ $customer['cwhatsapp'] ?? '' }}"  required=''>
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">Email :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="cemail" value="{{ $customer['cemail'] ?? '' }}" required >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">GSTIN :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="cgstin" value="{{ $customer['cgstin'] ?? '' }}" >
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
                                                         
                                                            <div class="field-group">
                                                                <select class="form-control" name="occasion_id">
                                                                        @foreach($occasion as $st)
                                                                                <option value="{{ $st->id }}"  {{ ( $inquiry->occasion_id == $st->id ) ? 'selected=""' :'' }}>{{ $st->occasion }} </option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">Readyness</div> 
                                                            <div class="field-group">
                                                                <input type="text" class="ml-2" name="creadyness" value="{{ $customer['creadyness'] ?? '' }}" class="w-100" required="">
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
                                       <tr>
                                            <td>
                                               <table>
                                                    <tbody>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="label">Landmark :</div> 
                                                                    <div class="field-group width-full">
                                                                        <input type="text" class="w-100" name="dlandmark" value="{{ $venue_details['dlandmark'] ?? '' }}" style="margin-left: -8px;" >
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
                                                                            <div class="field-group">
                                                                                {{-- <input type="text" class="w-75" name="dcity" value="" >  --}}
                                                                                <div class="dcity-div">
                                                                                    <select class="form-control" name="dcity">
                                                                                        @foreach($city as $st)
                                                                                                <option value="{{ $st->id }}" {{ ($venue_details['dcity'] == $st->id ) ? 'selected=""'  : '' }} >{{ $st->city }} </option>
                                                                                        @endforeach
                                                                                    </select>  
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">State :</div> 
                                                                            <div class="field-group">
                                                                               <div class="dstate-div"> 
                                                                                    <select class="form-control" name="dstate" {{ ( $venue_details['dstate'] == $st->id ) ? 'selected' : ''  }}>
                                                                                        @foreach($state as $st)
                                                                                                <option value="{{ $st->id }}">{{ $st->state }} </option>
                                                                                        @endforeach
                                                                                    </select>  
                                                                               </div>
                                                                               {{--  <input type="text" name="dstate" value="" >  --}}
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
                                                    <input type="text" class="w-100" name="dperson" value="{{ $venue_details['dperson'] ?? '' }}" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group width-full">
                                                    <input type="number" class="w-100" name="dmobile" value="{{ $venue_details['dmobile'] ?? '' }}" >
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
                                                                                <input type="number" class="w-75" name="dpincode" value="{{ $venue_details['dpincode'] ?? '' }}" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">Readyness:</div> 
                                                                            <div class="field-group">
                                                                                <input type="text" name="dreadyness" value="{{ $venue_details['readyness'] ?? '' }}" > 
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
                                                <div class="label">Remark : </div> 
                                                <div class="field-group">
                                                    <input type="text" name="remark"  value="{{ $venue_details['remark'] ?? '' }}" class="" >
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
                        $inquiry_items = App\Models\EnquireItem::where('inquiry_id',$inquiry->id)->get();
                        
                    @endphp
                    
                     @php $item = App\Models\Item::get(); @endphp
                    
                    <table class="table-grid td-item-table no-border-top" cellspacing="0">

                        <tbody>
                            {{-- style="background: #ffa5d740;"  --}}
                            <tr class="sub-heading-item" >
                                <td rowspan="2" >S.No</td>
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

                            @php
                                $invoice_items =  App\Models\QuotationsItem::where('invoice_id',$quotation->id)->get();
                                $count = 0;
                            @endphp
                             @foreach($invoice_items as $invoice_item)
                        <tr class="center item">
                                    <td class="space"> {{ ++$count }}</td>
                                    <td class="hsn">{{ $invoice_item->hsn_code ?? '' }}</td>
                                    <input type="hidden" class="phsn" name="phsn[]" value="{{ $invoice_item->hsn_code ?? '' }}" />
                                    <td class="item-display">{{ $invoice_item->description ?? '' }}</td>
                                    <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $invoice_item->description ?? '' }}"   />
                                    <input type="hidden" class="pname" name="pname[]" value="{{ $invoice_item->item ?? '' }}"/>
                                  
                                    <td class="item">
                                           @foreach($item_list as $it)
                                                    @if($invoice_item->item_id==$it->id)
                                                        {{ $it->name }}
                                                    @endif
                                           @endforeach
                                    </td>
                                   
                                    <td class="item_rate">
                                        {{ $invoice_item->rate  ?? '' }}
                                    </td>
                                    <td class="item_qty">{{ $invoice_item->quantity  ?? '' }}</td>
                                    <td class="item_pday"> {{ $invoice_item->days ?? '' }}
                                    </td>
                                    <td class="gross-amount">{{ $invoice_item->gross_amount }}</td>
                                    <td>{{ $invoice_item->discount }}</td>
                                    <td class="cgst">{{ $invoice_item->cgst }}</td>
                                    <td class="sgst">{{ $invoice_item->sgst }}</td>
                                    <td class="igst">{{ $invoice_item->igst }}</td>
                                    <td class="tax-amount">{{ $invoice_item->tax_amount }}</td>
                                    <td class="total-amount">{{ $invoice_item->total_amount }}</td>
                                  
                        </tr>

                        @endforeach

                           

                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="3"></td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $quotation->net_amount }}
                                </td>
                                <td></td>
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $quotation->total_tax }}</td>

                                    
                                <td id="display-grand-amount">
                                   {{ $quotation->total_amount }}
                                </td>
                            </tr>
                            
                        
                        </tbody>
                    </table>
                </div>
                

                @php
                $pitches = [];

                $pitches  = $quotation->pitch;
                
                if( count($pitches) <= 0 ){
                    $pitches  = [];
                }
                $count = 0;
              
                @endphp
              
                @foreach($pitches as $pitch)

                @php
                    $item_id  = json_decode($pitch->item_id);
                    $prate  = json_decode($pitch->prate);
                    $phsn  = json_decode($pitch->phsn);
                    $pname  = json_decode($pitch->pname);
                    $pdescription  = json_decode($pitch->pdescription);
                    $product_id  = json_decode($pitch->product_id);
                    $qty  = json_decode($pitch->qty);
                    $days  = json_decode($pitch->days);
                    $gross_amount  = json_decode($pitch->gross_amount);
                    $discount  = json_decode($pitch->discount);
                    $cgst  = json_decode($pitch->cgst);
                    $sgst  = json_decode($pitch->sgst);
                    $igst  = json_decode($pitch->igst);
                    $tax_amount  = json_decode($pitch->tax_amount);
                    $total_amount  = json_decode($pitch->total_amount);
                    $quotation_id  = $pitch->quotation_id;
                  //  dd($quotation_id);
                @endphp
                <form action="{{ route('pitch.update',['pitch'=>$pitch->id]) }}" method="post" id="invoice-submit">
                     @method('PATCH')
                     @csrf
                    <div class="invoice-box">
                        <table class="billing-info">
                            <tr>
                                <td> <b>Pitch {{ ++$count }} </b></td>
                                <td colspan="1" class="text-center">
                                    Lead Status
                                    <b>@foreach($leads as $lead)
                                        @if($inquiry->leads_id == $lead->id)
                                            {{ $lead->lead }}
                                        @endif
                                    @endforeach
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="label">Date:</div> 
                                                    <div class="field-group">
                                                        <input type="date" name="date" value="{{ $pitch->date  }}" class="w-100"  required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Minutes of Discussion (MOD)</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  value="{{ $pitch->date  }}" name="mod" value="" required >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Revised Quote</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="revised_quote" value="{{ $pitch->revised_quote  }}" required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Next Appointment</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="next_appointment" value="{{ $pitch->next_appointment  }}" required>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <table>
                                        <tbody>
                                            
                                            <tr class="venue_name" >
                                               {{--  <td>
                                                    <div class="label">Venue Name :</div> 
                                                    <div class="field-group td-city-width">
                                                         <input type="text" name="venue_name" value="{{ $venue_details['venue_name'] }}"  class="w-100 mt-2" id="venue_name" required="" >
                                                    </div>
                                                   
                                                </td> --}}
                                            </tr>
                                            <tr>
                                               {{--  <td>
                                                    <div class="label">Address :</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100" name="daddress" value="{{ $venue_details['daddress'] ?? '' }}" required="" >
                                                    </div>
                                                </td> --}}
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        
                        <table class="table-grid td-item-table no-border-top" cellspacing="0">

                            <tbody>
                               
                                <tr class="sub-heading-item" >
                                    <td rowspan="2" >S.No</td>
                                    <td rowspan="2" style="width: 75px;">HSN Code</td>
                                    <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                    <td rowspan="2">Item</td>
                                    <td rowspan="2">Rate</td>
                                    <td rowspan="2">Qty</td>
                                    <td rowspan="2"> <select name="dayormonth">
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
                                
                                 @foreach($item_id as $key => $item)
                                <tr class="center item">
                                            <td class="space"><span class="remove-btn">X</span></td>
                                            <td class="hsn">{{ $phsn[$key] ?? '' }}</td>
                                            <input type="hidden" class="phsn" name="phsn[]" value="{{ $phsn[$key] ?? '' }}" />
                                            <td class="item-display">{{ $pdescription[$key] ?? '' }}</td>
                                            <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $pdescription[$key] ?? '' }}"   />
                                            <input type="hidden" class="pname" name="pname[]" value="{{ $pname[$key] ?? '' }}"/>
                                          
                                            <td class="item">
                                                <select class="form-control select-2 select-item-product" name="item_id[]" >
                                                        <option value="">Please Select Product</option>
                                                        @foreach($item_list as $it)
                                                            <option value="{{ $it->id }}"  {{ ($item_id[$key]==$it->id) ? 'selected' : ''  }} >{{ $it->name }}</option>
                                                        @endforeach
                                                </select>
                                            </td>
                                           
                                            <td class="item_rate">
                                                <input class="td-input-width item-gross-total"  type="number" name="prate[]" value="{{ $prate[$key]  ?? '' }}"  value=""  />
                                            </td>
                                            <td class="item_qty"><input class="td-input-width item-gross-total"  type="number"   name="pqty[]"  value="{{ $qty[$key]  ?? '' }}" /></td>
                                            <td class="item_pday"> <input class="td-input-width item-gross-total"  type="number"   name="pday[]" value="{{ $days[$key] ?? '' }}" />
                                            </td>
                                            <td class="gross-amount">{{ $gross_amount[$key] ?? '' }}</td>
                                            <td><input class="td-input-width item-discount"  type="number" name="pdiscount[]"  value="{{ $discount[$key] }}"/></td>
                                            <td class="cgst">{{ $invoice_item->cgst }}</td>
                                            <input type="hidden" class="cgst" name="cgst[]" value="{{ $cgst[$key] }}" />
                                            <td class="sgst">{{ $invoice_item->sgst }}</td>
                                            <input type="hidden" class="sgst" name="sgst[]" value="{{ $sgst[$key] }}" />
                                            <td class="igst">{{ $invoice_item->igst }}</td>
                                            <input type="hidden" class="igst" name="igst[]" value="{{ $igst[$key] }}" />
                                            <td class="tax-amount">{{ $tax_amount[$key] ?? '' }}</td>
                                            <td class="total-amount">{{ $total_amount[$key]  ?? ''}}</td>
                                            
                                            <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $gross_amount[$key] ?? '' }}" />
                                            <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $tax_amount[$key] ?? '' }} " />
                                            <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $total_amount[$key]  ?? ''}}" />
                                            <input type="hidden" class="invoice_product_id" name="product_id[]" value="{{ $product_id[$key] }}" />
                                </tr>

                            @endforeach     

                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="3"></td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $quotation->net_amount }}
                                </td>
                                <td></td>
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $quotation->total_tax }}</td>

                                    
                                <td id="display-grand-amount">
                                   {{ $quotation->total_amount }}
                                </td>
                            </tr>
                              
                            
                            </tbody>
                        </table>

                        <table>
                            <tr>
                                <td>
                                    <button class="btn btn-primary">Update</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" value="{{ $quotation->id  }}" name="quotation_id">
                </form>
                @endforeach


                 <form action="{{ route('pitch.store') }}" method="post" id="invoice-submit">
                     @csrf
                    <div class="invoice-box">
                        <table class="billing-info">
                            <tr>
                                <td> <b>Create Pitch </b></td>
                                <td colspan="1" class="text-center">
                                    Lead Status
                                    <b>@foreach($leads as $lead)
                                        @if($inquiry->leads_id == $lead->id)
                                            {{ $lead->lead }}
                                        @endif
                                    @endforeach
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="label">Date:</div> 
                                                    <div class="field-group">
                                                        <input type="date" name="date" value="" class="w-100"  required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Minutes of Discussion (MOD)</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="mod" value="" required >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Revised Quote</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="revised_quote" value="" required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Next Appointment</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="next_appointment" value="" required>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <table>
                                        <tbody>
                                            
                                            <tr class="venue_name" >
                                               {{--  <td>
                                                    <div class="label">Venue Name :</div> 
                                                    <div class="field-group td-city-width">
                                                         <input type="text" name="venue_name" value="{{ $venue_details['venue_name'] }}"  class="w-100 mt-2" id="venue_name" required="" >
                                                    </div>
                                                   
                                                </td> --}}
                                            </tr>
                                            <tr>
                                               {{--  <td>
                                                    <div class="label">Address :</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100" name="daddress" value="{{ $venue_details['daddress'] ?? '' }}" required="" >
                                                    </div>
                                                </td> --}}
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        
                        <table class="table-grid td-item-table no-border-top" cellspacing="0">

                            <tbody>
                               
                                <tr class="sub-heading-item" >
                                    <td rowspan="2" >S.No</td>
                                    <td rowspan="2" style="width: 75px;">HSN Code</td>
                                    <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                    <td rowspan="2">Item</td>
                                    <td rowspan="2">Rate</td>
                                    <td rowspan="2">Qty</td>
                                    <td rowspan="2"> <select name="dayormonth">
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
                                @php
                                    $invoice_items =  App\Models\QuotationsItem::where('invoice_id',$quotation->id)->get();
                                @endphp
                                 @foreach($invoice_items as $invoice_item)
                                <tr class="center item">
                                            <td class="space"><span class="remove-btn">X</span></td>
                                            <td class="hsn">{{ $invoice_item->hsn_code ?? '' }}</td>
                                            <input type="hidden" class="phsn" name="phsn[]" value="{{ $invoice_item->hsn_code ?? '' }}" />
                                            <td class="item-display">{{ $invoice_item->description ?? '' }}</td>
                                            <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $invoice_item->description ?? '' }}"   />
                                            <input type="hidden" class="pname" name="pname[]" value="{{ $invoice_item->item ?? '' }}"/>
                                          
                                            <td class="item">
                                                <select class="form-control select-2 select-item-product" name="item_id[]" >
                                                        <option value="">Please Select Product</option>
                                                        @foreach($item_list as $it)
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
                                            <td class="total-amount">{{ $invoice_item->total_amount }}</td>
                                            
                                            <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $invoice_item->gross_amount }}" />
                                            <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $invoice_item->tax_amount }}" />
                                            <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $invoice_item->total_amount }}" />
                                            <input type="hidden" class="invoice_product_id" name="product_id[]" value="{{ $invoice_item->id }}" />
                                </tr>

                            @endforeach     

                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="3"></td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $quotation->net_amount }}
                                </td>
                                <td></td>
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $quotation->total_tax }}</td>

                                    
                                <td id="display-grand-amount">
                                   {{ $quotation->total_amount }}
                                </td>
                            </tr>
                              
                            
                            </tbody>
                        </table>

                        <table>
                            <tr>
                                <td>
                                    <button class="btn btn-primary">Save</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" value="{{ $quotation->id  }}" name="quotation_id">
                </form>

            <script>
        
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

            <script type="text/javascript" src="{{ asset('resources/js/invoice.js?v='.time()) }}"></script>

        </div>

    </div>


@endsection