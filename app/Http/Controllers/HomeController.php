<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Slider;
session_start();
class HomeController extends Controller
{
    public function index(Request $req){
        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Chuyên bán nước hoa";
        //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaKeywords = "nước hoa nam, nước hoa nữ,nước hoa chiết";
        // tiêu đề
        $metaTitle = "Nước hoa";
        //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        $urlCanonical = $req->url();
        // ----------- End Seo -----------\\
        //category
        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->take(4)->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

        $allSlider = Slider::where('slider_status',1)->orderby('slider_id','DESC')->get();
        $newProducts = DB::table('tbl_product')->where('product_status',1)
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->orderby('product_id','desc')->limit(4)->get();
       // return view('pages.home')->with('categoryProduct',$categoryProduct)->with('brandProduct',$brandProduct)->with('newProducts',$newProducts);
        return view('pages.home')->with(compact('categoryProduct','brandProduct','newProducts','metaDes','metaKeywords','metaTitle','urlCanonical','allSlider'));
    }
    public function search(Request $req){
        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Tìm kiếm sản phẩm";
        $metaKeywords = "Tìm kiếm sản phẩm";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Tìm kiếm sản phẩm"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\

        //category
        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

        $keywords = $req->keywords_submit;
        $searchProduct = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('tbl_product.product_status',1)
            ->where('tbl_product.product_name','like','%'.$keywords.'%')
            ->orwhere('tbl_category_product.category_name','like','%'.$keywords.'%')
            ->orderby('product_id','desc')->get();
        return view('pages.product.search')
            ->with('categoryProduct',$categoryProduct)
            ->with('brandProduct',$brandProduct)
            ->with('searchProduct',$searchProduct)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);
    }
    public function sendMail(){
            // send mail
        $toName = "Lý";
        $toEmail = "william.lynguyen@gmail.com";//send to this email
        $data = array("name"=>"Mail từ tài khoản khách hàng","body"=>"Mail gửi về vấn đề hàng hóa"); //body of sendMail.blade.php
        Mail::send('pages.sendMail',$data,function ($message) use ($toName,$toEmail){
            $message->to($toEmail)->subject('Test gửi mail google '); // send this mail with subject(tiêu đề)
            $message->from($toEmail,$toName); // send from this mail
        });
        return Redirect::to('/');
    }
}
