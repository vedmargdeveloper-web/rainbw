<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Mailer;
use Illuminate\Http\Request;
use Auth;
use App\Models\Quotation;
use App\Models\Inquiry;
use App\Models\QuotationsItem;
use App\Models\Pitch;
use App\Models\Customer;
use PDF;
use Storage;

class PitchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pitch = [];
        $pitch = Pitch::with(['quotation.inquiry','quotation.occasion'])->get();
        return view(_template('pitch.index'),['pitch'=>$pitch,'invoices'=>$pitch,'title'=>'All Pitch']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = "Create Pitch";
        return view(_template('pitch.create', ['title' => $title]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        
        $data = [
                    'date'=>$request->date,
                    'revised_quote'=>$request->revised_quote,
                    'next_appointment'=>$request->next_appointment,
                    'mods'=>$request->mod,
                    'dayormonth'=>$request->dayormonth,
                    'phsn'=>json_encode($request->phsn),
                    'pdescription'=>json_encode($request->pdescription),
                    'pname'=>json_encode($request->pname),
                    'item_id'=>json_encode($request->item_id),
                    'prate'=>json_encode($request->prate),
                    'sgst'=>json_encode($request->sgst),
                    'qty'=>json_encode($request->pqty),
                    'days'=>json_encode($request->pday),
                    'discount'=>json_encode($request->pdiscount),
                    'cgst'=>json_encode($request->cgst),
                    'igst'=>json_encode($request->igst),
                    'gross_amount'=>json_encode($request->pgros_amount),
                    'tax_amount'=>json_encode($request->ptax_amount),
                    'total_amount'=>json_encode($request->ptotal_amount),
                    'product_id'=>json_encode($request->product_id),
                    'quotation_id'=>$request->quotation_id,
                    'total_tax_amount'=>$request->total_tax_amount,
                    'total_grand_amount'=>$request->total_grand_amount,
                    'total_net_discount'=>$request->total_net_discount,
        ];

        store_lead_status($request->enquire_id,$request->lead_status);
        Pitch::create($data);
        return redirect( route('pitch.check.view',['id'=>$request->quotation_id]) )->with('msg','Your Pitch is updated');
        //return redirect( route('pitch.index') )->with('msg','Your Pitch is Added');
        // return redirect()->route('pitch.edit',['quotation'=>$invoice_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function show($id)
    {
        // dd('dd');
        $quotation = Quotation::with(['inquiry','pitch','leadstatus'])->where('enquire_id',$id)->first();
        // dd($quotation);
        if(!$quotation){
            return redirect( route('pitch.create',['id'=>$id]) );
        }

        return view( _template('pitch.show'),['inquiry'=>$quotation->inquiry,'quotation'=>$quotation,'title'=>'Invoice Create'] );
    }

    public function print($id){
        // $this->email($id);
        // return;
        $title = "View Pitch";

        $obj = new Mailer();
        
        $pitch = Pitch::with('quotation.inquiry')->find($id);
        if(!$pitch){
            dd('Something wrong');
        }
       // dd($pitch);
      //  dd($pitch);
        $pdf=PDF::loadView(_template('pitch.print'),['title' => $title,'pitch'=>$pitch,'id'=>$id]);

        $pdf->setPaper('A4','landscape');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        // if(isset($_GET['type'])){
        //     $type= $_GET['type'];
        //     if($type=='dom'){
        //         return $pdf->stream('Day-Book.pdf');
        //     } else {
        //         return view(_template('quotation.print-test'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
        //     }
        // }
         return $pdf->stream('quotation.pdf');
        // return view(_template('quotation.print'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);      
    }

    public function email($id){
        $title = "View Invoice";
        $obj = new Mailer();
        
        $invoice = Quotation::where('id',$id)->first();

        $customer = Customer::where('id',$invoice->customer_id)->first();
        
        //

        $invoice = Quotation::with(['quotationItem','customerType'])->where('id',$id)->first();
        $pdf=PDF::loadView(_template('quotation.print'),['title' => $title,'invoice'=>$invoice,'id'=>$id]);
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
        $title = "Edit Quotation";
        //$invoice = Quotation::with(['quotationItem','inquiry','pitch'])->where('id',$id)->first();
        
        //dd($Quotation::where('invoice_id'));
        
        $pitch = Pitch::with(['quotation.inquiry','quotation.leadstatus','quotation.pitch'])->find($id);
        
        if(!$pitch){
            dd('Something wrong');
        }
        
       
        return view(_template('pitch.edit'),['title' => $title,'quotation'=>$pitch->quotation,'pitch'=>$pitch,'inquiry'=>$pitch->quotation->inquiry,'id'=>$id]);
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
                $data = [
                    'date'=>$request->date,
                    'revised_quote'=>$request->revised_quote,
                    'next_appointment'=>$request->next_appointment,
                    'mods'=>$request->mod,
                    'dayormonth'=>$request->dayormonth,
                    'phsn'=>json_encode($request->phsn),
                    'pdescription'=>json_encode($request->pdescription),
                    'pname'=>json_encode($request->pname),
                    'item_id'=>json_encode($request->item_id),
                    'prate'=>json_encode($request->prate),
                    'sgst'=>json_encode($request->sgst),
                    'qty'=>json_encode($request->pqty),
                    'days'=>json_encode($request->pday),
                    'discount'=>json_encode($request->pdiscount),
                    'cgst'=>json_encode($request->cgst),
                    'igst'=>json_encode($request->igst),
                    'gross_amount'=>json_encode($request->pgros_amount),
                    'tax_amount'=>json_encode($request->ptax_amount),
                    'total_amount'=>json_encode($request->ptotal_amount),
                    'product_id'=>json_encode($request->product_id),
                    'quotation_id'=>$request->quotation_id,
                    'total_tax_amount'=>$request->total_tax_amount,
                    'total_grand_amount'=>$request->total_grand_amount,
                    // 'total_gross_amount'=>json_encode($request->total_gross_amount),
                    'total_net_discount'=>$request->total_net_discount,
                ];
        //dd('xd');
       // dd($data);
        Pitch::where(['id'=>$id])->update($data);
        
        store_lead_status($request->enquire_id,$request->lead_status);
        return redirect( route('pitch.check.view',['id'=>$request->quotation_id]) )->with('msg','Your Pitch is updated');
        
    }

    public function check_view($id)
    {
        $title = "Check View";
        // $obj = new Mailer();
        $invoice = Quotation::with(['quotationItem','customerType','pitchLastest'])->where('id',$id)->first();
        return view( _template('pitch.check'),['title' => $title,'invoice'=>$invoice,'id'=>$id] );
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

