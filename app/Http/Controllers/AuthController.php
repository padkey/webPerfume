<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;
use App\Models\Roles;
use Auth;
class AuthController extends Controller
{
    public function registerAuth(){
            return view('admin.customAuth.registerAuth');
    }
    public function register(Request $req){
        //vào hàm kiểm tra
        $this->validation($req);
         $data = $req->all();
         $admin = new Admin();
         $admin->admin_name = $data['adminName'];
         $admin->admin_phone = $data['adminPhone'];
         $admin->admin_password = md5($data['adminPassword']);
         $admin->admin_email = $data['adminEmail'];
         $admin->save();

         return redirect()->back()->with('message','You have successfully registerd.');
    }
    public function loginAuth(){
            return view('admin.customAuth.loginAuth');
    }
    public function login(Request $req){
        //kiểm tra dữ liệu lấy về đúng điều kiện của mình chưa, chưa thì hàm tự in lỗi cho mình
        $this->validate($req,[
           'adminEmail'=>'required|email',
           'adminPassword'=>'required',
        ]);


        //đây là hàm kiểm tra đăng nhập đúng sai, đúng trả về true, sai thì ngược lại
        // mật khẩu đã được mã hóa trong Auth rồi nên k cần mã hóa
        //mặc định laravel sẽ lấy email và password để so sánh với 2 trường dưới,
        // nhưng mình xài cột tên khác là admin_email và admin password , nên mình phải vào config auth để đổi lại
            if(Auth::attempt(['admin_email'=> $req->adminEmail,'admin_password'=>  $req->adminPassword ])){
                //nếu true thì trả về trang dashboard
              return Redirect::to('/dashboard');
            }else{
                return redirect()->back()->with('message','Wrong email or password!');
            }


    }
    public function logoutAuth(){
        Auth::logout();
        return Redirect::to('loginAuth')->with('message','You have successfully logged out');
    }
    //kiểm tra các trường mình gửi qua có đúng yêu cầu hay không
    public function validation($req){
            return $this->validate($req,[
                    'adminName' => 'required|max:255',
                'adminPhone'=>'required|max:15',
                'adminEmail'=>'required|email',
                'adminPassword'=>'required|max:15'
            ]);
    }
}
