<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title></title>
        <meta name="base_url" content="{{ url('/') }}">
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    @php
       $customer_type =  App\Models\CustomerTypeMaster::all();
       $delivery_address =  App\Models\Address::where('type','delivery')->get();
       $supply_address =  App\Models\Address::where('type','supply')->get();
       $invoice_items =  App\Models\InvoiceItem::where('invoice_id',$invoice->id)->get();
       
       $customers =  App\Models\Customer::where('customer_type',$invoice->customer_type)->get();
       $edit_customer_type =  $customer_type->where('id',$invoice->customer_type)->first()  ;
      // dd($supply_address);
       $meta =  App\Models\Meta::all();
       $gstMaster =  App\Models\GstMaster::all();
       $gst  = $meta->where('meta_name','gst')->first()->meta_value;
       $udyam_reg  = $meta->where('meta_name','udyam_reg')->first()->meta_value;
       $head_office  = $meta->where('meta_name','head_office')->first()->meta_value;
       $branch_office  = $meta->where('meta_name','branch_office')->first()->meta_value;
       $email  = $meta->where('meta_name','email')->first()->meta_value;
       $phone  = $meta->where('meta_name','mobile')->first()->meta_value;
       // dd();
       //dd($delivery_address);
       $customers_details = json_decode($invoice->customer_details,true);
       //dd($customers_details);
           $state = App\Models\State::get();
       $city = App\Models\City::get();
       // dd();
    @endphp
    <body>
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
            <div class="invoice-box">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td class="left-grid">
                            <table>
                                <tr>
                                    <td class="title">
                                        GSTIN :     
                                    </td>
                                    <td><select class="select-2 main-gst-selection" name="gst_id">
                                                        <option value="">Please Select</option>
                                                        @foreach($gstMaster as $gm)
                                                            <option value="{{ $gm->id }}" {{ ($invoice->gst_id == $gm->id) ? 'selected' : '' }}>{{ strtoupper($gm->gstin) }}</option>
                                                        @endforeach
                                                    </select></td>
                                    <td></td>
                                    <td id="udyam_no">{{ $udyam_reg }} </td>
                                </tr>

                                <tr rowspan="3" >
                                    <td colspan="3" class="pt-20" style="font-size: 10px;">
                                        <ul class="gst-head-ul">
                                           
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td class="center">
                                      {{--   <b>Invoice</b> --}}

                                        <select name="invoice_type" id="invoice_type" >
                                                <option value="invoice" {{ ($invoice->invoice_type == 'invoice') ? 'selected=""' : ''  }}  >Invoice</option>
                                                <option value="challan" {{ ($invoice->invoice_type== 'challan') ? 'selected=""' : ''  }}  >Challan</option>
                                                <option value="quotation" {{ ($invoice->invoice_type== 'quotation') ? 'selected=""' : ''  }}>Quotation</option>
                                        </select>
                                       {{--  <input type="hidden" name="invoice_type" value="invoice"> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center">
                                        <b>RAINBOW</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="center" style="font-size: 9px;">
                                        Head Office: <span id="head_office">{{ $head_office }} </span> <br />
                                        Branch Office:<span id="branch_office"> {{ $branch_office }}</span> <br />
                                        <span id="temp_address"></span>
                                    </td>
                                </tr>
                                <tr class="flex-td">
                                    <td>
                                        <b>Mobile : <span id="head_mobile">{{ $phone }}</span></b> <br />
                                        <b>Email: <span id="head_email">{{ $email }}</span></b> </b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <table class="billing-info">
                        <tr class="">
                            @php
                                $invoice_last_y = date('y')+1;
                                $totalInvoice =  App\Models\Invoice::count()+1;
                                
                            @endphp
                            <span style="display:none ;" id="default-invoice-no"><?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInvoice" ?></span>
                            <?php $invoice_no = $invoice->invoice_no; ?> 
                            <td class="pt-20" colspan="2">Bill No.: <input type="hidden" name="invoice_no" value="<?=  $invoice->invoice_no ?>"> <b id="invoice_no"><?=  $invoice->invoice_no ?></b></td>
                            <td class="pt-20  right-" colspan="2">Issue Date : <b><?=  $invoice->invoice_date ?></b><input type="hidden" name="invoice_date" value="{{ date('d.m.Y') }}"></td>
                        </tr>
                        <tr class="">

                            
                            <td class="pt-20">Customer Type :  <span id="cp_type">{{ $edit_customer_type->code ?? '' }}</span></td>
                            <td>

                                @foreach($customer_type as $ct)
                                <input type="radio"  id="{{ $ct->code }}" name="customer_type" {{ ($invoice->customer_type ==  $ct->id) ? 'checked="checked"' : '' }} value="{{ $ct->id }}">
                                <label for="{{ $ct->code }}">{{ $ct->type }} </label>
                            @endforeach     
                            </td>

                            <td>
                                <td class="pt-20"><b>Delivery Address</b></td>
                            </td>
                            
                        </tr>
                        <tr><td>Client Name: </td>
                        <td>

                            
                                
                                    <select class="select-2 invoice-customer-type" > 
                                        @foreach($customers   as $customer)
                                            <option value="{{ $customer->id }}"  {{ ($customer->id == $invoice->customer_id) ? 'selected=""' : ''  }}>{{ $customer->company_name }}</option>
                                        @endforeach     
                                    </select>
                                    <input type="hidden" name="customer_id" value="{{ $invoice->customer_id }}"> 
                                

                            <input type="text" name="company_name" placeholder="client Name" id="company_name" value="{{ isset($customers_details['company_name']) ? $customers_details['company_name'] : ''}}">
                            </select>

                        </td>
                            <td>Venue:</td>

                            <td><select class="select-2 invoice-delivery-address" name="delivery_id" >
                                <option value="">Please Select Delivery Address</option>
                                    @foreach($delivery_address as $da)
                                        <option value="{{ $da->id }}" {{  ($da->id == $invoice->delivery_id ) ? 'selected=""' : '' }} >{{ $da->venue }}</option>
                                    @endforeach    
                            </select>
                         </td>
                        </tr>
                        <tr>
                            <td>Address: 
                            </td>
                            <td><input type="text" name="caddress" value="{{ $customers_details['ccaddress'] }}"> </td>
                            <td>Address: </td>
                            <td><input type="text" name="daddress" value="" ></b> </td>
                        </tr>
                        <tr>
                            <td>Pin Code:  <input type="text" name="cpincode" value="{{ $customers_details['cpincode'] }}" >   City: </td>
                            <td class="ccity-div"><input type="text" name="ccity" value="{{ $customers_details['ccity'] }}"></td>
                            
                        </tr>
                        <tr>
                            <td>State: </td>
                            <td class="cstate-div"> <input type="text" name="cstate" value="{{ $customers_details['cstate'] }}" >  </td>
                         <td><label for="cars">City:</label></td>
                            <td>   <input type="text" name="dcity" value="" >     </td>

                        </tr>
                        <tr>
                            <td>Contact Person: </td>
                            <td class="contact-person"> <input type="text" name="contact_person_c" value="{{ $customers_details['contact_person_c'] }}" >  </td>
                            <td> Landmark: </td>
                            <td> <input type="text" name="dlandmark" value="" >  </td>
                        </tr>

                        <tr>
                            <td>Mobile: </td>
                            <td><input type="text" name="cmobile" value="{{ $customers_details['cmobile'] }}" > </td>
                            <td> Contact Person </td>
                            <td> <input type="text" name="dperson" value="" >  </td>
                        </tr>

                        <tr>
                            <td>Email: </td>
                            <td> <input type="text" name="cemail" value="{{ $customers_details['cemail'] }}" > </td>
                            <td> Mobile:  </td>
                            <td> <input type="text" name="dmobile" value="" >  </td>
                        </tr>

                        <tr>
                            <td>GSTIN: </td>
                            <td> <input type="text" name="cgstin" value="{{ $customers_details['cgstin'] }}" > </td>
                            <td> Pin Code :  <input type="text" name="dpincode" value="" > </td>
                            <td> State : <input type="text" name="dstate" value="" > </td>
                        </tr>

                    </table>
                    @php $item = App\Models\Item::get(); @endphp
                    
                    <table class="table-grid td-item-table" cellspacing="0">
                        <tbody>

                            <tr class="sub-heading-item" style="background: #ffa5d740;" >
                                <td rowspan="2">Remove.</td>
                                <td rowspan="2">SAC Code</td>
                                <td rowspan="2">HSN Code</td>
                                <td rowspan="2">Description of Goods/Services</td>
                                <td rowspan="2">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2">
                                    <select name="invoice_dayormonth">
                                        <option value="day" {{ ($invoice->dayormonth =='day') ?  'selected' : '' }}> Days</option>
                                        <option value="month" {{ ($invoice->dayormonth =='month') ?  'selected' : '' }}>Months</option>
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
                        @foreach($invoice_items as $invoice_item)
                        <tr class="center item">
                                    <td class="space"><span class="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></span></td>
                                     <td class="sac">{{ $invoice_item->sac_code ?? '' }}</td>
                                    <input type="hidden" class="psac" name="psac[]" value="{{ $invoice_item->sac_code ?? '' }}" />
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
                                    <td class="total-amount">{{ $invoice_item->total_amount }}</td>
                                    
                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="{{ $invoice_item->gross_amount }}" />
                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="{{ $invoice_item->tax_amount }}" />
                                    <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="{{ $invoice_item->total_amount }}" />
                                    <input type="hidden" class="invoice_product_id" name="invoice_product_id[]" value="{{ $invoice_item->id }}" />
                        </tr>

                        @endforeach

                            <tr class="inser-div-before">
                                <td colspan="15"><center><a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">ADD ITEM</a></center><td>
                            </tr>
                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="4">Tax Payable on Rev. Charge Basis: NO</td>
                                <td colspan="3">Net Amount</td>
                                <td id="display-gross-total-amount">{{ $invoice->net_amount }}
                                </td>
                                <td></td>
                                <td>    </td>
                                
                                <td></td>
                                <td></td>
                                <td id="display-total-tax-amount">  

                                    
                                <td id="display-grand-amount">
                                   {{ $invoice->total_amount }}
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                                    <input name="total_gross_sum" id="total_gross_sum" type="hidden" value="{{ $invoice->net_amount }}" >
                                    <input name="total_tax_amount" id="total_tax_amount" type="hidden" value="{{ $invoice->total_tax }}" >
                                    <input name="total_grand_amount" id="total_grand_amount" type="hidden" value="{{ $invoice->total_amount }}" >
                                    <input name="total_net_discount" id="total_net_discount" type="hidden" value="{{ $invoice->net_amount }}" >
                                    <input name="amount_in_words" id="amount_in_words" type="hidden" value="{{ $invoice->amount_in_words }}" >
                                    <input name="customer_id" id="customer_id" type="hidden" value="{{ $invoice->customer_id }}" >
                    <table class="billing-info">
                        <tr class="bottom">
                            <td class="border-right">
                                <table>
                                    <tr>
                                        <td class="title center">
                                            <h3>Supply Address</h3>
                                             <select class="select-2 invoice-supply-address" name="supply_id" >
                                                @foreach($supply_address as $da)
                                                    <option value="{{ $da->id }}">{{ $da->venue }} | {{ $da->address }}</option>
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
                                    <tr>
                                        <td class="center">
                                            <h3>BANK DETAILS</h3>
                                        </td>
                                    </tr>
                                    <tr></tr>

                                    <tr class="flex-td">
                                        <td>
                                            <b>Name : RAINBOW</b> <br />
                                            <b> Bank : ICICI BANK</b>
                                        </td>
                                    </tr>
                                    <tr class="flex-td">
                                        <td>
                                            <b>A/c No. : 628505015233</b> <br />
                                            <b> IFSC Code: ICIC0006285</b>
                                        </td>
                                    </tr>
                                    <tr class="flex-td">
                                        <td class="center"><b>Address : Rajlok, 4, Civil Lines, Boundary Road, Meerut (UP) - 250001</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="center background">
                        <tr>
                            <td><b>Amount in words :</b> <span id="amountinword"> {{ $invoice->amount_in_words ?? '' }}</span></td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                                Terms and conditions

                                <p>1.) E. & O.E.</p>
                                <p>2.) Payment should be received within 7 days of receipt of bill.</p>
                                <p>3.) Any dispute on bills, should be notified within 3 days of receipt of bill.</p>
                                <p>4.) Delhi courts shall be the final jurisdiction for any disputes.</p>
                                <p>5.) PAN AAJFV5838Q</p>

                                <p class="center">This is a system generated {{ $invoice->invoice_type }} and does not require a signature.</p>
                            </td>
                        </tr>
                    </table>

                    <table class="billing-info center">
                        <tr>
                            {{-- <td><button class="email">Email</button></td>
                            <td><button class="whatapp">Whatapp</button></td>
                            <td><button class="send">Send</button></td> --}}
                            <td colspan="4"><button class="btn btn-submit" >Update</button></td>
                        </tr>
                    </table>
                </table>
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
'                                    <input type="hidden" class="pname" name="pname[]" value="" />'+
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
'                                    <td><input class="td-input-width item-discount" type="number" name="pdiscount[]" value=""/></td>'+
'                                    <td class="cgst"></td>'+
'                                    <input type="hidden" class="cgst" name="cgst[]" value="" />'+
'                                    <td class="sgst"></td>'+
'                                    <input type="hidden" class="sgst" name="sgst[]" value="" />'+
'                                    <td class="igst"></td>'+
'                                    <input type="hidden" class="igst" name="igst[]" value="" />'+
'                                    <td class="tax-amount"></td>'+
'                                    <td class="total-amount"></td>'+
'                                    '+
'                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="" />'+
'                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="" /><input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="" />'+
'                        </tr>';

        //get_item_sum_with_tax();
        $( myvar ).insertBefore(".inser-div-before");
        $('.select-item-product').select2();
        

    });


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
    <script type="text/javascript" src="{{ asset('resources/js/invoice.js?v='.time()) }}"></script>
    </body>
</html>
