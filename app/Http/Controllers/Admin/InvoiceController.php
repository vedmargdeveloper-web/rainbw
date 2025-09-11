<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Mailer;
use Illuminate\Http\Request;
use Auth;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\GstMaster;
use App\Models\Customer;
use PDF;
use Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::where('invoice_type', 'invoice')->with('customerType')->get();
        return view(_template('invoice.index'),['invoices'=>$invoice,'title'=>'All Invoice']);
    }

    public function challan()
    {
        $invoice = Invoice::where('invoice_type', 'challan')->with('customerType')->get();
        return view(_template('invoice.challan'),['invoices'=>$invoice,'title'=>'All Invoice']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Create Invoice";
        return view(_template('invoice.create', ['title' => $title]));
    }
    
    /**
     * Get the totalInvoice count based on the provided invoiceType
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
       public function invoicetype(Request $request)
        {
            try {
                $invoiceType = $request->input('invoice_type');

                // Fetch the totalInvoice count based on the provided invoiceType
                $da = date('Y-m-d');
                $getFullYears = getFinancialFullYear($da);
                $start_date = $getFullYears['start_year'] . '-04-01';
                $end_date = $getFullYears['end_year'] . '-03-31';

                $totalInvoice = Invoice::where('invoice_type', $invoiceType)
                    ->whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date)
                    ->count();

                // Check if it's an AJAX request
                if ($request->ajax()) {
                    // Return JSON response
                    return response()->json(['totalInvoice' => $totalInvoice]);
                } else {
                    // Return view with totalInvoice data
                    return view(_template('invoice.create', ['title' => "title", 'totalInvoice' => $totalInvoice]));
                }
            } catch (\Exception $e) {
                // Handle any exceptions and return the error message
                return response()->json(['error' => $e->getMessage()]);
            }
        }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd($request->invoice_no);
        
        if(!$request->gst_id){
            echo 'something wrong';
            return;
        }

        //dd($request->all());
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();

        $customer = Customer::where(['id'=>$request->customer_id])->first();
      //  dd($request->all());
       
        if($request->customer_id == 0){
                $customer_details = [
                    'ccaddress' => $request->caddress,
                    'ccaddress1' => $request->caddress1,
                    'ccity' => $request->ccity, 
                    'company_name' => $request->company_name, 
                    'cstate' => $request->cstate,
                    'cpincode' => $request->cpincode, 
                    'cmobile' => $request->cmobile, 
                    'contact_person_c' => $request->contact_person_c,
                    'cgstin' => $request->cgstin,
                    'cemail' => $request->cemail
                ]; 
        } else{
                //dd(is_string($request->contact_person_c) );
                $customer_details = [
                    'ccaddress' => $request->caddress,
                    'ccaddress1' => $request->caddress1,
                    'ccity' => $request->ccity, 
                    'company_name' => $customer->company_name, 
                    'cstate' => $request->cstate,
                    'cpincode' => $request->cpincode, 
                    'cmobile' => $request->cmobile, 
                    'contact_person_c' => $request->contact_person_c,
                    'select_two_name' => $request->select_two_name,
                    'contact_name_edit' => $request->select_two_name,
                    'cgstin' => $request->cgstin,
                    'cemail' => $request->cemail
                ];     
               // echo 'JJJJJJ';
        }

        
        // die();


        

        //dd($customer_id);
        //dd($request->all());  
        
       

       // dd($customer_details);

        //dd($customer_details);

        $delvery_details = [
        'daddress' => $request->daddress,
        'daddress1' => $request->daddress1,
         'dcity' => $request->dcity, 
         'dstate' => $request->dstate, 
         'dpincode' => $request->dpincode, 
         'dmobile' => $request->dmobile, 
         'dlandmark' => $request->dlandmark, 
         'dperson' => $request->dperson,
         'dvenue_name' => $request->venue_name
        ];


       //dd($delvery_details);


        $supply_details = ['saddress' => $request->saddress,
         'scity' => $request->scity, 
         'sstate' => $request->sstate, 
         'spincode' => $request->spincode, 
         'smobile' => $request->smobile, 
         'slandmark' => $request->slandmark,
          'sperson' => $request->sperson
      ];

        

        $invoice_data = ['user_id' => Auth::id() , 
        'invoice_type' => $request->invoice_type, 
        'invoice_no' => $request->invoice_no,
        // 'invoice_date' => $request->invoice_date,
        'billing_date' => $request->billing_date,
        'event_date' => $request->event_date,

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

        //  'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0 ? $request->total_net_discount ? $request->total_net_discount : 0 : 0];
       // dd($invoice_data);
        //$request->all();
        $invoice_id = Invoice::create($invoice_data)->id;

        if ($request->has('pname'))
        {
            $products = $request->pname;
            foreach ($products as $key => $p)
            {
                //dd($request);
                //dd($request->ptotal_amount);
                ///echo  $request->ptotal_amount[$key];
                //  dd($request->ptotal_amount[$key]);

                $invoice_products = ['invoice_id' => $invoice_id, 'item_id' => $request->item_id[$key],'sac_code' => $request->psac[$key] ?? null, 'hsn_code' => $request->phsn[$key] ?? null, 'description' => $request->pdescription[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
               
               InvoiceItem::create($invoice_products);
            }
        }

        return redirect()->route('invoice.edit',['invoice'=>$invoice_id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function show($id)
    {

    }

    public function print($id){
        // $this->email($id);
        // return;
        $title = "View Invoice";

        $obj = new Mailer();
        
        $invoice = Invoice::with(['invoiceItem','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('invoice.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        if(isset($_GET['type'])){
            $type= $_GET['type'];
            if($type=='dom'){
                return $pdf->stream('Day-Book.pdf');
            } else {
                return view(_template('invoice.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
            }
        }
         return $pdf->stream('Invoice.pdf');
        // return view(_template('invoice.print'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
    }

    public function email($id){
        $title = "View Invoice";
        $obj = new Mailer();
        
        $invoice = Invoice::where('id',$id)->first();

        $customer = Customer::where('id',$invoice->customer_id)->first();
        
        //

        $invoice = Invoice::with(['invoiceItem','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('invoice.print'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        Storage::put("public/invoice/".$invoice_name,$content);
        
        $path ="public/storage/invoice/".$invoice_name;
        
        $arr = ['email'=>$customer->email,'subject'=>'Rainbow Invoice','message'=>'Hi this is your invoice','path'=>$path];
        //$arr = ['email'=>'techdostdesigner@gmail.com','subject'=>'Rainbow Invoice','message'=>'Hi this is your invoice','path'=>$path];
        
        $obj->sendMail($arr);
        return redirect()->back()->with(['msg'=>'Email send Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Invoice";
        $invoice = Invoice::with('invoiceItem')->where('id',$id)->first();
        //dd($invoice::where('invoice_id'));
        return view(_template('invoice.edit'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       

        //dd($request->gst_id);
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        //dd();
        $customer = Customer::where(['id'=>$request->customer_id])->first();
    
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

         //    dd($request->select_two_name);
         // dd($customer_details);
            // dd($customer_details);
        //dd($request);

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


        //dd($delvery_details);


        $supply_details = ['saddress' => $request->saddress,
         'scity' => $request->scity, 
         'sstate' => $request->sstate, 
         'svenue' => $request->svenue, 
         'spincode' => $request->spincode, 
         'smobile' => $request->smobile, 
         'slandmark' => $request->slandmark,
          'sperson' => $request->sperson
      ];

        //dd($supply_details);
        // echo $request->total_net_discount;
        // dd();

        $invoice_data = ['user_id' => Auth::id() , 
        'invoice_type' => $request->invoice_type, 
        'invoice_no' => $request->invoice_no,
        // 'invoice_date' => $request->invoice_date,
        'billing_date' => $request->billing_date,
        'event_date' => $request->event_date,
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
        'dayormonth' => $request->invoice_dayormonth,
        'gst_id' => $request->gst_id,
        'total_tax' => $request->total_tax_amount,
        'readyness' => $request->readyness ? $request->readyness : '' ,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0];
         
         // dd($request->all());

        //$request->all();
          Invoice::where('id',$id)->update($invoice_data);
          InvoiceItem::where('invoice_id',$id)->delete();
          if ($request->has('pname'))
            {
                $products = $request->pname;
                foreach ($products as $key => $p)
                {
                    $invoice_products = ['invoice_id' => $id, 'item_id' => $request->item_id[$key], 'sac_code' => $request->psac[$key] ?? null , 'hsn_code' => $request->phsn[$key] ?? null, 'description' => $request->pdescription[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
                     InvoiceItem::create($invoice_products);
                }
            }

        return redirect( route('invoice.index') )->with('msg','Your invoice is updated');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        
    }
}

