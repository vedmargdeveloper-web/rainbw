<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
    </head>
    <style>
         *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Work Sans', sans-serif;
        }
        :root{
        
            --black: #000;
            --white:#ffff;
            --helper : hsl(50deg 27% 82%);
            --red: hsl(0deg 99% 50%);
            --blue: hsl(199deg 100% 52%);
        }
        .main-container{
            padding:5px 40px;
        }
        .container{
            padding: 10px 40px;
            border: 1px solid black;
        }
        table{
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td,th{
            border: 1px solid var(--black);
            text-align: left;
            padding: 8px;
        }
        .no-border{
            border:none!important;
        }
        table{
             font-size: 14px;
        }
        /* .table-info{
            font-size: 11px;
        } */
    </style>
    <body>
        <section>
            <div class="main-container">
                <div class="container">
                    <table class="billing-info">
                        <tbody>
                            <tr>
                                <td class="no-border"></td>
                                <td colspan="1" class="text-center no-border">
                                    Lead Status
                                    <b> Open </b>
                                </td>
                            </tr>

                            <tr>
                                <td class="no-border">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="no-border" style="width: 140px;">
                                                    <div class="label">Date:  </div>
                                                </td>
                                                <td class="no-border" >{{ date('d-m-Y',strtotime($pitch->date))  }} </td>
                                            </tr>
                                            <tr>
                                                <td class="no-border" style="width: 140px;"  >
                                                    <div class="label">Minutes of Discussion (MOD):</div>
                                                </td>
                                                <td class="no-border">{{ $pitch->mods  }}</td>
                                            </tr>
                                            <tr>
                                                <td class="no-border" style="width: 140px;" >
                                                    <div class="label ">Revised Quote: <span></span> </div>
                                                </td>
                                                <td class="no-border">{{ $pitch->revised_quote  }}</td>
                                            </tr>
                                            <tr>
                                                <td class="no-border" style="width: 140px;">
                                                    <div class="label ">Next Appointment: <span></span></div>
                                                </td>
                                                <td class="no-border">{{ $pitch->next_appointment  }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>

                    <table class="table-grid td-item-table no-border-top" cellspacing="0">
                        <tbody class="table-info">
                            <tr class="sub-heading-item">
                             
                                <td rowspan="2">Item</td>
                                <td rowspan="2">Rate</td>
                                <td rowspan="2">Qty</td>
                                <td rowspan="2"> Days</td>
                                <td rowspan="2">Gross Amount</td>
                                <td rowspan="2">Discount</td>
                                <td colspan="3" style="text-align: center;">Tax Rate</td>
                                <td rowspan="2">Tax Amount</td>
                                <td rowspan="2" >Total Amount</td>
                            </tr>

                            <tr class="heading">
                                <td>CGST</td>
                                <td>SGST</td>
                                <td>IGST</td>
                            </tr>
                            <tr class="center item">
                                <td class="item-display">Platform Crane Zero Degrees</td>
                                <td class="item_rate">
                                   4
                                </td>
                                <td class="item_qty">8</td>
                                <td class="item_pday">9</td>
                                <td class="gross-amount">288.00</td>
                                <td>9</td>
                              
                                <td class="sgst">9</td>
                              
                                <td class="igst">0</td>
                              
                                <td class="tax-amount">50.40</td>
                                <td class="total-amount">330.40</td>
                                <td class="total-amount">244.26</td>
                            </tr>
                            <tr class="center item">
                                <td colspan="4">Net Rate</td>
                                <td class="item_qty">500</td>
                                <td class="item_pday">0</td>
                                <td class="item_pday"></td>
                                <td class="item_pday"></td>
                                <td class="item_pday"></td>
                                <td class="gross-amount">9180</td>
                                <td class="gross-amount">60180</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>
</html>
