<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileManager;
use Illuminate\Http\Request;
use App\Models\Media;
use Auth;
use Image;



class MediaController extends Controller
{
    public function index(){

        $result['media'] = Media::orderBy('id','desc')->get();

        return view('admin/media/media',$result );
    }


    public function store(Request $request){

        $request->validate([
            "file" => "required|max:15000",
        ]);

        $modle = new Media();

        $modle->user_id =Auth::user()->id;
      
        if($request->hasfile('file')){

            // $this->upload_feature($request->file('file'));

            $file = $request->file('file');
            $ext = $file->extension();
            $file_name = time().'.'.$ext;

            // $file->storeAs('/public/media',$file_name);
            $file->storeAs('/public/media', $file_name);
            $modle->file = $file_name;
            $modle->ext = $ext;
            $modle->title = $request->input('title');
        }

        $modle->save();

        return Redirect()->back()->with(['message' => 'File successfully uploaded!']);
    }


    public function upload_feature($image ) {
 
        $year = date('Y');
        $month = date('m');
        $path = public_path('/public/media');
        // $path = storage_path("app/public/items/");
 
        // File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
 
        $hashname = clean( $image->getClientOriginalName() ) . '-' . randomString(8);
        $filename = config('filesize.thumbnail.0') . 'x' . config('filesize.thumbnail.1').'-'.$hashname .'.' . $image->getClientOriginalExtension();
 
        // FileManager::upload( $filename, $image, $path, config('filesize.thumbnail.0'), config('filesize.thumbnail.1') );
 
        // $filename = config('filesize.medium.0') . 'x' . config('filesize.medium.1') .
        // '-'.$hashname .'.'. $image->getClientOriginalExtension();
        // FileManager::upload( $filename, $image, $path, config('filesize.medium.0'), config('filesize.medium.1') );
 
        // $filename = config('filesize.large.0') . 'x' . config('filesize.large.1') .
        // '-'.$hashname . '.' . $image->getClientOriginalExtension();
        // FileManager::upload( $filename, $image, $path, config('filesize.large.0'), config('filesize.large.1') );
 
        $filename = $hashname . '.' . $image->getClientOriginalExtension();
        FileManager::upload( $filename, $image, $path );
 
        return $filename;
    }

    public function edit($id){

        $result['media'] =  Media::where('id',$id)->first();
        return view('admin/media/edit-media',$result);
    }

    public function update(Request $request){


        // dd($request);        

        $modle =  Media::find($request->edit_id);


        if($request->hasfile('file')){

            $file = $request->file('file');
            $ext = $file->extension();
            $file_name = time().'.'.$ext;
            $file->storeAs('/public/media',$file_name);
            $modle->file = $file_name;
        }
        else{
            $modle->file = $request->input('file');
             
         }

        $modle->save();
        return Redirect()->back()->with(['message' => 'File successfully uploaded!']);
    }


    public function delete($id){


        $media = Media::find($id);
        $media->delete();

        return Redirect()->back()->with(['message' => 'File successfully deleted!']);

    }
}
