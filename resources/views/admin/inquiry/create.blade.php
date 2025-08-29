@extends(_app())

@section('title', 'Create Inquiry')

@section('content')

    <div class="main-container">
        <style type="text/css">
            .dstate-div input{
                    width: 164px;
            }
            .width-70{
                width: 69% !important;
            }
            /*span#select2-contact_person_c-yn-container {
                    background: #e9f4f8;
                    height: 18px;
                }
            span#select2-3kkp-container {
                background: #e9f4f8;
                height: 18px;
            }*/
            span.select2-selection.select2-selection--single {
                background: #e9f4f8;
                height: 18px;
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
               $inquiry =  App\Models\Inquiry::get(['unique_id','id']);
               $da = date('Y-m-d');
            ?>

             @php
                $invoice_last_y = date('y')+1;
                $totalInquiry =  App\Models\Inquiry::count()+2;
                
            @endphp
        
             <span id="get_pre_city" style="display: none;">
                <option value="">Select</option>
                @foreach($city as $st)
                    <option value="{{ $st->city }}">{{ $st->city }} </option>
                @endforeach
             </span>
             <span id="get_pre_state" style="display: none;">
                <option value="">Select</option>
                @foreach($state as $st)
                    <option value="{{ $st->state }}">{{ $st->state }} </option>
                @endforeach
             </span>

            <form action="{{ route('inquiry.store') }}" method="post" id="invoice-submit">
                @csrf
                <div class="invoice-box">
                   

                    <table class="billing-info">
                        <tr class="td-no-padding">
                            <span style="display:none ;" id="default-invoice-no">
                                <?= getFinancialYear($da,"y")."/X/$totalInquiry" ?>
                            </span>
                            <?php 

                            $invoice_no = getFinancialYear($da,"y")."/INQ/$totalInquiry"; ?> 
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Unique ID: </div>
                                <div class="field-group tn-margin-left-side">
                                    <input type="" name="unique_id" value="<?=  $invoice_no ?>">
                                </div>
                            </td>
                            <td class="text-right td-no-padding relative" >
                                <div class="label"></div>
                                <div class="field-group" >
                                <b class="lead-td">Lead Status : Open</b>
                                
                                <input type="hidden" name="lead_status" value="9" readonly="">
                                {{-- <select name="lead_status">
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" >{{ $lead->lead }}</option>
                                    @endforeach
                                </select> --}}
                                    <b>Source</b>
                                     <select name="source_id" class="tn-lead-status mandatory" required>
                                        <option value="">Select</option>
                                    @foreach($sources as $source)
                                        <option value="{{ $source->id }}">{{ $source->source }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </td> 
                        </tr>

                        <tr class="td-no-padding">  
                            <td rowspan="" class="td-no-padding">
                                {{-- <div class="label">Unique ID: </div>
                                <div class="field-group">
                                    <select name="uid" id="quotation_unique_id">
                                            <option value="1"> FY22-23/GC/INQ/1</option>
                                            <option value="2" selected=""> FY22-23/GC/INQ/2</option>
                                    </select> 
                                </div> --}}
                            </td>
                            <td class="text-right td-no-padding">
                                <div class="label"></div>
                                <div class="field-group" style="padding-right: 37px;">
                                    
                                    <b><span id="change_billing_type">Inquiry </span> Date :</b>
                                    <input type="date" name="inquire_date" class="mandatory" value="" required="">
                                </div>
                            </td>  
                        </tr>
                        <tr class="td-no-padding">  
                            <td rowspan="" class="td-no-padding">
                                {{-- <div class="label">Unique ID: </div>
                                <div class="field-group">
                                    <select name="uid" id="quotation_unique_id">
                                            <option value="1"> FY22-23/GC/INQ/1</option>
                                            <option value="2" selected=""> FY22-23/GC/INQ/2</option>
                                    </select> 
                                </div> --}}
                            </td>
                            <td class="text-right td-no-padding">
                                <div class="label"></div>
                                <div class="field-group" style="padding-right: 37px;">
                                    
                                    <b><span id="change_billing_type">Event </span> Date :</b>
                                    <input type="date" name="event_date" class="mandatory" value="" required="">
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
                                                <div class="field-group tn-left-margin-less">
                                                    <select class="select-2 invoice-customer-type mandatory"  required> 
                                                        <option value=""></option>   
                                                    </select>
                                                   <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;">
                                                   {{--  <input type="text" name="client_name" class="w-100" > --}}
                                                    {{-- <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;"> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group tn-left-margin-less">
                                                    <input type="text" class="form-control- w-100"  name="caddress" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label"></div> 
                                                <div class="field-group tn-left-margin-less">
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
                                        
                                        <tr class="" >
                                            <td>
                                                <div class="label">Venue Name :</div> 
                                                <div class="field-group td-city-width">
                                                     <select class="select-2 invoice-delivery-address" name="delivery_id"  required>
                                                        <option value=""> Select </option>
                                                            @foreach($delivery_address as $da)
                                                                <option value="{{ $da->id }}">{{ $da->venue }}</option>
                                                            @endforeach    
                                                          
                                                    </select>
                                                     {{-- <input type="text" name="venue_name"  class="w-100 mt-2" id="venue_name" required="" > --}}
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        <tr class="venue_name" style="display:none;">
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
                                                    <input type="text" class="form-control- mandatory w-100" name="daddress" value="" required="" >
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
                                                            <div class="field-group tn-left-margin ml-2">
                                                                <div class="ccity-div"  style=" margin-left: -6px;">
                                                                    {{-- <input type="text" name="ccity" class="custom-pincode" value="" > --}}
                                                                    <select class="form-control" name="ccity" required="">
                                                                        <option value="">Select</option>
                                                                        @foreach($city as $st)
                                                                                <option value="{{ $st->id }}">{{ $st->city }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="label label-state">State :</div> 
                                                            <div class="field-group state-select">
                                                                <div class="cstate-div" >
                                                                     <select class="form-control" name="cstate" required="">
                                                                        <option value="">Select</option>
                                                                        @foreach($state as $st)
                                                                            <option value="{{ $st->id }}">{{ $st->state }} </option>
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
                                                                <input type="number" name="cpincode" value="" class="custom-pincode">
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state">Landmark</div> 
                                                            <div class="field-group">
                                                                <input type="text" class="ml-2" name="clandmark"  value=""  maxlength="48" class="w-100">
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
                                                    <input type="text" class="w-100 mandatory" name="contact_person_c" value="" required >
                                                </div>
                                            </td>
                                            {{-- <input type="hidden"  name="select_two_name" id="select_two_name"> --}}
                                        </tr>
                                         <tr class="pincode-inner-tr"  >
                                            <td colspan="2">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Mobile:</div> 
                                                            <div class="field-group">
                                                                  <input type="number" class="w-100 mandatory" name="cmobile" id="customer_mobile" value=""  required=''>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-whatsapp label-state">WhatsApp</div> 
                                                            <div class="field-group td-whatsapp">
                                                                <input  type="number" class="w-100 mandatory" name="cwhatsapp" value=""  required=''>
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
                                                    <input type="text" class="w-100 mandatory" name="cemail" value="" required >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">GSTIN :</div> 
                                                <div class="field-group width-full">
                                                    <input type="text" class="w-100 mandatory" name="cgstin" value="" >
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
                                                                <select class="form-control-" name="occasion_id">
                                                                        <option>Select</option>
                                                                        @foreach($occasion as $st)
                                                                                <option value="{{ $st->id }}">{{ $st->occasion }} </option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state label-whatsapp">Readyness</div> 
                                                            <div class="field-group td-whatsapp">
                                                                <input type="text" class="w-100 mandatory" name="creadyness" value=""  required="">
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
                                                                <div class="field-group width-full tn-field-group">
                                                                    <input type="text" class="w-100" name="dlandmark" maxlength="48" value="" style="margin-left: -8px;" >
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
                                                                            <div class="field-group tn-left-margin">
                                                                                {{-- <input type="text" class="w-75" name="dcity" value="" >  --}}
                                                                                <div class="dcity-div">
                                                                                    <select class="form-control- mandatory" name="dcity" required="">
                                                                                        <option value="">Select</option>
                                                                                        @foreach($city as $st)
                                                                                                <option value="{{ $st->id }}">{{ $st->city }} </option>
                                                                                        @endforeach
                                                                                    </select>  
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                            <div class="label label-state">State :</div> 
                                                                            <div class="field-group">
                                                                               <div class="dstate-div "> 
                                                                                    <select class="form-control- mandatory tn-input-filed" name="dstate" required="">
                                                                                        <option value="">Select</option>
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
                                                <div class="label">Contact  Person : </div> 
                                                <div class="field-group width-full tn-field-group tn-field-group-width">
                                                    <input type="text"  class="width-full-set" name="dperson" value="" >
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="label">Mobile :</div> 
                                                <div class="field-group tn-field-group">
                                                    <input type="number"  name="dmobile" value="" class="width-full-set">
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
                                                                            <div class="field-group tn-field-group">
                                                                                <input type="number" class="w-75" name="dpincode" value="" > 
                                                                            </div>
                                                                        </td>
                                                                        <td class="td-no-padding">
                                                                           {{--  <div class="label label-whatsapp label-state">Readyness:</div> 
                                                                            <div class="field-group tn-field-group-right">
                                                                                <input type="text" name="dreadyness" value="" class="tn-dreadyness" > 
                                                                            </div> --}}
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
                                                <div class="label">Remark :</div> 
                                                <div class="field-group tn-field-group">
                                                    <input type="text" name="remark" maxlength="48" class=" width-full-set" >
                                                </div>
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
                                <td rowspan="1" >Action</td>
                                <td rowspan="1" >Item</td>
                                <td rowspan="1" style="width: 75px;">Qty</td>
                                <td rowspan="1" style=" width: 173px;">Days</td>
                            </tr>

                            <tr class="center item">
                                    <td class="space"><span class="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></span></td>
                                    <td class="item">
                                        <select class="form-control select-2 select-item-product" name="item_id[]" required >
                                                <option value="">Please Select Product</option>
                                                @foreach($item as $it)
                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td ><input type="number" required class="w-100" name="qty[]" value="" /></td>
                                    <td ><input type="number" required class="w-100" name="days[]" value="" /></td>
                            </tr>

                            <tr class="inser-div-before">
                                <td colspan="7">
                                    <center>
                                        <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">ADD ITEM</a>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="billing-info- center">
                        <tbody>
                            <tr>
                                <input name="customer_id" id="customer_id" type="hidden" value="0">
                                <input type="hidden"  name="select_two_name" id="select_two_name">
                                <td><button class="send -btn-submit">Save </button></td>
                            </tr>
                    </tbody>
                </table>
                </div>
                
            </form>


            <a href="#" class="history-btn" style="display: none;">Existing User</a>
            <div class="modal fade" id="show-history-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">History</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="history-table">
                           
                        </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                  </div>
                </div>
              </div>
            </div>

            <script>

                $("#add-more-btn").click(function(){
                let error = 0;
                $("input[name='qty[]']").each(function(index,val){
                     if($(this).val()==''){
                         swal("Qty !", "Qty is required", "error", {
                                button: "Ok!",
                            });
                         error = 1;
                        return false;
                     }
                });

                $("input[name='pdays[]']").each(function(index,val){
                     if($(this).val()==''){
                         swal("Day !", "Day is required", "error", {
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
                            '                                        <select class="form-control  select-2 select-item-product" required name="item_id[]" >'+
                            '                                                <option value="">Please Select Product</option>'+
                            '                                                @foreach($item as $it)'+
                            '                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>'+
                            '                                                @endforeach'+
                            '                                        </select>'+
                            '                                    </td>'+
                            '                                    <td ><input type="number"  class="w-100" required name="qty[]" value="" /></td>'+
                            '                                    <td ><input type="number"  class="w-100" required  name="days[]" value="" /></td>'+
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