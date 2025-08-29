@extends(_app())

@section('title', 'Create Challan')

@section('content')

    <div class="main-container">
        <style type="text/css">
            .dstate-div input{
                    width: 164px;
            }
        </style>
        <div class="content-wrapper">
            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">

            <?php
        	   $customer_type =  App\Models\CustomerTypeMaster::get();
               $delivery_address =  App\Models\Address::where('type','delivery')->get();
               $supply_address =  App\Models\Address::where('type','supply')->get();
               $meta =  App\Models\Meta::all();
               $gstMaster =  App\Models\GstMaster::all();
            //    $performaInvoice = App\Models\Quotation::all();
               $performaInvoice = App\Models\Quotation::orderBy('created_at', 'desc')->get();
                 $occasion =  App\Models\Occasion::get();

               $challanTypes  = App\Models\ChallanTypeMaster::all();


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

            <form action="{{ route('challan.store') }}" method="post" id="challan-submit">
                @csrf
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
                                                    <option {{ $key == 0 ? 'selected' : '' }} data-state="{{ $gm->state }}" value="{{ $gm->id }}"> {{ strtoupper($gm->gstin) }}</option>
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
                                    </tr> --}}
                                    <tr>
                                        <td colspan="2" class="pt-20" style="font-size: 10px;">
                                            <ul class="gst-head-ul">
                                               
                                            </ul>
                                        </td>
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
                        <tr class="td-no-padding">
                             <?php
                                $da = date('Y-m-d');
                                $getFull_years  = getFinancialFullYear($da);
                                $start_date     =  $getFull_years['start_year'].'-04-01';
                                $end_date       =  $getFull_years['end_year'].'-03-31';
                                $totalChallan =  App\Models\PerformaInvoiceChallan::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count()+1;
                                
                            ?>
                            <span style="display:none;" id="default-invoice-no">
                                <?= getFinancialYear($da, "y") . "/X/" ?>
                            </span>

                            <?php $challan_no = getFinancialYear($da,"y")."/CH/$totalChallan"; ?> 
 
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Serial No.: </div>
                                <div class="field-group">
                                    <input type="hidden" name="challan_no" value="<?= $challan_no ?>" id="challan_no_hidden">
                                    <b id="challan_no_display"><?= $challan_no ?></b>
                                </div>
                            </td>
                            <td class="text-right td-no-padding" >
                                <div class="label"></div>
                                <div class="field-group" style="    padding-right: 37px;">
                                    {{-- <b>{{ date('d.m.Y') }}</b> --}}
                                    <b><span id="change_billing_type">Challan</span> Date :</b>
                                    <input type="date" name="billing_date" value="{{ date('d.m.Y') }}">
                                </div>
                            </td>
                        </tr>
                        <tr class="td-no-padding">
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Ref. PI No.: </div>
                                <div class="field-group">
                                    <select name="ref_pi_no" class="field-group select-2 " style="width: 150px;">
                                        <option value="">Select PI No.</option>
                                        @foreach($performaInvoice as $pi)
                                            <option value="{{ $pi->invoice_no }}">{{ $pi->invoice_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                          <td class="text-right td-no-padding">
                                <div class="label"></div>
                                <div class="field-group" style="padding-right: 37px;">
                                    <b>Challan Time :</b>
                                    <input type="time" name="event_time" value="{{ date('H:i') }}">
                                </div>
                            </td>

                            
                        </tr>
                        <tr class="td-no-padding">
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Challan Type: </div>
                                <div class="field-group">
                                    {{-- <select name="challan_type" class="field-group select-2 " style="width: 150px;">
                                        <option value="">Select Type</option>
                                        <option value="challan">Delivery Challan</option>
                                        <option value="return-challan">Return Challan</option>
                                    </select> --}}
                                     <select name="challan_type" class="field-group select-2" style="width: 150px;">
                                        <option value="">Select Type</option>
                                        @foreach($challanTypes as $type)
                                            <option value="{{ $type->type_name }}">{{ $type->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="text-right td-no-padding">
                            </td>

                            
                        </tr>
                         <tr class="td-no-padding">
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Rental Start Date :  </div>
                                <input type="date" name="start_date"  /> </td>
                             <td class="text-right td-no-padding">
                            </td>
                            
                        </tr>
                        <tr class="td-no-padding">
                          <td class="td-no-padding"> 
                            <div class="label">Rental End Date : </div>
                          <input type="date" name="end_date" /></td>
                             <td class="text-right td-no-padding">
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
                                <label for="compition">
                                    <input type="checkbox" name="compition" value="1" id="compition" >
                                    Compition
                                </label>
                                <br/>
                                <div class="label">Customer Type:  </div>
                                <div class="field-group">
                                    <span id="cp_type"></span>
                                    @foreach($customer_type as $ct)
                                        <label for="{{ $ct->code }}"><input type="radio"  id="{{ $ct->code }}" name="customer_type" value="{{ $ct->id }}"> {{ $ct->type }}</label>
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
                                                        <option value=""></option>   
                                                    </select>
                                                    <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100"  name="caddress" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100"  name="caddress1" value="" >
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
                                                                <option value="{{ $da->id }}">{{ $da->venue }}</option>
                                                            @endforeach    
                                                            <option value="other">Other</option>
                                                    </select>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr class="venue_name" style="display: none;">
                                            <td>
                                                <div class="label">Venue Name :</div> 
                                                <div class="field-group td-city-width">
                                                     <input type="text" name="venue_name" placeholder="Venue Name" class="w-100 mt-2" id="venue_name" style="display: none;">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress1" value="" >
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
                                                                <div class="ccity-div"  style=" margin-left: -6px;"><input type="text" name="ccity" class="custom-pincode" value="" ></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="label label-state">State :</div> 
                                                            <div class="field-group state-select">
                                                                <div class="cstate-div" > <input type="text" name="cstate" value="" >  </div>
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
                                                                <input type="number" name="cpincode" value="" class="custom-pincode">
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">Landmark</div> 
                                                            <div class="field-group">
                                                                <input type="text" class="ml-2" name="clandmark" value="" class="w-100">
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
                                                    <input type="text" class="w-100" name="contact_person_c" value="" >
                                                </div>
                                            </td>
                                            <input type="hidden"  name="select_two_name" id="select_two_name">
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="2">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group width-full">
                                                    <input type="number" class="w-100" name="cmobile" value="" >
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
                                                                                <input type="number" class="custom-pincode" name="cmobile" value="" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">Whatsapp:</div> 
                                                                            <div class="field-group">
                                                                                <input type="number" name="cwhatsappmobile" value="" class="w-95 ml-2" > 
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
                                                    <input type="text" class="w-100" name="cemail" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">GSTIN :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100" name="cgstin" value="" >
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
                                                                <select class="form-control select-2" name="occasion_id" readonly="readonly" style="height: 20px !important;" >
                                                                        @foreach($occasion as $st)
                                                                                <option value="{{ $st->id }}"  >{{ $st->occasion }} </option>
                                                                        @endforeach
                                                                </select>
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
                                                                        <input type="text" class="w-100" name="dlandmark" value=""  >
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
                                                                                    <input type="text" name="dcity" class="w-100" value="">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">State :</div> 
                                                                            <div class="field-group">
                                                                               <div class="dstate-div"> 
                                                                                    <input type="text" name="dstate" value="">  
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
                                                    <input type="text" class="w-100" name="dperson" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group width-full">
                                                    <input type="number" class="w-100" name="dmobile" value="" >
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
                                                                                <input type="number" class="w-75" name="dpincode" value="" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">Readyness:</div> 
                                                                            <div class="field-group">
                                                                                <input type="text" name="readyness" value="" > 
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
                            <tr class="sub-heading-item" >
                                <td rowspan="2" >S.No</td>
                                <td rowspan="2" style="width: 50px;">SAC Code</td>
                                <td rowspan="2" style="width: 50px;">HSN Code</td>
                                <td rowspan="2" style=" width: 173px;">Description of Goods/Services</td>
                                <td rowspan="2" style="width: 100px;">Item</td>
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
                            <tr class="center item">
                                    <td class="space"><span class="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></span></td>
                                    <td class="sac"></td>
                                    <input type="hidden" class="psac" name="psac[]" value="" />
                                    <td class="hsn"></td>
                                    <input type="hidden" class="phsn" name="phsn[]" value="" />
                                    <td class="item-display"></td>
                                    <input type="hidden" class="pdescription"  name="pdescription[]" value=""   />
                                                                        <div style="margin-top: 5px;">
                                        <input type="hidden" name="from_date[]" class="from_date" value="{{ date('d.m.Y') }}" style="background-color: yellow;" />
                                        <input type="hidden" name="to_date[]" class="to_date" value="{{ date('d.m.Y') }}" style="background-color: yellow;" />
                                    </div>    
                                    <input type="hidden" class="pname" name="pname[]" value="product name"  />
                                    <td class="item">
                                        <select class="form-control select-2 select-item-product" name="item_id[]"  style="width: 150px !important; white-space: normal; word-wrap: break-word;">
                                                <option value="">Please Select Product</option>
                                                @foreach($item as $it)
                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>
                                                @endforeach
                                        </select>
                                    </td>
                                   
                                    <td class="item_rate">
                                        <input class="td-input-width item-gross-total"  type="number" name="prate[]" value=""  />
                                    </td>
                                    <td class="item_qty"><input class="td-input-width item-gross-total"  type="number"   name="pqty[]" value="0" /></td>
                                    <td class="item_pday"> <input class="td-input-width item-gross-total"  type="number"   name="pday[]" value="0" /></td>
                                    <td class="gross-amount">0</td>
                                    {{-- <td class="my-discount"><input class="td-input-width item-discount" type="number" name="pdiscount[]"  value="0"/></td> --}}
                                    <td class="cgst"></td>
                                    <input type="hidden" class="cgst" name="cgst[]" value="0" />
                                    <td class="sgst"></td>
                                    <input type="hidden" class="sgst" name="sgst[]" value="0" />
                                    <td class="igst"></td>
                                    <input type="hidden" class="igst" name="igst[]" value="0" />
                                    <td class="tax-amount"></td>
                                    <td class="total-amount"></td>
                                    
                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="" />
                                     <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="" />
                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="" />
                            </tr>

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
                                <td id="display-gross-total-amount">0
                                </td>
                                <td>0</td>
                                <td>0</td>
                                
                                <td>0</td>
                                <td>0</td>
                                <td id="display-total-tax-amount">0</td>

                                    
                                <td id="display-grand-amount">
                                   0
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Amount in words :</td>
                                <td colspan="11"><input name="amount_in_words" id="amount_in_words" type="text" value="" class="w-100" ></td>
                            </tr>
                        
                        </tbody>
                    </table>


                    <input name="total_gross_sum" id="total_gross_sum" type="hidden" value="0" >
                    <input name="total_tax_amount" id="total_tax_amount" type="hidden" value="0" >
                    <input name="total_grand_amount" id="total_grand_amount" type="hidden" value="0" >
                    <input name="total_net_discount" id="total_net_discount" type="hidden" value="0" >
                    
                    <input name="customer_id" id="customer_id" type="hidden" value="0" >

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
                            {{-- <td>
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
                            </td> --}}
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
                   
                    <table>
                        {{-- <tr>
                            <td>Start Date : <input type="date" name="start_date"  /> End Date :<input type="date" name="end_date" /></td>
                            
                        </tr> --}}
                        <tr>
                            <td >
                                {{-- {!! $term_and_conditions->meta_value !!} --}}

                                <p class="center">This is a system generated <span id="footer_invoice_type">Invoice</span> and does not require a signature.</p>

                            </td>
                        </tr>
                    </table>

                    <table class="billing-info- center">
                        <tr>
                            <td><button  class="send btn-submit">Save </button></td>
                        </tr>
                    </table>
                </div>
                
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

                var myvar = '<tr class="center item">'+
                '                                    <td class="space"><span class="remove-btn">X</span></td>'+
                '                                    <td class="sac"></td>'+
                '                                    <input type="hidden" class="psac" name="psac[]" value="" />'+
                '                                    <td class="hsn"></td>'+
                '                                    <input type="hidden" class="phsn" name="phsn[]" value="" />'+
                '                                    <td class="item-display"></td>'+
                '                                    <input type="hidden" class="pdescription"  name="pdescription[]" value="" />'+
                '                                    <input type="hidden" class="from_date" name="from_date[]" value="" />'+
                '                                    <input type="hidden" class="to_date" name="to_date[]" value="" />'+
                '                                    <input type="hidden" class="pname" name="pname[]" value="product name" />'+
                '                                  '+
                '                                    <td class="item"  style="white-space: normal; word-wrap: break-word; max-width: 100px !important;">'+
                '                                        <select class="form-control select-2 select-item-product" name="item_id[]"  style="width: 100px; white-space: normal; word-wrap: break-word;" >'+
                '                                                <option value="">Please Select Product</option>'+
                '                                                @foreach($item as $key => $it)'+
                '                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>'+
                '                                                @endforeach'+
                '                                        </select>'+
                '                                    </td>'+
                '                                   '+
                '                                    <td class="item_rate">'+
                '                                        <input class="td-input-width item-gross-total"  type="number" name="prate[]" value="0" />'+
                '                                    </td>'+
                '                                    <td class="item_qty"><input class="td-input-width item-gross-total"  type="number" name="pqty[]"  value="0" /></td>'+
                '                                    <td class="item_pday"> <input class="td-input-width item-gross-total"   type="number" name="pday[]" value="0" /></td>'+
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
                '                                    <input type="hidden" class="pgros_amount" name="pgros_amount[]" value="0" />'+
                '                                    <input type="hidden" class="ptotal_amount" name="ptotal_amount[]" value="0" />'+
                '                                    <input type="hidden" class="ptax_amount" name="ptax_amount[]" value="0" />'+
                '                        </tr>';

                    //get_item_sum_with_tax();
                    $( myvar ).insertBefore(".inser-div-before");
                    $('.select-item-product').select2();
                    

                });
            </script>
           

            <script type="text/javascript" src="{{ asset('resources/js/challan.js?v='.time()) }}"></script>

        </div>

    </div>


@endsection