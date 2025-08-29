<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Source;
use Hash;
class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Source::get();
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
        $title = 'Create Source';
        return view(_template('customer.create'),['title'=>$title]);
    }

    public function ajax_customers_limit($id)
    {
        //
        
        $typ =  ($id==1) ? 'B2B' : "B2C";
        $customers = Source::where('customer_type',$id)->get();
        $option =  "<option>Please select ".$typ."</option>";
        foreach($customers as $cust){
            $option .= "<option value=".$cust->id." data-complete=".$cust.">".$cust->company_name.' '.$cust->contact_persion_name."</option>";
        }
            $option .="<option value='other'> Other </option>";
        return response()->json(['option'=>$option,'type'=>$typ]);
        // $title = 'Create State';
        // return view(_template('customer.create'),['title'=>$title]);
    }
    public function ajax_customers_details($id)
    {
        //
        
       
        $customer = Source::where('id',$id)->first();
        
        
        return response()->json($customer);
        // $title = 'Create State';
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
        
        Source::create($data);
        //return redirect()->back()->with('msg','customer is added');
       return response()->json(['status'=>$data]);
    }

    public function validation($request){
        $this->validate($request, [
            'source' => 'required | string',
            
        ],
        [
            'source.required' => 'source *',
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
         $item = Source::find($id);
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
        $title = 'Edit Lead';
        $customer = Source::find($id);
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
        $data = $request->except(['_token','submit','_method']);   
        Source::where('id',$id)->update($data);
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
        
        Source::destroy($id);
        return response()->json(['status'=>true]);
    }
}
