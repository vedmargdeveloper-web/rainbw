
@extends(_app())

@section('title', $title ?? 'Dashboard')

@section('content')
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
    .invoice-box table tr.top table td{
      padding: 0 10px!important;
    }
    .invoice-box-{
          margin: 10px 20px;
    }
    .green{
        background: #fde9d9;
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
.billing-info tr td{
  width: unset!important;
}
.billing-info tr td table td{
  width: unset;
}
.invoce-table-bord{
border: 2px solid #333;
}
.billing-info{
  border: unset;
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
        background-color: #fde9d9;
   
        border-bottom: 0.5px solid #000;
        width: 15%;
          
    }
     .billing-information tr td:nth-child(4){
        background-color: #fde9d9;
       border-bottom: 0.5px solid #000;
      
    }
    .billing-information tr td:nth-child(6){
        background-color: #fde9d9;
   
        border-bottom: 0.5px solid #000;

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
        background-color: #fde9d9;
       border-bottom: 0.5px solid #000;
    }
    .billing-information tr td{
        padding: 0px 5px;
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
    border-right: 1px solid #000!important;
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
.invoice-box table tr.flex-td td{
  display: inline-block;
  width: 50%;
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
             <div class="invoice-box">
                <form action="{{ route('invoice.update',['invoice'=>$invoice->id]) }}" method="post" id="invoice-submit">
                    
                    @csrf
                    {{ method_field('PATCH') }}

                    <div class="invoice-box-">
                      <div class="invoce-table-bord">
                        <table cellpadding="0" class="invoice-header" cellspacing="0" width="100%" style="border-bottom: 2px solid">
                            <tr class="top">
                                <td class="left-grid" style="width: 40%;">
                                    <table>
                                        <tr>
                                          <td style="text-align: right;"><strong>GSTIN :</strong></td>
                                            <td  >
                                                   {{ $gst_details['gstin'] }} 
                                            </td>
                                        </tr>
                                        <tr>
                                          <td style="text-align: right;"><strong >Udyam Reg. No. :</strong> </td>
                                            <td >{{ $udyam_reg }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="pt-20" style="font-size: 10px; padding-top: 10px!important;">
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

                        <table class="billing-information" style="width: 100%;">
                          <tbody>
                            <br>
                              <tr>
                                  <td>UID:</td>
                                  <td colspan="1" >  @foreach($inquiry as $inq)
                                                @if($invoice->enquire_id == $inq->id)
                                                    {{ $inq->unique_id }}
                                                @endif
                                             @endforeach</td>
                                  <td colspan="3"></td>
                          
                                  <td style="background: unset;border: unset;"></td>
                                  <td style="background: unset;border: unset;"><?=  ucfirst($invoice->invoice_type) ?> Date:</td>
                                  <td colspan="2" style="background: #fde9d9; border-bottom:1px solid black ;"><?=  date('d-m-Y',strtotime($invoice->billing_date)) ?></td>

                              </tr>
                              <tr>

                                  <td>Bill No.:</td>
                                  <td colspan="1"><?=  $invoice->invoice_no ?></td>
                                  <td colspan="3"></td>
                                  <td style="background: unset;border: unset;"></td>
                                  <td style="background: unset;border: unset;">Event Date:</td>
                                  <td style="background: #fde9d9; border-bottom:1px solid black ;" colspan="3"><?=  date('d-m-Y',strtotime($invoice->event_date)) ?></td>
                                
                                
                              </tr>
                             
                              <tr>
                                  <td>Customer Type </td>
                                  <td >{{ $edit_customer_type->code ?? '' }}</td>
                                  <td colspan="3"  style="background: unset;" ></td>
                                  <td  style="background: unset;text-align: left;  font-weight: 600; border: 0;"> <p style="border-bottom: 1px solid; display: inline-block;">Delivery Address</td>
                              </tr>
                              <tr>
                                  <td>Client</td>
                                  <td colspan="3">{{ $customers_details['company_name'] ?? '' }}</td>
                                
                                  <td>Venue</td>
                                  <td colspan="4">   @foreach($delivery_address as $da)
                                                                    @if($da->id == $invoice->delivery_id)
                                                                        {{ $da->venue }}
                                                                    @endif
                                                                @endforeach  
                                    </td>
                              </tr>
                              <tr>
                                  <td>Address</td>
                                  <td colspan="3" style="max-width: 100px"> {{ $customers_details['ccaddress'] ?? '' }}</td>
                                  
                                  <td>Address</td>
                                  <td colspan="4" style="max-width: 100px"> {{ $delivery_details['daddress'] ?? '' }}</td>
                                 
                              </tr>
                                <tr>
                                  <td></td>
                                  <td colspan="3"> {{ $customers_details['ccaddress1'] ?? '' }}</td>
                                  
                                  <td></td>
                                  <td colspan="4"> {{ $delivery_details['daddress1'] ?? '' }}</td>
                                 
                              </tr>
                              <tr>
                                  <td>City</td>
                                  <td>{{ $customers_details['ccity'] }}</td>
                                  <td>State:</td>
                                  <td>{{ $customers_details['cstate'] }}</td>

                                  <td>City</td>
                                  <td>{{ $delivery_details['dcity'] ?? '' }}</td>
                                  <td>State:</td>
                                  <td colspan="2">{{ $delivery_details['dstate'] ?? '' }}</td>
                                  
                              </tr>
                              <tr>
                                  <td>Pin Code</td>
                                  <td>{{ $customers_details['cpincode'] }}</td>
                                  <td>Landmark:</td>
                                  <td>{{ $customers_details['clandmark'] ?? '' }} </td>
                                  
                                  <td> Landmark</td>
                                  <td colspan="4">{{ $delivery_details['dlandmark'] ?? '' }}</td>

                              </tr>
                              <tr>
                                  <td>Contact Person</td>

                                  <td colspan="3">  @if(isset($customers_details['contact_name_edit']))
                                                            {{ $customers_details['contact_name_edit'] }}
                                                    @else
                                                            {{ $customers_details['contact_person_c'] }}
                                                    @endif
                                                </td>
                                                <td></td>
                                  <td colspan="4">      </td>
                                  
                                  {{-- <td>Landmark</td>
                                  <td colspan="4">{{ $delivery_details['dlandmark'] ?? '' }}</td> --}}
                                       
                                  
                              </tr>
                              <tr>
                                  <td>Mobile</td>
                                  <td colspan="3">{{ $customers_details['cmobile'] }}</td>
                                           <td>Contact Person</td>
                                  <td colspan="4">{{ $delivery_details['dperson'] ?? '' }}</td>
                              </tr>
                                 <tr>
                                  <td>Email </td>
                                  <td colspan="3">{{ $customers_details['cemail'] }}</td>

                                   <td>Mobile</td>
                                  <td colspan="4">{{ $delivery_details['dmobile'] ?? '' }}</td>
                                 
                              </tr>
                                <tr>
                                  <td>GSTIN  </td>
                                  <td colspan="3">{{ $customers_details['cgstin'] }}</td>
                                  <td>Pin Code</td>
                                  <td>{{ $delivery_details['dpincode'] }} </td>
                                  <td>Readyness</td>
                                  <td colspan="2">{{ $invoice->readyness  }}</td>
                              </tr>
                          </tbody>
                    
                        </table>


                        @php 
                            $item = App\Models\Item::get(); 
                            $pitchLastest =   $invoice->pitchLastest;
                           // dd($pitchLastest);
                            $item_list = App\Models\Item::all();
                            $item_id  = json_decode($pitchLastest->item_id);
                            //dd($pitchLastest);
                            if(!$pitchLastest){
                                dd('something wrong in items list');
                                die();
                            }

                            $item_list_selected = $item_list->whereIn('id',$item_id);

                            // dd($pitchLastest);
                    

                            // dd($item_list_selected);
                            // die();
                            $prate  = json_decode($pitchLastest->prate);
                            $phsn  = json_decode($pitchLastest->phsn);
                            $pname  = json_decode($pitchLastest->pname);
                            $pdescription  = json_decode($pitchLastest->pdescription);
                            $product_id  = json_decode($pitchLastest->product_id);
                            $qty  = json_decode($pitchLastest->qty);
                            $days  = json_decode($pitchLastest->days);
                            $gross_amount  = json_decode($pitchLastest->gross_amount);
                            $discount  = json_decode($pitchLastest->discount);
                            $cgst  = json_decode($pitchLastest->cgst);
                            $sgst  = json_decode($pitchLastest->sgst);
                            $igst  = json_decode($pitchLastest->igst);
                            $tax_amount  = json_decode($pitchLastest->tax_amount);
                            $total_amount  = json_decode($pitchLastest->total_amount);
                            $quotation_id  = $pitchLastest->quotation_id;
                            $edit_grand_total = 0;
                            // dd($item_id);
                            // die();
                        @endphp
                        @php $item = App\Models\Item::get(); @endphp
                        <table class="td-item-table no-border-top- m-width" id="main-table"  cellspacing="0"  style="margin: auto; width: 99%; border-bottom: 1px solid" >
                          <br>
                            <tbody>   
                                <tr class="sub-heading-item" >
                                    <td rowspan="2" >SN</td>
                                    <td rowspan="2" >HSN Code</td>
                                    <td rowspan="2" style="width: 20%;">Description of Goods/Services</td>
                                    <td rowspan="2" >Item</td>
                                    <td rowspan="2">Rate</td>
                                    <td rowspan="2">Qty</td>
                                    <td rowspan="2"> <select name="invoice_dayormonth">
                                        <option value="day" > Days</option>
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
                                    $count = 0;
                                    $mykey = 0;
                                @endphp
                             
                                  
                                    @foreach($item_list_selected as $key => $invoice_item)
                                    <tr class="center item">
                                                <td>{{ ++$count }}</td>
                                                <td class="hsn"> {{ $invoice_item->hsn ?? '' }}</td> 
                                                <td class="item-display">{{ $invoice_item->description ?? '' }}</td>
                                                <td class="item">
                                                @foreach($item_list as $it)
                                                    @if($item_id[$mykey] == $it->id)
                                                        {{ $it->name }}
                                                    @endif
                                                @endforeach
                                                </td>
                                                <td class="item_rate green">
                                                    {{ $prate[$mykey] ?? 0 }}
                                                </td>
                                                <td class="item_qty green">
                                                    {{ $qty[$mykey]  ?? '' }}
                                                </td>
                                                <td class="item_pday green"> 
                                                    {{ $days[$mykey] ?? '' }}
                                                </td>
                                                <td class="gross-amount green">{{ $gross_amount[$mykey] ?? 0 }}
                                                    <?php $edit_grand_total += $gross_amount[$mykey] ?>
                                                </td>
                                                <td class="green">{{ $discount[$mykey] }}</td>

                                                <td class="cgst green">{{ $cgst[$mykey] }}</td>
                                                <td class="sgst green">{{ $sgst[$mykey] }}</td>
                                                <td class="igst green">{{ $igst[$mykey] }}</td>
                                                <td class="tax-amount green">{{ $tax_amount[$mykey] ?? 0 }}</td>
                                                <td class="total-amount ">{{ $total_amount[$mykey]  ?? 0 }}</td>

                                    </tr>
                                @php
                                    $mykey++;
                                 @endphp
                                @endforeach    
                                <tr class="center bottom-footer-tr">
                                    
                                    <td colspan="4"></td>
                                    <td colspan="3">Net Amount  </td>
                                    <td id="display-gross-total-amount">
                                        {{ $edit_grand_total }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="display-total-tax-amount">{{ $pitchLastest->total_tax_amount }}</td>
                                    <td id="display-grand-amount">
                                       {{ $pitchLastest->total_grand_amount }}
                                    </td>
                                </tr>
                            </table>

                            <table class="billing-info no-border-top" width="100%" style="border: 1px solid; width: 99%; margin: auto;">
                                <tr class="bottom">
                                    <td class="border-right">
                                        <table>
                                            <tr >
                                                <td class="center" colspan="2">
                                                    <h3 style="position: relative; top: -2%;"><u>Supply Address</u></h3>
                                                </td>
                                            </tr>
                                            <br>
                                            
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
                                    <td>
                                        <table style="width: 100%;" style="margin-top: -4px;">
                                        
                                            <tr>
                                                <td class="center" colspan="2">
                                                    <h3>BANK DETAILS</h3>
                                                </td>
                                            </tr>
                                            
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
                                                <td class="" colspan="2"><b style="">Address : {{ $bank_address }}</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <table class="billing-info- center">
                                <tbody>
                                    <tr>

                                        <td style="width: 16%;"><a href="javascript:alert('we are working')" class="btn-print-edit">Email</a></td>
                                        <td style="width: 16%;"><a href="javascript:alert('we are working')" class="btn-print-edit">WhatsApp</a></td>
                                        <td style="width: 16%;"><a href="{{ route('quotation.print',['id'=>$pitchLastest->quotation_id ]) }}?type=quotation-print" class="btn-print-edit">Print</a></td>
                                        <td style="float: right;">
                                            {{-- <button class="send btn-submit">Update</button> --}}
                                        </td>
                                    </tr>
                                </tbody>
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
                    </div>
                </form>

             </div>
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


@endsection