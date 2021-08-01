<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Models\Coupon;
use Session;

session_start();
class CouponController extends Controller
{
    //
    public function allCoupon(){

        $allCoupon = Coupon::orderby('coupon_id','DESC')->get();

        return view('admin.coupon.allCoupon')->with('allCoupon',$allCoupon);
    }
    public function addCoupon(){
        return view('admin.coupon.addCoupon');
    }
    public function saveCoupon(Request $req){
        $data = $req->all();
        $coupon = new Coupon;
        $coupon['coupon_name'] = $data['couponName'];
        $coupon['coupon_time'] = $data['couponTime'];
        $coupon['coupon_condition'] = $data['couponCondition'];
        $coupon['coupon_number'] = $data['couponNumber'];
        $coupon['coupon_code'] = $data['couponCode'];
        $coupon->save();
       // return view('admin.coupon.s')
        return redirect()->back()->with('message','insert coupon successfully');
    }
    public function deleteCoupon($couponId){
        Coupon::find($couponId)->delete();
        return redirect()->back()->with('message','Delete code successfully');
    }
}
