<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Items';
        $items = Item::get();
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

    public function fetch_item_ajax(){
        $items = Item::get(['name','hsn','description','cgst','sgst','igst','sac','status','id','created_at']);
        return response()->json(['data'=>$items]);
    }

    public function ajax_fetch_item($product_id){
        // $product_id = $request->product_id;
        $product = Item::where('id',$product_id)->first();
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
        Item::create($data);

        //return redirect()->back()->with('msg','Product is added');
        return response()->json(['msgs'=>'Product is added']);
       
    }

    public function validation($request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'hsn' => 'required',
            'cgst' => 'required|numeric',
            'igst' => 'required|numeric',
            'sgst' => 'required|numeric',
            'status' => 'required',
        ],
        [
            'name.required' => 'Product Name is required *',
            'description.required' => 'Description is required *',
            'hsn.required' => 'HSN is required *',
            'sgst.required' => 'sgst is required *',
            'igst.required' => 'igst is required *',
            'cgst.required' => 'cgst is required *',
            'status.required' => 'Status is required *',
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
        $item = Item::find($id);
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
        $item = Item::find($id);
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
        $ee = Item::where('id',$id)->update($data);
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
        
        Item::destroy($id);
        return response()->json(['msg'=>'Item is deleted']);
        //return redirect()->back()->with('msg','Product Deleted Successfully...');   
    }
}
