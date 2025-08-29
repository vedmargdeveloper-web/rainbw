<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\VendorAllocation;
use App\Models\Logistice;
use App\Models\BookingsItem;
use App\Models\VechicleIDGenration;
use App\Models\Lead;
use App\Models\Challan;
use App\Models\Item;
use PDF;


class LogisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return view(_template('logistics.create'));
    }

    public function create(Request $request)
    {
        $title = ' Allocation | Rainbow '; 
        $customers  = Customer::with('VendorAllocation.Allocation')->where(['customer_type'=>1,'allocation'=>1])->get(['id','company_name']);
        
        $allocations = VendorAllocation::with(['Allocation.booking.leadstatus','vendorfetch'])->whereHas('Allocation',function($q){
            $q->whereNull('status');
        })->where('allocation_qty','!=',0)->get();
        //dd($allocations);
        return view(_template('logistics.create'),['customers'=>$customers,'bookings'=>$allocations,'title'=>$title]);     
    }

    public function ajax_delivery_details($id)
    {
        $address = Address::with(['city','state'])->where('id',$id)->first();
        return response()->json($address);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    public function validation($request){
        $this->validate($request, [
            'type' => 'required',
            'address' => 'required|max:255',
            'city' => 'required|string',
            'state' => 'required|string',
            'venue' => $request->type=='delivery' ? 'required'  : 'nullable',
            'landmark' => $request->type=='delivery' ? 'nullable'  : 'nullable',
            'pincode' =>  'nullable|numeric',
            'mobile' => $request->type=='delivery' ? 'nullable|digits:10'  : 'nullable|numeric|digits:10',
            'contact_person_name' => $request->type=='delivery' ? 'nullable'  : 'nullable',
        ],
        [
            'venue.required' => 'Venue is required *',
            'type.required' => 'type is required *',
            'address.required' => 'address is required *',
            'state.required' => 'State is required *',
            'pincode.required' => 'pincode is required *',
            'contact_person_name.required' => 'Contact  is required *',
        ]);
    }

    public function ajax_store_data( Request $request ){
        $data = $request->all();
        $data['performance_details']= json_encode($request->marged);
        unset($data['marged']);
        if($request->lead_status){
            store_lead_status($request->inquires_id,$request->lead_status);    
        }
        Logistice::updateOrCreate(['uniqueid'=>$request->uniqueid],$data);
        return response()->json(['final'=>$request->lead_status,'data'=>$data]);
    }

    public function challan(Request $request)
    {
        $id =  $request->id;
        $item_id = $request->item_id;
        $unique_id_tr = $request->unique_id_tr;
        $challan = challan::where('unique_id_tr',$request->unique_id_tr)->first();
        $item  =  VechicleIDGenration::with('item')->where('id',$request->selected_vehicleid)->first();
        
        //$item = BookingsItem::where(['invoice_id'=>$id,'item_id'=>$item_id])->first();
        
        $booking = Booking::with('bookingItem')->where('id',$id)->first();
        $htmlContent = view( _template('logistics.challan') ,['itemsingle'=>$item,'newitem'=>$item,'invoice_id'=>$id,'booking'=>$booking,'item_id'=>$item_id,'id'=>$id,'unique_id_tr'=>$unique_id_tr,'challan'=>$challan])->render();
        //$htmlContent = ;
       // return view( _template('logistics.challan') ,['itemsingle'=>$item,'newitem'=>$item,'invoice_id'=>$id,'booking'=>$booking,'item_id'=>$item_id,'id'=>$id,'unique_id_tr'=>$unique_id_tr,'challan'=>$challan]);
        return response()->json(['status'=>true,'html'=>$htmlContent]);
    }

    public function challan_store(Request $request ){
        $data  = $request->all();
        Challan::updateOrCreate(['unique_id_tr'=>$request->unique_id_tr,'challan_no'=>$request->challan_no],$data);
        return response()->json(['status'=>true,'msg'=>'thank you']);
    }
    
    public function challan_print(Request $request)
    
    {
        $id =  $request->id;
        $item_id = $request->item_id;
        //dd($item_id);
        //$item =  Item::where('id',$item_id)->first();
        $item = BookingsItem::where(['invoice_id'=>$id,'item_id'=>$item_id])->first();
        //dd($item); 
        
        $booking = Booking::with('bookingItem')->where('id',$id)->first();
        $pdf=PDF::loadView(_template('logistics.challan-print'),['itemsingle'=>$item,'booking'=>$booking]);

        $pdf->setPaper('A4','portrait');
        $content = $pdf->download()->getOriginalContent();
        $invoice_name = time().'.pdf';
        return $pdf->stream('quotation.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
         $address = Address::find($id);
        
        return response()->json($address);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('working...');
        //
        $title = 'Edit Address';
        
        $address = Address::find($id);
        
        return response()->json($address);

        //return view(_template('address.edit'),['title'=>$title,'address'=>$address]);
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
        $this->validation($request);
        $data = $request->except(['_token','submit','_method']); 
        Address::where('id',$id)->update($data);
        return response()->json(['msg'=>true]);
        //return redirect()->back()->with('msg','Address is updated');
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
        
        Address::destroy($id);
        return response()->json(['msg'=>true]);
    }
}
