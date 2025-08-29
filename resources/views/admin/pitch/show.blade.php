@extends(_app())

@section('title', 'Edit Pitch')

@section('content')
@php
    $revised = 0;
@endphp
    <div class="main-container">
        <style type="text/css">
            table{
                border-collapse: unset!important;
            }
            .dstate-div input{
                    width: 164px;
            }
            .td-item-table tr td {
                border: 1px solid #000;
                border-left: unset!important;
                border-bottom: unset!important;
            }
            .width-70{
                width: 69% !important;
            }
            .billing-info tr td{
                padding: 0;
            }
            .billing-info tr td{
                width: unset!important;
            }
            .billing-info.main tr td>div.label{
                width: 95%!important;
            }
            .only-readable {
                border-bottom: 2px solid #000;
            }

            .invoice-box table.billing-info.main td:nth-child(5){
                width: 20%!important;
            }
            .invoice-box table.billing-info.main td:nth-child(2){
                width: 15%!important;
            }
            .invoice-box table.billing-info.main td:first-child{
                width: 15%!important;
            }
            .billing-info td>div.field-group{
                width: 150px!important;
            }
        </style>
        <div class="content-wrapper">

            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">

            <?php
               $customer_type =  App\Models\CustomerTypeMaster::get();
               $delivery_address =  App\Models\Address::where('type','delivery')->get();
               $supply_address =  App\Models\Address::where('type','supply')->get();
               $meta =  App\Models\Meta::all();
               $leads =  App\Models\Lead::where('lead_heads_id',2)->get();
               $sources =  App\Models\Source::get();
               $occasion =  App\Models\Occasion::get();
               $gstMaster =  App\Models\GstMaster::all();
               $term_and_conditions = $meta->where('meta_name', 'term')->first();
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
                $gst_details = json_decode($quotation->gst_details,true);

            @endphp
            <div class="cstate-div-default" style="display: none;">{{ $gst_details['state']  ?? '' }}</div>
                <div class="invoice-box"> 
                    <table class="billing-info main tn-billing-info-top">
                        <tr class="td-no-padding">
                           
                                <span style="display:none ;" id="default-invoice-no">
                                <?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInquiry" ?>
                                </span>
                                <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/INV/$totalInquiry"; ?> 
                                <td><div class="label">Unique ID:</div> </td>
                                <td >
                                    @foreach($inquiry_all as $inq)
                                            @if($quotation->enquire_id == $inq->id)
                                                    {{ $inq->unique_id }}
                                            @endif{{--   <option value="{{ $inq->id }}" {{ ($quotation->enquire_id == $inq->id)  ? 'selected'  : '' }}> </option> --}}
                                    @endforeach

                                    {{-- <select name="unique_id" id="unique_id" readonly="readonly">
                                        @foreach($inquiry_all as $inq)
                                            @if($quotation->enquire_id == $inq->id)
                                                    {{ $inq->unique_id }}
                                            @endif
                                            <option value="{{ $inq->id }}" {{ ($quotation->enquire_id == $inq->id)  ? 'selected'  : '' }}> </option>
                                        @endforeach
                                    </select>  --}}
                            </td>
                            <td></td>
                            <td colspan="3" style="text-align: center;">
                            <b>Lead Status : </b>
                             <b>
                                    {{ $quotation->leadstatus ? $quotation->leadstatus->status : ''   }}   
                                </b>
                            </td>

                            <td><div class="label">Source:</div></td>
                            <td >
                            <b>
                            @foreach($sources as $source)
                                @if($inquiry->sources_id == $source->id)
                                    {{ $source->source }}
                                @endif
                            @endforeach
                            </b>
                            </td>   
                        </tr>
                       
                        <tr class="">
                          
                            <td class="">
                                 <div class="label">Customer Type:</div>  
                                
                            </td>
                            <td colspan="3">
                                <div class="only-readable">
                                    <span id="cp_type"></span>
                                    @foreach($customer_type as $ct)
                                    {{ ($inquiry->customer_type == $ct->id )  ? $ct->type : '' }}
                                    
                                    {{--     <label for="{{ $ct->code }}"><input type="radio"  id="{{ $ct->code }}" {{ ($inquiry->customer_type == $ct->id )  ? 'checked=""' : '' }} name="customer_type" value="{{ $ct->id }}"> {{ $ct->type }}</label> --}}
                                    @endforeach
                                </div>
                            </td>
                            
                            <td >
                                <div class="label">Venu Name :  </div>
                            </td>
                            <td colspan="3">
                                <div class="only-readable">
                                    {{ $venue_details['venue_name'] ?? '' }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="label">Client:</div></td>
                            <td colspan="3"><div class="only-readable">
                                                    {{ $customer['client_name'] ?? '' }}
                                                    {{-- <input type="text" name="company_name "  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;"> --}}</div>
                            </td>
                            <td><div class="label">Address :</div></td>
                            <td colspan="3"><div class="only-readable">
                                                    {{ $customer['caddress'] ?? '' }}
                                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="label">Venue Name :</div> </td>
                            <td colspan="3"><div class="only-readable td-city-width">
                                                     {{ $venue_details['venue_name'] }}
                                                </div>
                            </td>
                            <td><div class="label">Address :</div></td>
                            <td colspan="3"> <div class="only-readable">
                                                    {{ $venue_details['daddress'] ?? '' }}
                                </div>
                            </td>
                        </tr>
                        

                        <tr>
                            <td><div class="label">City : </div></td>
                            <td><div class="only-readable ">
                                                                <div class=""  >
                                                                    {{-- <input type="text" name="ccity" readonly="readonly" class="custom-pincode" value="" > --}}
                                                                    {{-- <select class="form-control" name="ccity">
                                                                        @foreach($city as $st)
                                                                                <option value="{{ $st->id }}" {{ ( $customer['ccity'] ==  $st->id ) ? 'selected' : ''   }}>{{ $st->city }} </option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    
                                                                    
                                                                   {{--  <?php $cst = ''; ?>
                                                                    @foreach($city as $st)
                                                                        @php  if( $customer['ccity'] ==  $st->city ){
                                                                                $cst =  $st->city;
                                                                            } 
                                                                        @endphp
                                                                    @endforeach --}}
                                                                    

                        {{ $customer['ccity'] ?? '' }}
                                                                     
                            </div> 
                            </td><td> <div class="ccity-div" id="clientstate">{{ $customer['cstate'] ?? '' }}</div></td>
                            <td><div class="label">Pincode :</div></td>
                            <td> <div class="only-readable">
                                                                {{ $customer['cpincode'] ?? '' }}
                                                            </div></td>

                            <td ><div class="label label-state">Landmark</div> </td>
                            <td colspan="3"><div class="only-readable">
                                                                {{ $customer['clandmark'] ?? '' }}
                                                            </div></td>
                        </tr>
                        <tr>
                            <td ><div class="label">Contact person :</div></td>
                            <td colspan="3"><div class="only-readable" >
                                                    {{ $customer['contact_person_c'] ?? '' }}
                                                </div></td>
                            
                            <td><div class="label">Landmark :</div></td>
                            <td colspan="3"><div class="only-readable ">
                                                                        {{ $venue_details['dlandmark'] ?? '' }}
                                                                    </div></td>
                        </tr>
                        <tr>
                            <td> <div class="label">Mobile:</div></td>
                            <td><div class="only-readable">
                                                                  {{ $customer['cmobile'] ?? '' }}
                                                            </div></td>
                            <td><div class="label label-state label-whatsapp">WhatsApp</div></td>
                            <td><div class="only-readable td-whatsapp">
                                                                {{ $customer['cwhatsapp'] ?? '' }}
                                                            </div></td>
                            <td><div class="label">City :</div></td>
                            <td><div class="only-readable">
                                                                               
                                                                                {{-- <div class="dcity-div">
                                                                                    <select class="form-control-" name="dcity">
                                                                                        @foreach($city as $st)
                                                                                                <option value="{{ $st->id }}" {{ ($venue_details['dcity'] == $st->id ) ? 'selected=""'  : '' }} >{{ $st->city }} </option>
                                                                                        @endforeach
                                                                                    </select>  
                                                                                </div> --}}
                                                                                 {{ $venue_details['dcity'] }}
                                                                            </div></td>
                            <td><div class="label label-state">State :</div></td>
                            <td><div class="only-readable">
                                                                               {{-- <div class="dstate-div"> 
                                                                                    <select class="form-control-" name="dstate" {{ ( strtolower($venue_details['dstate']) == strtolower($st->state) ) ? 'selected' : ''  }}>
                                                                                        @foreach($state as $st)
                                                                                                <option value="{{ $st->id }}">{{ $st->state }} </option>
                                                                                        @endforeach
                                                                                    </select>  
                                                                               </div> --}}
                                                                            {{ ucfirst($venue_details['dstate']) ?? '' }}
                                                                            </div></td>
                        </tr>
                        <tr>
                            <td><div class="label">Email :</div></td>
                            <td colspan="3"> <div class="only-readable">
                                                    {{ $customer['cemail'] ?? '' }}
                            </div></td>
                            <td> <div class="label">Contact Person :</div></td>
                            <td colspan="3"><div class=" only-readable ">
                                                    {{ $venue_details['dperson'] ?? '' }}
                                                </div></td>
                        </tr>
                        <tr>
                            <td><div class="label">GSTIN :</div></td>
                            <td colspan="3"><div class=" only-readable ">
                                                    {{ $customer['cgstin'] ?? '' }}
                                                </div></td>
                            <td><div class="label">Mobile :</div></td>
                            <td colspan="3"><div class="  only-readable ">
                                                    {{ $venue_details['dmobile'] ?? '' }}
                                                </div></td>
                        </tr>
                        <tr>
                            <td><div class="label">Occasion:</div></td>
                            <td><div class="only-readable">
                                                                @foreach($occasion as $st)
                                                                            @if($inquiry->occasion_id == $st->id )
                                                                                {{ $st->occasion }}
                                                                            @endif
                                                                @endforeach
                                                            </div></td>
                            <td><div class="label label-state label-whatsapp">Readyness</div></td>
                            <td><div class="only-readable ">
                                                                {{ $customer['creadyness'] ?? '' }}
                                                            </div></td>
                            <td><div class="label">Pincode :</div> </td>
                            <td><div class="only-readable">
                                                                                {{ $venue_details['dpincode'] ?? '' }}
                                                                            </div></td>
                            <td><div class="label label-state label-whatsapp">Readyness:</div></td>
                            <td> <div class="only-readable ">
                                                                                {{ $venue_details['readyness'] ?? '' }}
                            </div></td>
                        </tr>
                        <tr class="">
                          
                            <td class="">
                               {{--   <div class="label">Customer Type:</div>   --}}
                                
                            </td>
                            <td colspan="3">
                                {{-- <div class="only-readable">
                                    <span id="cp_type"></span>
                                    @foreach($customer_type as $ct)
                                    {{ ($inquiry->customer_type == $ct->id )  ? $ct->type : '' }}
                                
                                    @endforeach
                                </div> --}}
                            </td>
                            
                           <td >
                                <div class="label">Remark : </div>
                            </td>
                            <td colspan="3">
                                <div class="only-readable">
                                    {{ $venue_details['remark'] ?? '' }}
                                </div>
                            </td>
                        </tr>
                        
                    </table>
                    @php 
                        $item_list = App\Models\Item::get();
                        // $inquiry_items = App\Models\EnquireItem::where('inquiry_id',$inquiry->id)->get();            
                       //dd($inquiry_items);
                    @endphp
                  {{--   @php $item = App\Models\Item::get(); @endphp --}}
                    <table class="table-grid td-item-table no-border-top " cellspacing="0">
                        <tbody>   
                            <tr class="sub-heading-item" >
                              {{--   <td rowspan="2" >S.No</td>
                                <td rowspan="2" style="width: 75px;">HSN Code</td>
                                <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td> --}}
                                <td rowspan="2">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> 
                                    {{ ($quotation->dayormonth == 'day') ? 'Day' : 'Month'  }}
                                    {{-- <select name="invoice_dayormonth">
                                        <option value="day"  {{ ($quotation->dayormonth == 'day') ? 'selected=""' : ''  }}> Days</option>
                                        <option value="month" {{ ($quotation->dayormonth == 'month') ? 'selected=""' : ''  }}>Months</option>
                                    </select> --}}
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
                            //dd($quotation);
                            $invoice_items =  App\Models\QuotationsItem::where('invoice_id',$quotation->id)->get();
                           // dd($invoice_items);
                            $count = 0;
                            @endphp
                            @foreach($invoice_items as $invoice_item)
                                    <tr class="center item">
                                               {{--  <td class="space"> {{ ++$count }}</td>
                                                <td class="hsn">{{ $invoice_item->hsn_code ?? '' }}</td>
                                                <input type="hidden" class="phsn" name="phsn[]" value="{{ $invoice_item->hsn_code ?? '' }}" />
                                                <td class="item-display">{{ $invoice_item->description ?? '' }}</td>
                                                <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $invoice_item->description ?? '' }}"   /> --}}
                                                <input type="hidden" class="pname" name="pname[]" value="{{ $invoice_item->item ?? '' }}"/>       
                                                <td class="item">
                                                       @foreach($item_list as $it)
                                                                @if($invoice_item->item_id==$it->id)
                                                                    {{ $it->name }}
                                                                @endif
                                                       @endforeach
                                                </td>
                                                <td class="item_rate only-readable">
                                                    {{ $invoice_item->rate  ?? '' }}
                                                </td>
                                                <td class="item_qty only-readable">{{ $invoice_item->quantity  ?? '' }}</td>
                                                <td class="item_pday only-readable"> {{ $invoice_item->days ?? '' }}
                                                </td>
                                                <td class="gross-amount-- only-readable">{{ $invoice_item->gross_amount }}</td>
                                                <td class="only-readable">{{ $invoice_item->discount }}</td>
                                                <td class="cgst only-readable">{{ $invoice_item->cgst }}</td>
                                                <td class="sgst only-readable">{{ $invoice_item->sgst }}</td>
                                                <td class="igst only-readable">{{ $invoice_item->igst }}</td>
                                                <td class=" tax-amount-- only-readable">{{ $invoice_item->tax_amount }}</td>
                                                <td class="total-amount--">{{ $invoice_item->total_amount }}</td>                  
                                    </tr>
                            @endforeach
                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="3"></td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount-">{{ $quotation->net_amount }}
                                </td>
                                <td></td>
                                <td id="display-total-tax-amount-">{{ $quotation->total_tax }}</td>
                                <td id="display-grand-amount-">
                                   {{ $quotation->total_amount }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
                <br/>
                @php
                $pitches = $quotation->pitch;
                if($pitches && count($pitches) <= 0 ){
                    $pitches  = [];
                }
                $totalValue = count($pitches);
                $count = 0;
                @endphp
                @foreach($pitches as $pitch_key => $pitch)
                @php
                    $item_id  = json_decode($pitch->item_id);
                    $prate  = json_decode($pitch->prate);
                    // var_dump($prate);
                    // die();
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
                    $total_gross_amount  = json_decode($pitch->total_gross_amount);

                    $total_amount  = json_decode($pitch->total_amount);
                    $quotation_id  = $pitch->quotation_id;
                    $edit_grand_total = 0;
                @endphp

                <form action="{{ route('pitch.update',['pitch'=>$pitch->id]) }}" method="post" id="invoice-submit">
                     @method('PATCH')
                     @csrf
                    <div class="invoice-box">
                        <table class="billing-info tn-form-top-bottom">
                            <tr>
                                <td style="text-align: center;"> <b>Pitch {{ ++$count }} </b></td>
                                <td colspan="1" class="text-center">
                                    Lead Status
                                    <b> 
                                        {{  $pitch->quotation->leadstatus ? $pitch->quotation->leadstatus->status : ''  }}
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="label">Date :</div> 
                                                    <div class="field-group only-readable">
                                                        {{ $pitch->date  }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Minutes of Discussion (MOD)</div> 
                                                    <div class="field-group only-readable">
                                                        {{ $pitch->mods ?? ''  }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Revised Quote</div> 
                                                    <div class="field-group only-readable">
                                                        {{ $pitch->revised_quote  }}
                                                        @php $revised =  $pitch->revised_quote  @endphp
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Next Appointment</div> 
                                                    <div class="field-group only-readable">
                                                        {{ $pitch->next_appointment  }}
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
                                 {{--    <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>  --}}
                                    <td rowspan="2">Item</td>
                                    <td rowspan="2">Rate</td>
                                    <td rowspan="2">Qty</td>
                                    <td rowspan="2"> 
                                        <select name="dayormonth">
                                            <option value="day"> Days</option>
                                            <option value="month">Months</option>
                                        </select>
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
                                @foreach($item_id as $key => $item)   
                                    <tr class="center item" data-key={{ $key }} data-pitch={{ $pitch_key  }}>
                                                <td class="item">
                                                    @foreach($item_list as $it)
                                                        @if($item_id[$key] ==$it->id)
                                                            {{ $it->name ?? '' }}  
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="item_rate only-readable">
                                                    {{ $prate[$key]  ?? '' }}
                                                </td>
                                                <td class="item_qty only-readable">{{ $qty[$key]  ?? '' }}</td>
                                                <td class="item_pday only-readable"> 
                                                    {{ $days[$key] ?? '' }}
                                                </td>
                                                <td class="gross-amount- only-readable">{{ $gross_amount[$key] ?? '' }}</td>

                                                <td class="my-discount only-readable">
                                                    {{ $discount[$key]  ?? 0 }}
                                                </td>
                                                <td class="cgst only-readable">{{ $cgst[$key] }}</td>
                                                
                                                <td class="sgst only-readable">{{ $sgst[$key] }}</td>
                                                
                                                <td class="igst only-readable">{{ $igst[$key] }}</td>
                                                
                                                <td class=" tax-bg tax-amount- only-readable{{ $pitch_key }}">
                                                    {{ $tax_amount[$key] ?? 0 }}
                                                </td>
                                                <td class="total-amount- {{ $pitch_key }}">{{ round($total_amount[$key],2)  ?? ''}}</td>
                                                
                                                <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $gross_amount[$key] ?? '' }}" />
                                                <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $tax_amount[$key] ?? '' }} " />
                                                <input type="hidden"  class="ptotal_amount" name="ptotal_amount[]" value="{{ round($total_amount[$key],2)  ?? ''}}" />
                                                <input type="hidden" class="invoice_product_id" name="product_id[]" value="{{ $product_id[$key] }}" />
                                                @php
                                                    $edit_grand_total += $total_amount[$key]  ?? 0; 
                                                @endphp
                                    </tr>
                                @endforeach     
                                <tr class="center bottom-footer-tr">
                                    <td></td>
                                    <td colspan="2"></td>
                                    <td colspan="1">Net Amount</td>
                                    <td id="display-gross-total-amount{{ $pitch_key }}">{{ $pitch->total_grand_amount }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="display-total-tax-amount{{ $pitch_key }}">{{ $pitch->total_tax_amount }}</td> 
                                    <td id="display-grand-amount{{ $pitch_key }}">{{ $edit_grand_total }}</td>
                                </tr>     
                            </tbody>
                        </table>

                        <table>
                            <tr>
                                <td colspan="2">
                                    {{-- <span>Lead Status</span>
                                    <select name="lead_status">
                                        @php 
                                            $selected = $pitch->quotation->leadstatus ? $pitch->quotation->leadstatus->status : '';
                                        @endphp
                                        @foreach($leads as $lead)

                                            <option value="{{ $lead->id }}"   {{  ( $selected == $lead->lead ) ? 'selected' : ''  }} >{{ $lead->lead }}</option>
                                        @endforeach
                                    </select> --}}
                                    @if($totalValue == $count )
                                        <center><a href="{{ route('pitch.edit',['pitch'=>$pitch->id]) }}" class="btn btn-primary">Click to edit </a></center>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                </form>
                <br/>
                @endforeach

                <form action="{{ route('pitch.store') }}" method="post" id="invoice-submit">
                     @csrf
                    <div class="invoice-box">
                        <table class="billing-info">
                            <tr>
                                <td style="padding: 0 10px;"> <b>Create Pitch  </b></td>
                                <td colspan="1" class="text-center">
                                    Lead Status
                                    <b>
                                        {{ $quotation->leadstatus ? $quotation->leadstatus->status : ''   }}   
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="label">Date 9:</div> 
                                                    <div class="field-group">
                                                        <input type="date" name="date"  class="w-100" value="<?php echo date('Y-m-d'); ?>"  required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Minutes of Discussion (MOD)</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="mod"  >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Revised Quote</div> 
                                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="revised_quote" value="{{ ($revised==0) ? $quotation->total_amount : $revised  }}" >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="label">Next Appointment</div> 
                                                    <div class="field-group">
                                                        <input type="date" class="form-control- w-100"  name="next_appointment" value="" >
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
                                    {{-- <td rowspan="2" >S.No</td>
                                    <td rowspan="2" style="width: 75px;">HSN Code</td>
                                    <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td> --}}
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
                                   // dd($invoice_items);
                                @endphp
                                 @foreach($invoice_items as $key_parent => $invoice_item)
                                <tr class="center item">
                                            {{-- <td class="space"><span class="remove-btn">X</span></td>
                                            <td class="hsn">{{ $invoice_item->hsn_code ?? '' }}</td> --}}
                                            {{--   <input type="hidden" class="phsn" name="phsn[]" value="{{ $invoice_item->hsn_code ?? '' }}" /> --}}
                                            {{-- <td class="item-display">{{ $invoice_item->description ?? '' }}</td> --}}
                                            {{-- <input type="hidden" class="pdescription"  name="pdescription[]" value="{{ $invoice_item->description ?? '' }}"   /> --}}
                                            {{-- <input type="hidden" class="pname" name="pname[]" value="{{ $invoice_item->description ?? '' }}"/> --}}
                                          
                                            <td class="item">
                                            <select class="select-item-product" name="item_id[]">
                                                @foreach($item_list as $key => $it)
                                                        <option readonly="readonly" value="{{ $it->id }}"  {{ ($invoice_item->item_id==$it->id) ? 'selected=""' : '' }}>{{ $it->name }}</option>
                                                @endforeach
                                            </select>
                                            </td>
                                            <td class="item_rate">
                                                <input class="td-input-width item-gross-total"  type="number" name="prate[]" value="{{ isset($prate) ?  $prate[$key_parent] : $invoice_item->rate }}"  value=""  />
                                            </td>
                                            <td class="item_qty"><input class="td-input-width item-gross-total"  type="number"   name="pqty[]"  value="{{  isset($prate) ? $qty[$key_parent] : $invoice_item->quantity }}" /></td>
                                            <td class="item_pday"> <input class="td-input-width item-gross-total"  type="number"   name="pday[]" value="{{ $invoice_item->days ?? '' }}" />
                                            </td>
                                            <td class="gross-amount">{{ $invoice_item->gross_amount }}</td>
                                            <td class="my-discount"><input class="td-input-width item-discount"  type="number" name="pdiscount[]"  value="{{ isset($prate) ? $discount[$key_parent] : $invoice_item->discount }}"/></td>
                                            <td class="cgst">{{ $invoice_item->cgst }}</td>
                                            <input type="hidden" class="cgst" name="cgst[]" value="{{ $invoice_item->cgst }}" />
                                            <td class="sgst">{{ $invoice_item->sgst }}</td>
                                            <input type="hidden" class="sgst" name="sgst[]" value="{{ $invoice_item->sgst }}" />
                                            <td class="igst">{{ $invoice_item->igst }}</td>
                                            <input type="hidden" class="igst" name="igst[]" value="{{ $invoice_item->igst }}" />
                                            <td class="tax-amount">{{ $invoice_item->tax_amount  }}</td>
                                            <td class="total-amount">{{ $invoice_item->total_amount  }}</td>
                                            
                                            <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $invoice_item->gross_amount }}" />
                                            <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $invoice_item->tax_amount }}" />
                                            <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $invoice_item->total_amount }}" />
                                            <input type="hidden" class="invoice_product_id" name="product_id[]" value="{{ $invoice_item->id }}" />
                                </tr>

                            @endforeach     

                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="1">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $quotation->net_amount }}</td>
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
                        @php
                            $selected = $quotation->leadstatus ? $quotation->leadstatus->status :  '';
                        @endphp
                        <table>
                            <tr>
                                <td >
                                    <span>Lead Status</span>
                                    <select name="lead_status">
                                        @foreach($leads as $lead)
                                            <option value="{{ $lead->id }}" {{ ($selected == $lead->lead) ? 'selected' : '' }}>{{ $lead->lead }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                 <td style="text-align: right;">
                                    <center><button class="btn btn-primary">Save</button></center>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" value="{{ $quotation->id  }}" name="quotation_id">
                    <input type="hidden" value="{{ $quotation->enquire_id  }}" name="enquire_id">
                    <input name="total_tax_amount" id="total_tax_amount" type="hidden" value="{{ $quotation->total_tax }}}">
                    <input name="total_grand_amount" id="total_grand_amount" type="hidden" value="{{ $quotation->total_amount }}">
                    <input name="total_net_discount" id="total_net_discount" type="hidden" value="{{ '' }}">
                </form>
            <script>
                $(function(){
                    $('.select-item-product').change();
                    setTimeout(function(){
                        $('.td-input-width').focusout();
                        //alert('xd');
                    },5000);
                });
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
            <script type="text/javascript" src="{{ asset('resources/js/pitching.js?v='.time()) }}"></script>
        </div>
    </div>
@endsection