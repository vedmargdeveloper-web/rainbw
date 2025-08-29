<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GstMaster;

class GstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Gst List';
        $items = GstMaster::with(['city','state'])->get();
        //dd($items);
        return view(_template('item.index'),['title'=>$title,'items'=>$items]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Masters';
        //return view(_template('item.create'),['title'=>$title]);
        return view(_template('master.sections.item'),['title'=>$title]);
    }

    public function fetch_gst_ajax(){
        $items = GstMaster::with(['city','state'])->get();
        return response()->json(['data'=>$items]);
    }

    public function ajax_fetch_gst($product_id){
        // $product_id = $request->product_id;
        $product = GstMaster::with(['city','state'])->where('id',$product_id)->first();
        return response()->json($product,200);
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
        $this->validation($request);
        $data = $request->except(['_token','submit']); 
        // dd($data);
        $data['head'] = json_encode($request->head);
        GstMaster::create($data);

        //return redirect()->back()->with('msg','Product is added');
        return response()->json(['msgs'=>'gst is added']);
       
    }

    public function validation($request){
        $this->validate($request, [
            'company_name' => 'required',
            'head_office' => 'required',
            'branch_office' => 'required',
            'temp_address' => 'nullable|',
            'gstin' => 'required|size:15',
            'udyam_reg_no' => 'required',
            'pincode' => 'required|digits:6',
            'state' => 'required',
            //'issue_date' => 'required',
            'city' => 'required',
            'state' => 'required',
            //'expiry_date' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'required',
        ],
        [
            // 'name.required' => 'Product Name is required *',
            // 'description.required' => 'Description is required *',
            // 'hsn.required' => 'HSN is required *',
            // 'sgst.required' => 'sgst is required *',
            // 'igst.required' => 'igst is required *',
            // 'cgst.required' => 'cgst is required *',
            // 'status.required' => 'Status is required *',
        ]);
        // if( $validator->fails() ) {
        //     return response()->json( $validator->errors() );
        // }
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
        $item = GstMaster::find($id);
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
        $title = 'Edit Item';
        $item = GstMaster::find($id);
        return view(_template('item.edit'),['title'=>$title,'item'=>$item]);
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
        $data['head'] = json_encode($request->head);
        $ee = GstMaster::where('id',$id)->update($data);
    //    return redirect()->back()->with('msg','Product is updated');
        return response()->json(['msgs'=>true]);
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
        
        GstMaster::destroy($id);
        return response()->json(['msg'=>'Item is deleted']);
        //return redirect()->back()->with('msg','Product Deleted Successfully...');   
    }
}
