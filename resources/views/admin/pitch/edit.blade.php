@extends(_app())

@section('title', 'Edit Pitch')

@section('content')

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
            .billing-info.middle tr td>div.field-group{
                width: 150px!important;
            }
            .billing-info.middle tr td>div.label{
                display: block!important;
                width: unset!important;

            }

            .billing-info.middle td:first-child{
                width: 15%!important;
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
                   // dd($venue_details);
                @endphp
        
             

           

                <div class="invoice-box">
                     <div class="cstate-div-default" style="display: none;">{{ $gst_details['state']  ?? '' }}</div>
                   
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
                                            @endif
                                          {{--   <option value="{{ $inq->id }}" {{ ($quotation->enquire_id == $inq->id)  ? 'selected'  : '' }}> </option> --}}
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
                            <b>Lead Status:</b>
                             <b>
                                    {{ $quotation->leadstatus ? $quotation->leadstatus->status : ''   }}   
                                </b>
                            </td>

                            <td><div class="label">Source:</div></td>
                            <td >
                                   
                                     
                                    
                                    <b>@foreach($sources as $source)
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
                                <div class="label">Venu Name : </div>
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
                            <td><div class="label">City :</div></td>
                            <td><div class="only-readable ">
                                                                <div class="ccity-div"  >
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
                                                                       <div class="ccity-div">{{ $customer['ccity'] ?? '' }}</div>
                            </div></td>
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
                    $grand_gross_total =  array_sum($gross_amount);
                    // dd();
                  //  dd($quotation_id);
                @endphp
                <form action="{{ route('pitch.update',['pitch'=>$pitch->id]) }}" method="post" id="invoice-submit">
                     @method('PATCH')
                     @csrf
                    <div class="invoice-box">
                        <table class="billing-info middle">
                            <tr>
                                <td colspan="2" class="text-center">
                                    Lead Status :
                                    <b> {{ $quotation->leadstatus->status ?? ''  }}
                                    </b>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="label">Date:</div></td>
                                <td>
                                    <div class="field-group ">
                                                        <input type="date" name="date" value="{{ $pitch->date  }}" class="w-100"  required>
                                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="label"> Minutes of Discussion (MOD):</div></td>
                                <td>
                                    <div class="field-group">
                                                        <input type="text" class="form-control- w-100"  value="{{ $pitch->mods  }}" name="mod" value=""  >
                                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="label">Revised Quote</div></td>
                                <td><div class="field-group">
                                                        <input type="text" class="form-control- w-100"  name="revised_quote" value="{{ $pitch->revised_quote  }}" >
                                                    </div></td>
                            </tr>
                            <tr>
                                <td><div class="label">Next Appointment</div> </td>
                                <td> <div class="field-group">
                                                        <input type="date" class="form-control- w-100"  name="next_appointment" value="{{ $pitch->next_appointment  }}" >
                                                    </div></td>
                            </tr>
                            
                        </table>
                        
                        <table class="table-grid td-item-table no-border-top" cellspacing="0">

                            <tbody>
                               
                                <tr class="sub-heading-item" >
                                    
                                    {{-- <td rowspan="2" style="width: 75px;">HSN Code</td>
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
                                
                                 @foreach($item_id as $key => $item)
                                <tr class="center item">
                                            {{-- <td class="space"><span class="remove-btn">X</span></td>
                                            <td class="hsn">{{ $phsn[$key] ?? '' }}</td> --}}
                                            {{-- <input type="hidden" class="phsn" name="phsn[]" value="{{ $phsn[$key] ?? '' }}" /> --}}
                                            {{-- <td class="item-display">{{ $pdescription[$key] ?? '' }}</td> --}}
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
                                            <td class="cgst">{{ $cgst[$key] }}</td>
                                            <input type="hidden" class="cgst" name="cgst[]" value="{{ $cgst[$key] }}" />
                                            <td class="sgst">{{ $sgst[$key] }}</td>
                                            <input type="hidden" class="sgst" name="sgst[]" value="{{ $sgst[$key] }}" />
                                            <td class="igst">{{ $igst[$key] }}</td>
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
                                <td colspan="1"></td>
                                {{-- <td colspan="3"></td> --}}
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $grand_gross_total }}
                                </td>
                                <td></td>
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $pitch->total_tax_amount  }}</td>
                                <td id="display-grand-amount">
                                   {{ $pitch->total_grand_amount }}
                                </td>
                            </tr>
                              
                            
                            </tbody>
                        </table>

                        <table>
                            <tr>

                                <td>
                                    <select name="lead_status">
                                        @foreach($leads as $val)
                                            <option value="{{ $val->id }}">{{ $val->lead }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="text-align: right;">
                                    <button class="btn btn-primary">Update</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" value="{{ $quotation->id  }}" name="quotation_id">
                    <input type="hidden" value="{{ $pitch->quotation->enquire_id ?? 0  }}" name="enquire_id">
                    <input type="hidden" value="{{ $pitch->total_grand_amount  }}" name="total_grand_amount" id="total_grand_amount">
                    <input type="hidden" value="{{ $pitch->total_net_discount  }}" name="total_net_discount" id="total_net_discount">
                    <input type="hidden" value="{{ $pitch->total_tax_amount  }}" name="total_tax_amount" id="total_tax_amount">
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

            <script type="text/javascript" src="{{ asset('resources/js/pitching.js?v='.time()) }}"></script>

        </div>

    </div>


@endsection