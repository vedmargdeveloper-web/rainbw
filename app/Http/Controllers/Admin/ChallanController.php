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
use PDF;
use Storage;


class ChallanController extends Controller
{
       public function index()
    {
        $challan = PerformaInvoiceChallan::with('customerType')->get();
        return view(_template('challan.index'),['challans'=>$challan,'title'=>'All Challan']);
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
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        $customer = Customer::where(['id'=>$request->customer_id])->first();
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
                'cemail' => $request->cemail
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
        'challan_no' => $request->challan_no,
        'ref_pi_no'=> $request->ref_pi_no,
        'billing_date' => $request->billing_date,
        'event_time' => $request->event_time,
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

        $challan_id = PerformaInvoiceChallan::create($challan_data)->id;

        if ($request->has('pname')){
            $products = $request->pname;
            foreach ($products as $key => $p){
               $challan_products = ['challan_id' => $challan_id, 'item_id' => $request->item_id[$key], 'hsn_code' => $request->phsn[$key], 'sac_code' => $request->psac[$key], 'description' => $request->pdescription[$key],'from_date' => $request->pfrom_date[$key],'to_date' => $request->pto_date[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
               PerformaInvoiceChallanItem::create($challan_products);
            }
        }
      return redirect()->route('challan.edit', ['id' => $challan_id]);
    }

    public function print($id){
        $title = "View Challan";
        $obj = new Mailer();
        $challan = PerformaInvoiceChallan::with(['challanItems','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('challan.print'),['title' => $title,'challan'=>$challan,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $challan_name = time().'.pdf';
        if(isset($_GET['type'])){
            $type= $_GET['type'];
            if($type=='dom'){
                return $pdf->stream('Day-Book.pdf');
            } else {
                return view(_template('challan.print'),['title' => $title,'challan'=>$challan,'id'=>$id]);      
            }
        }
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
        // dd($challan);
        return view(_template('challan.edit'),['title' => $title,'challan'=>$challan,'id'=>$id]);
    }


    public function update(Request $request, $id){
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        $customer = Customer::where(['id'=>$request->customer_id])->first();
    
        // dd($request->all());
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
                'clandmark' => $request->clandmark
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
            'event_time' => $request->event_time,
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
            // if ($request->has('pname')){
            //         $products = $request->pname;
            //         foreach ($products as $key => $p)
            //         {
            //             $challan_products = ['challan_id' => $id, 'item_id' => $request->item_id[$key],'sac_code' => $request->psac[$key],'hsn_code' => $request->phsn[$key],  'description' => $request->pdescription[$key], 'from_date' => $request->pfrom_date[$key] ?? '','to_date' => $request->pto_date[$key] ?? '', 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
            //             PerformaInvoiceChallanItem::create($challan_products);
            //         }
            //     }
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

    public function destroy($id)
    {
        
    }
}
