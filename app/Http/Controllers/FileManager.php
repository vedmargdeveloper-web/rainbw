<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
/*use App\models\Settings;*/
use Image;
use File;

class FileManager extends Controller
{
    private $width = 200;
	private $height = 200;

	public static function upload( $filename, $image, $path, $width = '', $height = '' ) {

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        if( $width !== '' ) {

            $img = Image::make( $image->getRealPath() );
            $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($image->getClientOriginalExtension());
            return $img->save( $path . $filename );
        }
        else {
            $resize = Image::make( $image->getRealPath() )
			        				->encode($image->getClientOriginalExtension());
            return $resize->save( $path . $filename );
        }
    }

    public function update( $request, $user_id ) {

    	$size = Settings::where('field_name', 'avtar_size')->value('field_value');
		list($width, $height) = explode( 'x',  $size );

    	if( $request->hasFile('image') ) {

            $image = $request->file('image');
            $hashFileName = md5($image->getClientOriginalName(). time());
            $img_resize = Image::make( $image->getRealPath() )->resize( $width, $height )
                                        ->encode($image->getClientOriginalExtension());
            $filename = $hashFileName .'.' . $image->getClientOriginalExtension();
            $img_resize->save( public_path( avtar_upload() . $filename ) );
            
            if( Avtars::exist( $user_id ) )
                return Avtars::where('user_id', $user_id)->update(['filename' => $filename]);
            else
                return Avtars::create(['user_id' => $user_id, 'type'=>'avtar', 'filename'=>$filename]);
        }
    	else if( $request->avtar ) return true;
        else
            return false;

    }
}
