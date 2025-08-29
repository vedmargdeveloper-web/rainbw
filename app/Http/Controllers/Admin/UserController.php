<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = ' All Users';
        $users = User::with('business')->where('role','!=','admin')->get();
        return view(_template('users.index'),['title'=>$title,'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        //

        $title = " Create User";
        return view(_template('users.create'),['title'=>$title]);
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
        $data['s_password'] =  $request->password;
        $data['password'] =  Hash::make($request->password);
        $data['role'] = "staff";
        
        //dd($data);
        if($request->has('photo')){
            $data['photo'] = $request->photo->store('users','public');
        }
       // dd($data);
        User::create($data);
        return redirect()->back()->with('msg','Users is added');
       
    }

    public function validation($request){
        $this->validate($request, [
            'name' => 'required',
            'aadhar' => 'required|max:255', 
            'mobile' => 'required|numeric|digits:10|unique:users',
            'employee_code' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5048 ',
            'business_type' => 'required|string',
            'business_short_code' => 'required|string',
            'aadhar' => 'required|digits:16',
            'status' => 'required|string:',
            'email' => 'nullable|email',
        ],
        [
            'name.required' => 'Name is required *',
            'mobile.required' => 'Mobile is required *',
            'aadhar.required' => 'Aadhar No  is required *',
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
    }
    public function permissions($id)
    {   
        //isPermission(7);
        // if(!isset($_GET['q'])){
        //     echo 'reload ';
        //     //echo $_SERVER['HTTP'];
        //     echo '<script>wino</script>';
        // }
        // die();
        $permissions = Permission::where('user_id',$id)->first();
        
        return view(_template('users.permission'),['id'=>$id,'user'=>$permissions]);
    }



    public function permissions_store(Request $request){
              $this->validate($request, [
                                'uid' => 'required',
                                'permissions' => 'required'
                        ]);

        $user = User::where('id', $request->uid)->first();
        if( !$user )
            return redirect()->back()->withErrors(['msg' => 'Oops! something went wrong.'])->withInput();

        $arr = [];
        foreach ($request->permissions as $key => $value) {
            $a = explode(',', $value);
            $arr[] = [
                        'route' => $a[0],
                        'label' => $a[1],
                        'parent' => $a[2]
                    ];
        }

        //dd($arr);
        //dd(array_keys($arr));
          
        if( $per = Permission::where('user_id', $user->id)->first() ) {
            
            Permission::where('id', $per->id)->update(['permissions' => json_encode($arr)]);
        }
        else {
            Permission::create(['user_id' => $user->id, 'permissions' => json_encode($arr)]);
        }

        return redirect()->back()->with(['msg' => 'Permissions successfully assigned!']);
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
        $title = 'Edit User';
        $user = User::find($id);
        return view(_template('users.edit'),['title'=>$title,'user'=>$user]);
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
           //dd($data);
        if($request->has('photo')){
            $data['photo'] = $request->photo->store('users','public');
        }
        User::where('id',$id)->update($data);
        return redirect()->back()->with('msg','User is updated');
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
        
        User::destroy($id);
        return redirect()->back()->with('msg','User Deleted Successfully...');   
    }
}
