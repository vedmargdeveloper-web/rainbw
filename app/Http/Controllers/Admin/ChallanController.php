<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerformaInvoiceChallanItem;
use App\Models\PerformaInvoiceChallan;
use App\Http\Controllers\Admin\Mailer;
use Auth;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\GstMaster;
use App\Models\Customer;
use App\Models\Occasion;
use App\Models\Address;
use App\Models\Quotation;
use PDF;
use Storage;


class ChallanController extends Controller
{

    public function index(Request $request){
        $query = PerformaInvoiceChallan::with('customerType');

        if ($request->has('challan_type') && $request->challan_type != '') {
            $query->where('challan_type', $request->challan_type);
        }
        if ($request->has('challan_no') && $request->challan_no != '') {
            $query->where('challan_no', 'like', '%' . $request->challan_no . '%');
        }
        if ($request->has('ref_pi_no') && $request->ref_pi_no != '') {
            $query->where('ref_pi_no', 'like', '%' . $request->ref_pi_no . '%');
        }
        if ($request->has('customer_type') && $request->customer_type != '') {
            $query->where('customer_type', $request->customer_type);
        }

        $challans = (clone $query)
            ->where('challan_type', '!=', 'Returnable Challan - Given on Rent')
            ->get();

        $returnableChallans = (clone $query)
            ->where('challan_type', 'Returnable Challan - Given on Rent')
            ->get();

        $customerTypes = \App\Models\CustomerTypeMaster::all();
        $challanTypes  = \App\Models\ChallanTypeMaster::all();

        return view(
            _template('challan.index'),
            compact('challans', 'returnableChallans', 'customerTypes', 'challanTypes')
        );
    }



    public function create(Request $request){
        try {
            $challanType = $request->input('challan_type');
            $da = date('Y-m-d');
            $getFullYears = getFinancialFullYear($da);
            $start_date = $getFullYears['start_year'] . '-04-01';
            $end_date = $getFullYears['end_year'] . '-03-31';

            $totalChallan = PerformaInvoiceChallan::where('challan_type', $challanType)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->count();

            if ($request->ajax()) {
                return response()->json(['totalChallan' => $totalChallan]);
            } else {
                return view(_template('challan.create', ['title' => "title", 'totalChallan' => $totalChallan]));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function store(Request $request){
        if(!$request->gst_id){
            echo 'something wrong';
            return;
        }
        $lastChallan = PerformaInvoiceChallan::orderBy('id', 'desc')->first();

        if ($lastChallan && preg_match('/(\d+)$/', $lastChallan->challan_no, $matches)) {
            $lastNumber = (int) $matches[1]; 
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1; 
        }

    // Build challan no with prefix (you can make this dynamic if needed)
    $challan_no = "25-26/CH/" . $nextNumber;
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        $customer = Customer::where(['id'=>$request->customer_id])->first();
         $eventTime24 = $request->input('event_time');
        $eventTime12 = \Carbon\Carbon::createFromFormat('H:i', $eventTime24)->format('h:i A'); 
        if($request->customer_id == 0){
            $customer_details = [
                'ccaddress' => $request->caddress,
                'ccaddress1' => $request->caddress1,
                'ccity' => $request->ccity, 
                'company_name' => $request->company_name, 
                'cstate' => $request->cstate,
                'cpincode' => $request->cpincode, 
                'cmobile' => $request->cmobile, 
                'cwhatsappmobile' => $request->cwhatsappmobile, 
                'contact_person_c' => $request->contact_person_c,
                'cgstin' => $request->cgstin,
                'cemail' => $request->cemail
            ]; 
    } else{
            $customer_details = [
                'ccaddress' => $request->caddress,
                'ccaddress1' => $request->caddress1,
                'ccity' => $request->ccity, 
                'company_name' => $customer->company_name, 
                'cstate' => $request->cstate,
                'cpincode' => $request->cpincode, 
                'cmobile' => $request->cmobile, 
                'cwhatsappmobile' => $request->cwhatsappmobile, 
                'contact_person_c' => $request->contact_person_c,
                'select_two_name' => $request->select_two_name,
                'contact_name_edit' => $request->select_two_name,
                'cgstin' => $request->cgstin,
                'occasion_id' => $request->occasion_id,
                'creadyness'=>$request->creadyness,
                'cwhatsappmobile'=>$request->cwhatsappmobile

            ];       
        }

        $delvery_details = [
        'daddress' => $request->daddress,
        'daddress1' => $request->daddress1,
         'dcity' => $request->dcity, 
         'dstate' => $request->dstate, 
         'dpincode' => $request->dpincode, 
         'dmobile' => $request->dmobile, 
        'cwhatsappmobile' => $request->cwhatsappmobile, 
         'dlandmark' => $request->dlandmark, 
         'dperson' => $request->dperson,
         'dvenue_name' => $request->venue_name
        ];
        $supply_details = ['saddress' => $request->saddress,
         'scity' => $request->scity, 
         'sstate' => $request->sstate, 
         'spincode' => $request->spincode, 
         'smobile' => $request->smobile, 
         'cwhatsappmobile' => $request->cwhatsappmobile, 
         'slandmark' => $request->slandmark,
          'sperson' => $request->sperson
      ];
        $challan_data = ['user_id' => Auth::id() , 
        'challan_type' => $request->challan_type, 
        'challan_no' => $challan_no,
        'ref_pi_no'=> $request->ref_pi_no,
        'billing_date' => $request->billing_date,
        'event_time' => $eventTime12 ?? '',
        'customer_id' => $request->customer_id,
        'customer_type' => $request->customer_type,
        'customer_details' => json_encode($customer_details) ,
        'delivery_details' => json_encode($delvery_details) ,
        'delivery_id' => $request->delivery_id,
        'supply_id' => $request->supply_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'gst_id' => $request->gst_id,
        'supply_details' => json_encode($supply_details) ,
        'gst_details' => json_encode($gstMaster) ,
        'net_amount' => $request->total_gross_sum,
        'dayormonth' => $request->invoice_dayormonth,
        'readyness' => $request->readyness,
        'gst_id' => $request->gst_id,
        'total_tax' => $request->total_tax_amount,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'net_discount' => $request->total_net_discount ?? 0,
    ];


    // dd($request->all());
        $challan_id = PerformaInvoiceChallan::create($challan_data)->id;

        if ($request->has('pname')){
            $products = $request->pname;
            // foreach ($products as $key => $p){
            //    $challan_products = ['challan_id' => $challan_id, 'item_id' => $request->item_id[$key], 'hsn_code' => $request->phsn[$key], 'sac_code' => $request->psac[$key], 'description' => $request->pdescription[$key],'from_date' => $request->pfrom_date[$key],'to_date' => $request->pto_date[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
            //    PerformaInvoiceChallanItem::create($challan_products);
            // }
            foreach ($products as $key => $p) {
                $challan_products = [
                    'challan_id'     => $challan_id,
                    'item_id'        => $request->item_id[$key] ?? null,
                    'hsn_code'       => $request->phsn[$key] ?? null,
                    'sac_code'       => $request->psac[$key] ?? null,
                    'description'    => $request->pdescription[$key] ?? null,
                    'from_date'      => $request->pfrom_date[$key] ?? null,
                    'to_date'        => $request->pto_date[$key] ?? null,
                    'item'           => $request->pname[$key] ?? null,
                    'rate'           => $request->prate[$key] ?? 0,
                    'quantity'       => $request->pqty[$key] ?? 0,
                    'days'           => $request->pday[$key] ?? 0,
                    'month'          => '',
                    'gross_amount'   => $request->pgros_amount[$key] ?? 0,
                    'discount'       => $request->pdiscount[$key] ?? 0,
                    'total_amount'   => $request->ptotal_amount[$key] ?? 0,
                    'cgst'           => $request->cgst[$key] ?? 0,
                    'igst'           => $request->igst[$key] ?? 0,
                    'sgst'           => $request->sgst[$key] ?? 0,
                    'tax_amount'     => $request->ptax_amount[$key] ?? 0,
                ];
                PerformaInvoiceChallanItem::create($challan_products);
            }

        }
      return redirect()->route('challan.edit', ['id' => $challan_id]);
    }

  

    public function print(Request $request)
{
    $id = $request->id;
    $copies = $request->input('copies', []);

    $title = "View Challan";

    $challan = PerformaInvoiceChallan::with(['challanItems', 'customerType','occasion'])
        ->where('id', $id)
        ->first();

    // Generate PDF
    $pdf = PDF::loadView(_template('challan.print'), [
        'title' => $title,
        'challan' => $challan,
        'copies' => $copies
    ]);
    $pdf->setPaper('A4', 'portrait');

    // Stream PDF in browser
    return $pdf->stream('challan.pdf');
}


    
    public function printReturnChallan($id){
        $title = "View Challan";
        $obj = new Mailer();

        
        $challan = PerformaInvoiceChallan::with(['challanItems','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('challan.print-return'),['title' => $title,'challan'=>$challan,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $challan_name = time().'.pdf';
        if(isset($_GET['type'])){
            $type= $_GET['type'];
            if($type=='dom'){
                return $pdf->stream('Day-Book.pdf');
            } else {
                return view(_template('challan.print-return'),['title' => $title,'challan'=>$challan,'id'=>$id]);      
            }
        }
         return $pdf->stream('challan.pdf');
    }
    public function email($id){
        $title = "View Challan";
        $obj = new Mailer();

        
        $challan = PerformaInvoiceChallan::where('id',$id)->first();
        $customer = Customer::where('id',$challan->customer_id)->first();
        $challan = PerformaInvoiceChallan::with(['challanItems','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('challan.email'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $challan_name = time().'.pdf';
        Storage::put("public/challan/".$challan_name,$content);
        $path ="public/storage/challan/".$challan_name;
        $arr = ['email'=>$customer->email,'subject'=>'Rainbow Challan','message'=>'Hi this is your Challan','path'=>$path];
        $obj->sendMail($arr);
        return redirect()->back()->with(['msg'=>'Email send Successfully']);
    }

    public function edit($id){
        $title = "Edit Challan";
        $challan = PerformaInvoiceChallan::with('challanItems')->where('id',$id)->first();
        $occasion = Occasion::all();
        return view(_template('challan.edit'),['title' => $title,'challan'=>$challan,'id'=>$id, 'occasion'=> $occasion,]);
    }


    public function update(Request $request, $id){
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        $customer = Customer::where(['id'=>$request->customer_id])->first();

        $eventTime24 = $request->input('event_time');
        $eventTime12 = \Carbon\Carbon::createFromFormat('H:i', $eventTime24)->format('h:i A'); 

        if($request->customer_id == 0){
            $customer_details = 
                [   
                'ccaddress' => $request->caddress,
                'ccaddress1' => $request->caddress1,
                'ccity' => $request->ccity, 
                'company_name' => $request->company_name, 
                'cstate' => $request->cstate,
                'cpincode' => $request->cpincode, 
                'cmobile' => $request->cmobile, 
                'contact_person_c' => $request->contact_person_c,
                'cgstin' => $request->cgstin,
                'cemail' => $request->cemail,
                'clandmark' => $request->clandmark  ?? '',
                'occasion_id' => $request->occasion_id ?? '',
                'creadyness'=>$request->creadyness ?? '',
                'cwhatsappmobile'=>$request->cwhatsappmobile ?? ''
                ];    
        } else {
                $customer_details = [
                'ccaddress' => $request->caddress,
                'ccaddress1' => $request->caddress1,
                'ccity' => $request->ccity, 
                'company_name' => $customer->company_name, 
                'cstate' => $request->cstate,
                'cpincode' => $request->cpincode, 
                'cmobile' => $request->cmobile, 
                'contact_person_c' => $request->contact_person_c, 
                'contact_name_edit' =>$request->select_two_name,
                'cgstin' => $request->cgstin,
                'cemail' => $request->cemail,
                'clandmark' => $request->clandmark,
                'occasion_id' => $request->occasion_id ?? '',
                'creadyness'=>$request->creadyness ?? '',
                'cwhatsappmobile'=>$request->cwhatsappmobile ?? ''
                ];
            }

        $delvery_details = [
            'daddress' => $request->daddress,
            'daddress1' => $request->daddress1,
            'dcity' => $request->dcity, 
            'dstate' => $request->dstate, 
            'dpincode' => $request->dpincode, 
            'venue_name' => $request->venue_name ?? '', 
            'dmobile' => $request->dmobile, 
            'dlandmark' => $request->dlandmark, 
            'dperson' => $request->dperson
            ];

        $supply_details = ['saddress' => $request->saddress,
            'scity' => $request->scity, 
            'sstate' => $request->sstate, 
            'svenue' => $request->svenue, 
            'spincode' => $request->spincode, 
            'smobile' => $request->smobile, 
            'slandmark' => $request->slandmark,
            'sperson' => $request->sperson
        ];

        $challan_data = ['user_id' => Auth::id() , 
            'challan_type' => $request->challan_type, 
            'challan_no' => $request->challan_no,
            'ref_pi_no'=> $request->ref_pi_no,
            'billing_date' => $request->billing_date,
            // 'event_time' => $request->event_time,
            'event_time'     => $eventTime12 ?? '',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'customer_id' => $request->customer_id,
            'customer_type' => $request->customer_type,
            'customer_details' => json_encode($customer_details) ,
            'delivery_details' => json_encode($delvery_details) ,
            'delivery_id' => $request->delivery_id,
            'supply_id' => $request->supply_id,
            'gst_id' => $request->gst_id,
            'supply_details' => json_encode($supply_details) ,
            'gst_details' => json_encode($gstMaster) ,
            'net_amount' => $request->total_gross_sum,
            'dayormonth' => $request->challan_dayormonth,
            'gst_id' => $request->gst_id,
            'total_tax' => $request->total_tax_amount,
            'readyness' => $request->readyness ? $request->readyness : '' ,
            'total_amount' => $request->total_grand_amount,
            'amount_in_words' => $request->amount_in_words,
            'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0];
            PerformaInvoiceChallan::where('id', $id)->update($challan_data);
            PerformaInvoiceChallanItem::where('challan_id', $id)->delete();
           
            if ($request->has('pname')) {
            $products = $request->pname;

            foreach ($products as $key => $p) {
                $challan_products = [
                    'challan_id'    => $id,
                    'item_id'       => $request->item_id[$key] ?? '',
                    'sac_code'      => $request->psac[$key] ?? '',
                    'hsn_code'      => $request->phsn[$key] ?? '',
                    'description'   => $request->pdescription[$key] ?? '',
                    'from_date'     => $request->pfrom_date[$key] ?? '',
                    'to_date'       => $request->pto_date[$key] ?? '',
                    'item'          => $request->pname[$key] ?? '',
                    'event_time'     => $eventTime12 ?? '', 
                    'rate'          => $request->prate[$key] ?? '',
                    'quantity'      => $request->pqty[$key] ?? '',
                    'days'          => $request->pday[$key] ?? '',
                    'month'         => '', // default empty
                    'gross_amount'  => $request->pgros_amount[$key] ?? '',
                    'discount'      => $request->pdiscount[$key] ?? '',
                    'total_amount'  => $request->ptotal_amount[$key] ?? '',
                    'cgst'          => $request->cgst[$key] ?? '',
                    'igst'          => $request->igst[$key] ?? '',
                    'sgst'          => $request->sgst[$key] ?? '',
                    'tax_amount'    => $request->ptax_amount[$key] ?? '',
                ];

                PerformaInvoiceChallanItem::create($challan_products);
            }
        }

        return redirect( route('challan.index') )->with('msg','Your challan is updated');
    }


    public function returnChallan($id){
        $title = "Return Challan";
        // $challan = PerformaInvoiceChallan::with('challanItems')->where('id',$id)->first();
        // $occasion = Occasion::all();
        // $supply_address = Address::all();
        $challan = Quotation::with(['quotationItem','leadstatus'])->where('id',$id)->first();
        $occasion = Occasion::all();
        return view(_template('challan.return-challan'),['title' => $title,'challan'=>$challan,'id'=>$id, 'occasion'=> $occasion]);
    }


      public function returnChallanStore(Request $request, $id){
        if(!$request->gst_id){
            echo 'something wrong';
            return;
        }
      $lastChallan = PerformaInvoiceChallan::orderBy('id', 'desc')->first();

    if ($lastChallan && preg_match('/(\d+)$/', $lastChallan->challan_no, $matches)) {
        $lastNumber = (int) $matches[1]; 
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    $challan_no = "25-26/CH/" . $nextNumber;
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        $customer = Customer::where(['id'=>$request->customer_id])->first();
         $eventTime24 = $request->input('event_time');
        $eventTime12 = \Carbon\Carbon::createFromFormat('H:i', $eventTime24)->format('h:i A'); 
        if($request->customer_id == 0){
            $customer_details = [
                'ccaddress' => $request->caddress,
                'ccaddress1' => $request->caddress1,
                'ccity' => $request->ccity, 
                'company_name' => $request->company_name, 
                'cstate' => $request->cstate,
                'cpincode' => $request->cpincode, 
                'cmobile' => $request->cmobile, 
                'cwhatsappmobile' => $request->cwhatsappmobile, 
                'contact_person_c' => $request->contact_person_c,
                'cgstin' => $request->cgstin,
                'cemail' => $request->cemail
            ]; 
    } else{
            $customer_details = [
                'ccaddress' => $request->caddress,
                'ccaddress1' => $request->caddress1,
                'ccity' => $request->ccity, 
                'company_name' => $customer->company_name, 
                'cstate' => $request->cstate,
                'cpincode' => $request->cpincode, 
                'cmobile' => $request->cmobile, 
                'cwhatsappmobile' => $request->cwhatsappmobile, 
                'contact_person_c' => $request->contact_person_c,
                'select_two_name' => $request->select_two_name,
                'contact_name_edit' => $request->select_two_name,
                'cgstin' => $request->cgstin,
                'occasion_id' => $request->occasion_id,
                'creadyness'=>$request->creadyness,
                'cwhatsappmobile'=>$request->cwhatsappmobile

            ];       
        }

        $delvery_details = [
        'daddress' => $request->daddress,
        'daddress1' => $request->daddress1,
         'dcity' => $request->dcity, 
         'dstate' => $request->dstate, 
         'dpincode' => $request->dpincode, 
         'dmobile' => $request->dmobile, 
        'cwhatsappmobile' => $request->cwhatsappmobile, 
         'dlandmark' => $request->dlandmark, 
         'dperson' => $request->dperson,
         'dvenue_name' => $request->venue_name
        ];
        $supply_details = ['saddress' => $request->saddress,
         'scity' => $request->scity, 
         'sstate' => $request->sstate, 
         'spincode' => $request->spincode, 
         'smobile' => $request->smobile, 
         'cwhatsappmobile' => $request->cwhatsappmobile, 
         'slandmark' => $request->slandmark,
          'sperson' => $request->sperson
      ];
        $challan_data = ['user_id' => Auth::id() , 
        'challan_type' => $request->challan_type, 
        'challan_no' => $challan_no,
        'ref_pi_no'=> $request->ref_pi_no,
        'billing_date' => $request->billing_date,
        'event_time' => $eventTime12 ?? '',
        'customer_id' => $request->customer_id,
        'customer_type' => $request->customer_type,
        'customer_details' => json_encode($customer_details) ,
        'delivery_details' => json_encode($delvery_details) ,
        'delivery_id' => $request->delivery_id,
        'supply_id' => $request->supply_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'gst_id' => $request->gst_id,
        'supply_details' => json_encode($supply_details) ,
        'gst_details' => json_encode($gstMaster) ,
        'net_amount' => $request->total_gross_sum,
        'dayormonth' => $request->invoice_dayormonth,
        'readyness' => $request->readyness,
        'gst_id' => $request->gst_id,
        'total_tax' => $request->total_tax_amount,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'net_discount' => $request->total_net_discount ?? 0,
        'original_challan_id' => $id,
    ];


    // dd($request->all());
        $challan_id = PerformaInvoiceChallan::create($challan_data)->id;

        if ($request->has('pname')){
            $products = $request->pname;
            foreach ($products as $key => $p) {
                $challan_products = [
                    'challan_id'     => $challan_id,
                    'item_id'        => $request->item_id[$key] ?? null,
                    'hsn_code'       => $request->phsn[$key] ?? null,
                    'sac_code'       => $request->psac[$key] ?? null,
                    'description'    => $request->pdescription[$key] ?? null,
                    'from_date'      => $request->pfrom_date[$key] ?? null,
                    'to_date'        => $request->pto_date[$key] ?? null,
                    'item'           => $request->pname[$key] ?? null,
                    'rate'           => $request->prate[$key] ?? 0,
                    'quantity'       => $request->pqty[$key] ?? 0,
                    'days'           => $request->pday[$key] ?? 0,
                    'month'          => '',
                    'gross_amount'   => $request->pgros_amount[$key] ?? 0,
                    'discount'       => $request->pdiscount[$key] ?? 0,
                    'total_amount'   => $request->ptotal_amount[$key] ?? 0,
                    'cgst'           => $request->cgst[$key] ?? 0,
                    'igst'           => $request->igst[$key] ?? 0,
                    'sgst'           => $request->sgst[$key] ?? 0,
                    'tax_amount'     => $request->ptax_amount[$key] ?? 0,
                ];
                PerformaInvoiceChallanItem::create($challan_products);
            }

        }
      return redirect()->route('challan.edit', ['id' => $challan_id]);
    }

    //  public function editreturnChallan($id){
    //     $title = "Edit Challan";
    //     $challan = PerformaInvoiceChallan::with('challanItems')->where('id',$id)->first();
    //     $occasion = Occasion::all();
    //     return view(_template('challan.edit'),['title' => $title,'challan'=>$challan,'id'=>$id, 'occasion'=> $occasion,]);
    // }


     public function createQuotationChallan($id){
        $title = "Create Challan";
        $challan = Quotation::with(['quotationItem','leadstatus'])->where('id',$id)->first();
        $occasion = Occasion::all();
        return view(_template('challan.quatation-create'),['title' => $title,'challan'=>$challan,'id'=>$id, 'occasion'=> $occasion, ]);
    }



    public function destroy($id)
    {
        
    }
}
