<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\VendorAllocation;
use App\Models\Allocation;
use App\Models\Lead;


class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        return view(_template('allocation.index'));
    }
    // for insert quanitry and rate  and on allocation 
    public function ajax_table_location(Request $request)
    {   
        $unique_tr = $request->unique_tr;
        $data_amount = $request->data_amount;
        $data_finalrainbowbooking = $request->data_finalrainbowbooking;
        $allocation = Allocation::with('allocationVendor.item')->where('unique_tr_id',$unique_tr)->first();
        $customers  = Customer::where(['customer_type'=>1,'allocation'=>1])->get(['id','company_name']);
        $leads = Lead::where('lead_heads_id',3)->get();
        $returnHTML = view(_template('allocation.allocation_table_fetch'),['customers'=>$customers,'unique_tr'=>$unique_tr,'allocation'=>$allocation,'data_amount'=>$data_amount,'leads'=>$leads,'data_finalrainbowbooking'=>$data_finalrainbowbooking])->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
        //return view(_template('allocation.allocation_table_fetch'),['customers'=>$customers,'unique_tr'=>$unique_tr,'allocation'=>$allocation,'data_amount'=>$data_amount,'leads'=>$leads,'data_finalrainbowbooking'=>$data_finalrainbowbooking]);
    }
    public function allocation_vendor_table_fetch(Request $request)
    {   
        $vendor_id = $request->vendorid;
        $item_id = isset($request->item_id) ? $request->item_id : false;
        if($item_id){
            $vendor_no1 = VendorAllocation::with(['vendorfetch','allocation'])->whereHas('allocation',function($q){
                    $q->where('allocation_in',1);
            })->where(['vendor_id'=>$vendor_id])->where('item_id',$item_id)->get();    

            $vendor_no2 = VendorAllocation::with(['vendorfetch','allocation'])->whereHas('allocation',function($q){
                    $q->where('allocation_in',2);
            })->where(['vendor_id'=>$vendor_id])->where('item_id',$item_id)->get();    

        }else{
            $vendor_no1 = VendorAllocation::with(['vendorfetch','allocation'])->whereHas('allocation',function($q){
                    $q->where('allocation_in',1);
            })->where(['vendor_id'=>$vendor_id])->get();
            $vendor_no2 = VendorAllocation::with(['vendorfetch','allocation'])->whereHas('allocation',function($q){
                    $q->where('allocation_in',2);
            })->where(['vendor_id'=>$vendor_id])->get();
        }
         
     //   return view(_template('allocation.vendor_details_table'),['vendor'=>$vendor]);
        $returnHTML = view(_template('allocation.vendor_details_table'),['vendor1'=>$vendor_no1,'vendor2'=>$vendor_no2])->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Allocation | Rainbow';
        $customers  = Customer::with('VendorAllocation.Allocation')->where(['customer_type'=>1,'allocation'=>1])->get(['id','company_name']);
        $bookings  = Booking::with(['bookingItem'=>function($qu){
                        $qu->withCount('vechicleGenration');
                    },'leadstatus'])->whereHas('leadstatus',function($q){
                    $q->orderBy('created_at', 'desc')->where('status', 'Proceed for Allocation')->limit(1);
        })->get();
        //dd($bookings->toArray());
        //dd($bookings->toArray());
        return view(_template('allocation.create'),['customers'=>$customers,'bookings'=>$bookings,'title'=>$title]);     
        /*if(isset($_GET['vikrant'])){
            return view(_template('allocation.testing_desgin'),['customers'=>$customers,'bookings'=>$bookings,'title'=>$title]);
        }else{
            
        }*/
        
       
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



        $allocation_store_obj =  $request->allocation_store_obj['unique_tr_id'] ?? '';
        $vendor_allocation = [];


        $allocation = [
                         'allocation_date'=>$request->allocation_store_obj['allocation_date'],
                         'billing_date'=>$request->allocation_store_obj['billing_date'],
                         'booking_id'=>$request->allocation_store_obj['booking_id'],
                         'day'=>$request->allocation_store_obj['day'],
                         'grand_total_booked'=>$request->allocation_store_obj['grand_total_booked'],
                         'grand_unallocated_booking'=>($request->allocation_store_obj['grand_unallocated_booking'] > 0) ? $request->allocation_store_obj['grand_unallocated_booking'] : 0 ,
                         'item'=>$request->allocation_store_obj['item'],
                         'item_id'=>$request->allocation_store_obj['item_id'],
                         'rainbow_booking'=>$request->allocation_store_obj['rainbow_booking'],
                         'bookings_table_id'=>$request->allocation_store_obj['bookings_table_id'],
                         'rainobw_unallocated'=>$request->allocation_store_obj['rainobw_unallocated'],
                         'readyness'=>$request->allocation_store_obj['readyness'],
                         'required_qty'=>$request->allocation_store_obj['required_qty'],
                         'allocation_in'=>$request->allocation_store_obj['allocation_in'],
                         'total_dealer_booked'=>$request->allocation_store_obj['total_dealer_booked'],
                         'unique_tr_id'=>$request->allocation_store_obj['unique_tr_id'],
                         'venue_name'=>$request->allocation_store_obj['venue_name'],
                         'leadstatus'=>$request->allocation_store_obj['leadstatus_btn_allocation'],
                    ];

        $bookingid = Booking::where('id',$request->allocation_store_obj['bookings_table_id'])->first()->enquire_id;
       // return response()->json($bookingid);
        
        if($request->allocation_store_obj['leadstatus_btn_allocation']){
            store_lead_status($bookingid,$request->allocation_store_obj['leadstatus_btn_allocation']);    
        }
        

        $last_id = Allocation::updateOrCreate(['unique_tr_id'=>  $request->allocation_store_obj['unique_tr_id'] ],$allocation);
        
        foreach($request->get_allocation_entries as  $key => $get_allocation_entries):
            $metch = ['unique_tr_id' =>$allocation_store_obj, 'vendor_id' =>$get_allocation_entries['vendor_id']];
            $vendor_allocation = [
                                    // 'accomodation' =>$get_allocation_entries['accomodation'],
                                    'vendor_id' =>$get_allocation_entries['vendor_id'],
                                    'allocation_qty' =>$get_allocation_entries['allocation_qty'],
                                    'rental' =>$get_allocation_entries['rental'],
                                    'booking_date' => $request->allocation_store_obj['billing_date'],
                                    // 'transport' =>$get_allocation_entries['transport'],
                                    // 'driver' =>$get_allocation_entries['driver'],
                                    // 'food' =>$get_allocation_entries['food'],
                                    // 'accomodation' =>$get_allocation_entries['accomodation'],
                                    // 'conveyance' =>$get_allocation_entries['conveyance'],
                                    // 'security' =>$get_allocation_entries['security'],
                                    // 'other' =>$get_allocation_entries['other'],
                                    // 'tax' =>$get_allocation_entries['tax'],
                                    'remark' =>$get_allocation_entries['remark'],
                                    'unique_tr_id' =>$allocation_store_obj,
                                    'allocation_id' =>$last_id->id,
                                    'item_id'=>$request->allocation_store_obj['item_id'],
                                ];
        VendorAllocation::updateOrCreate($metch,$vendor_allocation);

            
        endforeach;
        return response()->json(['status'=>true,'msg'=>'All Good']);
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
