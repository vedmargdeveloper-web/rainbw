<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Registration;


class AdminController extends Controller
{
    

    public function index() {
        if(Auth::check()){
            return redirect()->route('admin.home');
            die();
        }
        return view('admin/login');
    }

    public function login( Request $request ) {

        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);


        if( Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin']) ) {
            return redirect()->route('admin.home');
        }elseif( Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'teacher']) ) {
            return redirect()->route('teacher.home');
        }

        return redirect()->back()->with('message', 'Invalid Email or password!');

    }

       public function searchPincode( Request $request ) {

        // if( !$request->ajax() )
        //     return;
            
        if( !$request->pincode )
            return;

        $headers = array(
                            'Accept: application/json',
                            'Content-Type: application/json',
                    );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.postalpincode.in/api/pincode/' . $request->pincode );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //$body = '{}';
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
        //curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);

        if( !isset( $json->Status ) || $json->Status !== 'Success' )
            return response()->json(['error' => true, 'message' => 'Pincode not found!']);

        if( !isset( $json->PostOffice ) || !$json->PostOffice )
            return response()->json(['error' => true, 'message' => 'Pincode not found!']);

        if( count($json->PostOffice) < 1 )
            return response()->json(['error' => true, 'message' => 'Pincode not found!']);

        $data = [
                    'pincode' => $request->pincode,
                    'city' => $json->PostOffice[0]->District,
                    'state' => $json->PostOffice[0]->State,
                    'country' => $json->PostOffice[0]->Country,
                ];

        return response()->json(['error' => false, 'data' => $data]);
    }


    public function home(){
        $title = 'Dashboard';
        return view(_template('dashboard.index'),['title'=>$title]);
    }


   
    public function teachers(){

        return view('admin/setting/all_teacher');
    }

    public function registration(){
        $registration = Registration::get();
        return view('admin/registration/index',['registrations'=>$registration]);
    }
    public function registration_view($id){
        $registration = Registration::where('id',$id)->first();
        return view('admin/registration/view',['registration'=>$registration]);
    }
    public function registration_delete(){
        $registration = Registration::get();
        return view('admin/registration/index',['registrations'=>$registration]);
    }

    public function createteacher(){

        return view('admin/setting/createteacher');
    }

    public function edit_teacher(){

        return view('admin/setting/edit_teacher');
    }


    public function createteacherstore(Request $request){


        $this->validate($request, [
                    'name' => 'required|max:255|string',
                    'email' => 'required|max:255|email|unique:users',
                    'mobile' => 'required|max:255|digits:10',
                    'department' => 'required',
                    'password' => 'required|min:8|max:255'
            ],
            [
                    'name.required' => 'Name is required *',
                    'name.max' => 'Name can have upto 255 characters!',
                    'email.required' => 'Email is required *',
                    'email.max' => 'Email can have upto 255 characters!',
                    'email.email' => 'Email must be valid!',
                    'email.unique' => 'Email already exist!',
            ]);

            $user = new User();
            $user->role = 'teacher';
            $user->name = $request->name;
            $user->department = $request->department;
            $user->email = $request->email;
            $user->password = Hash::make( $request->password );
            $user->s_password =  $request->password ;
            $user->mobile = $request->mobile;
            $user->save();

        return redirect()->back()->with('message', 'Teacher Created');

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin');
    }

    
}
