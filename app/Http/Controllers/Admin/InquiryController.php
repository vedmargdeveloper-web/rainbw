<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Inquiry;
use App\Models\EnquireItem;
use App\Models\Address;
use App\Models\LeadStatusLog;
use App\Models\Lead;
use App\Models\Customer;
use Auth;
use DB;


class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request);
       $inquiry = Inquiry::with(['customer','address'])->orderBy('id','DESC')->get();
       
       if( $request->has('filter') ){
            $inquiry = Inquiry::with(['customer','address','leadstatus'])->where('status_id',$request->filter)->orderBy('id','DESC')->get();
       }
       
        //dd($inquiry); //->take(6)->orderBy('id','DESC')
        //return view(_template('inquiry.update'),['title'=>'All Inquiry','inquiry'=> $inquiry ]);
       return view(_template('inquiry.index'),['title'=>'All Inquiry','inquiry'=> $inquiry ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(_template('inquiry.create'),['title'=>'Create Inquiry']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        //dd($request);

        $isEnquiry = Inquiry::where('unique_id',$request->unique_id)->first();
        if($isEnquiry){
           return redirect()->back(); 
        }
            // dd($request->toArray());
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
        
            if($request->customer_id == 0){    

                $customer_details = [
                        'client_name'=>$company_name,
                        'caddress'=>$request->caddress,
                        'caddress1'=>$request->caddress1,
                        'ccity'=>$request->ccity,
                        'cstate'=>$request->cstate,
                        'cpincode'=>$request->cpincode,
                        'clandmark'=>$request->clandmark,
                        'contact_person_c'=>$request->contact_person_c,
                        'select_two_name'=>$request->select_two_name,
                        'cmobile'=>$request->cmobile,
                        'cwhatsapp'=>$request->cwhatsapp,
                        'cemail'=>$request->cemail,
                        'cgstin'=>$request->cgstin,
                        'creadyness'=>$request->creadyness,
                    ];
                } else {
                    $customer_details = [
                        'client_name'=>$company_name,
                        'caddress' => $request->caddress,
                        'caddress1' => $request->caddress1,
                        'ccity' => $request->ccity, 
                        'company_name' => $customer->company_name, 
                        'cstate' => $request->cstate,
                        'cpincode' => $request->cpincode, 
                        'cwhatsapp'=>$request->cwhatsapp,
                        'cmobile' => $request->cmobile, 
                        'contact_person_c' => $request->contact_person_c,
                        'select_two_name' => $request->select_two_name,
                        'cemail'=>$request->cemail,
                        'cgstin'=>$request->cgstin,
                        'creadyness'=>$request->creadyness,
                    ];    
                }

//        dd($customer_details);

        $venue_details  = [
            'venue_name'=>$venue,
            'daddress'=>$request->daddress,
            'daddress1'=>$request->daddress1,
            'dcity'=>$request->dcity,
            'dstate'=>$request->dstate,
            'dperson'=>$request->dperson,
            'dpincode'=>$request->dpincode,
            'readyness'=>$request->dreadyness,
            'dmobile'=>$request->dmobile,
            'dlandmark'=>$request->dlandmark,   
            'remark'=>$request->remark,   
        ];

        $item_id  = $request->item_id;
        
        $inquiry = [
                    'unique_id'=>$request->unique_id,
                    'delivery_id'=>$request->delivery_id,   
                    'customer_id'=>$request->customer_id,   
                    'contact_person_c'=>$request->contact_person_c,   
                    'remark'=>$request->remark,
                    'customer_details'=>json_encode($customer_details),
                    'venue_details'=>json_encode($venue_details),
                    'occasion_id'=>$request->occasion_id,
                    'email'=>$request->cemail,
                    'phone'=>$request->cmobile,
                    'venue_phone'=>$request->dmobile,
                    'sources_id'=>$request->source_id,
                    'leads_id'=>$request->lead_status,
                    'inquire_date'=>$request->inquire_date,
                    'event_date'=>$request->event_date,
                    'customer_type'=>$request->customer_type,
                    'compition'=>$request->compition,
                    'status_id'=>$request->lead_status
        ];


        //dd($request->lead_status);

        //dd($inquiry);
                $inquiry_id   = Inquiry::create($inquiry)->id;
                foreach ($item_id as $key => $value) {
                        $item = [
                            'item_id'=>$request->item_id[$key],
                            'qty'=>$request->qty[$key],
                            // 'date'=>$request->date[$key],
                            'days'=>$request->days[$key],
                            // 'time'=>$request->time[$key],
                            // 'time_two'=>$request->time_two[$key],
                            
                            'inquiry_id'=>$inquiry_id,
                            ];  
                        EnquireItem::create($item);
                }
                
                store_lead_status($inquiry_id,$request->lead_status);
                return redirect()->back()->with(['msg'=>'Inquiry added successfully']); 
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
        $inquiry = Inquiry::with(['leadstatus','address','customer.customer_state','customer.customer_city','address','address.icity','address.istate'])->find($id);
        if(!$inquiry)
            return  'Something wrong';

        
        return view(_template('inquiry.edit'),['title'=>'Edit Inquiry','inquiry'=> $inquiry ]);
        
    }

    public function fetch_ajax_inquiry_history(Request $request)
    {
       $inquiries = Inquiry::where('phone',$request->phone)->get(['id']);
        // dd($inquiries->toArray());
       $lead_status =  LeadStatusLog:: select("status", DB::raw("count(*) as status_count"))
                        ->whereIn('inquires_id',$inquiries->toArray())->groupBy('status')
                        ->get();//whereIn('inquires_id',$inquiries->toArray())->groupBy('status')->get();
        if(count($lead_status) > 0 ){
         
            $html = "<tr>
                        <th>Lead Status</th>
                        <th>Financial</th>
                    </tr>";

            foreach($lead_status as $inq):
                           $html .= "<tr><th>$inq->status</th><th>".$inq->status_count."</th></tr>";
            endforeach;
            return response()->json(['status'=>true,'inquires'=>$html]);
        }
       // dd($lead_status);
        return response()->json(['status'=>false]);
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
            // dd();
            // dd($request->toArray());
            $customer = Customer::where(['id'=>$request->customer_id])->first();
            
            $delivery = Address::where(['id'=>$request->delivery_id])->first();  

            
                if($customer){
                        $company_name = $customer->company_name;
                }   else{
                        $company_name = $request->company_name;
                }

               
                if($delivery){
                    $venue = $delivery->venue;
                }else{
                    $venue = $request->venue_name;
                }

          //  dd($venue);

            if($request->customer_id == 0){        
                $customer_details = [
                    'client_name'=>$company_name,
                    'caddress'=>$request->caddress,
                    'caddress1'=>$request->caddress1,
                    'ccity'=>$request->ccity,
                    'cstate'=>$request->cstate,
                    'cpincode'=>$request->cpincode,
                    'clandmark'=>$request->clandmark,
                    'contact_person_c'=>$request->contact_person_c,
                    'cmobile'=>$request->cmobile,
                    'cwhatsapp'=>$request->cwhatsapp,
                    'cemail'=>$request->cemail,
                    'cgstin'=>$request->cgstin,
                    'creadyness'=>$request->creadyness,
                ];
            } else {
                $customer_details = [
                    'client_name'=>$company_name,
                    'caddress' => $request->caddress,
                    'caddress1' => $request->caddress1,
                    'ccity' => $request->ccity, 
                    'company_name' => $customer->company_name, 
                    'clandmark'=>$request->clandmark,
                    'cstate' => $request->cstate,
                    'cpincode' => $request->cpincode, 
                    'cmobile' => $request->cmobile, 
                    'contact_person_c' => $request->contact_person_c,
                    'select_two_name' => $request->select_two_name,
                    'cemail'=>$request->cemail,
                    'cwhatsapp'=>$request->cwhatsapp,
                    'cgstin'=>$request->cgstin,
                    'creadyness'=>$request->creadyness,
                ];    
            }

        // dd($customer_details);

        $venue_details  = [
            'venue_name'=>$venue,
            'daddress'=>$request->daddress,
            'daddress1'=>$request->daddress1,
            'dcity'=>$request->dcity,
            'dstate'=>$request->dstate,
            'dperson'=>$request->dperson,
            'dpincode'=>$request->dpincode,
            'readyness'=>$request->dreadyness,
            'dmobile'=>$request->dmobile,
            'dlandmark'=>$request->dlandmark,   
            'remark'=>$request->remark,   
        ];

        $item_id  = $request->item_id;
        
        $inquiry = [
                    'unique_id'=>$request->unique_id,
                    // 'delivery_id'=>$request->delivery_id,   
                    // 'customer_id'=>$request->customer_id,   
                    'remark'=>$request->remark,
                    'customer_details'=>json_encode($customer_details),
                    'venue_details'=>json_encode($venue_details),
                    'occasion_id'=>$request->occasion_id,
                    'email'=>$request->cemail,
                    'phone'=>$request->cmobile,
                    
                    'venue_phone'=>$request->dmobile,
                    'sources_id'=>$request->source_id,
                    'leads_id'=>$request->lead_status,
                    'customer_type'=>$request->customer_type,
                    'status_id'=>$request->lead_status,
        ];
               
                Inquiry::where('id',$id)->update($inquiry);
                EnquireItem::where('inquiry_id',$id)->delete();

                

                foreach ($item_id as $key => $value) {
                        $item = [
                            'item_id'=>$request->item_id[$key],
                            'qty'=>$request->qty[$key],
                            // 'date'=>$request->date[$key],
                            'days'=>$request->days[$key],
                            // 'time'=>$request->time[$key],
                            // 'time_two'=>$request->time_two[$key],
                            // 'venue'=>$request->venue[$key],
                            'inquiry_id'=>$id,
                            ];  
                        EnquireItem::create($item);
                }
            // lead status 9 for open
        store_lead_status($id,$request->lead_status);
        return redirect()->back()->with(['msg'=>'Inquiry updated successfully']);


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
