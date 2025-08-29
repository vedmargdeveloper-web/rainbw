<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileManager;
use Image;
use Illuminate\Http\Request;

use App\Models\Meta;

class MetaController extends Controller
{
    
    public function index() {
        $title =  "Software details";
        return view(_template('meta.index'),['title'=>$title]);

    }


    public function store( Request $request ) {


        $input = $request->except('_token');

        foreach ($input as $key => $value) {

            Meta::where('meta_name',$key)->update(['meta_name' => $key, 'meta_value' => $value]);
        }

        return redirect()->back()->with('msg', 'Setting successfully saved!');

    }

    public function headerindex() {

        return view('admin.setting.header');

    }


    public function headerstore( Request $request ) {


        $input = $request->except('_token');

        foreach ($input as $key => $value) {

            if( Meta::where('meta_name', $key)->first() )
                Meta::where('meta_name', $key)->update(['meta_value' => $value]);
            else
                Meta::create(['meta_name' => $key, 'meta_value' => $value]);

            // Meta::where('meta_name',$key)->update(['meta_name' => $key, 'meta_value' => $value]);
        }

        if( $request->file() ) :

            foreach( $request->file() as $key => $image ) :

                $image = $request->file('header_image');
                $ext = $image->extension();
                $image_name = time().'.'.$ext;
                $image->storeAs('/public/media',$image_name);

                // $filename = $this->upload_file( $image );
                
                if( Meta::where('meta_name', $key)->first() )
                    Meta::where('meta_name', $key)->update( ['meta_value' => $image_name] );
                else
                    Meta::create( ['meta_name' => $key, 'meta_value' => $image_name] );

            endforeach;

        endif;

        return redirect()->back()->with('message', 'Setting successfully saved!');

    }

    public function footerindex() {

        return view('admin.setting.footer');

    }

    public function footerstore( Request $request ) {


        $input = $request->except('_token');

        foreach ($input as $key => $value) {

            if( Meta::where('meta_name', $key)->first() )
                Meta::where('meta_name', $key)->update(['meta_value' => $value]);
            else
                Meta::create(['meta_name' => $key, 'meta_value' => $value]);

            // Meta::where('meta_name',$key)->update(['meta_name' => $key, 'meta_value' => $value]);
        }

        if( $request->file() ) :

            foreach( $request->file() as $key => $image ) :

                $image = $request->file('footer_image');
                $ext = $image->extension();
                $image_name = time().'.'.$ext;
                $image->storeAs('/public/media',$image_name);

                // $filename = $this->upload_file( $image );
                
                if( Meta::where('meta_name', $key)->first() )
                    Meta::where('meta_name', $key)->update( ['meta_value' => $image_name] );
                else
                    Meta::create( ['meta_name' => $key, 'meta_value' => $image_name] );

            endforeach;

        endif;

        return redirect()->back()->with('message', 'Setting successfully saved!');

    }

    public function contactindex() {

        return view('admin.setting.contact');

    }

    public function contactstore( Request $request ) {


        $request->validate([
            "facebook" => "url|nullable",
            "instagram" => "url|nullable",
            "twiter" => "url|nullable",
            "linkedin" => "url|nullable",
        ]);

        $input = $request->except('_token');

        foreach ($input as $key => $value) {

            if( Meta::where('meta_name', $key)->first() )
                Meta::where('meta_name', $key)->update(['meta_value' => $value]);
            else
                Meta::create(['meta_name' => $key, 'meta_value' => $value]);

            // Meta::where('meta_name',$key)->update(['meta_name' => $key, 'meta_value' => $value]);
        }

        if( $request->file() ) :

            foreach( $request->file() as $key => $image ) :

                $image = $request->file('contact_image');
                $ext = $image->extension();
                $image_name = time().'.'.$ext;
                $image->storeAs('/public/media',$image_name);

                // $filename = $this->upload_file( $image );
                
                if( Meta::where('meta_name', $key)->first() )
                    Meta::where('meta_name', $key)->update( ['meta_value' => $image_name] );
                else
                    Meta::create( ['meta_name' => $key, 'meta_value' => $image_name] );

            endforeach;

        endif;

        return redirect()->back()->with('message', 'Setting successfully saved!');

    }

    














}
