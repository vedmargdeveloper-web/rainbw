<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Mailer;
use Illuminate\Http\Request;
use Auth;
use App\Models\Quotation;
use App\Models\Inquiry;
use App\Models\QuotationsItem;
use App\Models\GstMaster;
use App\Models\Customer;
use App\Models\LeadStatusLog;
use App\Models\Address;
use PDF;
use Storage;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Quotation::with('customerType','leadstatus','inquiry','quotationItem','occasion')->withCount('pitch')->get();
        return view(_template('quotation.index'),['invoices'=>$invoice,'title'=>'All Quotations']);
    }

    public function fetch_ajax_status(Request $request)
    {
        $lead = LeadStatusLog::where('inquires_id',$request->inquiry_id)->latest()->first('status');
        return response()->json($lead);
        // $invoice = Quotation::with('customerType')->get();
        // return view(_template('quotation.index'),['invoices'=>$invoice,'title'=>'All Quotations']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Create Quotation";
        return view(_template('quotation.create', ['title' => $title]));
    }

    public function last_enquiries(Request $request)
    {
        $inquires = Inquiry::withCount('quotation')->with(['customer','address','occassion','inquiryItems.item'])->get();
        //dd($inquires);
        /// dd($inquires);
        // //$inquires = Inquiry::with('occassion')->get();
        // dd($inquires);
        return view(_template('quotation.fresh'),['fresh_inquires'=>$inquires]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        
        
        if(!$request->gst_id){
            echo 'something wrong';
            return;
        }

        //dd($request->gst_id);
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
           
            $customer = Customer::where(['id'=>$request->customer_id])->first();
            $delivery = Address::where(['id'=>$request->delivery_id])->first();  

            if($customer){
                $company_name = $customer->company_name;
            }else{
                $company_name = $request->company_name;
            }
            if($delivery){
                $venue = $delivery->venue;
            }else{
                $venue = $request->venue_name;
            }
            
     //  dd($request->customer_id);
       
        if($request->customer_id == 0){
                $customer_details = [
                    'ccaddress' => $request->caddress,
                    'ccaddress1' => $request->caddress1,
                    'ccity' => $request->ccity, 
                    'company_name' => $company_name, 
                    'cstate' => $request->cstate,
                    'cpincode' => $request->cpincode, 
                    'cmobile' => $request->cmobile, 
                    'contact_person_c' => $request->contact_person_c,
                    'select_two_name' => $request->select_two_name,
                    'cgstin' => $request->cgstin,
                    'cemail' => $request->cemail,
                    'creadyness' => $request->creadyness ?? '',
                    'cwhatsapp' => $request->cwhatsapp
                ]; 
        } else{
               
                $customer_details = [
                    'ccaddress' => $request->caddress,
                    'ccaddress1' => $request->caddress1,
                    'ccity' => $request->ccity, 
                    'company_name' => $company_name, 
                    'cstate' => $request->cstate,
                    'cpincode' => $request->cpincode, 
                    'cmobile' => $request->cmobile, 
                    'contact_person_c' => $request->contact_person_c,
                    'select_two_name' => $request->select_two_name,
                    'contact_name_edit' => $request->select_two_name,
                    'cgstin' => $request->cgstin,
                    'cemail' => $request->cemail,
                    'creadyness' => $request->creadyness ?? '',
                    'cwhatsapp' => $request->cwhatsapp
                    
                ];     
        }

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



        $supply_details = ['saddress' => $request->saddress,
         'scity' => $request->scity, 
         'sstate' => $request->sstate, 
         'spincode' => $request->spincode, 
         'smobile' => $request->smobile, 
         'slandmark' => $request->slandmark,
          'sperson' => $request->sperson
        ];

        // dd($supply_details);

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
        'remark' => $request->remark,
        'gst_id' => $request->gst_id,
        'supply_details' => json_encode($supply_details) ,
        'gst_details' => json_encode($gstMaster) ,
        'net_amount' => $request->total_gross_sum,
        
        'dayormonth' => $request->invoice_dayormonth,
        'occasion_id' => $request->occasion_id,
        'readyness' => $request->readyness,
        'gst_id' => $request->gst_id,
        'total_tax' => $request->total_tax_amount,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'enquire_id' => $request->uid,
        'lead_status' => $request->lead_status,
        // 'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0 ? $request->total_net_discount ? $request->total_net_discount : 0 : 0];
      'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0,
    ];


       //dd($invoice_data);
        $invoice_id = Quotation::create($invoice_data)->id;


        

        if ($request->has('pname'))
        {
            $products = $request->pname;
            foreach ($products as $key => $p)
            {
                //dd($request);
                //dd($request->ptotal_amount);
                ///echo  $request->ptotal_amount[$key];
                //  dd($request->ptotal_amount[$key]);

                $invoice_products = ['invoice_id' => $invoice_id, 'item_id' => $request->item_id[$key], 'hsn_code' => $request->phsn[$key], 'description' => $request->pdescription[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
               
               QuotationsItem::create($invoice_products);
            }
        }
        store_lead_status($request->uid,$request->lead_status);
        //with()
        // $request->session()->flash;
        return redirect()->route('quotation.check.view',['id'=>$invoice_id])->with('msg', 'Quotation added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function show($id)
    {
        $title = "VIEW ONLY";
        
        // $invoice = Quotation::with(['quotationItem','customerType','pitchLastest'])->where('id',$id)->first();
        // if(!isset($_GET['type'])){
        //     $_GET['type']= 'print-pitch';
        // }

        // $pdf=PDF::loadView(_template('quotation.'.$_GET['type']),['title' => $title,'invoice'=>$invoice,'id'=>$id]);

        // $pdf->setPaper('A4','portrait');
        // $content = $pdf->download()->getOriginalContent();
        // $invoice_name = time().'.pdf';
        // if(isset($_GET['type'])){
        //     $type= $_GET['type'];
        //     if($type=='dom'){
        //         return $pdf->stream('Day-Book.pdf');
        //     } else {
        //         return $pdf->stream('Day-Book.pdf');
        //         //
        //     }
        // }

        //return view(_template('quotation.show'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
        // ./return $pdf->stream('quotation.pdf');
        
        $inquiry = Inquiry::with(['inquiryItems','leadstatus','address','customer.customer_state','customer.customer_city','address','address.icity','address.istate'])->where('id',$id)->first();
        //dd($inquiry);

        $quotation = [];
        return view( _template('quotation.show'),['inquiry'=>$inquiry,'quotation'=>$quotation,'id'=>$id,'title'=>'Quotation Create'] );
    }

    public function check_view($id)
    {
        // code...
        $title = 'Only View';
        $invoice = Quotation::with(['quotationItem','customerType','pitchLastest'])->where('id',$id)->first();
        if(!isset($_GET['type'])){
            $_GET['type']= 'print-pitch';
        }
        return view(_template('quotation.check'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      

    }

    public function print(Request $request,$id){
        //dd($request);
        $title = "View Invoice";
        $obj = new Mailer();
        $invoice = Quotation::with(['quotationItem','customerType','pitchLastest'])->where('id',$id)->first();
        if(!$invoice){
            dd('something wrong');
        }
        //$pdf=PDF::loadView(_template('quotation.print-pitch'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
        if(!isset($_GET['type'])){
            $_GET['type']= 'print-pitch';
        }
        if($request->tax==0){
            $customView = 'quotation.'.$_GET['type'].'-without-tax';
        }else{
            $customView = 'quotation.'.$_GET['type'];
        }
        
        $pdf=PDF::loadView(_template($customView),['title' => $title,'invoice'=>$invoice,'id'=>$id]);

        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        if(isset($_GET['type'])){
            $type= $_GET['type'];
            if($type=='dom'){
                return $pdf->stream('Performa-invoice.pdf');
            } else {
                return $pdf->stream('Performa-invoice.pdf');
                //return view(_template('quotation.'.$_GET['type']),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
            }
        }
         return $pdf->stream('quotation.pdf');
        // return view(_template('quotation.print'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
    }

    public function printChallanOne(Request $request, $id)
{
    $title = "Print Challan";
    $copyType = $request->get('print_type', 'Original');
    
    $invoice = Quotation::with(['quotationItem', 'customerType', 'pitchLastest'])->where('id', $id)->first();
    if (!$invoice) {
        abort(404, 'Invoice not found');
    }

    // Use your custom Blade file
    $customView = 'admin.quotation.quotation-challan-print';

    $pdf = PDF::loadView($customView, [
        'title' => $title,
        'invoice' => $invoice,
        'id' => $id,
        'copyType' => $copyType
    ]);

    $pdf->setPaper('A4', 'portrait');

    return $pdf->stream('challan-print.pdf');
}

 public function printReturnChallan(Request $request, $id)
{
    $title = "Print Return Challan";
     $copyType = $request->get('print_type', 'Original');
    
    $invoice = Quotation::with(['quotationItem', 'customerType', 'pitchLastest'])->where('id', $id)->first();
    if (!$invoice) {
        abort(404, 'Invoice not found');
    }

    // Use your custom Blade file
    $customView = 'admin.quotation.quotation-return-challan-print';

    $pdf = PDF::loadView($customView, [
        'title' => $title,
        'invoice' => $invoice,
        'id' => $id,
        'copyType'=> $copyType
    ]);

    $pdf->setPaper('A4', 'portrait');

    return $pdf->stream('challan-print.pdf');
}



    public function email($id){
        $title = "View Invoice";
        $obj = new Mailer();
        
        $invoice = Quotation::where('id',$id)->first();

        $customer = Customer::where('id',$invoice->customer_id)->first();
        
        //

        $invoice = Quotation::with(['quotationItem','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('quotation.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        Storage::put("public/invoice/".$invoice_name,$content);
        
        $path ="public/storage/invoice/".$invoice_name;
        
        $arr = ['email'=>$customer->email,'subject'=>'Rainbow Invoice','message'=>'Hi this is your invoice','path'=>$path];
        // $arr = ['email'=>'ishusirohi4@gmail.com','subject'=>'Rainbow Invoice','message'=>'Hi this is your invoice','path'=>$path];
        
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
        $title = "Edit Quotation";
        $invoice = Quotation::with(['quotationItem','leadstatus'])->where('id',$id)->first();
        //dd($Quotation::where('invoice_id'));
        return view(_template('quotation.edit'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
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
       // $customer = Customer::where(['id'=>$request->customer_id])->first();
        
        $delivery = Address::where(['id'=>$request->delivery_id])->first();  

            if($customer){
                $company_name = $customer->company_name;
            }else{
                $company_name = $request->company_name;
            }
            if($delivery){
                $venue = $delivery->venue;
            }else{
                $venue = $request->venue_name;
            }

        
        if($request->customer_id == 0){
             
            $customer_details = 
                    [   
                        'ccaddress' => $request->caddress,
                        'ccaddress1' => $request->caddress1,
                        'ccity' => $request->ccity, 
                        'company_name' => $company_name, 
                        'cstate' => $request->cstate,
                        'cpincode' => $request->cpincode, 
                        'cmobile' => $request->cmobile, 
                        'contact_person_c' => $request->contact_person_c,
                        'cgstin' => $request->cgstin,
                        'select_two_name' => $request->select_two_name,
                        'cemail' => $request->cemail,
                        'clandmark' => $request->clandmark,
                        'creadyness' => $request->creadyness,
                        'cwhatsapp' => $request->cwhatsapp
                    ];    
            } else {

                     $customer_details = [
                        'ccaddress' => $request->caddress,
                        'ccaddress1' => $request->caddress1,
                        'ccity' => $request->ccity, 
                        'company_name' => $company_name, 
                        'cstate' => $request->cstate,
                        'cpincode' => $request->cpincode, 
                        'cmobile' => $request->cmobile, 
                        'contact_person_c' => $request->contact_person_c, 
                        'contact_name_edit' =>$request->select_two_name,
                        'select_two_name' =>$request->select_two_name,
                        'creadyness' => $request->creadyness,
                        'cgstin' => $request->cgstin,
                        'cemail' => $request->cemail,
                        'clandmark' => $request->clandmark,
                        'cwhatsapp' => $request->cwhatsapp
                    ];
            }

            //dd($customer_details);

         //    dd($request->select_two_name);
         // dd($customer_details);

        //dd($request);

        $delvery_details = [
            'daddress' => $request->daddress,
            'daddress1' => $request->daddress1,
         'dcity' => $request->dcity, 
         'dstate' => $request->dstate, 
         'dpincode' => $request->dpincode, 
         'venue_name' => $venue ?? '', 
         'dmobile' => $request->dmobile, 
         'dlandmark' => $request->dlandmark, 
         'dperson' => $request->dperson,
         'dvenue_name' => $venue
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

        //dd($supply_details);
        // echo $request->total_net_discount;
        // dd();

        $invoice_data = ['user_id' => Auth::id() , 
        'invoice_type' => $request->invoice_type, 
        'invoice_no' => $request->invoice_no,
        // 'invoice_date' => $request->invoice_date,
        'billing_date' => $request->billing_date,
        'lead_status' => $request->lead_status,
        'event_date' => $request->event_date,

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
        'occasion_id' => $request->occasion_id,
        'gst_id' => $request->gst_id,
        'remark' => $request->remark,
        'total_tax' => $request->total_tax_amount,
        'readyness' => $request->readyness ? $request->readyness : '' ,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'enquire_id' => $request->uid,
        'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0];
         
         //dd($invoice_data);pt
        

        //$request->all();
          Quotation::where('id',$id)->update($invoice_data);
          QuotationsItem::where('invoice_id',$id)->delete();
          if ($request->has('pname'))
            {
                $products = $request->pname;
                foreach ($products as $key => $p)
                {
                    $invoice_products = ['invoice_id' => $id, 'item_id' => $request->item_id[$key], 'hsn_code' => $request->phsn[$key], 'description' => $request->pdescription[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
                     QuotationsItem::create($invoice_products);
                }
            }
            store_lead_status($request->uid,$request->lead_status);

        return redirect( route('quotation.index') )->with('msg','Your Quotation is updated');

        
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

