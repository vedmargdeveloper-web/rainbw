<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\ChallanTypeMaster;
use Hash;
class MasterController extends Controller
{

    public function index()
    {

      
        
    }

    public function master_password(){
        return view(_template('master.sections.password') );
    }
    public function fetch_user_ajax(Request $request ){
        $user = User::find($request->id);
        return response()->json($user);
    }
    public function update_password(Request $request ){
        $this->validation($request);
        //$user = User::find($request->id);
        User::where('employee_code',$request->user_id)->update(['password'=>Hash::make($request->password)]);
        return response()->json(['status'=>true]);
    }

    public function city() {
        $city = City::get();
        $state =State::get();

        $city_options =  "<option> Select city </option>";
        $state_options =  "<option> Select State </option>";
        foreach($city as $c){
            $city_options .= "<option value='$c->id'>$c->city</option>";
        }

        foreach($state as $c){
            $state_options .= "<option value='$c->id'>$c->state</option>";
        }

        return response()->json(['city'=>$city_options,'state'=>$state_options]);


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
        $challanTypes = ChallanTypeMaster::get();
        //return view(_template('item.create'),['title'=>$title]);
        return view(_template('master.index'),['title'=>$title, 'challanTypes'=>$challanTypes]);
     
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       
    }

    public function validation($request){
        $this->validate($request, [
            'password' => 'required|min:6',
            'username' => 'required',
            'user_id' => 'required',
            'password_confirmation' => 'required|same:password|min:6'
        ],
        [
            'user_id.required' => 'User id is required *',
            'username.required' => 'Name is required *',
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
        
        
        //return redirect()->back()->with('msg','Product Deleted Successfully...');   
    }
}
