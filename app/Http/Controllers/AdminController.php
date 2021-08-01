<?php

namespace App\Http\Controllers;
// sử dụng database
use DB;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
//đăng nhập facebook
use App\Models\Social;
use App\Models\Login;
use Socialite; // trang xã hội
use App\Rules\Captcha; // captcha
use Validator;
session_start();
class AdminController extends Controller
{
    //google
    public function loginGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user();
        // return $users->id;
        $authUser = $this->findOrCreateUser($users,'google');
        if($authUser){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('adminName',$account_name->admin_name);
            Session::put('loginNormal',true);
            Session::put('adminId',$account_name->admin_id);
        }
        else if ($customerNew){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('adminName',$account_name->admin_name);
            Session::put('loginNormal',true);
            Session::put('adminId',$account_name->admin_id);
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');


    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }else{
            $customerNew = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider) //strtoupper là cho thành chữ hoa thui  k có j hết
            ]);

            $orang = Login::where('admin_email',$users->email)->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $users->name,
                    'admin_email' => $users->email,
                    'admin_password' => '',

                    'admin_phone' => '',
                    // 'admin_status' => 1
                ]);
            }
            $customerNew->login()->associate($orang);
            $customerNew->save();
            return $customerNew;
          //  $account_name = Login::where('admin_id',$hieu->provider_user_id)->first();
        }


       /* Session::put('adminName',$account_name->admin_name);
        Session::put('adminId',$account_name->admin_id);
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');*/


    }

    //end google

    //facebook
    public function loginFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function callbackFacebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->firt();
        if($account){
            //login vào trang dashboard
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('adminName',$account_name->admin_name);
            Session::put('adminId',$account_name->admin_id);
            return redirect('/dashboard')->with('message','Đăng nhập Amin thành công');
        }else{
                    $ly = new Social([
                        'provider_user_id'=> $provider->getId(),
                        'provider'=>'facebook'
                    ]);
        }           $orang = Login::where('admin_email',$provider->getEmail())->first();
                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $provider->getName(),
                        'admin_email'=> $provider->getEmail(),
                        'admin_password'=>'', //password rỗng vì login bằng facebook k cần password
                       'admin_phone'=>'',
                    ]);
                }
                $ly->login()->associate($orang);
                $ly->save();
                $account_name = Login::where('admin_id',$account->user)->first();
                Session::put('adminName',$account_name->admin_name);
                 Session::put('adminId',$account_name->admin_id);
                return Redirect::to('/dashboard')->with('message','Đăng nhập Admiin thành công');
    }
    //kiểm tra login
    public function authLogin(){
        $adminId = Session::get('adminId');
       // $loginNormal = Session::get('loginNormal');
            if($adminId){
                return Redirect::to('dashboard');
            }else{
                return Redirect::to('admin')->send(); // phải thêm hàm send() ,không thêm là không được
            }


    }
    public function index(){
      return view('admin_login');
    }
    public function showDashboard(){
        $this->authLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $req){


        $data = $req->validate([
            //tìm hiểu ở validation laravel
            'adminEmail' => 'required',
            'adminPassword' => 'required',
            'g-recaptcha-response' => new Captcha(), 		//dòng kiểm tra Captcha
        ]);

        $adminEmail = $req->adminEmail;
        $adminPassword = md5($req->adminPassword);
        $result = Login::where('admin_email',$adminEmail)
            ->where('admin_password',$adminPassword)->first();
      if($result){
          // đếm coi nó có dòng nào không nếu có nghĩa là login đúng
          $countResult = $result->count();
          if($countResult > 0){
              Session::put('adminName',$result->admin_name);
              Session::put('adminId',$result->admin_id);
              //chuyển hướng qua trang dashboard
              return Redirect::to('/dashboard');
          }

      }else{
          Session::put('message','Password or email is incorrect,please re-enter');
          return Redirect::to('/admin');
      }
    }
    public function logout(){
        $this->authLogin();
        //cho 2 session adminId và adminName thành null
        Session::put('loginNormal',false);
        Session::put('adminName',null);
        Session::put('adminId',null);
        return Redirect::to('/admin');
    }
}
