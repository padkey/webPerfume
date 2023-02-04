<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; // tạo mã uuid v4
use App\Models\Order;
session_start();
class MomoController extends Controller
{
    //
    public function paymentByMomo(Request $req){
      /*  $uuid = Str::uuid()->toString();
        $orderId =  Str::random(40);*/
        //kiểm tra xem  đơn hàng đang chờ thanh toán không
        $order = Order::where('order_code',$req->orderCode)->where('order_status',1)->first();
        //nếu có order thì
        if($order){
            $response = \MoMoAIO::purchase([
                'amount' => 10000,//$order->order_amount
                'returnUrl' => 'http://localhost:8080/shopperfume/addOrderMomo', // nếu thành công thì
                'notifyUrl' => 'http://localhost:8080/shopperfume/orderHistory', // không thì
                'orderId' => $order->order_code,
                'requestId' => $order->request_id,
            ])->send();

            $redirectUrl  = $response->getRedirectUrl(); //lấy đường dẫn thanh toán để chuyển hướng người dùng

            //  Session::put('dataOrder',$data);
           echo $redirectUrl; //chuyển hướng đến url momo trả về để mình thanh toán*/
        }



    }
    public function addOrderMomo(){
          //  print_r(Session::get('dataOrder'));
        //kiểm tra thông tin khi khách hàng thanh toán xong được momo gửi về, thành công hay thất bạn
        $response = \MoMoAIO::completePurchase()->send(); //hoàn thành mua hàng

        //nếu thanh toán thành công thì
        if ($response->isSuccessful()) {
            // TODO: xử lý kết quả và hiển thị.
           // print $response->amount;
          //  print $response->orderId;
           // print $response->requestId;
           // print $response->partnerRefId; // Mã đơn hàng phía momo lưu để sau này yêu cầu hoàn tiền
           // print $response->transId; //khi thanh toán thành công momo thành công , momo sẽ cung cấp transId để có thể yêu cầu hoàn tiền

            /*cập nhật lại status cho đơn hàng thành processing, và thêm transId vào để sau này người dùng hủy đơn hàng
            thì mình có thể hoàn tiền cho người dùng */
           Order::where('order_code',$response->orderId)->update(['order_status'=>'3','trans_id'=>$response->transId]);

          //  echo $response->isSuccessful();
           // echo '<pre>';

         //   var_dump($response->getData()); // toàn bộ data do MoMo gửi sang.
            //    echo '</pre>';
            return Redirect('/orderHistory/0');
        } else { //thất bại thì in ra lỗi

            print $response->getMessage();
        }
    }


    public function refund(){
        // 2621926462

        $uuid = Str::uuid()->toString();
        $orderId =  Str::random(40);
        $response2 = \MoMoAIO::refund([
            'orderId' => $orderId,
            'requestId' =>$uuid,
            'transId' => '2621926462',
            'amount' => 50000,
        ])->send();

        if ($response2->isSuccessful()) {

            print $response2->amount;
            print $response2->orderId;

            var_dump($response2->getData()); // toàn bộ data do MoMo gửi về.

        } else {
            echo'lỗi';
            print $response2->getMessage();
        }

    }
    public function destroyMomo(){
        $response = \MoMoQRCode::refund([
            'partnerRefId' => '123',
            'requestId' => '999',
            'momoTransId' => 321,
            'amount' => 50000,
        ])->send();

        if ($response->isSuccessful()) {
            // TODO: xử lý kết quả.
            print $response->amount;

            var_dump($response->getData()); // toàn bộ data do MoMo gửi về.

        } else {

            print $response->getMessage();
        }
    }

    public function checkDestroyMomo(){
        $response = \MoMoAIO::queryRefund([
            'orderId' => '123',
            'requestId' => '321',
        ])->send();

        if ($response->isSuccessful()) {
            // TODO: xử lý kết quả và hiển thị.
            print $response->amount;
            print $response->orderId;

            var_dump($response->getData()); // toàn bộ data do MoMo gửi về.

        } else {

            print $response->getMessage();
        }
    }

}
