<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\VehicleMajorHead;
use Hash;
class VehicleHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = VehicleMajorHead::where('major',0)->get();
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
        $title = 'Create State';
        return view(_template('customer.create'),['title'=>$title]);
    }

    public function ajax_customers_details($id)
    {
        $customer = VehicleMajorHead::where('id',$id)->first();
        return response()->json($customer);
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
        VehicleMajorHead::create(['name'=>$request->heads]);
        return response()->json(['status'=>$data]);
    }
    public function minor_store(Request $request)
    {
        $this->validation($request);
        $data = $request->except(['_token','submit']); 
        VehicleMajorHead::create(['name'=>$request->heads,'major'=>$request->major]);
        return response()->json(['status'=>$data]);
    }

    public function validation($request){
        $this->validate($request, [
            'heads' => 'required | string',
            
        ],
        [
            'heads.required' => 'Head is required *',
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
        $item = VehicleMajorHead::find($id);
        return response()->json($item);
    }
    public function minor_fetch()
    {
        $items = VehicleMajorHead::where('major','>',0)->get();
        $ie = [];
        foreach($items as $item):
            $parent = VehicleMajorHead::where('id',$item->major)->first();
            $ie[] = ['name'=>$item->name,'id'=>$item->id,'parent_id'=> $parent ? $parent->id : '','parent'=> $parent ? $parent->name : ''];
        endforeach;
        return response()->json($ie);
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
        $customer = VehicleMajorHead::find($id);
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
        VehicleMajorHead::where('id',$id)->update(['name'=>$request->heads,'major'=>isset($request->major) ? $request->major : 0 ]);
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
        
        VehicleMajorHead::destroy($id);
        return response()->json(['status'=>true]);
    }
}
