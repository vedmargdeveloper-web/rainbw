<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Customers';
        $customers = Customer::with(['city','state','type'])->get();
      
        return response()->json($customers);

        //return view(_template('customer.index'),['title'=>$title,'customers'=>$customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Create Customer';
        return view(_template('customer.create'),['title'=>$title]);
    }

    public function ajax_customers_limit($id,$compition)
    {
    
        $typ =  ($id==1) ? 'B2B' : "B2C";
        $customers = Customer::where(['customer_type'=>$id,'allocation'=>$compition])->get();
        $option =  "<option>Please select </option>";
        foreach($customers as $cust){
            $option .= "<option value=".$cust->id." data-complete=".$cust.">".$cust->company_name.' '.$cust->contact_persion_name."</option>";
        }
        return response()->json(['option'=>$option,'type'=>$typ]);
        // $title = 'Create Customer';
        // return view(_template('customer.create'),['title'=>$title]);
    }
    public function ajax_customers_details($id)
    {
        
        $customer = Customer::with(['city','state'])->where('id',$id)->first();
        return response()->json($customer);
        // $title = 'Create Customer';
        // return view(_template('customer.create'),['title'=>$title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $data = $request->except(['_token','submit']); 
        // dd($data);
        $data['designation'] =json_encode($request->designation);  
        $data['mobile'] =json_encode($request->mobile);  
        $data['contact_person_name'] =json_encode($request->contact_person_name);  
        Customer::create($data);
        //return redirect()->back()->with('msg','customer is added');
       return response()->json(['status'=>$data]);
    }

    public function validation($request){
        $this->validate($request, [
            'customer_type' => 'required',
            'company_name' => 'nullable|required',
            'address' => 'required|max:255',
            'city' => 'required|string',
            'cwhatsapp' => 'required|numeric',
            'state' => 'required|string',
            'pincode' => 'nullable|numeric',
            'gstin' => $request->customer_type == 2 ? 'nullable' : 'required|min:15|max:15',
            'email' => 'required|email',
        ],
        [
            'customer_type.required' => 'Customer Type  is required *',
            'address.required' => 'Address is required *',
            'city.required' => 'City is required *',
            'state.required' => 'State is required *',
            'pincode.required' => 'pincode is required *',
            'gstin.required' => 'GST is required *',
            'status.required' => 'Status is required *',
            'contact_person_name.required' => 'contact person name is required *',
            'contact_person_name.required' => 'contact person name is required *',
            'mobile.required' => 'Mobile  is required *',
            'mobile.email' => 'Email  is required *',
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
         $item = Customer::find($id);
        return response()->json($item);
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
        $title = 'Edit customer';
        $customer = Customer::find($id);
        return view(_template('customer.edit'),['title'=>$title,'customer'=>$customer]);
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
        $data['designation'] =json_encode($request->designation);  
        $data['mobile'] =json_encode($request->mobile);  
        $data['contact_person_name'] =json_encode($request->contact_person_name);  
        Customer::where('id',$id)->update($data);
        return response()->json(['msgs'=>$data]);
        //return redirect()->back()->with('msg','Customer is updated');
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
        
        Customer::destroy($id);
        return response()->json(['status'=>true]);
    }
}
