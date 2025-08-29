<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Color;
use Hash;
class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Color::get();
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
        $title = 'Create Color';
        return view(_template('customer.create'),['title'=>$title]);
    }


    public function ajax_customers_details($id)
    {
        //
        
       
        $customer = Color::where('id',$id)->first();
        
        
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
        
        Color::create($data);
        //return redirect()->back()->with('msg','customer is added');
        return response()->json(['status'=>$data]);
    }

    public function validation($request){
        $this->validate($request, [
            'color' => 'required | string',
            
        ],
        [
            'color.required' => 'color *',
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
         $item = Color::find($id);
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
        $title = 'Edit State';
        $customer = Color::find($id);
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
        Color::where('id',$id)->update($data);
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
        
        Color::destroy($id);
        return response()->json(['status'=>true]);
    }
}
