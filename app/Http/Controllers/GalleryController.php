<?php

namespace App\Http\Controllers;

//sử dung session
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\Gallery;

class GalleryController extends Controller
{
    //kiểm tra login
    public function authLogin(){
        $adminId = Auth::id();
        if($adminId){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function addGallery($productId){

        return view('admin.gallery.addGallery')->with(compact('productId'));
    }
    public function selectGallery(Request $req){
        //lấy gallery bằng productId mình gửi qua
        $allGallery = Gallery::where('product_id',$req->productId)->get();
        //đếm xem có ảnh không
        $countGallery = $allGallery->count();
        $output ='<table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Manage</th>
                            </tr>
                            </thead>
                            <tbody>';
        //nếu có ảnh
        if($countGallery>0){
            $i=1;
            foreach ($allGallery as $key => $gallery){
                $output .='<tr>
                            <td>'.$i++.'</td>
                            <td contenteditable data-id="'.$gallery->gallery_id.'" class="editNameGallery">'.$gallery->gallery_name.'</td>
                            <td>
                            <img class="img-thumbnail" width="100px" src="'.url('public/uploads/gallery/'.$gallery->gallery_image).'">
                            <input type="file" name="fileImage" class="fileImage" data-id="'.$gallery->gallery_id.'" id="file-'.$gallery->gallery_id.'">
                            </td>
                            <td><button type="button" class="btn btn-danger deleteGallery" data-id ="'.$gallery->gallery_id.'">Delete</button></td>
                       </tr>';
            }
        }else{ //nếu không có ảnh
            $output .='<tr><td>This product has no gallery yet !</td></tr>';
        }

        $output .= '</tbody></table>';
        echo $output;
    }

/*    public function saveGallery(Request $req){
        //ta lấy ra hình ảnh trước
        $getImage = $req->file('file');
        if($getImage){
            foreach ($getImage as $key => $image){
                $getFullName = $image->getClientOriginalName();
                $getName = current(explode('.',$getFullName));
                $newName = $getName.rand(0,99).'.'.$image->getClientOriginalExtension();
                $image->move('public/uploads/gallery',$newName);

                //lưu vào tbl_gallery
                $gallery = new Gallery();
                $gallery->gallery_name =$newName;
                $gallery->gallery_image = $newName;
                $gallery->product_id = $req->productId;
                $gallery->save(); //lưu lại
            }
        }

       return \redirect()->back()->with('message','Added gallery successfully!');
    }*/

    public function saveGallery(Request $req){
        $getImage = $req->file('file');
        if($getImage){
            // lặp để lấy ra từng hình ảnh
            foreach($getImage as $key => $image){
                $getFullName = $image->getClientOriginalName();
                $getName = current(explode('.',$getFullName));
                $newName = $getName.rand(0,99).'.'.$image->getClientOriginalExtension();
                // lưu hình vào folder gallery
                $image->move('public/uploads/gallery',$newName);

                //lưu vào tbl_gallery
                $gallery = new Gallery;
                //lấy tạm tên hình để lưu vào gallery
                $gallery->gallery_name = $newName;
                $gallery->product_id= $req->productId;
                $gallery->gallery_image = $newName;
                $gallery->save(); // lưu hình lại
            }
        }
        return redirect()->back()->with('message','Added gallery successfully!');
    }
    public function editNameGallery(Request $req){
        Gallery::find($req->galleryId)->update(['gallery_name'=>$req->galleryName]);

    }
    public function deleteGallery(Request $req){
        $gallery = Gallery::find($req->galleryId);
        unlink('public/uploads/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }
    public function updateGallery(Request $req){
        $gallery = Gallery::find($req->galleryId);
        $getImage = $req->file('file');
        if($getImage){
            $getFullName = $getImage->getClientOriginalName();
            $imageName = current(explode('.',$getFullName));
            $newName = $imageName.rand(0,200).'.'.$getImage->getClientOriginalExtension();

            //xóa hình cũ
            unlink('public/uploads/gallery/'.$gallery->gallery_image);
            //update hình mới

            $getImage->move('public/uploads/gallery',$newName);
            $gallery->gallery_image = $newName;
            $gallery->save();

        }
    }
}
