<?php

namespace App\Http\Controllers;
// sử dụng database
use DB;
//sử dung session
use Cart;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;

use App\Models\OrderDetails;
use App\Models\Order;
use App\Models\Shipping;
session_start();

class CheckoutController extends Controller
{

    public function authLogin(){
        $adminId = Session::get('adminId');
        if(!$adminId){
            return Redirect::to('/')->send();
        }
    }
    public function ensureLogin(){

        if(!Session::get('customerId')){
            return Redirect::to('/loginCheckout')->send();
        }
    }
/*   public function manageOrder(){
        $this->authLogin();

        $allOrder = DB::table('tbl_order')
            ->join('tbl_customer','tbl_customer.customer_id',"=",'tbl_order.customer_id')
            ->select('tbl_order.*','tbl_customer.customer_name')
            ->orderby('tbl_order.order_id','desc')->get();

        $managerOrder = view('admin.order.manageOrder')->with('allOrder',$allOrder);
        return view('admin_layout')
            ->with('admin.order.manageOrder',$managerOrder);
    }
    public function viewOrder($orderId){
        $this->authLogin();

        $orderById = DB::table('tbl_order')
            ->join('tbl_customer','tbl_customer.customer_id',"=",'tbl_order.customer_id')
            ->join('tbl_shipping','tbl_shipping.shipping_id',"=",'tbl_order.shipping_id')
            ->join('tbl_order_detail','tbl_order_detail.order_id',"=",'tbl_order.order_id')

            ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_detail.*')
            ->first();

        $managerOrderById= view('admin.order.viewOrder')->with('orderById',$orderById);
        return view('admin_layout')->with('admin.order.viewOrder',$managerOrderById);

    }*/
    //end Admin Pages
    public function loginCheckout(Request $req){
        $metaDes = "Giỏ hàng của bạn";
        $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Giỏ hàng Ajax"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập


        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

            return view('pages.checkout.loginCheckout')
                ->with('categoryProduct',$categoryProduct)
                ->with('brandProduct',$brandProduct)
                ->with('metaDes',$metaDes)
                ->with('metaKeywords',$metaKeywords)
                ->with('metaTitle',$metaTitle)
                ->with('urlCanonical',$urlCanonical);
    }
    public function addCustomer(Request $req){
        $data = array();
        $data['customer_name'] = $req->name;
        $data['customer_email'] = $req->email;
        $data['customer_phone']=$req->phone;
        $data['customer_password'] = md5($req->password);

        //kiểm tra email đã được đk trước đó chưa
        $checkEmail = DB::table('tbl_customer')->where('customer_email',$req->email)->first();
        /*if($checkEmail == []){

            Session::put('message','This email already exists');
            return Redirect::to('/loginCheckout');
        }*/

            //thêm và lấy ra Id customer để lưu vào session
            $customerId = DB::table('tbl_customer')->insertGetId($data);
            Session::put('customerId',$customerId);
            Session::put('customerName',$req->name);

            return Redirect::to('/checkout');


    }
    public function checkout(Request $req){
        $this->ensureLogin();
        $metaDes = "Giỏ hàng của bạn";
        $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Checkout"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập



        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

        $allCity = City::orderby('matp','ASC')->get();
            return view('pages.checkout.showCheckout')
                ->with('categoryProduct',$categoryProduct)
                ->with('brandProduct',$brandProduct)
                ->with('allCity',$allCity)
                ->with('metaDes',$metaDes)
                ->with('metaKeywords',$metaKeywords)
                ->with('metaTitle',$metaTitle)
                ->with('urlCanonical',$urlCanonical);

    }
    public function saveCheckoutCustomer(Request $req){
        $data = array();
        //dữ liệu shipping
        $data['shipping_name'] = $req->shippingName;
        $data['shipping_email'] = $req->shippingEmail;
        $data['shipping_address'] = $req->shippingAddress;
        $data['shipping_phone'] = $req->shippingPhone;
        $data['shipping_notes'] = $req->shippingNotes;

        $shippingId = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shippingId',$shippingId);
        return Redirect::to('/payment');

    }
    public function payment(Request $req){
        $metaDes = "Giỏ hàng của bạn";
        $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Payment"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập

        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')
            ->with('categoryProduct',$categoryProduct)
            ->with('brandProduct',$brandProduct)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);
    }

    //done payment
    public function orderPlace(Request $req){
        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        //insert payment method

             $paymentData = array();
               $paymentData['payment_method']= $req->paymentOption;
               $paymentData['payment_status'] = 8; // đang chờ xử lý
               $paymentId = DB::table('tbl_payment')->insertGetId($paymentData);

               //insert order
           $orderData = array();
           $orderData['customer_id'] = Session::get('customerId');
           $orderData['shipping_id'] = Session::get('shippingId');
           $orderData['payment_id'] = $paymentId;
           $orderData['order_total'] = Cart::total();
           $orderData['order_status'] = 8; // đang chờ xử lý
           $orderId = DB::table('tbl_order')->insertGetId($orderData);

           //insert order detail
        $content = Cart::content();
        foreach($content as $v_content){
            $orderDetailData = array();
            $orderDetailData['order_id'] = $orderId;
            $orderDetailData['product_id'] = $v_content->id;
            $orderDetailData['product_name'] = $v_content->name;
            $orderDetailData['product_price'] = $v_content->price;
            $orderDetailData['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_detail')->insert($orderDetailData);
        }
        if($paymentData['payment_method']==1){
            echo "thanh toán bằng thẻ";
        }
        elseif ($paymentData['payment_method']==2){
            //hủy giỏ hàng để cho giỏ hàng sạch trong lần đặt hàng tiếp theo của khách hàng
            Cart::destroy();
            return view('pages.checkout.handcash')
                ->with('categoryProduct',$categoryProduct)
                ->with('brandProduct',$brandProduct);
        }
        elseif ($paymentData['payment_method']==3){
            echo "thanh toán qua paypal";
        }

    }
        public function selectDeliveryHome(Request $req){
         $data = $req->all();
         if($data['action']){
             $output = '';
             if($data['action']=='city'){
                    $allProvince = Province::where('matp',$data['id'])->get();
                    $output .='<option>----- Choose Province -----</option>';
                    foreach ($allProvince as $key => $province){
                        $output .= '<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                    }
             }else{
                    $allWards = Wards::where('maqh',$data['id'])->get();
                    $output ='<option>----- Choose Wards -----</option>';
                    foreach ($allWards as $key => $wards){
                        $output .='<option value="'.$wards->xaid.'">'.$wards->name_xaphuong.'</option>';
                    }
             }
             echo $output;
         }
        }

        public function calculateFeeship(Request $req){
                $data = $req->all();
               if($data['cityId']){
                $feeship = Feeship::where('fee_matp',$data['cityId'])
                    ->where('fee_maqh',$data['provinceId'])
                    ->where('fee_xaid',$data['wardsId'])->get();
                   if($feeship){
                       // kiểm tra coi có dữ liệu khôg , kiểm tra bằng cách đếm . kiểm tra tồn tại không được
                       $countFeeship = $feeship->count();
                       // có thì
                       if($countFeeship>0){
                           foreach ($feeship as $key => $fee){
                               Session::put('feeship',$fee->fee_feeship);
                               Session::save();
                           }
                       }else{
                           Session::put('feeship',20000);
                           Session::save();
                       }


                   }
            }
        }

        public function delFeeship(){
                if(Session::get('feeship')){
                    Session::forget('feeship');
                }
                return \redirect()->back()->with('message','Delete feeship successfully');
        }

        public function confirmOrder(Request $req){
         $data = $req->all();
         // đầu tiên lưu dữ liệu vào bảng shipping trước
            $shipping = new Shipping;
            $shipping->shipping_name = '';
            $shipping->shipping_address = $data['shippingAddress'];
            $shipping->shipping_phone = $data['shippingPhone'];
            $shipping->shipping_email = $data['shippingEmail'];
            $shipping->shipping_notes = $data['shippingNotes'];
            $shipping->shipping_method = $data['shippingMethod'];
            $shipping->save();
            //lấy ra shipping_id để lát insert vào bảng order
            $shipping_id = $shipping->shipping_id;


            // sau khi thêm vào bảng tbl_shipping rồi thì ta thêm vào bảng tbl_order, thêm tbl_order vào trước vì ta phải lấy được hóa đơn thì ta mới xem được chi tiết đơn hàng
            $order = new Order;
            //random để trả ra chữ và số bất kì ,microtime là trả về thời gian tại thời điểm hiện tại bao gòm microseconds
            $orderCode = substr(md5(microtime()),rand(0,26),5);

            $order->customer_id = Session::get('customerId');
            $order->shipping_id = $shipping_id;
            $order->order_status = 1; // là mới
            $order->order_code = $orderCode;
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $order->created_at = now();
            $order->save();

            // cuối cùng là thêm vào bảng tbl_order_details
            if(Session::get('cart')){
                foreach(Session::get('cart') as $key => $cart){
                       $orderDetails = new OrderDetails(); // phải bỏ trong foreach không bỏ là nó chỉ thêm sản phẩm cuối cùng thui
                        $orderDetails->order_code = $orderCode;
                        $orderDetails->product_id = $cart['product_id'];
                        $orderDetails->product_price =  $cart['product_price'];
                        $orderDetails->product_name = $cart['product_name'];
                        $orderDetails->product_sales_quantity = $cart['product_qty'];
                        $orderDetails->product_feeship = $data['orderFeeship'];
                        $orderDetails->product_coupon = $data['orderCoupon'];
                        $orderDetails->save();

                }
            }
            // nếu đặt hàng mọi thứ thành công thì ta xóa mã coupon mà cart , feeship để đặt lại
            Session::forget('coupon');
            Session::forget('feeship');
            Session::forget('cart');
        }

    //customer
    public function loginCustomer(Request $req){
        $email = $req->emailAccount;
        $password = md5($req->passwordAccount);
       // first để lấy ra dữ liệu gọi được, không dùng get() bởi thì lấy dữ liệu bằng get() phải foreach() mới gọi được
         $customer = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

         if($customer){
             Session::put('customerId',$customer->customer_id);
             Session::put('customerName',$customer->customer_name);
             return Redirect::to('/checkout');
         }else{

             Session::put('messageLogin','This account does not exist');
             return Redirect::to('/loginCheckout');
         }




    }
    public function logoutCheckout(){
        // sử dụng Session::flush() để xóa tất cả session
        Session::flush();
        return Redirect::to('loginCheckout');

    }
}
