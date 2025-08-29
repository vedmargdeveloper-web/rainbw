

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
        margin: 0px; !important;
        padding: unset; !important;

    }
    .conditions thead{}
    .conditions thead {}

            .conditions td {
                padding: 0.5px 8px;
                font-size: 12px !important;
            }

            .conditions th {
                padding: 0px 8px;
                font-size: 12px !important;
            }

            .conditions thead td {
                border: unset !important;
            }

            .conditions thead td:first-child {
               
            }

            .conditions thead th {
                background: #bfbfbf;
                font-size: 15px;
                padding: 1px 0;
            }

            .conditions tbody th {
                background: #f2f2f2;
                font-size: 12px;
                padding: 3px 0;
            }

            .conditions tbody tr td:first-child {
             
            }

            .conditions tbody tr td:nth-child(3) {
                background: #f2f2f2;
                text-align: center;
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
    #main-table  tr td {
    padding: 2px 4px;
    text-align: center;
    border-bottom:  unset;
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
                   $invoice_items =  App\Models\QuotationsItem::where('invoice_id',$invoice->id)->get();
                   
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

            <form action="{{ route('invoice.update',['invoice'=>$invoice->id]) }}" method="post" id="invoice-submit">
                
                @csrf
                {{ method_field('PATCH') }}
                <div class="invoice-box-">
                  <div class="invoce-table-bord">
                    <table cellpadding="0" class="invoice-header" cellspacing="0" width="100%" style="border-bottom: 2px solid">
                        <tr class="top">
                            <td class="left-grid" style="width: 40%;">
                                <table style="position: relative; top: -15px;">
                                    <tr>
                                      <td style="text-align: right; padding-right: 0; "><strong> GSTIN : </strong></td>
                                        <td  style="text-align: left; padding-left: 0;">
                                            <strong>    {{ $gst_details['gstin'] }} </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                      <td style="text-align: right; padding-right: 0; padding-top: 0;"><strong>Udyam Reg. No. :</strong></td>
                                        <td class="text-right" style="padding-left: 0; padding-top: 0;"><strong > {{ $udyam_reg }} </strong></td>
                                        
                                    </tr>
                                     <tr>
                                      <td style="text-align: right; padding-right: 0; "><strong> PAN : </strong></td>
                                        <td  style="text-align: left; padding-left: 0;">
                                            <strong>AAXFR1185Q</strong>
                                        </td>
                                    </tr>
                                     <tr>
                                      <td style="text-align: right; padding-right: 0; "><strong> TAN : </strong></td>
                                        <td  style="text-align: left; padding-left: 0;">
                                            <strong>MRTR10927A</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="pt-20" style="font-size: 10px;">
                                            <ul class="gst-head-ul">
                                               {{-- @php
                                                $gst_head = [];
                                                if(isset($gst_details['head'])){
                                                    $gst_head  =  json_decode($gst_details['head'],true);
                                                }
                                               @endphp --}}
                                               {{-- @foreach($gst_head as $h)
                                               <li>{{ $h }}</li>
                                               @endforeach --}}
                                               <li>Rental Services of Golf Carts</li>
                                            </ul>
                                        </td >
                                    </tr>

                                </table>
                            </td>

                            <td>
                                <table width="100%">
                                  
                                    <tr>
                                        <td colspan="2">
                                            <div style="display: flex; text-align: center; position: relative;">
                                                <strong><u>Delivery Challan</u></strong>
                                                <small style="position: absolute; right: 0;">{{ $copyType ?? 'Original' }}</small>
                                                
                                            </div>
                                            <input type="hidden" name="challan_type" value="challan">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" colspan="2">
                                            <h2 style="margin: 0;">RAINBOW</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center" colspan="2" style="font-size: 10px;">
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

                    <table class="billing-information" style="width: 100%; table-layout: fixed;">
                      <tbody>
                            <tr>
                                <td colspan="6"></td>   
                            </tr>
                            <tr>
                            <td>Serial No.:</td>
                            <td colspan="1" style="display: block; width: 150px; height: 15px;">
                                {{-- {{ $challan->challan_no }} --}}
                            </td>
                            <td colspan="4"></td>
                            <td style="background: unset;border: unset; text-align: right;">
                                <b>Ch. Date:  </b></td>
                           <td style="background: unset; border-bottom:1px solid black ; text-align: center;">
                                {{ \Carbon\Carbon::now('Asia/Kolkata')->format('d-m-Y') }}
                            </td>
                            
                            </tr>
                             <tr>
                                <td>Ref. PI No.:</td>
                                <td colspan="1" style="display: block; width: 150px; height: 15px;">
                                   <?=  $invoice->invoice_no ?></td>
                                <td colspan="4"></td>
                                <td style="background: unset;border: unset; text-align: right;">
                                    <b>Ch. Time:</b></td>
                                <td style="background: unset; border-bottom:1px solid black ; text-align: center;">
                                   {{-- {{ $invoice->event_time ?? ''}}</td> --}}
                                  @php
                                    use Carbon\Carbon;
                                    $currentTime = Carbon::now('Asia/Kolkata')->format('H:i');
                                @endphp

                                {{ $currentTime }}
                            </tr>
                             <tr>
                                <td>Challan Type:</td>
                                <td colspan="1" style="display: block; width: 150px; height: 15px;">
                                    Delivery Challan
                                </td>
                               
                            </tr>
                            {{-- @if(!empty($challan->start_date) ) --}}
                            <tr>
                                <td>Rental Start Date:</td>
                                <td style="width: 150px; height: 15px;">
                                    {{-- {{ $challan->start_date }} --}}
                                </td>
                            </tr>
                            {{-- @endif
                             @if(!empty($challan->end_date)) --}}
                            <tr>
                                <td>Rental End Date:</td>
                                <td style="width: 150px; height: 15px;">
                                    {{-- {{ $challan->end_date }} --}}
                                </td>
                            </tr>
                            {{-- @endif --}}

                              <tr>
                                <td colspan="6"></td>
                            </tr>
                             <tr>
                               <td colspan="6"></td>
                            </tr>
                    
                          <tr>
                              <td>Customer Type: </td>
                              <td style="display: block; width: 80px; height: 15px;">{{ $edit_customer_type->code ?? '' }}</td>
                              <td colspan="3"  style="background: unset;"  ></td>
                              <td colspan="3" style="background: unset;text-align: left;  font-weight: 600; border: 0;"> <p style="border-bottom: 1px solid; display: inline-block;"> Delivery Address </p></td>

                                </tr>
                          <tr>
                              <td>Client:</td>
                              <td colspan="3">{{ $customers_details['company_name'] ?? '' }}</td>
                            
                              <td style="width: 20%;">Venue:</td>
                              <td colspan="3">   
                                @if($invoice->delivery_id == 'other') 
                                            {{ $delivery_details['dvenue_name'] }}
                                    @else
                                        @foreach($delivery_address as $da)
                                            @if($da->id == $invoice->delivery_id)
                                                {{ $da->venue }}
                                            @endif
                                        @endforeach
                                    @endif  
                                </td>
                          </tr>
                          <tr>
                              <td>Address:</td>
                              <td colspan="3" style="max-width: 100px"> {{ $customers_details['ccaddress'] ?? '' }}</td>
                              
                              <td>Address:</td>
                              <td colspan="3" style="max-width: 100px"> {{ $delivery_details['daddress'] ?? '' }}</td>
                             
                          </tr>
                            <tr>
                              <td></td>
                              <td colspan="3"> {{ $customers_details['ccaddress1'] ?? '' }}</td>
                              
                              <td></td>
                              <td colspan="3"> {{ $delivery_details['daddress1'] ?? '' }}</td>
                             
                          </tr>
                          <tr>
                              <td>City:</td>
                              <td>{{ $customers_details['ccity'] }}</td>
                              <td>State:</td>
                              <td>{{ $customers_details['cstate'] }}</td>

                              <td>City:</td>
                              <td>{{ $delivery_details['dcity'] ?? '' }}</td>
                              <td>State:</td>
                              <td >{{ $delivery_details['dstate'] ?? '' }}</td>
                              
                          </tr>
                          <tr>
                              <td>Pin Code:</td>
                              <td>{{ $customers_details['cpincode'] }}</td>
                              <td>Landmark:</td>
                              <td>{{ $customers_details['clandmark'] ?? '' }} </td>
                              
                              <td> Landmark:</td>
                              <td colspan="3">{{ $delivery_details['dlandmark'] ?? '' }}</td>

                          </tr>
                          <tr>
                              <td>Contact Person:</td>

                              <td colspan="3">  @if(isset($customers_details['contact_name_edit']))
                                                        {{ $customers_details['contact_name_edit'] }}
                                                @else
                                                        {{ $customers_details['contact_person_c'] }}
                                                @endif
                                            </td>
                                            <td></td>
                              <td colspan="3">      </td>
                              
                              
                              
                          </tr>
                          <tr>
                              <td>Mobile:</td>
                              <td colspan="3">{{ $customers_details['cmobile'] }}</td>
                                       <td>Contact Person</td>
                              <td colspan="3">{{ $delivery_details['dperson'] ?? '' }}</td>
                          </tr>
                             <tr>
                              <td>Email: </td>
                              <td colspan="3">{{ $customers_details['cemail'] }}</td>

                               <td>Mobile:</td>
                              <td colspan="3">{{ $delivery_details['dmobile'] ?? '' }}</td>
                             
                          </tr>
                            <tr>
                              <td>GSTIN:  </td>
                              <td colspan="3">{{ $customers_details['cgstin'] }}</td>
                              <td>Pin Code:</td>
                              <td>{{ $delivery_details['dpincode'] }} </td>
                              <td>Readyness:</td>
                              <td >{{
                               $invoice->readyness  }}</td>
                          </tr>
                          
                      </tbody>
                
                    </table>


                    
                    @php 
                        $item = App\Models\Item::get(); 
                    @endphp

                      <table class="td-item-table no-border-top- m-width" id="main-table"  cellspacing="0" width="100%"   style=" " >
                        <thead>
                          <br>
                            <tr class="sub-heading-item" >
                                <td rowspan="2" >S.No</td>
                                <td rowspan="2" >HSN/SAC Code</td>
                                <td rowspan="2" style=" width: 25%;">Description of Goods/Services</td>
                                <td rowspan="2" style="width: 20%">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> {{ $invoice->dayormonth }} </td>
                                <td rowspan="2">Gross Amount</td>
                                {{-- <td rowspan="2">Discount</td> --}}
                                <td colspan="3" style="text-align: center;">Tax </td>
                                <td rowspan="2">Tax Amount</td>
                                <td rowspan="2">Total Amount</td>
                            </tr>

                            <tr class="heading">
                                <td>CGST</td>
                                <td>SGST</td>
                                <td>IGST</td>
                            </tr>
                          </thead>
                            @php
                                $count = 1;
                            @endphp

                             @foreach($invoice_items as $invoice_item)
                             <tbody class="main-td">
                                <tr class=" item">
                                            <td class="space-" width="4%">{{ $count++  }}</td>
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
                                            <td class="gross-amount green" width="8%">{{ round($invoice_item->gross_amount) }}</td>
                                            {{-- <td width="6%" class="green">{{ round($invoice_item->discount) }}</td> --}}
                                            <td class="cgst green" width="5%">{{ $invoice_item->cgst }}</td>
                                            <td class="sgst green" width="5%">{{ $invoice_item->sgst }}</td>
                                            <td class="igst green" width="5%">{{ $invoice_item->igst }}</td>
                                            <td class="tax-amount green" width="6%">{{ $invoice_item->tax_amount }} </td>
                                            <td class="total-amount " width="9%">{{ $invoice_item->total_amount }}</td>
                                </tr>
                              </tbody>
                        @endforeach

                            <tr class="center bottom-footer-tr">
                             
                                <td colspan="4"></td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $invoice->net_amount }}
                                </td>
                                {{-- <td></td> --}}
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">{{ $invoice->total_tax }}</td>
                                    
                                <td id="display-grand-amount">
                                   {{ $invoice->total_amount }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right; ">Amount in words :  </td>
                                <td colspan="11" class="green" style="font-weight: 600; text-align: left;"><span id="amountinword">
                                    @if($invoice->total_amount == 0 ) Zero @else {{ getIndianCurrency($invoice->total_amount) }}@endif</span> 
                                </td>
                            </tr>
                            {{-- <tr>
                                <td colspan="3" style="text-align: right; ">Remark :  </td>
                                <td colspan="11" class="green" style="font-weight: 600; text-align: left;"><span id="amountinword">
                                    {{ $invoice->remark ?? '' }}
                                </span></td>
                            </tr> --}}
                        
                        </tbody>
                    </table>
                    
                            <table class="bank-detail" width="100%" 
                                style="border-top: 1px solid #000!important; border-bottom:  1px solid #000!important;">
                                <tr class="bottom">
                                    <td style="width: 40%; border-right: 1px solid #000;">
                                        <table style="width: 100%; text-align: center;">
                                            <tr>
                                                <td class="center" colspan="2">
                                                    <h3><u>Supply Address :</u></h3>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 40%;">
                                        <table style="width: 100%; text-align: center;">
                                        
                                            <tr>
                                                <td class="title center">
                                                    <p id="supplyaddress" >
                                                            @foreach($supply_address as $da)
                                                                @if($invoice->supply_id ==  $da->id)
                                                                    {{ $da->venue }} {{ $da->address }}                                                    
                                                                @endif
                                                            @endforeach </p>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    
                                </tr>
                            </table>

                             
                            <table class="bank-detail" width="100%" 
                                style="border-top: 1px solid #000!important; 
                                    border-bottom: 1px solid #000!important; 
                                    height:60px; 
                                    background-color: black;">
                                <tr>
                                    <td style="color: white; 
                                            text-align: center; 
                                            font-weight: bold; 
                                            font-size: 22px; 
                                            padding-top: 15px; 
                                            padding-bottom: 15px;">
                                        <u>The Above Mentioned Article Is &nbsp; NOT FOR SALE</u>
                                    </td>
                                </tr>
                            </table>
                            {{-- {{ $meta->where('meta_name', 'term')->first()->meta_value }} --> --}}

                    <table class="conditions" width="100%">
                        <thead>
                            <tr>
                                <th colspan="4">Terms & Conditions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="1">1.) E.&.O.E.</td>
                               
                            </tr>
                            <tr>
                                <td colspan="1">2.) Delhi courts shall be the only jurisdiction for any disputes.</td>
                                
                            </tr>
                            
                        </tbody>
                        
                       
                    </table>
                    <center>
                        <p class="center" style="padding-bottom: 10px;">This is a system generated
                            challan and does not require a signature.</p>
                    </center>
                </div>
              </div>
                
            </form>
            {{-- {{ dd('xd') }} --}}

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

            <script type="text/javascript" src="{{ asset('resources/js/challan.js?v='.time()) }}"></script>

        </div>

    </div>
<script>
     $(function(){
    $('.main-gst-selection').change();
    $('.item-gross-total').focusout();
    alert();
    
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
