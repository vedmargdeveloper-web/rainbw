<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <div class="main-container">
            <div class="content-wrapper">
                <style>
                    /**{
                            margin: 0px; !important;
                            padding: unset; !important;

                        }*/
                    .invoice-box-challan {
                        margin: 10px 10px;
                    }
                    .billing-info tr td > div.field-group {
                        width: unset !important;
                    }
                    .green {
                        background: unset;
                    }
                    .margin-top-tr-info {
                        top: -10px;
                        position: relative;
                    }
                    .billing-information-challan {
                        /*border-left: 2px solid black;
                            border-top: 2px solid black;
                            border-right: 2px solid black;*/
                    }
                    table.invoice-header-challan {
                        /* border-top: 2px solid #333; */
                        /* border-left: 2px solid #333; */
                        /* border-right: 2px solid #333; */
                        border: unset;
                    }
                    .invoce-table-bord {
                        border: 2px solid #333;
                    }
                    .billing-info {
                        border: unset;
                    }
                    #main-table-challan thead tr td:nth-child(1) {
                    }
                    #main-table-challan tr td:last-child {
                    }
                    #main-table-challan tr td:nth-child(1) {
                    }
                    #main-table-challan thead tr td:last-child {
                    }

                    .billing-information-challan tr td:nth-child(1) {
                        font-weight: 600;
                        text-align: right;
                        width: 13%;
                    }
                    .billing-information-challan tr td:nth-child(2){
                        text-align: left!important;
                        background-color: transparent!important;
                    }

                    .billing-information-challan tr td:nth-child(3) {
                        font-weight: 600;
                        text-align: right;
                    }
                    .billing-information-challan tr td:nth-child(2) {
                        background-color: unset;

                        border-bottom: 0.5px solid #000;
                        width: unset;
                    }
                    .billing-information-challan tr td:nth-child(4) {
                        
                        border-bottom: 0.5px solid #000;
                        text-align: left!important;
                        background: transparent;
                    }
                    .billing-information-challan tr td:nth-child(6) {
                        background: transparent;
                        text-align: left;
                        border-bottom: 0.5px solid #000;
                        width: 122px;
                    }
                    .billing-information-challan tr td:nth-child(5) {
                        text-align: right;
                        font-weight: 600;
                    }
                    .billing-information-challan tr td:nth-child(7) {
                        text-align: right;
                        font-weight: 600;
                    }
                    .billing-information-challan tr td:nth-child(8) {
                        background: transparent;
                        border-bottom: 0.5px solid #000;
                        text-align: left;
                    }
                    .billing-information-challan tr td {
                        padding: 2px 5px;
                    }
                    .billing-information-challan td {
                        height: 10px;
                    }
                    #main-table-challan tr td {
                        padding: 2px 4px;
                        text-align: center;
                        font-size: 12px;
                    }
                    .td-item-table-challan tbody.main-td tr td {
                        border:1px solid;
                    }
                    .border-right-challan {
                        border-right: 2px solid #000;
                    }
                    thead.thead tr td {
                        border: 1px solid !important;
                    }
                    .bank-detail {
                    }
                    .bank-detail tr {
                    }
                    .bank-detail tr td.border {
                        border-bottom: 2px solid #000;
                    }
                    .bank-detail tr td {
                        padding: 3px 5px;
                    }

                    .conditions-challan thead {
                    }
                    .conditions-challan td {
                        padding: 0.5px 8px;
                    }
                    .conditions-challan th {
                        padding: 0px 8px;
                    }
                    .conditions-challan thead td {
                        border: unset !important;
                    }
                    .conditions-challan thead td:first-child {
                        text-align: center;
                        background: #f2f2f2;
                        border-color: #fff;
                    }
                    .conditions-challan thead th,
                    .conditions-challan tbody tr td{
                        /* background: #bfbfbf;
                          font-size: 15px;
                          padding: 1px 0;*/
                        text-align: left!important;
                    }
                    .conditions-challan tbody th {
                        background: #f2f2f2;
                        font-size: 12px;
                        padding: 3px 0;
                    }
                    .conditions-challan tbody tr td:first-child {
                        /*  background: #f2f2f2;
                          text-align: center;*/
                    }
                    .conditions-challan tbody tr td:nth-child(3) {
                        background: #f2f2f2;
                        text-align: center;
                    }

                    .not-sale-challan {
                    }
                    .not-sale-challan th {
                        padding: 5px 0;
                        text-decoration: underline;
                        font-size: 25px;
                        background: #000;
                        color: #fff;
                    }
                    .invoice-box-challan tbody td {
                        font-size: 10px;
                        border: 0;
                        padding: 1px 0px;
                    }
                    .invoice-box-challan .gst-head-ul {
                        list-style: none;
                        text-align: left;
                    }
                    .invoice-box-challan table tbody tr td {
                        text-align: center;
                    }
                    .invoice-print-table-cutom td,
                    .invoice-print-table-cutom th{
                        padding: 5px!important;
                    }
                    .billing-information-challan td,
                    .billing-information-challan th{

                    }
                    .btn-save-challan{
                            display: flex;
                            justify-content: center;
                    }
                    .btn-print{
                        box-shadow: 0 0 15px #cccc;
                        padding: 6px 10px;
                        text-decoration: none;
                        color: black;
                        text-transform: uppercase;
                    }
                    
                    .btn-save{
                            box-shadow: 0 0 15px #cccc;
                            padding: 6px 10px;
                            text-decoration: none;
                            color: black;
                            text-transform: uppercase;
                            margin-right: 12px;
                            cursor: pointer;
                    }
                    .btn-save:hover,.btn-print:hover{
                        border-bottom: 2px solid;
                        transition: 0.2s;
                    }

                </style>
                @php
                   $meta_value =  App\Models\Meta::where('meta_name','branch_office')->first()->meta_value;
                @endphp
                <form action="" method="post" id="invoice-submit-challan">
                    <div class="invoice-box-challan">
                        <div class="invoce-table-bord invoice-print-table-cutom" style="width: 780px; margin: 50px auto;">
                            <table cellpadding="0" class="invoice-header-challan" cellspacing="0" width="100%" style="border-bottom: 1.5px solid;">
                                <tbody>
                                    <tr class="top">
                                        <td class="left-grid" style="width: 40%; border-right: 1px solid;">
                                            <table style="position: relative; border: 0;">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: right; padding-right: 0;"><strong>GSTIN : </strong></td>
                                                        <td style="text-align: left; padding-left: 0;">
                                                            <strong> 09AAXFR1185Q1Z1 </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right; padding-right: 0; padding-top: 0;"><strong> Udyam Reg. No. : </strong></td>
                                                        <td style="text-align: left; padding-left: 0; padding-top: 0;"><strong> UDYAM-UP-56-0012462</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="" style="font-size: 10px; padding-top: 10px;">
                                                            <ul class="gst-head-ul">
                                                                <li>Rental Services of Golf Carts</li>
                                                                <li>Rental Services of VIP Luxury Mobile Toilets</li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                        <td>
                                            <table width="100%" style="border: 0;">
                                                <tbody>
                                                    <tr>
                                                        <td class="center" colspan="2">
                                                            <b><u>Delivery Challan</u></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" colspan="2">
                                                            <h2 style="margin: 0;">RAINBOW</h2>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="center" colspan="2" style="font-size: 10px;">
                                                            Head Office: <span id="head_office">G.F.19, VIDYA LAXMI COMPLEX, 182, ABU LANE, MEERUT (UP) - 250001 </span> <br />
                                                            Branch Office:<span id="branch_office"> Plot No. 6-B, Near Bhagwani Nursery,Village Jonapur, Chattarpur, Delhi - 110047</span> <br />
                                                            <span id="temp_address"></span>
                                                            <span>Website : www.rainbowrentals.co.in</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="flex-td">
                                                        <td>
                                                            <b>Mobile : <span id="head_mobile">9997771234</span></b>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <b>Email: <span id="head_email">sales@rainbowgolfcarts.co.in</span></b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @php $client = json_decode($booking->customer_details,true); $delivery = json_decode($booking->delivery_details,true); @endphp
                            <br>
                            <table class="billing-information-challan" style="width: 100%; border: unset;">
                                <body>
                                    <tr>
                                        <td>Ref. Booking No. :</td>
                                        <td colspan="1" style="display: inline-block; height: 18px;">{{ $booking->invoice_no ?? '' }}</td>
                                        <td colspan="4"></td>
                                        <td style="background: unset; border: unset; width: 100%; display: block; text-align: right!important;">Dated:</td>
                                        <td style=" font-weight: 400; background: transparent;border-bottom: 0.5px solid black;text-align: left;font-size: 13px;padding: 0 7px!important;letter-spacing: 0.6px;"><?= date('d-m-Y') ?></td>
                                        <!-- <td colspan="3" style="border-bottom: unset;"></td> -->
                                    </tr>
                                    <tr>
                                        <?php
                                            $last_y = date('y')+1;
                                            $challan_no = "FY".date('y')."-".$last_y."/GC/DC/"; 
                                            $totalchallan = App\Models\Challan::count();
                                        ?>
                                        <td>Delivery Challan No.:</td>
                                        <input type="hidden" name="challan_no"  value="{{ $challan_no }}{{ $totalchallan+1 }}">
                                        <td style="display: inline-block; border-bottom: 0.5px solid #000; width: unset; height: 18px; text-align: left; font-weight: 400;">{{ $challan_no }}{{ $totalchallan+1  }}</td>
                                        <td colspan="4" style="background: none;border: none;"></td>

                                        <td style="background: unset; border: unset; width: 80px; text-align: right!important;">Delivery Challan Date :</td>
                                        <td style="background: transparent; padding: 0!important; border-bottom: 0.5px solid black; text-align: center;">
                                            <input style="background: unset;border:unset;" type="date" value="<?= $challan ? $challan->challan_date : date('Y-m-d') ?>" name="challan_date" > </td>
                                    </tr>

                                    <tr>
                                        <td>Customer Type:</td>
                                        <td style="display: block; width: 30px; height: 19px;">B2B</td>
                                        <td colspan="3" style="background: unset;"></td>
                                        <td style="background: unset; text-align: right!important; font-weight: 600; border: 0;">
                                            <p style="border-bottom: 1px solid; display: inline-block;">
                                                Delivery Address:
                                            </p>
                                        </td>
                                        <td colspan="3" style="background: unset;"></td>
                                    </tr>
                                </body>
                            </table>
                            <table class="billing-information-challan" style="width: 100%; border: unset;">
                                <tbody>
                                    
                                    <tr>
                                        <td>Client: </td>
                                        <td colspan="3">{{ $client['company_name'] ?? '' }}</td>

                                        <td style="width: 20%;">Venue:</td>
                                        <td colspan="3" style="width: 35%;">
                                            {{ $delivery['dvenue_name'] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td colspan="3" style="max-width: 100px;">{{ $client['ccaddress'] ?? '' }}</td>

                                        <td>Address:</td>
                                        <td colspan="3" style="max-width: 100px;">{{ $delivery['daddress'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3">{{ $client['ccaddress1'] ?? '' }}</td>

                                        <td></td>
                                        <td colspan="3">{{ $delivery['daddress1'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>City:</td>
                                        <td>{{ $client['ccity'] ?? '' }}</td>
                                        <td>State:</td>
                                        <td>{{ $client['cstate'] ?? '' }}</td>
                                        <td>City:</td>
                                        <td>{{ $delivery['dcity'] ?? '' }}</td>
                                        <td>State:</td>
                                        <td>{{ $delivery['dstate'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pin Code:</td>
                                        <td>{{ $client['cpincode'] ?? '' }}</td>
                                        <td>Landmark:</td>
                                        <td></td>

                                        <td>Landmark:</td>
                                        <td colspan="3">{{ $delivery['dlandmark'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Person:</td>
                                        <td colspan="3">
                                            {{ $client['contact_person_c'] ?? ''  }}
                                    </td>
                                        <td></td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile:</td>
                                        <td colspan="3">{{ $client['cmobile'] ?? '' }}</td>
                                        <td>Contact Person</td>
                                        <td colspan="3">{{ $delivery['dperson'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td colspan="3">{{ $client['cemail'] ?? '' }}</td>

                                        <td>Mobile:</td>
                                        <td colspan="3">{{ $delivery['dmobile'] ?? '' }}  </td>
                                    </tr>
                                    <tr>
                                        <td>GSTIN:</td>
                                        <td colspan="3">{{ $client['cgstin'] ?? '' }}</td>
                                        <td>Pin Code:</td>
                                        <td>{{ $delivery['dpincode'] ?? '' }}</td>
                                        <td>Readyness:</td>
                                        <td>{{ $booking->readyness ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <br />
                            <table class="td-item-table-challan no-border-top- m-width" id="main-table-challan" cellspacing="0" width="100%" style="width: 80%; margin: 0 auto; border:0.5px solid;">
                                <thead class="thead">
                                    <tr class="sub-heading-item">
                                        <td rowspan="2">S.No</td>
                                        <td rowspan="2">HSN Code </td>
                                        <td rowspan="2" style="width: 22%;">Description of Goods/Services</td>
                                        <td rowspan="2" style="width: 20%;">Item</td>
                                        <td rowspan="2">Qty</td>
                                        <td rowspan="2">Value</td>
                                    </tr>
                                </thead>
                               
                                <tbody class="main-td">
                                    <tr class="item">
                                        <td>1</td>
                                        <td class="hsn">{{ $newitem->item->hsn  ?? ''}}</td>
                                        <td class="item-display">{{ $newitem->item->description ?? '' }}</td>
                                        <td class="item">
                                            {{ $newitem->item->name  ?? 'sss' }}
                                        </td>

                                        <td class="item_qty green">
                                            1
                                        </td>

                                        <td class="item_pday green">
                                            {{  $newitem->value ?? ''}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br />
                            <table class="Supply-add" style="width: 80%; margin: 0 auto; border: 2px solid #000;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 0;font-size: 13px;text-decoration: underline;display: flex;align-items: center;justify-content: space-around;">
                                            Supply Address : <textarea style="border:unset;" name="supply_address" cols="50">{{ $challan ? $challan->supply_address  : $meta_value }} </textarea> 
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <br />
                            <table class="not-sale-challan" style="width: 80%; margin: 0 auto; border: 2px solid #000;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 0; text-decoration: underline;">
                                            The Above Mentioned Article Is NOT FOR SALE
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <br />
                            <table class="conditions-challan" style="width: 100%; border-top: 1.5px solid #000; border-left: 0; border-right: 0;">
                                <thead>
                                    <tr>
                                        <th style="border: 0;">Terms & Conditions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>E.&amp;.O.E.</td>
                                    </tr>
                                    <tr>
                                        <td>Delhi courts shall be the only jurisdiction for any disputes.</td>
                                    </tr>
                                    <tr>
                                        <td>PAN - AAJFV5838Q</td>
                                    </tr>
                                    <tr>
                                        <td>TAN - MRTR10927A</td>
                                    </tr>
                                </tbody>
                            </table>

                            <center><p class="center" style="padding: 5px;">This is a system generated Delivery Challan and does not require a signature.</p></center>
                        </div>
                        <div class="btn-save-challan">
                            <input type="hidden" value="{{ $unique_id_tr }}" name="unique_id_tr" />
                            @if($challan)
                                <div class="btn-edit"> Edit  Challan  </div>
                            @endif
                            
                            <div class="btn-save"> Save  Challan  </div>
                            <a class="btn-print" href="{{ route('logistics.challan.print') }}?id={{ $id }}&item_id={{ $item_id }}"> Print Challan </a>
                        </div>
                     
                    </div>
                    
                </form>

            </div>
        </div>

    </body>
</html>
