<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Models\Coupon;
use Session;
use Auth;
use App\Models\Customer;
use Carbon\Carbon;
use Mail;
session_start();
class CouponController extends Controller
{
    //
    public function allCoupon(){

        $allCoupon = Coupon::orderby('coupon_id','DESC')->get();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y/m/d');
        return view('admin.coupon.allCoupon')->with(compact('allCoupon','today'));
    }
    public function addCoupon(){
        return view('admin.coupon.addCoupon');
    }
    public function saveCoupon(Request $req){
        $data = $req->all();
        $coupon = new Coupon;
        $coupon['coupon_name'] = $data['couponName'];
        $coupon['coupon_date_start'] = $data['couponDateStart'];
        $coupon['coupon_date_end'] = $data['couponDateEnd'];

        $coupon['coupon_quantity'] = $data['couponQty']; // số lượng mã
        $coupon['coupon_condition'] = $data['couponCondition']; // điều kiện giảm, giảm theo % hay theo tiền

        $couponNumber = filter_var($data['couponNumber'],FILTER_SANITIZE_NUMBER_INT); // lấy kí tự là số nguyên
        $coupon['coupon_number'] = $couponNumber;// số tiền giảm hoặc số % giảm
        $coupon['coupon_code'] = $data['couponCode'];
        $coupon->save();

        return redirect()->back()->with('message','insert coupon successfully');
    }
    public function deleteCoupon($couponId){
        Coupon::find($couponId)->delete();
        return redirect()->back()->with('message','Delete code successfully');
    }

    public function sendCouponVip($couponId){
        //lấy ra các customer vip
        $customerVip = Customer::where('customer_vip',1)->get();
        //lấy ra coupon
        $coupon = Coupon::where('coupon_id',$couponId)->first();


        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
       // echo $now;
        $titleMail = "Mã khuyễn mãi ".$now; // title này là cái dòng thư để người dùng thấy và click vào

        $data = [];// cách 2 : $data = array() 2 cái đều như nhau
        //lấy ra email của các khách hàng vip và lưu vào mảng với key là email
        foreach($customerVip as $key => $customer){
            $data['email'][] = $customer->customer_email;
        }

        //ghi chuẩn hàm send google
            Mail::send('pages.sendCoupon',['coupon'=>$coupon],function($message) use ($titleMail,$data){
            $message->to($data['email'])->subject($titleMail); //send this mail with subject(chủ  đề)
            $message->from($data['email'],$titleMail); //từ chính mail đó luôn
        });

       return redirect()->back()->with('message','Sent Coupon to vip customers successfully!');
    }

    //gửi mã cho khách hàng thường
    public function sendCouponNormal($couponId){
        //lấy ra các Customer thường
        $customerNormal = Customer::where('customer_vip','!=',1)->get();
        //lưu email của customer thường vào mảng data với key là email
        $data = [];
        foreach ($customerNormal as $key =>$customer){
            $data['email'][] = $customer->customer_email;
        }
        //lấy ra mã giảm giá
        $coupon = Coupon::where('coupon_id',$couponId)->first();
        //title
        $titleMail = "Bạn có một mã giảm giá Của shopperfume";
        Mail::send('pages.sendCoupon',['coupon'=>$coupon],function ($message) use($titleMail,$data){
            $message->to($data['email'])->subject($titleMail);  //gửi tới mail này với subject chủ đề
            $message->from($data['email'],$titleMail); // gửi bằng chính mail đó, sau này gửi lại cái mail của shop
        });
        return \redirect()->back()->with('message','Sent Coupon to Normal customers successfully!');
    }
}
