<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Mail;
use Illuminate\Http\Request;
use DB;
//sử dung session
use Session;
use Illuminate\Support\Facades\Redirect;

use App\Models\Feeship;

use App\Models\OrderDetails;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\Product;
use PDF; // để in hóa đơn
use App\Models\Statistical;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function cancelOrder(Request $req){
            $order = Order::where('order_code',$req->orderCode)->first();
            $order->order_status = 3; // bằng 3 là hủy đơn
            $order->order_destroy = $req->reason;
            $order->save();
    }


    public function manageOrder(){
            $allOrder = Order::with('orderStatus')->orderby('created_at','DESC')->get();
            return view('admin.order.manageOrder')->with(compact('allOrder'));
    }
    public function viewOrder($orderCode){
        //phải with product mới lấy product ra được nhaa
        $orderDetails = OrderDetails::with('product')->where('order_code',$orderCode)->get();
        // lấy customerId và shipping bằng bảng order cho lẹ
        $order = Order::where('order_code',$orderCode)->get();
        foreach($order as $key => $ord){
            $customerId = $ord->customer_id;
            $shippingId = $ord->shipping_id;
            $orderStatus = $ord->order_status;
        }
        $customer = Customer::find($customerId);
        $shipping = Shipping::find($shippingId);
        //lấy ra mã coupon để lấy ra tiền và condition để tính tổng tiền
        foreach ($orderDetails as $key => $details){
            $productCoupon = $details->product_coupon;
        }
        $coupon= Coupon::where('coupon_code',$productCoupon)->first(); // first nên k cần lặp
        // nếu product = 'no' có nghĩa là không nhập mã giảm giá, thì ta cho couponNumber = 0 ; và condition = 2
        if($productCoupon == 'no'){
            $couponCondition = 2; // 2 là giảm theo tiền, 1 là giảm theo %
            $couponNumber = 0; // cho giảm 0 đồng
        }else{
            $couponNumber = $coupon->coupon_number;
            $couponCondition = $coupon->coupon_condition;
        }
                //update status dựa trên order
        return view('admin.order.viewOrder')->with(compact('orderStatus','orderDetails','order','customer','shipping','couponNumber','couponCondition'));
    }
    public function printOrder($checkoutCode){
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($this->print_order_convert($checkoutCode));
            return $pdf->stream();
    }
    public function print_order_convert($checkoutCode){
        //lấy product thì phải with mới lấy được nha
        $orderDetails = OrderDetails::with('product')->where('order_code',$checkoutCode)->get();
        //lấy ra customer và shipping
        $order = Order::where('order_code',$checkoutCode)->get();
        foreach ($order as $key => $ord){
            $customerId =$ord->customer_id;
            $shippingId = $ord->shipping_id;
        }
        $customer = Customer::find($customerId);
        $shipping = Shipping::find($shippingId);

        $output ='';
        $output .=' <style> body {
                                     font-family:DejaVu Sans;
                                     }.table-styling{
                                      border: 1px solid #000000;
                                     }
                      </style>
            <h1><center>Shop Perfume</center></h1>
            <p><center>Customer order</center></p>
            <table class="table table-styling">
                        <thead>
                             <tr>
                                <th>Customer name</th>
                                <th>Phone</th>
                                <th>Email</th>
                             </tr>
                         </thead>
                <tbody>';

                $output .= '<tr>
                                <td>'.$customer->customer_name.'</td>
                                <td>'.$customer->customer_phone.'</td>
                                <td>'.$customer->customer_email.'</td>
                             </tr></tbody></table>';


    // ship đến
    $output .= '  <table class="table table-styling">
                        <thead>
                             <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Notes</th>
                             </tr>
                         </thead>
                <tbody>';
    $output .='<tr>
                        <td>'.$shipping->shipping_name.'</td>
                        <td>'.$shipping->shipping_address.'</td>
                        <td>'.$shipping->shipping_phone.'</td>
                        <td>'.$shipping->shipping_email.'</td>
                        <td>'.$shipping->shipping_notes.'</td>
                </tr></tbody></table>';

    //các sản phẩm đã đặt
        $output .='  <table class="table table-styling">
                        <thead>
                             <tr>
                                <th>Product name</th>
                                <th>Discount code</th>
                                <th>Feeship</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Sub total</th>
                             </tr>
                         </thead>
                <tbody>';
        // tổng tiền trong giỏ hàng
        $total = 0;
        foreach($orderDetails as $key => $detail){
            $subTotal = $detail->product_price*$detail->product_sales_quantity;
            $total += $subTotal;
            // lấy mã coupon ra
            $productCoupon = $detail->product_coupon;
            $output .= '<tr>
                                <td>'.$detail->product_name.'</td>
                                <td>'.$detail->product_coupon.'</td>
                                <td>'.number_format($detail->product_feeship,0,',','.').'</td>
                                <td>'.$detail->product_sales_quantity.'</td>
                                <td>'.number_format($detail->product_price,0,',','.').'</td>
                                <td>'.number_format($subTotal,0,',','.').'</td>
                         </tr>';
        }
        //lấy coupon number và condition ra tính toán để show ra hóa đơn
        if($productCoupon != 'no'){
            $coupon = Coupon::where('coupon_code',$productCoupon)->first();
            $couponCondition = $coupon->coupon_condition;
            $couponNumber = $coupon->coupon_number;
        }else{
            $couponCondition = 2;
            $couponNumber = 0;
        }
        //kiểm tra giảm theo % hay tiền rồi xử lý
        if($couponCondition ==1 ){
            $totalCoupon = ($total* $couponNumber)/100;
            $echoCoupon = $couponNumber.'%';
        }else{
            $totalCoupon = $couponNumber;
            $echoCoupon = number_format($couponNumber,0,',','.').'đ';
        }


        $output .='<tr>
                                <td colspan="2">
                                        <p>Total price in the order : '.number_format($total,0,',','.').'đ</p>
                                        <p>Discount : '.$echoCoupon.'</p>
                                        <p>Feeship : '.number_format($detail->product_feeship,0,',','.').'đ</p>
                                       <p> Toltal payment : '.number_format($total-$totalCoupon+$detail->product_feeship,0,',','.').'đ</p>
                                </td>
                        </tr>';
            $output .='</tbody></table>';

            //Ký tên
        $output .= '
                <h3>Sign</h3>
                      <table>
                        <thead>
                             <tr>
                                <th width="200px">Sender</th>
                                <th width="800px">Receiver</th>
                             </tr>
                         </thead>
                        </table>';
            return $output;
    }
    //update hàng tồn kho và statistical dựa trên order status
    public function updateInventory(Request $req){
        $data = $req->all();
        //cập nhập status cho đơn hàng bằng id mới tìm được là status trả về
        $order =  Order::find($data['orderId']);

        $order->order_status = $data['orderStatus'];
        $customer = Customer::find($order->customer_id);
        $order->save();





        //nếu order_status = 3 có nghĩa là đơn hàng đã được xử lý và được gửi thì ta cập nhật lạt số lượng product trong kho và statistical
        if($order->order_status == 3){
            //các biến để lưu vào statistical
            $sales = 0; //doanh thu
            $profit = 0; //lợi nhuận
            $quantity = 0; //số lượng sản phẩm bán được
            $totalOrder = 1; //khi xác nhận ta cho nó là một
            foreach ($data['productId'] as $key => $productId){
                // lấy product trong đơn hàng cần cập nhật bằng id
                    $product = Product::find($productId);
                    //foreach để update quanty lúc nãy lấy ở ajax
                foreach($data['productQty'] as $key2 => $qty){
                    //cùng vị trí mới được vào update
                    if($key2 == $key){
                        //update số product tồn
                        $product->product_quantity -= $qty;
                        //update số sản phẩm đã bán
                        $product->product_sold += $qty;
                        $product->save();

                        //update doanh thu
                        //doanh thu sẽ bằng giá nhấn số lương
                        $sales += $product->product_price * $qty;
                        //lợi nhuận bằng giá bán trừ giá gốc
                        $profit += ($product->product_price * $qty) - ($product->product_cost * $qty);
                        $quantity += $qty;


                        //send mail
                        $cartArray[] = array(   // khi xài mảng muốn lưu nhiều phần tử theo vòng lặp thì $cartArray[] , nếu không có[] thì nó thỉ lưu một phần tử cuối thồi
                            'product_name'=> $product->product_name,
                            'product_qty'=> $qty,
                            'product_price'=> $product->product_price,
                        );
                    }

                }

            }

            // =====  Send mail confirm ====

            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
            $title = "Đơn hàng bạn đã xác nhận mua lúc ".$now;

            //ngày dự kiến giao hàng
            $ngayDuKienGiao = Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('d/m/Y');
            //lấy phí ship
            $orderDetail = OrderDetails::where('order_code',$order->order_code)->first();
            $feeship = $orderDetail->product_feeship;
            $couponCode = $orderDetail->product_coupon;


            //lấy shipping , không cần lưu nhiều phần tử nên không cần kí tự []
            $shipping = Shipping::find($order->shipping_id);
            $shippingArray = array(
                'feeship'=>$feeship, //lưa tạm vào đây
                'ngayDuKien'=>$ngayDuKienGiao,
                'shipping_name' => $shipping->shipping_name,
                'shipping_address'=> $shipping->shipping_address,
                'shipping_phone'=> $shipping->shipping_phone,
                'shipping_email'=> $shipping->shipping_email,
                'shipping_method'=> $shipping->shipping_method,
                'shipping_notes'=>$shipping->shipping_notes

            );
            $email = $customer->customer_email; //$shipping->shipping_email; //lưu để gửi mail

            //lưu mã đơn hàng và mã giảm giá
            $orderArray = array(
                'coupon_code'=>$couponCode,
                'order_code'=> $order->order_code,
                'totalDiscount' => $data['totalDiscount'], //tổng tiền mà mã giảm giá giảm được
            );

            Mail::send('pages.mail.mailOrder',['cartArray'=>$cartArray,'shippingArray'=>$shippingArray,'orderArray'=>$orderArray],function($message) use ($title,$email){
                $message->to($email)->subject($title);
                $message->from($email,$title);
            });

           // ==== end send mail ===
        }
        else if($order->order_status == 2){ // bằng 2 là đang cần xác nhận đơn từ admin
            //các biến để lưu vào statistical
            $sales = 0; //doanh thu
            $profit = 0; //lợi nhuận
            $quantity = 0; //số lượng sản phẩm bán được
            $totalOrder = -1; // cho bằng -1 để  trừ tổng đơn hàng trong satistical, khi nào cập nhật đã xử lý thì cộng lại
            //nếu order status khác 2
                //lấy product bằng mảng id mình gửi qua
            foreach($data['productId'] as $key => $productId){
                $product = Product::find($productId);
                foreach($data['productQty'] as $key2 => $qty){
                    //cùng vị trí mới được update , không có bước này code sẽ chạy update nhiều lần , nên kq sẽ sai
                    if($key2 == $key){
                        //update sold
                        $product->product_sold -= $qty;
                        //update inventory
                        $product->product_quantity += $qty;
                        $product->save(); // lưu lại


                        //update doanh thu
                        $sales -= $product->product_price * $qty;
                        $quantity -= $qty;
                        //lợi nhuận sẽ bằng giá bán * số lượng - trừ giá gốc *số lượng
                        $profit -= ($product->product_price* $qty) - ($product->product_cost * $qty);
                    }
                }
            }
        }
        //update Statistical
        $statistical = Statistical::where('order_date',$order->order_date)->first();
        if($statistical){ //nếu có tồn tại đơn hàng trong ngày này thì cập nhật
            $statistical->sales += $sales; // doanh thu
            $statistical->profit += $profit; // lợi nhuận
            $statistical->quantity += $quantity; // số lượng sản phẩm bán được trong ngày
            $statistical->total_order += $totalOrder; // cộng 1 vào tổng đơn hàng
            $statistical->save();
        }else{ //không thì tạo mới
        $statistical = new Statistical();
            $statistical->sales = $sales; // doanh thu
            $statistical->profit = $profit;
            $statistical->quantity = $quantity; // số lượng sản phẩm bán được trong ngày
            $statistical->total_order = 1; // tổng đơn hàng mới cho là 1
            $statistical->order_date = $order->order_date; // đơn hàng được đặt vào ngày
            $statistical->save();
        }


        /*$sendOrder = Http::withHeaders([
            'Content-type'=> 'application/json',
            'Token'=>'0829a146-0d87-11ec-b5ad-92f02d942f87'
        ])->get('https://services.giaohangtietkiem.vn/services/shipment/order/?ver=1.5 HTTP/1.1',[
            'district_id'=> $districtId_GHN,
        ]);*/


    }


    //update số lượng sản phẩm  trong đơn hàng
    public function updateQtyProductOrder(Request $req){
        $data = $req->all();

            OrderDetails::where('order_code',$data['orderCode'])
                ->where('product_id',$data['productId'])
                ->update(['product_sales_quantity'=>$data['productQty']]);



    }




    //update hàng tồn kho dựa trên order status
    /*public function updateInventory(Request $req){
        $data = $req->all();
        //cập nhập status cho đơn hàng bằng id mới tìm được là status trả về
        $order =  Order::find($data['orderId']);

        //status cũ bằng 1 hoặc 3 và status mới cũng bằng 1 hoặc 3 cho thì chỉ cập nhật status không cập nhật product
        $oldStatus = $order->order_status;
        if($oldStatus == 1 || $oldStatus == 3 ){
            if($data['orderStatus'] == 1 || $data['orderStatus'] == 3){
                $order->order_status = $data['orderStatus'];
                $order->save();
                return 0;  // dừng hàm
            }
        }

        $order->order_status = $data['orderStatus'];
        $order->save();
        //nếu order_status = 2 có nghĩa là đơn hàng đã được xử lý và được gửi thì ta cập nhật lạt số lượng product trong kho
        if($order->order_status == 2){
            foreach ($data['productId'] as $key => $productId){
                // lấy product trong đơn hàng cần cập nhật bằng id
                $product = Product::find($productId);
                //foreach để update quanty lúc nãy lấy ở ajax
                foreach($data['productQty'] as $key2 => $qty){
                    //cùng vị trí mới được vào update
                    if($key2 == $key){
                        //update số product tồn
                        $product->product_quantity -= $qty;
                        //update số sản phẩm đã bán
                        $product->product_sold += $qty;
                        $product->save();

                    }

                }

            }
            return 1; // dừng hàm
        }
        elseif($order->order_status !=2 ){
            //nếu order status khác 2 và khác 3 thì cộng lại number of inventory in stock
            //lấy product bằng mảng id mình gửi qua
            foreach($data['productId'] as $key => $productId){
                $product = Product::find($productId);
                foreach($data['productQty'] as $key2 => $qty){
                    //cùng vị trí mới được update , không có bước này code sẽ chạy update nhiều lần , nên kq sẽ sai
                    if($key2 == $key){
                        //update sold
                        $product->product_sold -= $qty;
                        //update inventory
                        $product->product_quantity += $qty;
                        $product->save(); // lưu lại
                    }
                }
            }
            return 1; // dừng hàm
        }

    }*/
}
