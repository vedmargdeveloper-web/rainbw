<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChallanTypeMaster;
use Illuminate\Http\Request;

class ChallanTypeMasterController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $challanTypes = ChallanTypeMaster::all();
    //     return response()->json($challanTypes);
    //     // return view(_template('customer.index'),['challanTypes'=>$challanTypes]);
    // }

    public function index()
{
    $challanTypes = ChallanTypeMaster::select('type_name')->get();
    return view('admin.master.sections.challan', compact('challanTypes'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Create Challa Type';
        return view(_template('customer.create'),['title'=>$title]);
    }


    public function ajax_customers_details($id)
    {
        //
        
       
        $customer = ChallanTypeMaster::where('id',$id)->first();
        
        
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
        
        ChallanTypeMaster::create($data);
        return redirect()->back()->with('msg','Challan Type is added');
        // return response()->json(['status'=>$data]);
    }

    public function validation($request){
        $this->validate($request, [
            'type_name' => 'required | string',
            
        ],
        [
            'type_name.required' => 'type_name *',
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
         $item = ChallanTypeMaster::find($id);
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 // Edit method
public function edit($id)
{
    $challanType = ChallanTypeMaster::find($id);

    if (!$challanType) {
        return response()->json(['status' => false, 'message' => 'Challan Type not found'], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $challanType,
        'message' => 'Challan Type data fetched successfully.'
    ]);
}

// Update method
public function update(Request $request, $id)
{
    $request->validate([
        'type_name' => 'required|string|max:255',
    ]);

    $challanType = ChallanTypeMaster::find($id);

    if (!$challanType) {
        return response()->json(['status' => false, 'message' => 'Challan Type not found.'], 404);
    }

    $challanType->type_name = $request->type_name;
    $challanType->save();

    return response()->json([
        'status' => true,
        'message' => 'Challan Type updated successfully.'
    ]);
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
        
        ChallanTypeMaster::destroy($id);
        return response()->json(['status'=>true]);
    }
}
