@extends(_app())

@section('title', 'Edit Inquiry')

@section('content')

    <div class="main-container">

        <div class="content-wrapper">
            <link rel="stylesheet" type="text/css" href="{{ asset('resources/css/invoice.css?v='.time()) }}">
              <style type="text/css">
                .invoice-box{
/*                     max-width: 1200px; */
                }
            .dstate-div input{
                    width: 164px;
            }
            .width-70{
                width: 69% !important;
            }
            .billing-info tr td{
                width:unset;
            }
            span.select2-selection.select2-selection--single {
                background: #e9f4f8;
                height: 18px;
            }
            .bb-2{
                border-bottom: 2px solid;
                min-height: 22px;
            }
            .td-state-pin .field-group{
               
            }
            .td-state-pin .label-state{
                width: 65px!important;
                text-align:right!important;
            }
            .billing-info tr td>div.field-group{
                width: 100%!important;
            }
            .tn-billing-info-top .field-group input{
                border:unset;
            }
            .billing-info tr td>div.label{
                margin-right: 0;
            }
            .billing-info tr td>div.label{
                width: 100%;
            }
        </style>
            <?php
               $customer_type =  App\Models\CustomerTypeMaster::get();
               
               $delivery_address =  App\Models\Address::where('type','delivery')->get();
               $customers =  App\Models\Customer::where('customer_type',$inquiry->customer_type)->get();
               $supply_address =  App\Models\Address::where('type','supply')->get();
               $meta        =  App\Models\Meta::all();
               $leads       =  App\Models\Lead::get();
               $sources     =  App\Models\Source::get();
               $occasion    =  App\Models\Occasion::get();
               $inquiries   =  App\Models\Inquiry::get();           
               $gstMaster   =  App\Models\GstMaster::all();
               $term_and_conditions = $meta->where('meta_name', 'term')->first();
               $gst         = $meta->where('meta_name','gst')->first()->meta_value;
               $udyam_reg   = $meta->where('meta_name','udyam_reg')->first()->meta_value;
               $head_office = $meta->where('meta_name','head_office')->first()->meta_value;
               $branch_office  = $meta->where('meta_name','branch_office')->first()->meta_value;
               $email  = $meta->where('meta_name','email')->first()->meta_value;
               $phone  = $meta->where('meta_name','mobile')->first()->meta_value;

            ?>

            @php
                $invoice_last_y = date('y')+1;
                $totalInquiry =  App\Models\Inquiry::count()+1;
                $customer = json_decode($inquiry->customer_details,true);
                $venue_details = json_decode($inquiry->venue_details,true);
            @endphp
        
             

            <form action="{{ route('inquiry.update',['inquiry'=>$inquiry->id]) }}" method="post" id="invoice-submit">
                 {{ method_field('PATCH') }}
                @csrf

                <div class="invoice-box">
                    <table class="billing-info main tn-billing-info-top">
                        <tbody>
                            <tr class="td-no-padding">
                                <?php $invoice_no = "FY".date('y')."-".$invoice_last_y."/GC/INV/$totalInquiry"; ?> 
                                <td><div class="label">Unique ID:</div></td>
                                <td colspan="2">
                                         <input type="" name="unique_id" value="<?=  $inquiry->unique_id ?? '' ?>">  
                                </td>
                                <td colspan="3" style="text-align: center;">
                                    @php
                                    $selected = $inquiry->leadstatus ? $inquiry->leadstatus->status  : '';
                                @endphp
                                <b  >Lead Status 
                                <select name="lead_status" class="mandatory" style="width: 60px;">
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" {{ ( $selected== $lead->lead) ? 'selected=""' : '' }}> {{ $lead->lead }}
                                        </option>
                                    @endforeach
                                </select></b>
                                   
                                </td>

                                <td><div class="label">Source:</div></td>
                                <td>
                                     <select name="source_id" class="mandatory tn-lead-status">
                                    @foreach($sources as $sourcevie)
                                        <option value="{{ $sourcevie->id }}" {{ ($inquiry->sources_id == $sourcevie->id) ? 'selected=""' : '' }}>{{ $sourcevie->source }}</option>
                                    @endforeach
                                </select>
                                </td>
                            </tr>
                            <tr class="td-no-padding">
                               
                                <td></td>
                                <td></td>
                                <td colspan="4" style="text-align: center;"></td>

                                <td><div class="label">Inquiry Date:</div></td>
                                <td>
                                    <input type="date" class="mandatory" name="inquire_date" value="{{ $inquiry->inquire_date ?? '' }}" required="">
                                </td>
                            </tr>
                             <tr class="td-no-padding">
                               
                                <td></td>
                                <td>
                                    
                                </td>
                                <td colspan="4" style="text-align: center;">
                                </td>

                                <td><div class="label">Event Date:</div></td>
                                <td>
                                    <input type="date" class="mandatory" name="event_date" value="{{ $inquiry->event_date ?? '' }}" required="">
                                </td>
                            </tr>

                            <tr class="">
                                <td class="">
                                    <div class="label">Customer Type:</div>
                                </td>
                                <td colspan="3">
                                    <div class="field-group" style="border:unset;">
                                        <span id="cp_type"></span>
                                        @foreach($customer_type as $ct)
                                            <label for="{{ $ct->code }}"><input type="radio"  id="{{ $ct->code }}" {{ ($inquiry->customer_type == $ct->id )  ? 'checked=""' : '' }} name="customer_type" value="{{ $ct->id }}"> {{ $ct->type }}</label>
                                        @endforeach
                                    </div>
                                </td>

                              
                            </tr>
                            <tr>
                                  <td><div class="label">Client Name:</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                        {{ $inquiry->customer->company_name ?? '' }}
                                    </div>
                                </td>
                                  <td>
                                    <div class="label">Venue Name :</div>
                                </td>
                                <td colspan="3">
                                    <div class="field-group">
                                        {{ $inquiry->address->venue ?? "" }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                              
                                <td><div class="label">Address :</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                       {{ $inquiry->customer->address ?? '' }}
                                    </div>
                                </td>
                                   <td><div class="label">Address :</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                       {{ $inquiry->address->address ?? "" }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <div class="field-group">
                                      {{ $inquiry->customer->address1 ?? '' }}
                                    </div>
                                </td>
                                <td></td>
                                <td colspan="3">
                                    <div class="field-group">
                                        {{ $inquiry->address->address1 ?? "" }}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="label">City :</div></td>
                                <td>
                                    <div class="field-group">
                                         {{ $inquiry->customer->customer_city->city ?? '' }}
                                    </div>
                                </td>
                                <td><div class="label">State :</div></td>
                                <td>
                                    <div class="field-group">
                                        {{ $inquiry->customer->customer_state->state ?? '' }}
                                    </div>
                                </td>

                                <td><div class="label label-state">Landmark :</div></td>
                                <td colspan="3"><div class="field-group">
                                     {{ $inquiry->address->landmark ?? "" }}
                                </div></td>
                            </tr>
                            <tr>
                                <td><div class="label">Pincode :</div></td>
                                <td>
                                    <div class="field-group">
                                      {{ $inquiry->customer->pincode ?? '' }}
                                    </div>
                                </td>
                                <td><div class="label label-state label-whatsapp">Landmark :</div></td>
                                <td>
                                    <div class="field-group">
                                        {{ $inquiry->customer->landmark ?? '' }}
                                    </div>
                                </td>
                                 @if($inquiry->delivery_id != 'other')
                                  <td><div class="label">City :</div></td>
                                    <td>
                                        <div class="field-group">
                                           {{ $inquiry->address->icity->city ?? "" }}
                                        </div>
                                    </td>
                                    <td><div class="label label-state">State :</div></td>
                                    <td>
                                        <div class="field-group">
                                            {{ $inquiry->address->istate->state ?? "" }}
                                        </div>
                                    </td>
                                    @else
                                     <td><div class="label">City :</div></td>
                                        <td>
                                            <div class="field-group">
                                                {{ $inquiry->address->icity->city ?? "" }}
                                            </div>
                                        </td>
                                        <td><div class="label label-state">State :</div></td>
                                        <td>
                                            <div class="field-group">
                                                {{ $inquiry->address->istate->state ?? "" }}
                                            </div>
                                        </td>
                                    @endif
                               
                            </tr>
                            <tr>
                                <td><div class="label">Contact Person :</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                        @php
                                            $contact_person        = json_decode($inquiry->customer->contact_person_name,true);
                                            $contact_person_mobile = json_decode($inquiry->customer->mobile,true);
                                        @endphp

                                        {{ $contact_person[$customer['contact_person_c'] ?? 0] ?? $contact_person[0] }}
                                    </div>
                                </td>
                                <td><div class="label">Contact Person :</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                       {{ $inquiry->address->contact_person_name ?? "" }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="label">Mobile :</div></td>
                                <td>
                                    <div class="field-group">
                                        {{ $contact_person_mobile[$customer['contact_person_c'] ?? 0] ?? $contact_person_mobile[0] }}
                                    </div>
                                </td>
                                <td><div class="label">Whatsapp :</div></td>
                                <td>
                                    <div class="field-group">
                                          <input type="text" style="border:unset;" value="{{ $customer['cwhatsapp'] ?? '' }}" name="cwhatsapp"  required />
                                    </div>
                                </td>

                                <td><div class="label label-state">Mobile :</div></td>
                                <td colspan="3"><div class="field-group">
                                     {{ $inquiry->address->mobile ?? "" }}
                                </div></td>
                            </tr>
                            <tr>
                                <td><div class="label">Email :</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                        {{ $inquiry->customer->email ?? '' }}
                                    </div>
                                </td>
                                 <td><div class="label">Pincode :</div></td>
                                <td>
                                    <div class="field-group">
                                        {{ $inquiry->address->pincode ?? "" }}
                                    </div>
                                </td>
                                <td><div class="label label-state label-whatsapp">Readyness</div></td>
                                <td>
                                    <div class="field-group">
                                         <input type="text" class="ready-input" name="dreadyness" value="{{ $venue_details['readyness'] ?? '' }}" > 
                                    </div>
                                </td>
                            </tr>
                            <tr>
                               <td>
                                    <div class="label">GSTIN :</div>
                                </td>
                                <td colspan="3">
                                    <div class="field-group">
                                         {{ $inquiry->customer->gstin ?? '' }}
                                    </div>
                                </td>
                                <td><div class="label">Remark :</div></td>
                                <td colspan="3">
                                    <div class="field-group">
                                         <input type="text" name="remark"  value="{{ $venue_details['remark'] ?? '' }}" class="tn-contact-person" >
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="">
                                    <div class="label">Occasion :</div>
                                </td>
                                <td>
                                    <div class="field-group">
                                        <select class="form-control--" style="width: 108px;" name="occasion_id">
                                            @foreach($occasion as $st)
                                                    <option value="{{ $st->id }}"  {{ ( $inquiry->occasion_id == $st->id ) ? 'selected=""' :'' }}>{{ $st->occasion }} </option>
                                            @endforeach
                                    </select>
                                    </div>
                                </td>

                                <td>
                                    <div class="label">Readyness :</div>
                                </td>
                                <td >
                                    <div class="field-group">
                                        
                                    <input type="text" style="border: unset; background:unset;" class="ml-2 readyness-cls mandatory" name="creadyness" value="{{ $customer['creadyness'] ?? '' }}" class="w-100" required="">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                   
                    @php 
                        $item = App\Models\Item::get();
                        $inquiry_items = App\Models\EnquireItem::where('inquiry_id',$inquiry->id)->get();
                        
                    @endphp
                    
                    <table class="table-grid td-item-table no-border-top" cellspacing="0">

                        <tbody>
                            {{-- style="background: #ffa5d740;"  --}}
                            <tr class="sub-heading-item" >
                                <td rowspan="1" >Action</td>
                                <td rowspan="1" >Item</td>
                                <td rowspan="1" style="width: 75px;">Qty</td>
                                <td rowspan="1" style=" width: 173px;">Days</td>
                                {{-- <td rowspan="1">Date</td> --}}
                                {{-- <td rowspan="1">Time</td>
                                <td rowspan="1">Venue</td>
                                <td rowspan="1">Address</td> --}}
                            </tr>

                            @foreach($inquiry_items as $inquiry_item)

                            <tr class="center item">
                                    <td class="space"><span class="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></span></td>
                                    <td class="item">
                                        <select class="form-control select-2 select-item-product" name="item_id[]"  required>
                                                <option value="">Please Select Product</option>
                                                @foreach($item as $it)
                                                    <option value="{{ $it->id }}" {{ ($it->id == $inquiry_item->item_id) ? 'selected=""' : '' }}>{{ $it->name }}</option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td ><input type="number"  class="w-100" required min="1" name="qty[]" value="{{ $inquiry_item->qty }}" /></td>
                                    <td ><input type="number"  class="w-100" required min="1" name="days[]" value="{{ $inquiry_item->days }}" /></td>
                                    {{-- <td ><input type="date"  class="w-100" name="date[]" value="{{ $inquiry_item->date }}" /> </td> --}}
                                    {{-- <td ><input type="time"  class="w-100" name="time[]" value="{{ $inquiry_item->time }}" /></td> --}}
                                    {{-- 
                                    <td><input type="text"  class="w-100" name="venue[]" value="{{ $inquiry_item->venue }}" /></td>
                                    <td><input type="text"  class="w-100" name="time_two[]" value="{{ $inquiry_item->time_two }}"/></td> 
                                    --}}
                                    
                            </tr>
                            @endforeach

                            <tr class="inser-div-before">
                                <td colspan="7">
                                    <center>
                                        <a href="javascript:void(0)" id="add-more-btn" class="btn btn-primary">ADD ITEM</a>
                                    </center>
                                </td>
                            </tr>
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
                    {{-- <input type="" name=""> --}}
                    <table class="billing-info- center">
                        <tbody>
                        <tr>    
                            <input type="hidden" name="customer_id" value="{{ $inquiry->customer_id  ?? ''}}">
                            <td><button class="send -btn-submit">Updated</button></td>
                        </tr>
                    </tbody></table>
                </div>
                
            </form>

            <a href="#" class="history-btn" style="display: none;">Existing User</a>
                
            <div class="modal fade" id="show-history-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"  aria-hidden="true">
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
                $(function(){
                    $("#customer_mobile").focusout();
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
'                                        <select class="form-control select-2 select-item-product" required name="item_id[]" >'+
'                                                <option value="">Please Select Product</option>'+
'                                                @foreach($item as $it)'+
'                                                    <option value="{{ $it->id }}">{{ $it->name }}</option>'+
'                                                @endforeach'+
'                                        </select>'+
'                                    </td>'+
'                                    <td ><input type="number" min="1" required class="w-100" name="qty[]" value="" /></td>'+
'                                    <td ><input type="number" min="1" required  class="w-100" name="days[]" value="" /></td>'+
'                            </tr>';
                    //get_item_sum_with_tax();
                    $( myvar ).insertBefore(".inser-div-before");
                    $('.select-item-product').select2();
                    

                });
            </script>

            <script>
                     $(function(){
                            $('.main-gst-selection').change();
                            
                            //$('.invoice-supply-address').find('option[value={{ $inquiry->supply_id ?? '' }}]').attr("selected",true);


                            $('.invoice-supply-address').change();
                               // $('input[name="customer_type"]').change();
                                setTimeout(function() {
                                        @if( $inquiry->customer_id != 0)
                                            $('.invoice-customer-type').find('option[value={{ $inquiry->customer_id }}]').attr("selected",true);
                                            $(".invoice-customer-type").select2();
                                           // $(".invoice-customer-type").change();  
                                        @endif
                                }, 1000);
                                
                                if($('input[name="daddress"]').val()==''){  
                                    // alert('xd');  
                                    // $('.invoice-delivery-address').find('option[value="{{ $inquiry->delivery_id }}"]').attr("selected",true);
                                    $(".invoice-delivery-address").select2();
                                    $(".invoice-delivery-address").change();
                                } 
                                @php
                                    $index =  $customer['contact_person_c'];
                                @endphp
                                
                                setTimeout(function() {
                                        $('.select-two-name').find('option[value="{{ $index }}"]').attr("selected",true);
                                        $(".select-two-name").select2();
                                        $('.select-two-name').change();
                                        // alert('xd{{ $index }}');
                                }, 5000);
                                
                           });
                </script>
            <script type="text/javascript" src="{{ asset('resources/js/invoice.js?v='.time()) }}"></script>

        </div>

    </div>


@endsection