<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        $type = $request->has('type') ? $request->type : 'supply'; 
        $title = ucfirst($type.' All Address');

        $addresss = Address::with(['city','state'])->get();
        // dd($addresss);
        return response()->json(['data'=>$addresss]);
        //return view(_template('address.index'),['title'=>$title,'addresss'=>$addresss]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    //
        //isPermission(7);
        $type = $request->has('type') ? $request->type : 'supply';  
        $title = ucfirst($type.' Create Address');
        return view(_template('address.create'),['title'=>$title,'type'=>$type]);
    }

    public function ajax_delivery_details($id)
    {
        //
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
        $this->validation($request);
        $data = $request->except(['_token','submit']); 
        Address::create($data);
        return response()->json(['msg'=>true]);
        //return redirect()->back()->with('msg','Address is added');
       
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
        dd('xe');
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
        return response()->json(['msg'=>true, 'all' => $request->all()]);
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
