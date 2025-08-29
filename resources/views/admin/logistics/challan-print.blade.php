<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            /**{
                            margin: 0px; !important;
                            padding: unset; !important;

                        }*/
            .invoice-box-challan {
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
            #main-table-challan tr td {
                border: 1px solid;
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
                text-align: right !important;
                width: 15%;
            }
            .billing-information-challan tr td:nth-child(2) {
                text-align: left !important;
                background-color: #fde9d9 !important;
            }

            .billing-information-challan tr td:nth-child(3) {
                font-weight: 600;
                text-align: right !important;
            }
            .billing-information-challan tr td:nth-child(2) {
                background-color: unset;

                border-bottom: 1px solid #000 !important;
                width: unset;
            }
            .billing-information-challan tr td:nth-child(4) {
                border-bottom: 1px solid #000 !important;
                text-align: left !important;
                background: #fde9d9;
            }
            .billing-information-challan tr td:nth-child(6) {
                background: #fde9d9;

                border-bottom: 1px solid #000 !important;
            }
            .billing-information-challan tr td:nth-child(5) {
                text-align: right !important;
                font-weight: 600;
            }
            .billing-information-challan tr td:nth-child(7) {
                text-align: right !important;
                font-weight: 600;
            }
            .billing-information-challan tr td:nth-child(8) {
                background: #fde9d9;
                border-bottom: 1px solid #000 !important;
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
            .conditions-challan tbody tr td {
                /* background: #bfbfbf;
                          font-size: 15px;
                          padding: 1px 0;*/
                text-align: left !important;
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
            .invoice-print-table-cutom th {
                padding: 2px 2px !important;
            }
            .billing-information-challan td,
            .billing-information-challan th {
            }
        </style>
    </head>
    <body>
        <div class="main-container">
            <div class="content-wrapper">
                <form action="" method="post" id="invoice-submit-challan">
                    <div class="invoice-box-challan">
                        <div class="invoce-table-bord invoice-print-table-cutom" style="width: 100%; margin: 50px auto;">
                            <table cellpadding="0" class="invoice-header-challan" cellspacing="0" width="100%" style="border-bottom: 2px solid;">
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
                                                        <td style="text-align: left;">
                                                            <b>Mobile : <span id="head_mobile">9997771234</span></b>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <b>Email: <span id="head_email">vipul@rainbowrentals.co.in</span></b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @php $client = json_decode($booking->customer_details,true); $delivery = json_decode($booking->delivery_details,true); @endphp
                            <br />
                            <table class="billing-information-challan" style="width: 100%; border: unset;">
                                <tbody>
                                    
                                    <tr>
                                        <td>Delivery Challan No.:</td>
                                          <?php
                                            $last_y = date('y')+1;
                                            $challan_no = "FY".date('y')."-".$last_y."/GC/DC/"; 
                                            $totalchallan = App\Models\Challan::count();
                                        ?>
                                        <td colspan="1" style="display: block; width: 122px; min-height: 15px;">{{ $challan_no }}{{ $totalchallan+1  }}</td>
                                        <td colspan="3"></td>

                                        <td style="background: unset; border: unset !important; width: 100px; text-align: right !important;">Delivery Challan Date :</td>
                                        <td colspan="2" style="background: #fde9d9; border-bottom: 1px solid black; text-align: center;">01-01-2023</td>
                                    </tr>

                                    <tr>
                                        <td>Customer Type:</td>
                                        <td style="display: block; width: 25px; min-height: 15px;">B2B</td>
                                        <td colspan="3" style="background: unset;"></td>
                                        <td colspan="3" style="background: unset; text-align: left; font-weight: 600; border: 0;">
                                            <p style="border-bottom: 1px solid; display: inline-block;">
                                                Delivery Address:
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Client:</td>
                                        <td colspan="3">{{ $client['company_name'] ?? '' }}</td>

                                        <td style="width: 20%;">Venue:</td>
                                        <td colspan="3" style="width: 40%;">
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
                                       {{--  <td>Contact Person:</td>
                                        <td colspan="3">{{ ($client['contact_person_c'] == 0 ) ? $client['select_two_name'] : $client['contact_person_c'] }}</td>
                                        <td></td>
                                        <td colspan="3"></td> --}}
                                    </tr>
                                    <tr>
                                        {{-- <td>Mobile:</td>
                                        <td colspan="3">{{ $client['cgstin'] ?? '' }}</td>
                                        <td>Contact Person</td>
                                        <td colspan="3">{{ $delivery['dperson'] ?? '' }}</td> --}}
                                    </tr>
                                    <tr>
                                      {{--   <td>Email:</td>
                                        <td colspan="3">{{ $client['cemail'] ?? '' }}</td>

                                        <td>Mobile:</td>
                                        <td colspan="3">{{ $client['cmobile'] ?? '' }}</td> --}}
                                    </tr>
                                    {{-- <tr>
                                        <td>GSTIN:</td>
                                        <td colspan="3">{{ $client['cgstin'] ?? '' }}</td>
                                        <td>Pin Code:</td>
                                        <td>{{ $delivery['dpincode'] ?? '' }}</td>
                                        <td>Readyness:</td>
                                        <td>{{ $booking->readyness ?? '' }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>

                            <br />

                            <table class="td-item-table-challan no-border-top- m-width" id="main-table-challan" cellspacing="0" style="width: 90%; margin: 0 auto;">
                                <thead class="thead">
                                    <tr class="sub-heading-item">
                                        <td>S.No</td>
                                        <td>HSN Code</td>
                                        <td style="width: 28%;">Description of Goods/Services</td>
                                        <td style="width: 20%;">Item</td>

                                        <td>Qty</td>
                                        <td>Value</td>
                                    </tr>
                                </thead>

                                <tbody class="main-td">
                                    <tr class="item">
                                        <td>1</td>
                                        <td class="hsn">{{ $itemsingle->hsn_code }}</td>
                                        <td class="item-display">{{ $itemsingle->description }}</td>
                                        <td class="item">
                                            {{ $itemsingle->item }}
                                        </td>

                                        <td class="item_qty green">
                                            1
                                        </td>
                                        <td class="item_pday green">
                                            {{ $itemsingle->total_amount }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <br />
                            <table class="Supply-add" style="width: 90%; margin: 0 auto; border: 2px solid #000;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 0; font-size: 12px; text-decoration: underline;">
                                            Supply Address : H.No.25, Ladrey Mohalla, Near Bhagwani Nursery, Jonapur, Chattarpur, New Delhi - 110047
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <br />
                            <table class="not-sale-challan" style="width: 90%; margin: 0 auto; border: 2px solid #000;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 0; text-decoration: underline;">
                                            The Above Mentioned Article Is NOT FOR SALE
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                            <br />
                            <table class="conditions-challan" style="width: 100%; border-top: 2px solid #000; border-left: 0; border-right: 0;">
                                <thead>
                                    <tr>
                                        <th style="border: 0;">Terms & Conditions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1). E.&amp;.O.E.</td>
                                    </tr>
                                    <tr>
                                        <td>2). Delhi courts shall be the <b> only </b> jurisdiction for any disputes.</td>
                                    </tr>
                                    <tr>
                                        <td><b> 3). PAN - AAJFV5838Q </b></td>
                                    </tr>
                                    <tr>
                                        <td><b> 4). TAN - MRTR10927A </b></td>
                                    </tr>
                                </tbody>
                            </table>

                            <center><p class="center" style="padding-bottom: 10px;">This is a system generated Delivery Challan and does not require a signature.</p></center>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
