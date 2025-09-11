

    <div class="main-container">

        <div class="content-wrapper">

            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">
<style>
    .billing-info tr td>div.field-group {
        width: unset !important;
        /*width: 53% !important;
        text-align: center !important;
        background: #e2efda;*/
    }

    *{
        margin: 2px; !important;
        padding: unset; !important;
    }
    .green{
        background: #e2efda;
    }
    .margin-top-tr-info{
        top: -10px; position: relative;
    }
</style>
            <?php
                   $customer_type =  App\Models\CustomerTypeMaster::all();
                   $delivery_address =  App\Models\Address::where('type','delivery')->get();
                   $supply_address =  App\Models\Address::where('type','supply')->get();
                   $invoice_items =  App\Models\InvoiceItem::where('invoice_id',$invoice->id)->get();
                   
                   $customers =  App\Models\Customer::where('customer_type',$invoice->customer_type)->get();

                   $edit_customer_type =  $customer_type->where('id',$invoice->customer_type)->first()  ;
                  // dd($supply_address);
                   $meta =  App\Models\Meta::all();
                   $gstMaster =  App\Models\GstMaster::all();
                   $term_and_conditions = $meta->where('meta_name', 'term')->first();
                   
                
                  
                   
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
                   $gst_details = json_decode($invoice->gst_details,true);

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

            <form action="{{ route('invoice.update',['invoice'=>$invoice->id]) }}" method="post" id="invoice-submit">
                
                @csrf
                {{ method_field('PATCH') }}

                <div class="invoice-box-">
                    <table cellpadding="0" class="invoice-header" cellspacing="0" width="100%">
                        <tr class="top">
                            <td class="left-grid" style="width: 40%;">
                                <table>
                                    <tr>
                                        <td colspan="2" class="title text-right" style="width: 120px; text-align: right;">
                                            <b>GSTIN :     {{ $gst_details['gstin'] }} </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2"><strong >Udyam Reg. No. : {{ $udyam_reg }}</strong></td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="pt-20" style="font-size: 10px;">
                                            <ul class="gst-head-ul">
                                               @php
                                                $gst_head = [];
                                                if(isset($gst_details['head'])){
                                                    $gst_head  =  json_decode($gst_details['head'],true);
                                                }
                                               @endphp
                                               @foreach($gst_head as $h)
                                               <li>{{ $h }}</li>
                                               @endforeach
                                            </ul>
                                        </td >
                                    </tr>

                                </table>
                            </td>

                            <td>
                                <table width="100%">
                                    <tr>
                                        <td class="center" colspan="2">
                                            <b><u>{{ ucfirst($invoice->invoice_type) }}</u></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" colspan="2">
                                            <h2 style="margin: 0;">RAINBOW</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" colspan="2" style="font-size: 9px;">
                                            Head Office: <span id="head_office">{{ $head_office }} </span> <br />
                                            Branch Office:<span id="branch_office"> {{ $branch_office }}</span> <br />
                                            <span id="temp_address"></span>
                                            <span >Website : www.rainbowrentals.co.in</span>
                                        </td>
                                    </tr>
                                    <tr class="flex-td">
                                        <td  >
                                            <b>Mobile : <span id="head_mobile">{{ $phone }}</span></b>
                                        </td>
                                        <td style="text-align:right ;">
                                            <b>Email: <span id="head_email">{{ $email }}</span></b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="billing-info" width="100%">
                        <tr class="">
                            <td class="td-no-padding">
                                <div class="label">UID: </div>
                                <div class="field-group">
                                    <b id="invoice_no"><?=  $invoice->id ?></b>
                                </div>
                            </td>
                            <td class="td-no-padding text-right-" colspan="6" style="text-align: right;">
                                <div class="label">Billing Date :</div>
                                <div class="field-group">
                                    <b><?=  date('d-m-Y',strtotime($invoice->billing_date)) ?></b>
                                </div>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="td-no-padding">
                                  <div class="label">Serial No.: </div>
                                <div class="field-group">
                                    <b id="invoice_no"><?=  $invoice->invoice_no ?></b>
                                </div>
                            </td>
                            <td class="td-no-padding " colspan="6" style="text-align: right;" >
                                <div class="label">Event Date :</div>
                                <div class="field-group">
                                    <b><?=  date('d-m-Y',strtotime($invoice->event_date)) ?></b>
                                </div>
                            </td>
                        </tr>

                        <tr class="">
                            <td class="td-no-padding" style="float: :right;">
                                <div class="label" style=" position: relative; top: 12px;">Customer Type:  </div>
                                <div class="field-group">
                                    <span id="cp_type" style=" position: relative; top: 12px;">{{ $edit_customer_type->code ?? '' }}</span>
                              
                                </div>
                            </td>
                            <td class="center"><b>Delivery Address</b></td>
                        </tr>
                        <tr>
                            <td class="td-no-padding">
                                <table style="margin-top: -6px;">
                                    <tbody>
                                        <tr>
                                            <td class="td-no-padding">
                                                <div class="label" >Client Name :</div> 
                                                <div class="field-group">{{ $customers_details['company_name'] ?? '' }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-no-padding" style="display: flex;  justify-content: center;;">
                                                <div class="label">Address :</div> 
                                                <div class="field-group" style="width: 40% !important;">
                                                    {{ $customers_details['ccaddress'] }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="pincode-inner-tr"  >
                                            <td colspan="2" class="td-no-padding">
                                               <table style="margin-top: -10px;">
                                                  <tbody>
                                                    <tr>
                                                        <td  class="td-no-padding">
                                                            <div class="label" style="margin-left: -4px; ">City :</div> 
                                                            <div class="field-group ">
                                                                <b>{{ $customers_details['ccity'] }}</b>
                                                            </div>
                                                        </td>
                                                        <td style="display: flex;" >
                                                            <div class="label label-state" style="text-align: right;"> 
                                                            <div class="field-group state-select">
                                                                <div class="cstate-div" > </div>
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                         <tr class="pincode-inner-tr"  >
                                            <td colspan="2" class="td-no-padding">
                                               <table style="margin-top: -14px;">
                                                  <tbody>
                                                    <tr>
                                                        <td style="display: flex;" class="td-no-padding">
                                                            <div class="label" style="margin-left: -3px; ">Pincode :</div> 
                                                            <div class="field-group">
                                                                {{ $customers_details['cpincode'] }}
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">Landmark</div> 
                                                            <div class="field-group">
                                                                {{ $customers_details['clandmark'] ?? '' }}
                                                            </div>
                                                        </td>
                                                    <tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr  >

                                            <td class="td-no-padding" colspan="2">
                                                <div class="label" style=" position: relative; bottom: 12px;">Contact person :</div> 
                                                <div class="field-group width-full contact-person" style="position: relative; bottom: 12px;" >
                                                    {{-- {{ $customers_details['contact_person_c'] }} --}}
                                                    @if(isset($customers_details['contact_name_edit']))
                                                        {{ $customers_details['contact_name_edit'] }}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="margin-top-tr-info">
                                            <td class="td-no-padding" colspan="2">
                                                <div class="label" style=" position: relative; bottom: 12px;">Mobile :</div> 
                                                <div class="field-group width-full" style=" position: relative; bottom: 12px;">
                                                    {{ $customers_details['cmobile'] }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="margin-top-tr-info">
                                            <td class="td-no-padding" colspan="2" >
                                                <div class="label" style=" position: relative; bottom: 12px;">Email :</div> 
                                                <div class="field-group width-full" style=" position: relative; bottom: 12px;">
                                                    {{ $customers_details['cemail'] }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="margin-top-tr-info">
                                            <td class="td-no-padding" colspan="2">
                                                <div class="label" style=" position: relative; bottom: 12px;">GSTIN :</div> 
                                                <div class="field-group width-full" style=" position: relative; bottom: 12px;">
                                                    <b>{{ $customers_details['cgstin'] }}</b>
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
                                                <div class="label">Venue :</div> 
                                                <div class="field-group td-city-width">
                                                    
                                                            @foreach($delivery_address as $da)
                                                                @if($da->id == $invoice->delivery_id)
                                                                    {{ $da->venue }}
                                                                @endif
                                                            @endforeach   
                                                    
                                                </div>

                                            </td>
                                        </tr>
                                        @if(isset($delivery_details['dvenue_name']))
                                        <tr class="venue_name" style="{{ $delivery_details['dvenue_name'] == null  ? 'display: none' : ''}} ;">
                                            <td class="td-no-padding">
                                                <div class="label">Venue Name : </div> 

                                                <div class="field-group td-city-width">
                                                     <input type="text" name="venue_name" placeholder="Venue Name" value="{{ $delivery_details['dvenue_name']  }}" class="w-100 mt-2" id="venue_name" style="{{ $delivery_details['dvenue_name'] == null  ? 'display: none' : ''}} ;">
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="td-no-padding">
                                                <div class="label">Address :</div> 
                                                <div class="field-group" style="width: 40% !important; padding-top: 2px;">
                                                    {{ $delivery_details['daddress'] }}
                                                </div>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td class="td-no-padding">
                                               <table>
                                                    <tbody>
                                                        <tr class="pincode-inner-tr"  >
                                                            <td colspan="2" class="td-no-padding">
                                                               <table style="margin-top: -5px;">
                                                                  <tbody>
                                                                    <tr>
                                                                        <td class="td-no-padding" >
                                                                            <div class="label" style=" position: relative; bottom: 10px;">City :</div> 
                                                                            <div class="field-group" style=" position: relative; bottom: 10px; margin-left: -5px;">
                                                                                <b>{{ $delivery_details['dcity'] }}</b>
                                                                            </div>
                                                                        </td>
                                                                        <td  class="td-no-padding">
                                                                            <div class="label label-state" style="  position: relative; bottom: 10px; text-align: left;">State : {{ $delivery_details['dstate'] }}</div> 
                                                                            <div class="field-group">
                                                                                
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
                                                <div class="label" style="margin-bottom: 18px;">Landmark :</div> 
                                                <div class="field-group width-full" style="margin-bottom: 18px; margin-left: -4px;">
                                                    {{ $delivery_details['dlandmark'] }}
                                                </div>
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <td class="td-no-padding" colspan="2">
                                                <div class="label" style=" position: relative; bottom: 20px; left: 8px;">Contact Person :</div> 
                                                <div class="field-group width-full" style="position: relative; bottom: 20px; margin-left: 4px;">
                                                    {{ $delivery_details['dperson'] }} 
                                                </div>
                                            </td>
                                        </tr>
                                      
                                        <tr>
                                            <td class="td-no-padding" colspan="2">
                                                <div class="label" style=" position: relative; bottom: 20px; left: 8px;">Mobile :</div> 
                                                <div class="field-group width-full" style=" position: relative; bottom: 20px; left: 4px;">
                                                    {{ $delivery_details['dmobile'] }} 
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
                                                                        <td class="td-no-padding" >
                                                                            <div class="label" style=" position: relative; bottom: 28px; ">Pincode :</div> 
                                                                            <div class="field-group" style="position: relative; bottom: 28px; left: -3px;">
                                                                                {{ $delivery_details['dpincode'] }}
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state" style="position: relative; bottom: 28px; left: 8px;">Readyness:</div> 
                                                                            <div class="field-group" style="position: relative; bottom: 28px; left: 8px;">
                                                                                {{ $invoice->readyness }}
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

                    <table class="table-grid td-item-table no-border-top- m-width"  cellspacing="0" width="100%"   style="table-layout:fixed; margin-top: -2px;" >

                        <tbody>
                            
                            <tr class="sub-heading-item" >
                                <td rowspan="2" >S.No</td>
                                <td rowspan="2" style="width: 50px;">SAC Code</td>
                                <td rowspan="2" style="width: 75px;">HSN Code</td>
                                <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                <td rowspan="2">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> {{ $invoice->dayormonth }} </td>
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
                            @endphp

                             @foreach($invoice_items as $invoice_item)
                             {{-- {{ var_dump($invoice_item) }} --}}
                                <tr class=" item">
                                            <td class="space-" width="4%">{{ $count++  }}</td>
                                             <td class="sac-" width="8%">{{ $invoice_item->sac_code ?? '' }}</td>
                                            <td class="hsn-" width="8%">{{ $invoice_item->hsn_code ?? '' }}</td>
                                           
                                            <td class="item-display" width="14%">{{ $invoice_item->description ?? '' }}</td>
                                         
                                            <td class="item" width="8%">
                                                {{ $invoice_item->item  }}     
                                            </td>
                                           
                                            <td class="item_rate green" width="4%">
                                                {{ $invoice_item->rate  ?? '' }}
                                            </td>
                                            <td class="item_qty green" width="4%">{{ $invoice_item->quantity  ?? '' }}</td>
                                            <td class="item_pday green" width="6%"> {{ $invoice_item->days ?? '' }}
                                            </td>
                                            <td class="gross-amount green" width="8%">{{ $invoice_item->gross_amount }}</td>
                                            <td width="6%" class="green"></td>
                                            <td class="cgst green" width="5%">{{ $invoice_item->cgst }}</td>
                                            <td class="sgst green" width="5%">{{ $invoice_item->sgst }}</td>
                                            <td class="igst green" width="5%">{{ $invoice_item->igst }}</td>
                                            <td class="tax-amount green" width="6%">{{ $invoice_item->tax_amount }} </td>
                                            <td class="total-amount " width="9%">{{ $invoice_item->total_amount }}</td>
                                </tr>

                        @endforeach

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
                                <td colspan="3">Amount in words :</td>
                                <td colspan="15"><span id="amountinword">{{ ucfirst($invoice->amount_in_words) ?? '' }}</span></td>
                            </tr>
                        
                        </tbody>
                    </table>
                    <table class="billing-info no-border-top" width="100%">
                        <tr class="bottom">
                            <td class="border-right">
                                <table>
                                    <tr>
                                        <td class="title center">
                                            <h3>Supply Address</h3>
                                            <p id="supplyaddress" >
                                                @foreach($supply_address as $da)
                                                    @if($invoice->supply_id ==  $da->id)
                                                        {{ $da->venue }} {{ $da->address }} {{ $da->address1 }}
                                                    @endif
                                                @endforeach </p>
                                         
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="width: 100%;" style="margin-top: -4px;">
                                
                                    <tr>
                                        <td class="center" colspan="2">
                                            <h3>BANK DETAILS</h3>
                                        </td>
                                    </tr>
                                    <tr></tr>
                                    @php
                                               $bank_name  = $meta->where('meta_name','bank_name')->first()->meta_value;
                                               $bank_holder_name  = $meta->where('meta_name','bank_holder_name')->first()->meta_value;
                                               $account_no  = $meta->where('meta_name','account_no')->first()->meta_value;
                                               $ifsc  = $meta->where('meta_name','ifsc')->first()->meta_value;
                                               $bank_address  = $meta->where('meta_name','bank_address')->first()->meta_value;
                                    @endphp
                                    <tr class="flex-td-">
                                        <td><b>Name : {{ $bank_holder_name }}</b> </td>
                                        <td><b> Bank : {{ $bank_name }}</b></td>
                                    </tr>
                                    <tr class="flex-td-">
                                        <td>
                                            <b>A/c No. : {{ $account_no }}</b> </td>
                                            <td>
                                            <b> IFSC Code: {{ $ifsc }}</b>
                                        </td>
                                    </tr>
                                    <tr class="flex-td-">
                                        <td class="" colspan="2"><b style="font-size: 10px;">Address : {{ $bank_address }}</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                   
                    <table>
                       
                        <tr>
                            <td>
                                {!! $term_and_conditions->meta_value !!}
                               
                            </td>
                        </tr>

                    </table>

                    <center> <p class="center">This is a system generated {{ $invoice->invoice_type }} and does not require a signature.</p></center>
                </div>
                
            </form>

            <script>
        
                $("#add-more-btn").click(function(){
                    //alert('xd');
                             var myvar = '<tr class="center item">'+
                '                                    <td class="space"><span class="remove-btn">X</span></td>'+
                '                                    <td class="sac"></td>'+
                '                                    <input type="hidden" class="psac" name="psac[]" value="" />'+
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
                '                                    <td><input class="td-input-width item-discount" type="number" name="pdiscount[]" value="00"/></td>'+
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

            <script type="text/javascript" src="{{ asset('resources/js/invoice.js?v='.time()) }}"></script>

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
                    $(".invoice-customer-type").change();  
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
        }, 2000);
        
   });
</script>
