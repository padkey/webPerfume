<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Slider;
use Session;
use Auth;

session_start();
class SliderController extends Controller
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
    public function allSlider(){
        $this->authLogin();
        $allSlider = Slider::orderby('slider_id','DESC')->get();
        return view('admin.slider.allSlider')->with(compact('allSlider'));
    }
    public function addSlider(){
        $this->authLogin();
        return view('admin.slider.addSlider');
    }
    public function saveSlider(Request $req){
        $this->authLogin();
        $data = $req->all();
        $slider = new Slider();
        $slider->slider_name = $data['sliderName'];
        $slider->slider_status = $data['sliderStatus'];
        $slider->slider_des = $data['sliderDes'];
        //lấy hình ra
        $getImage = $req->file('sliderImage');
        //nếu image tồn tại thì
        if($getImage){
            // lấy fullname của image vd: alo.jpg
            $fullNameImage = $getImage->getClientOriginalName();
            //lấy ra tên không lấy đuôi , current là lấy phần tử hiện tại cảu mãng, mà mỗi mãng có 1 phần tử đầu là phần tử hiện tại
            $getName = current(explode('.',$fullNameImage));
            // tạo ra name mới
            $newName = $getName.rand(0,99).'.'.$getImage->getClientOriginalExtension();
            //có tên mới rồi thì di chuyển hình đến thư mục mong muốn

            // đường dẫn lưu ý không được để / trước public
            $getImage->move('public/uploads/sliders',$newName);

            $slider->slider_image = $newName;
            $slider->save(); // lưu vào DB bằng hàm save()
            return redirect()->back()->with('message','Insert slider successfully');

        }else{
            $slider->save();
            return redirect()->back()->with('message','Insert slider successfully');
        }

    }
    public function unactiveSlider($sliderId){
        $this->authLogin();
        // hàm update phải truyền vào mảng, không truyền vào kiểu mảng là bị lỗi
            Slider::find($sliderId)->update(['slider_status'=>0]);
            return redirect()->back()->with('message','Slider unactived successfully');
    }
    public function activeSlider($sliderId){
        $this->authLogin();
        //hàm update là phải truyền vào kiểu mảng, không truyền theo kiểu mảng là lỗi
        Slider::find($sliderId)->update(['slider_status'=>1]);
        return redirect()->back()->with('message','Slider actived successfully');
    }
    public function deleteSlider($sliderId){
        $this->authLogin();
        // dùng hàm delete để xóa
        Slider::find($sliderId)->delete();
        return redirect()->back()->with('message','Slider deleted successfully');
    }
    public function editSlider($sliderId){
        $this->authLogin();
        $editSlider = Slider::find($sliderId);
        return view('admin.slider.editSlider')->with(compact('editSlider'));
    }
    public function updateSlider(Request $req){
        $this->authLogin();

        $slider = Slider::find($req->sliderId);
        $slider->slider_name = $req->sliderName;
        $slider->slider_des = $req->sliderDes;
        $getImage = $req->file('sliderImage');
        if($getImage){
            $fullNameImage = $getImage->getClientOriginalName();
            $getName = current(explode('.',$fullNameImage));
            $newName = $getName.rand(0,99).'.'.$getImage->getClientOriginalExtension();

            $getImage->move('public/uploads/sliders',$newName);

            $slider->slider_image = $newName;
            $slider->save(); // update và insert xài chung hàm save() để cập nhật và lưu dữ liệu
            return \redirect('/allSlider')->with('message','Slider updated successfully. ');
        }
    }
}
