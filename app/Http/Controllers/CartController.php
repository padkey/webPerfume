<?php

namespace App\Http\Controllers;

// sử dụng database
use DB;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Cart;
use App\Models\Coupon;
session_start();
class CartController extends Controller
{
   //
    public function saveCart(Request $req){

          $productId = $req->productId;
          $quantity = $req->quantity;
          $productInfo = DB::table('tbl_product')->where('product_id',$productId)->get();

          //Cart::add('293ad', 'Product 1', 1, 9.99, 550);
          foreach ($productInfo as $key => $product){
              $data['id'] = $product->product_id;
              $data['qty'] = $quantity;
              $data['name'] = $product->product_name;
              $data['price'] = $product->product_price;
              $data['weight'] = '123';
              $data['options']['image'] = $product->product_image;
          }


          //thêm vào giỏ hàng
          Cart::add($data);

        return   Redirect::to('/showCart');
   // Cart::destroy();

    }
    public function showCart(Request $req){
       /* //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Giỏ hàng của bạn";
        $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Giỏ hàng của bạn"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\

        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

        return view('pages.cart.showCart')
            ->with('categoryProduct',$categoryProduct)
            ->with('brandProduct',$brandProduct)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);*/
        Session::forget('cart');
        Session::forget('coupon');
    }
    public function deleteToCart($rowId){
            Cart::update($rowId,0);

            return Redirect::to('/showCart');
    }
    public function updateQuantityCart(Request $req){
                $rowId = $req->rowIdCart;
                $qty = $req->quantityCart;
                Cart::update($rowId,['qty' => $qty]);
               return Redirect::to('/showCart');
    }

    public function addToCartAjax(Request $req){
        $data = $req->all();
        $session_id = substr(md5(microtime()),rand(0,28),5); // substr là hàm lấy kí tự , số đầu là kí tự, 2 là lấy bất đầu từ đâu, 3 là lấy bao nhiêu
        //kiểm tra có seesion cart chưa
        $cart = Session::get('cart');
        //nếu tồn tại
        if($cart){
            $available = false;
            // chạy vòng lặp xem productId có trong giỏ hàng không
            foreach ($cart as $key =>$val){
                if($val['product_id'] == $data['cartProductId']){
                    // update quantity
                    $cart[$key]['product_qty'] += 1;
                    $available = true;
                }
            }
            //nếu không thì tạo ra cart mới
            if($available == false){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id'=> $data['cartProductId'],
                    'product_name' => $data['cartProductName'],
                    'product_price' => $data['cartProductPrice'],
                    'product_image' => $data['cartProductImage'],
                    'product_qty' => $data['cartProductQty']
                );
                Session::put('cart',$cart);
            }


        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_id'=> $data['cartProductId'],
                'product_name' => $data['cartProductName'],
                'product_price' => $data['cartProductPrice'],
                'product_image' => $data['cartProductImage'],
                'product_qty' => $data['cartProductQty']
            );
        }
      //  print_r($data);
        Session::put('cart',$cart);
        Session::save(); //lưu giỏ hàng
    }
    public function showCartAjax(Request $req){
        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Giỏ hàng của bạn";
        $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Giỏ hàng Ajax"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\

        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

        return view('pages.cart.cartAjax')
            ->with('categoryProduct',$categoryProduct)
            ->with('brandProduct',$brandProduct)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);
    }
    public function delProduct($sessionId){
        $cart = Session::get('cart');
        if($cart){
            foreach ($cart as $key => $val){
                if($val['session_id'] == $sessionId){
                    unset($cart[$key]); // xóa dữ liệu mang vị trí cần xóa
                }
            };
            // sau khi xóa thì ta phải cập nhật lại session giỏ hàng
            Session::put('cart',$cart);
           return redirect()->back()->with('message','delete product successfully'); // back() có nghĩ là quay lại trang trước
        }else{
            return redirect()->back()->with('message','delete product failly'); // back() có nghĩ là quay lại trang trước

        }

    }
    public function updateCart(Request $req){
        $data = $req->all();
            $cart = Session::get('cart');
            // foreach name để lấy ra các session_id của mỗi product , để cập nhật , mỗi name có một value là số lượng của product
            foreach($data['quantityCart'] as $sessionId => $qty){
                        foreach($cart as $key => $val){
                            if($val['session_id'] == $sessionId){
                                // update qty của product trong cart có session_id giống với $sessionId
                                $cart[$key]['product_qty'] = $qty;
                            }
                        }
            }
            //cập nhật lại giỏ hàng
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Update product quantity  successfully');
    }
    public function deleteAllProduct(){
        $cart = Session::get('cart');
        //$coupon = Session::get('coupon');
        if($cart ){
            // destroy là xóa tất cả session trong web
            //forget là xóa session mình chỉ định
            Session::forget('cart');
            Session::forget('coupon');

            return redirect()->back()->with('message','Delete all product successfully');
        }
    }
    //check coupon
    public function checkCoupon(Request $req){
        $data = $req->all();
        $coupon = Coupon::where('coupon_code',$data['couponCode'])->first(); // dùng phương thức first lấy ra một giá trị, thì không cần foreach
        if($coupon){
            // đếm coupon kiểm tra có dữ liệu không
            $countCoupon =  $coupon->count();
            //nếu >0 thì lưu mã vào session
            if($countCoupon > 0){
                // kiêm tra coupon session tồn tại chưa, nếu chưa thì tạo
                $couponSession = Session::get('coupon');
                if($couponSession){
                    $is_available = 0;
                    if($is_available==0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number'=>$coupon->coupon_number,
                        );
                        Session::put('coupon',$cou);
                    }

                }else{ // chưa tồn tại thì tạo mới
                    $cou[] = array(
                        'coupon_code' =>$coupon->coupon_code,
                        'coupon_condition'=>$coupon->coupon_condition,
                        'coupon_number'=>$coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
                }
                // lưu Session lại bằng lệnh save()
                Session::save();
                return redirect()->back()->with('message','Apply discount code successfully');
            }
        }else{
            return redirect()->back()->with('error','The discount code does not exist');
        }
    }
    public function deleteCouponCode(){
        Session::forget('coupon');
        return \redirect()->back()->with('message','delete coupon code successfully');
    }
}
