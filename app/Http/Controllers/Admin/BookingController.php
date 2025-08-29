<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Mailer;
use Illuminate\Http\Request;
use Auth;
use App\Models\Booking;
use App\Models\BookingsItem;
use App\Models\GstMaster;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\Quotation;
use App\Models\Address;
use PDF;
use Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $invoice = Booking::with(['customerType','inquiry','quotaiton.occasion','bookingItem'])->get();
        // dd($invoice);
        return view(_template('booking.index'),['invoices'=>$invoice,'title'=>'All Bookings']);
        //$this->fresh_quotations();
    }
    public function fresh_quotations()
    {
        $invoice = Quotation::with('customerType','leadstatus','inquiry','quotationItem','occasion')->withCount('pitch')->orderBy('id', 'DESC')->get();
        // dd($invoice);
        // dd($invoice);
        // dd($invoice);
        return view(_template('booking.fresh-quotation'),['invoices'=>$invoice,'title'=>'All Quotations']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Create Booking";
        return view(_template('booking.create', ['title' => $title]));
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
        //dd($customer);
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

            //dd($venue);
            //dd($request->customer_id);
       
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
                    'cemail' => $request->cemail
                ]; 
        } else{
                //dd(is_string($request->contact_person_c) );
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
                    'cemail' => $request->cemail
                ];     

               // echo 'JJJJJJ';
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
        'gst_id' => $request->gst_id,
        'supply_details' => json_encode($supply_details) ,
        'gst_details' => json_encode($gstMaster) ,
        'net_amount' => $request->total_gross_sum,
        'dayormonth' => $request->invoice_dayormonth,
        'remark' => $request->remark,
        'booking_type' => $request->booking_type,
        'readyness' => $request->readyness,
        'gst_id' => $request->gst_id,
        'total_tax' => $request->total_tax_amount,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'enquire_id' => $request->uid,
        'lead_status' => $request->lead_status,
        // 'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0 ? $request->total_net_discount ? $request->total_net_discount : 0 : 0];
        'net_discount' => $request->total_net_discount ?? 0,
    ];
        //dd($request->all());
        //$request->all();
        $invoice_id = Booking::create($invoice_data)->id;

        if ($request->has('pname'))
        {
            $products = $request->pname;
            foreach ($products as $key => $p)
            {
                
                //dd($request);
                // dd($request->ptotal_amount);
                ///echo  $request->ptotal_amount[$key];
                //  dd($request->ptotal_amount[$key]);

            $invoice_products = ['invoice_id' => $invoice_id, 'item_id' => $request->item_id[$key], 'hsn_code' => $request->phsn[$key], 'description' => $request->pdescription[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
               
               BookingsItem::create($invoice_products);
            }
        }

        store_lead_status($request->uid,$request->lead_status);
        return redirect()->route('booking.check.view',['id'=>$invoice_id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function show($id)
    {
        //die();
        $quotation = Quotation::with('pitchLastest','inquiry','quotationItem')->withCount('pitch')->where('id',$id)->first();
        //dd($quotation);
        //dd($quotation);
        
        if(!$quotation){
            return redirect( route('booking.create',['id'=>$id]) );
        }

        if( $quotation->pitch_count > 0){
            return view( _template('booking.quotation-show'),['inquiry'=>$quotation->inquiry,'quotation'=>$quotation,'id'=>$id,'title'=>'Quotation Create'] );
        } else {
            // echo 'dd';
            // dd('x');
            return view( _template('booking.show'),['inquiry'=>$quotation->inquiry,'quotation'=>$quotation,'id'=>$id,'title'=>'Quotation Create'] );    
        }
        
    }

    public function check_view($id){
        $title = "View Booking";
        $obj = new Mailer();
        $invoice = Booking::with(['bookingItem','customerType'])->where('id',$id)->first();
        //dd($invoice);
        return view( _template('booking.checkbooking'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
    }

    public function print($id){
        // $this->email($id);
        // return;
        $title = "View Booking";

        $obj = new Mailer();
        
        $invoice = Booking::with(['bookingItem','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('booking.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        // if(isset($_GET['type'])){
        //     $type= $_GET['type'];
        //     if($type=='dom'){
        //         return $pdf->stream('Day-Book.pdf');
        //     } else {
        //         return view(_template('booking.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
        //     }
        // }
         return $pdf->stream('booking.pdf');
        // return view(_template('booking.print'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
    }

    public function email($id){
        $title = "View Invoice";
        $obj = new Mailer();
        
        $invoice = Booking::where('id',$id)->first();

        $customer = Customer::where('id',$invoice->customer_id)->first();
        
        //

        $invoice = Booking::with(['quotationItem','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('booking.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
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
        $invoice = Booking::with('bookingItem')->where('id',$id)->first();
        //dd($Booking::where('invoice_id'));
        return view(_template('booking.edit'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
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
       

        $customer = Customer::where(['id'=>$request->customer_id])->first();
        
        
        //dd($request->gst_id);
        $gstMaster = GstMaster::where(['id'=>$request->gst_id])->first();
        //dd();
        $customer = Customer::where(['id'=>$request->customer_id])->first();
        $delivery = Address::where(['id'=>$request->delivery_id])->first();  
        
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

        //dd($request);

        $delvery_details = [
            'daddress' => $request->daddress,
            'daddress1' => $request->daddress1,
         'dcity' => $request->dcity, 
         'dstate' => $request->dstate, 
         'dpincode' => $request->dpincode, 
         'dvenue_name' => $venue, 
         'dmobile' => $request->dmobile, 
         'dlandmark' => $request->dlandmark, 
         'dperson' => $request->dperson
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
        'remark' => $request->remark,
        'supply_details' => json_encode($supply_details) ,
        'gst_details' => json_encode($gstMaster) ,
        'net_amount' => $request->total_gross_sum,
        'dayormonth' => $request->invoice_dayormonth,
        'booking_type' => $request->booking_type,
        'gst_id' => $request->gst_id,
        'total_tax' => $request->total_tax_amount,
        'readyness' => $request->readyness ? $request->readyness : '' ,
        'total_amount' => $request->total_grand_amount,
        'amount_in_words' => $request->amount_in_words,
        'enquire_id' => $request->uid,
        'net_discount' => $request->total_net_discount ? $request->total_net_discount : 0];

          Booking::where('id',$id)->update($invoice_data);
          BookingsItem::where('invoice_id',$id)->delete();
          if ($request->has('pname'))
            {
                $products = $request->pname;
                foreach ($products as $key => $p)
                {
                    $invoice_products = ['invoice_id' => $id, 'item_id' => $request->item_id[$key], 'hsn_code' => $request->phsn[$key], 'description' => $request->pdescription[$key], 'item' => $request->pname[$key], 'rate' => $request->prate[$key], 'quantity' => $request->pqty[$key], 'days' => $request->pday[$key],'month' => '', 'gross_amount' => $request->pgros_amount[$key], 'discount' => $request->pdiscount[$key], 'total_amount' => $request->ptotal_amount[$key] , 'cgst' => $request->cgst[$key], 'igst' => $request->igst[$key], 'sgst' => $request->sgst[$key], 'tax_amount' => $request->ptax_amount[$key]];
                     BookingsItem::create($invoice_products);
                }
            }

        store_lead_status($request->uid,$request->lead_status);

        return redirect( route('booking.index') )->with('msg','Your Booking is updated');

        
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

