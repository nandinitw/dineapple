<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;

class AjaxController extends Controller
{

public function upload(Request $request){

        $type   = $request->input('type')?$request->input('type'):'image';
        $width  = $request->input('width');
        $height = $request->input('height');

        switch ($type){

            case 'featured':
            {
                $image = $request->file('file');
                $folder = $request->file('folder')?$request->file('folder'):'images';
                $json = array();
                if($image != ''){
                    $extension = $image->getClientOriginalExtension();
                    $fileMime = $image->getClientMimeType();

                    if( $fileMime == 'image/jpg' || $fileMime == 'image/jpeg'
                        || $fileMime == 'image/png' | $fileMime == 'image/gif'){

                        $image_info = getimagesize($image);
                        $image_width = $image_info[0];
                        $image_height = $image_info[1];

                        Storage::disk('temp')->put(time().'-'.$image->getClientOriginalName(),  File::get($image));
                        $filename = time().'-'.$image->getClientOriginalName();
                        $image_url = asset('temp').'/'.time().'-'.$image->getClientOriginalName();
                        $json['status'] = 'success';
                        $json['file_name']  = $filename;
                        $json['file_url']   = $image_url;
                        $json['image_width']= $image_width;
                        $json['image_height']= $image_height;
                    }
                    else{
                       $json['status']    = 'fail';
                       $json['message']    = 'File type should be .PNG, .GIF or .JPG';
                    }
                }
                else{
                       $json['status']    = 'fail';
                       $json['message']    = 'File not selected!';
                }
            }
            break;
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE) ; exit;
    }

}
