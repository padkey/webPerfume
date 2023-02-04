<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use phpDocumentor\Reflection\Types\Array_;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Slider;
use App\Models\CatePost;
use App\Models\Category;
use App\Models\Product;
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

        $allSlider = Slider::where('slider_status',1)->orderby('slider_id','DESC')->get();

        $newProducts = DB::table('tbl_product')->where('product_status',1)
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->orderby('product_id','desc')->paginate(6);

            //lấy danh mục không phải danh mục chaa , và sắp xếp theo category_order mà mình đã sắp xếp nó ở admin
        $categoryTabs = Category::where('category_parent','!=',0)->orderby('category_order','ASC')->get();
        return view('pages.home2')->with(compact('categoryTabs','newProducts','metaDes','metaKeywords','metaTitle','urlCanonical','allSlider'));
    }
    public function search(Request $req){

        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Tìm kiếm sản phẩm";
        $metaKeywords = "Tìm kiếm sản phẩm";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Tìm kiếm sản phẩm"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\



    // Tìm kiếm sản phẩm
        $keywords = $req->keywords;
        $searchProduct = Product::with('category')->with('brand')
            ->where('product_status',1)
            ->where('product_name','like','%'.$keywords.'%')
            ->where('category_name','like','%'.$keywords.'%')
            ->where('brand_name','like','%'.$keywords.'%')
            ->orderBy('product_id','desc')->get();
        return view('pages.product.search')
            ->with(compact('searchProduct','metaDes','metaKeywords','metaTitle','urlCanonical'));


    }

    //gợi ý từ khóa
    public function autocomplete(Request $req){
        //lấy product qua keywords người dùng bấm
        $productByKeywords = Product::where('product_name','LIKE','%'.$req->value.'%')->get();

        //cái class dropdown-menu có set display:none , nên mình phải display:block để nó hiển thị
        $output ='<ul class="dropdown-menu" style="display:block; position:relative"> ';
        foreach ($productByKeywords as $key =>$product){
                $output .='<li class="searchResult"> <a href="#">'.$product->product_name.'</a></li>';
        }
        $output .='</ul>';
        echo $output;
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
