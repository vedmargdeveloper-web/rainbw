@extends(_app())

@section('title', 'Create Pitch')

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
            ?>
            @php
                $invoice_last_y = date('y')+1;
                $totalInquiry =  App\Models\Inquiry::count()+1;
                
                // dd();
            @endphp
            <form action="{{ route('inquiry.store') }}" method="post" id="invoice-submit">
                @csrf
                <div class="invoice-box">
                    <table class="billing-info">
                        <tr class="td-no-padding">
                           
                            <span style="display:none ;" id="default-invoice-no">
                                <?= "FY".date('y')."-".$invoice_last_y."/GC/X/$totalInquiry" ?>
                            </span>

                            <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/INQ/$totalInquiry"; ?> 
 
                            <td rowspan="" class="td-no-padding">
                                <div class="label">Unique ID: </div>
                                <div class="field-group">
                                    {{-- <input type="" name="unique_id" value=""> --}}
                                    <select required name="unique_id" id="unique_id">
                                        <option value="">Please Select </option>
                                        @php
                                            if(isset($_GET['id'])){
                                                $selected = $_GET['id'];
                                            }else{
                                                $selected = ''; 
                                            }
                                        @endphp
                                         @foreach($inquiry as $inq)
                                            <option value="{{ $inq->id }}"  {{ ($inq->id ==  $selected ) ? 'selected=""' :'' }}> {{ $inq->unique_id }}</option>
                                         @endforeach
                                    </select> 
                                </div>
                            </td>

                            <td class="text-right td-no-padding" >
                                <div class="label"></div>
                                <div class="field-group" >
                                <b>Lead Status</b>
                                    <select name="lead_status">
                                        @foreach($leads as $lead)
                                            <option value="{{ $lead->id }}">{{ $lead->lead }}</option>
                                        @endforeach
                                    </select>
                                        <b>Source</b>
                                    <select name="source_id">
                                        @foreach($sources as $source)
                                            <option value="{{ $source->id }}">{{ $source->source }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>       
                        </tr>
                        <tr class="td-no-padding">
                            <td></td>
                            <td class="text-right td-no-padding">
                               
                            </td>
                        </tr>
                        <tr class="">
                            <td class="">
                                <div class="label">Customer Type:  </div>
                                <div class="field-group">
                                    <span id="cp_type"></span>
                                    @foreach($customer_type as $ct)
                                        <label for="{{ $ct->code }}"><input type="radio"  id="{{ $ct->code }}" name="customer_type" value="{{ $ct->id }}"> {{ $ct->type }}</label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
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
                                                    <input type="text" name="client_name" class="w-100" >
                                                    {{-- <input type="text" name="company_name"  placeholder="Client Name" class="w-100 mt-2" id="company_name" style="display: none;"> --}}
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
                                        <tr class="venue_name" >
                                            <td>
                                                <div class="label">Venue Name :</div> 
                                                <div class="field-group td-city-width">
                                                     <input type="text" name="venue_name"  class="w-100 mt-2" id="venue_name" required="" >
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="label">Address :</div> 
                                                <div class="field-group">
                                                    <input type="text" class="form-control- w-100" name="daddress" value="" required="" >
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
                                                                <div class="ccity-div"  style=" margin-left: -6px;">
                                                                    {{-- <input type="text" name="ccity" class="custom-pincode" value="" > --}}
                                                                    <select class="form-control-" name="ccity">
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
                                                                     <select class="form-control-" name="cstate">
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
                                                                <input type="text" class="ml-2" name="clandmark" value="" class="w-100">
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
                                                    <input type="text" class="w-100" name="contact_person_c" value="" required >
                                                </div>
                                            </td>
                                            <input type="hidden"  name="select_two_name" id="select_two_name">
                                        </tr>
                                         <tr class="pincode-inner-tr"  >
                                            <td colspan="2">
                                               <table>
                                                  <tbody>
                                                    <tr>
                                                        <td style="width: 50%;" class="td-no-padding">
                                                            <div class="label">Mobile:</div> 
                                                            <div class="field-group">
                                                                  <input type="text" class="w-100" name="cmobile" value=""  required=''>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state label-whatsapp">WhatsApp</div> 
                                                            <div class="field-group td-whatsapp">
                                                                <input type="text" class="w-100" name="cwhatsapp" value=""  required=''>
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
                                                    <input type="text" class="w-100" name="cemail" value="" required >
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
                                                         
                                                            <div class="field-group">
                                                                <select class="form-control-" name="occasion_id">
                                                                        @foreach($occasion as $st)
                                                                                <option value="{{ $st->id }}">{{ $st->occasion }} </option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="td-no-padding">
                                                            <div class="label label-state ">Readyness</div> 
                                                            <div class="field-group">
                                                                <input type="text" class="ml-2" name="creadyness" value="" class="w-100" required="">
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
                                                                        <input type="text" class="w-100" name="dlandmark" value="" style="margin-left: -8px;" >
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
                                                                                    <select class="form-control-" name="dcity">
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
                                                                               <div class="dstate-div"> 
                                                                                    <select class="form-control-" name="dstate">
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
                                                                            <div class="label label-state label-whatsapp">Readyness:</div> 
                                                                            <div class="field-group">
                                                                                <input type="text" name="dreadyness" value="" > 
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
                                                <div class="label">Remark :</div> 
                                                <div class="field-group">
                                                    <input type="text" name="remark" class="td-remark" >
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                    @php $item = App\Models\Item::get(); @endphp
                    <table class="table-grid td-item-table no-border-top" cellspacing="0" style="display: none;">

                        <tbody>
                            {{-- style="background: #ffa5d740;"  --}}
                            <tr class="sub-heading-item" >
                                
                                <td rowspan="1" >Item</td>
                                <td rowspan="1" style="width: 75px;">Qty</td>
                                <td rowspan="1" style=" width: 173px;">Days</td>
                                <td rowspan="1">Date</td>
                                <td rowspan="1">Time</td>
                                <td rowspan="1">Time</td>
                                <td rowspan="1">Venue</td>
                            </tr>


                            <tr class="center item">

                                 
                                    <td class="item">
                                        <select class="form-control- select-2 select-item-product" name="item_id[]" >
                                                <option value="">Please Select Product</option>
                                                @foreach($item as $it)
                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td ><input type="number"  class="w-100" min="1" name="qty[]" value="" /></td>
                                    <td ><input type="number"  class="w-100" min="1" name="days[]" value="" /></td>
                                    <td ><input type="date"  class="w-100" name="date[]" value="" /></td>
                                    <td ><input type="time"  class="w-100" name="time[]" value="" /></td>
                                    <td ><input type="time"  class="w-100" name="time_two[]" value="" /></td>
                                    <td ><input type="text"  class="w-100" name="venue[]" value="" /></td>
                            </tr>

                            {{-- <tr class="inser-div-before">
                                <td colspan="7">
                                    <center>
                                        <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">ADD ITEM</a>
                                    </center>
                                </td>
                            </tr> --}}
                            {{-- 
                            <tr class="center bottom-footer-tr">
                                <td></td>
                                <td colspan="1">Tax Payable on Rev. Charge Basis: NO</td>
                                <td colspan="1">Net Amount</td>
                                <td id="display-gross-total-amount">0
                                </td>
                                
                                <td id="display-total-tax-amount"></td>

                                    
                                <td id="display-grand-amount">
                                   0
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">Amount in words :</td>
                                <td colspan="7"><input name="amount_in_words" id="amount_in_words" type="text" value="" class="w-100" ></td>
                            </tr> --}}
                        
                        </tbody>
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
                var myvar =  '<tr class="center item">'+
                        ''+
                        '                                    <td class="space"><span class="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></span></td>'+
                        '                                    <td class="item">'+
                        '                                        <select class="form-control- select-2 select-item-product" name="item_id[]" >'+
                        '                                                <option value="">Please Select Product</option>'+
                        '                                                @foreach($item as $it)'+
                        '                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>'+
                        '                                                @endforeach'+
                        '                                        </select>'+
                        '                                    </td>'+
                        '                                    <td ><input type="number"  class="w-100" min="1" name="qty[]" value="" /></td>'+
                        '                                    <td ><input type="number"  class="w-100" min="1" name="days[]" value="" /></td>'+
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