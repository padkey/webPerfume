<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    //

    //up nó lên máy chủ
    public function file_browser(Request $request){
        $paths = glob(public_path('uploads/ckeditor/*')); // public_path là hàm trỏ tới public thui k có j hết ,/* là lấy tất cả cái j có trong thư mục uploads

        $fileNames = array();
    //vòng lặp lấy đường dẫn của các ảnh ra
        foreach($paths as $path){
            //lưu hết lên vào biến $fileNames
            array_push($fileNames,basename($path)); // basename là lấy cái tên full name của hình ,
        }
        // tạo mảng data lưu cái fileNames
        $data = array(
            'fileNames' => $fileNames
        );

        return view('admin.images.fileBrowser')->with($data);
    }
    public function ckeditor_image(Request $request){
        if($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move('public/uploads/ckeditor', $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/uploads/ckeditor/'.$fileName);
            $msg = 'Tải ảnh thành công';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;

        }
    }




    /*public function uploadsCkeditorư(Request $req){
        $getImage =$req->file('upload');
        if($getImage){
            $fullNameImage = $getImage->getClientOriginalName();
            $nameImage = current(explode($fullNameImage));
            $newName = $nameImage.time().'.'.$getImage->getClientOriginalExtension();
            $getImage->move('public/uploads/ckeditor',$newName);

            $CKEditorFuncNum = $req->input('CKEditorFuncNum');
            $url = asset('public/uploads/ckeditor/'.$newName);
            $msg = 'Uploaded image successfully!';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum,'$url','$msg')</script>";
            @header('Content-type: text/html; charset=utf-8' );
            echo $response;
        }

    }*/
}
