<?php

namespace App\Http\Controllers;

// sử dụng database
use App\Models\CatePost;
use App\Models\Province;
use App\Models\Customer;
use DB;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Cart;
use App\Models\Coupon;
use Carbon\Carbon;
session_start();
class CartController extends Controller
{
   public function showCartQty(){
       $cartQtyItem = count(Session::get('cart'));
     $output = '<span class="badges">'.$cartQtyItem.'</span>';

       echo $cartQtyItem;
   }

   public function showCartMenu(){
       $output = '';
       if(Session::get('cart')){
           foreach(Session::get('cart') as $key => $cart){
                  $output .='<li>
                            <a href="">
                                    <img src="'.url('/public/uploads/products/'.$cart['product_image']).'" alt="" >
                                    <p>'.$cart['product_price'].'</p>
                                    <p>'.$cart['product_name'].'</p>
                                    <p>Số lượng : '.$cart['product_qty'].'</p>
                                </a>
 <a class="cart_quantity_delete" href="'.url('/delProduct/'.$cart['session_id']).'"><i class="fa fa-times"></i></a>

                            </li>

                            ';
           }
       }
       echo $output;
   }
    //khi click thêm thì nó thêm từng cái nên k xài vòng lặp
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
                    $cart[$key]['product_qty'] += $data['cartProductQty'];
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
                    'product_qty' => $data['cartProductQty'],
                    'qty_product_in_stock' =>$data['qtyProductInStock'],
                );
               // Session::put('cart',$cart);
            }


        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_id'=> $data['cartProductId'],
                'product_name' => $data['cartProductName'],
                'product_price' => $data['cartProductPrice'],
                'product_image' => $data['cartProductImage'],
                'product_qty' => $data['cartProductQty'],
                'qty_product_in_stock'=>$data['qtyProductInStock'],
            );
        }
      //  print_r($data);
        Session::put('cart',$cart);
        Session::save(); //lưu giỏ hàng
    }
    public function showCart(Request $req){
        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Giỏ hàng của bạn";
        $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Giỏ hàng Ajax"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\


        $allCity = Province::all();

        return view('pages.cart.showCart')
            ->with('allCity',$allCity)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);
    }

    public function updateCart1(Request $req){
        $data = $req->all();
       // print_r($data['quantityCart']);
         $cart = Session::get('cart');
        $message='';
            // foreach name để lấy ra các session_id của mỗi product , để cập nhật , mỗi name có một value là số lượng của product
            foreach($data['qtyOfProductInCart'] as $sessionId => $qty){
                $i=0;
                        foreach($cart as $key => $val){
                            $i++;
                            // nếu session_id của cart mới = cart cũ và số lượng product mới < số lượng product trong kho
                            if($val['session_id'] == $sessionId && $qty < $cart[$key]['qty_product_in_stock']){
                                // update qty của product trong cart có session_id giống với $sessionId
                                $cart[$key]['product_qty'] = $qty;
                                //hiển thị thông báo cập nhật số lượng thành công
                                $message .='<p style="color: #00aa00">'.$i.') Update the quantity of successful ' .$cart[$key]['product_name'].'</p>';
                            }elseif ($val['session_id'] == $sessionId && $qty > $cart[$key]['qty_product_in_stock']){
                                $message .='<p style="color: #9c3328">'.$i.') Update the quantity of faile '.$cart[$key]['product_name'].'!</p>';
                            }
                        }
            }
            //cập nhật lại giỏ hàng
           Session::put('cart',$cart);
            Session::save();
            return redirect()->back()->with('message',$message);
    }
    public function updateCart(Request $req){
       $data = $req->all();
       $cart = Session::get('cart');
       $message ='';
       foreach ($data['qtyOfProductInCart'] as $sessionId => $qty){
           foreach($cart as $key => $val){
               if($sessionId == $val['session_id'] && $qty <= $val['qty_product_in_stock']){ // nếu seesionId = cart[$key]['session_id'] thì update qty
                   if($cart[$key]['product_qty'] != $qty){ // kiểm tra số lượng của sản phẩm có thay đổi khôg
                       $cart[$key]['product_qty'] = $qty; // có thì cập nhật lại
                       $message .= '<p style="color: #00aa00"><i class="fa fa-check-circle"></i>  Updated the quantity of successful "'.$cart[$key]['product_name'].'" </p>';
                   }
               }elseif($sessionId == $val['session_id'] && $qty > $cart[$key]['qty_product_in_stock']){
                   $message .='<p style="color: red"><i class="fa fa-exclamation-circle"></i>   Quantity of "'.$val['product_name'].'" in stock is not enough </p>';
               }
           }
       }

        Session::put('cart',$cart);
       Session::save();
       if($message == ''){
           return redirect()->back();
       }
        return redirect()->back()->with('message',$message);
    }


    //check coupon
    public function checkCoupon(Request $req){
        $data = $req->all();


        //kiểm tra người dùng đã sử dụng mã này chưa
        $customer = Customer::find(Session::get('customerId'));
        if($customer){
            $allCouponCustomerUsed = explode(',',$customer->coupon_used); // lấy ra tất cả mã coupon mà customer đã sử dụng, và convert chuỗi thành mãng mỗi phần tử cách nhau bởi dấu phẩy
            foreach ($allCouponCustomerUsed as $key => $couponCode){
                    if($couponCode == $data['couponCode']){
                        echo -1;
                    }
            }
        }


        $now = Carbon::now('Asia/Ho_Chi_Minh')->todateString();
        $coupon = Coupon::where('coupon_code',$data['couponCode'])
            ->where('coupon_status',1)
            ->where('coupon_date_end','>=',$now) // ngày kết thúc phải lớn hơn hoặc bằng ngày hiện tại , như vậy là chưa hết hạn
            ->where('coupon_quantity','>',0) // kiểm tra mã còn không
            ->first(); // dùng phương thức first lấy ra một giá trị, thì không cần foreach

        if($coupon){
            $cou = array(
                'coupon_code' =>$coupon->coupon_code,
                'coupon_condition'=>$coupon->coupon_condition,
                'coupon_number'=>$coupon->coupon_number,
            );
            Session::put('coupon',$cou);
            // lưu Session lại bằng lệnh save()
            Session::save();
            echo 1;

        }else{
            return redirect()->back()->with('error','The discount code does not exist or expired');
        }
    }


    public function deleteCouponCode(){
        Session::forget('coupon');
        return \redirect()->back()->with('message','Delete coupon code successfully');
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
            return redirect()->back()->with('message','Deleted product successfully!'); // back() có nghĩ là quay lại trang trước
        }else{
            return redirect()->back()->with('message','Deleted product failly!'); // back() có nghĩ là quay lại trang trước

        }

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

}










/*public function checkCoupon(Request $req){
    $data = $req->all();

    $now = Carbon::now('Asia/Ho_Chi_Minh')->todateString();
    $coupon = Coupon::where('coupon_code',$data['couponCode'])
        ->where('coupon_status',1)
        ->where('coupon_date_end','>=',$now) // ngày kết thúc phải lớn hơn ngày hiện tại , như vậy là chưa hết hạn
        ->first(); // dùng phương thức first lấy ra một giá trị, thì không cần foreach

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
        return redirect()->back()->with('error','The discount code does not exist or expired');
    }
}*/
/* public function saveCart(Request $req){

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

    }*/
//cart chưa kiểm tra số lượng để sau này xem lại
/*public function updateCart(Request $req){
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
}*/
/*public function showCart(Request $req){
   //----seo để cho google biết là google biết mình miêu tả trang web như thế này
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
        ->with('urlCanonical',$urlCanonical);
   Session::forget('cart');
   Session::forget('coupon');
}*/
/*public function deleteToCart($rowId){
            Cart::update($rowId,0);

            return Redirect::to('/showCart');
    }*/

/*public function updateQuantityCart(Request $req){
    $rowId = $req->rowIdCart;
    $qty = $req->quantityCart;
    Cart::update($rowId,['qty' => $qty]);
    return Redirect::to('/showCart');
}*/
