<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Models\Roles;
use App\Models\Admin;
use Auth;
use Session;
session_start();
class UserController extends Controller
{
    public function index(){
        $admin = Admin::with('roles')->orderByDesc('admin_id')->paginate(5); // paginate(5) là phân 5 user trên một trang
        return view('admin.users.allUsers')->with(compact('admin'));
    }
    public function assignRoles(Request $req){
        if(Auth::id() == $req->adminId){
            return \redirect()->back()->with('message','You are not allowed to assign yourself !');
        }
               $user = Admin::where('admin_email',$req->adminEmail)->first();
               $user->roles()->detach(); // xóa hết quyền

        //nếu check vào input admin thì
        //ta dùng $req , dùng $data[] =req->all() không được
        if($req->adminRole){
            $user->roles()->attach(Roles::where('name','admin')->first()); // nếu mà check thì mình sẽ lấy dữ liệu từ tbl_roles với name là admin thêm vào cho user đó
        } if($req->authorRole){
            $user->roles()->attach(Roles::where('name','author')->first()); // thêm quyền author
        } if($req->userRole){
            $user->roles()->attach(Roles::where('name','user')->first()); // thêm quyên user
        }
               return Redirect()->back()->with('Successful roles assignment.');
    }
    public function addUser(){
        return view('admin.users.addUsers');
    }
    public function saveUser(Request $req){
        $user = new Admin();
        $user->admin_name = $req->adminName;
        $user->admin_phone = $req->adminPhone;
        $user->admin_email = $req->adminEmail;
        $user->admin_password = md5($req->adminPassword);
        $user->save();
        //tạo quyền
        $user->roles()->attach(Roles::where('name','user')->first());

        return \redirect()->back()->with('message','Added user successfully!');
    }

    //mạo danh
    public function impersonate($adminId){
        //lấy ra user thuộc cái tbl_admin
        $user = Admin::find($adminId);
        //nếu lấy được thì lưu id vào session
        if($user){
            Session::put('impersonate',$user->admin_id);
        }
        //khi mà chuyển quyền xong thì quay lại và trả về thông báo
        return \redirect()->back();
    }

    public function destroyImpersonate(){
           Session::forget('impersonate'); // khi xóa session thì nó sẽ quay về admin cũ khi mình đăng nhập
           return \redirect('/users');
    }

    public function deleteUserRoles($adminId){
        //kiểm tra xem adminId = adminId hiện tại không , nếu có thì k cho xóa
        if(Auth::id()==$adminId){
            return \redirect()->back()->with('message','You are not allowed to detele yourself!');
        }
        //tìm admin
        $admin = Admin::find($adminId);
        //kiêm tra tìm được không
        if($admin){
            //nếu timd được ta gỡ quyền
            $admin->roles()->detach(); // lúc này trong table admin_roles sẽ không còn admin này nữa
            //sau đó ta xóa admin trong bảng tbl_admin
            $admin->delete();
        }
        return \redirect()->back()->with('message','Deleted user successfully !');
    }
}
