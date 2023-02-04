<?php

namespace App\Http\Controllers;
// sử dụng database
use App\Models\Coupon;
use App\Models\Customer;
use DB;
//sử dung session
use Cart;
use Illuminate\Support\Facades\Http;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Feeship;

use App\Models\OrderDetails;
use App\Models\Order;
use App\Models\Shipping;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
session_start();

class CheckoutController extends Controller
{

    public function authLogin()
    {
        $adminId = Auth::id;
        if (!$adminId) {
            return Redirect::to('/')->send();
        }
    }

    public function ensureLogin()
    {
        if (!Session::get('customerId')) {
            return Redirect::to('/showLogin')->send();
        }
    }





    public function checkout(Request $req)
    {
        $this->ensureLogin();
        $metaDes = "Thanh toán";
        $metaKeywords = "Thanh toán";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Thanh toán"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập


        $allProvince = Province::all();

        return view('pages.checkout.showCheckout')
            ->with('allCity', $allProvince)
            ->with('metaDes', $metaDes)
            ->with('metaKeywords', $metaKeywords)
            ->with('metaTitle', $metaTitle)
            ->with('urlCanonical', $urlCanonical);

    }


    public function selectDeliveryHome(Request $req)
    {
        $data = $req->all();
        if ($data['action']) {
            $output = '';
            //nếu hành động thây đổi province thì ta cập nhật lại quận huyện
            if ($data['action'] == 'province') {
                $allDistrict = District::where('province_id', $data['id'])->get();
                $output .= '<option value="">Select a province ... </option>';
                foreach ($allDistrict as $key => $district) {
                    $output .= '<option value="' . $district->district_id . '">' . $district->district_name . '</option>';
                }
            } elseif($data['action'] == 'district') {
                $allWard = Ward::where('district_id', $data['id'])->get();
                $output = '<option value="">Select a ward ...</option>';
                foreach ($allWard as $key => $ward) {
                    $output .= '<option value="' . $ward->ward_id . '">' . $ward->ward_name . '</option>';
                }
            }
            echo $output;
        }
    }

    public function calculateFeeship(Request $req)
    {
        $data = $req->all();
        // lưu phí ship vào session
        if ($data['cityId']){
            $feeship = Feeship::where('fee_matp', $data['cityId'])
                ->where('fee_maqh', $data['provinceId'])
                ->where('fee_xaid', $data['wardsId'])->get();


            if ($feeship) {
                // kiểm tra coi có dữ liệu khôg , kiểm tra bằng cách đếm . kiểm tra tồn tại không được
                $countFeeship = $feeship->count();
                // có thì
                if ($countFeeship > 0) {
                    foreach ($feeship as $key => $fee) {
                        Session::put('feeship', $fee->fee_feeship);
                        Session::save();
                    }
                } else {
                    Session::put('feeship', 30000);
                    Session::save();
                }

            }
        }

    }


    public function updateShippingInfo(Request $req){
        $province = Province::find($req->provinceId);
        $district = District::find($req->districtId);
        $ward = Ward::find($req->wardId);
        $shippingInfo = array(
                'fullName'=> $req->fullName,
                'phone'=> $req->phone,
                'province'=>$province->province_name,
                'district'=>$district->district_name,
                'ward'=>$ward->ward_name,
                'addressDetails' => $req->addressDetails
            );
            Session::put('shippingInfo',$shippingInfo);

            $this->selectShippingCarrier();

            return redirect()->back()->with('message','Updated Shipping Address successfully');
    }
    public function selectShippingCarrier(){
        $shippingInfo = Session::get('shippingInfo');
        if($shippingInfo){
            //lấy tất cả province
            $dataProvinceGHN = Http::withHeaders([
                'Content-Type'=>  'application/json' ,
                'Token' => '0829a146-0d87-11ec-b5ad-92f02d942f87' //token này ở trong tài khoản sandbox
            ])->get('https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/province');
            //  echo 1;
            $dataProvinceGHN = json_decode($dataProvinceGHN);
            $allProvinceGHN = $dataProvinceGHN->data;
            /*echo '<pre>';
             print_r($allProvinceGHN);
             echo '</pre>';*/
            //lấy Id của province của GHN , bằng cách so sánh với tên province truyền vào
            $provinceId_GHN = -1;
            $districtId_GHN = -1;
            $wardId_GHN = '';
            foreach ($allProvinceGHN as $key => $provinceGHN){
                //vì tên province có nhiều loại nên phải foreach các loại tên của province
                foreach($provinceGHN->NameExtension as $key => $nameExtension){
                    if(strcmp($nameExtension, $shippingInfo['province']) == 0){
                        $provinceId_GHN = $provinceGHN->ProvinceID;
                    }
                }

            }

            //lấy được ProvinceId h ta sẽ lấy districtId
            $dataDistrictGHN = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => '0829a146-0d87-11ec-b5ad-92f02d942f87'
            ])->get('https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district',[
                'province_id' => $provinceId_GHN,
            ]);
            //ép chuỗi thành đối tượng
            $dataDistrictGHN = json_decode($dataDistrictGHN);
            $allDistrictGHN = $dataDistrictGHN->data;
            //foreach so sánh name District
            foreach ($allDistrictGHN as $key => $districtGHN){
                if($districtGHN->DistrictName == $shippingInfo['district']){
                    $districtId_GHN = $districtGHN->DistrictID;
                }
            }


            //có district rồi ta tìm ward
            $dataWardGHN = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => '0829a146-0d87-11ec-b5ad-92f02d942f87',
            ])->get('https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id',[
                'district_id'=> $districtId_GHN,
            ]);

            $dataWardGHN = json_decode($dataWardGHN);
            $allWardGHN = $dataWardGHN->data;

            foreach ($allWardGHN as $key => $wardGHN){
                if($wardGHN->WardName == $shippingInfo['ward']){
                    $wardId_GHN = $wardGHN->WardCode;
                }
            }


            //
            $getFeeship = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => '0829a146-0d87-11ec-b5ad-92f02d942f87',
                'ShopId' => 82300,
            ])->post('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee',[
                "from_district_id"=>1443, //1443 : quận 2  nãy select gắn vào, đây là quận của shop
                "service_id"=>53321,
                "service_type_id"=>3,  //loại vận chuyển, 1nhanh hay 2 chuẩn(53320) , hay 3 tiết kiệm
                "to_district_id"=>$districtId_GHN, // quận của người nhận
                "to_ward_code"=>$wardId_GHN,
                "height"=>50, // chiều cao của kiện hàng đơn vị cm
                "length"=>20, // chiều dài của kiện hàng
                "weight"=>200, //cân nặng đơn vị gram
                "width"=>20, // chiều rộng
                "insurance_fee"=>5000000, // phí bảo hiểm, khi kiện hàng vị vỡ thì bên vận chuyển phải bồi thường, vnđ
                "coupon"=> null
            ]);


            // echo $getFeeship;
            //chuyển thành kiểu mảng
            $getFeeship = json_decode($getFeeship);
            $feeship = $getFeeship->data;
            //  print_r($getFeeship);
            //lấy tổng phí ship

            //thời gian sự kiến giao hàng khi sản phẩm tring trạng thái sẳn sàng giao
            $leadTime = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => '0829a146-0d87-11ec-b5ad-92f02d942f87',
                'ShopId' => 82300,
            ])->post('https://dev-online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/leadtime',[
                "from_district_id"=> 1443,//1443 : quận 2  nãy select gắn vào, đây là quận của shop
                "from_ward_code"=> '20203', // phường
                "to_district_id"=> $districtId_GHN,
                "to_ward_code"=> $wardId_GHN,
                "service_id"=> 53321 //tiết khiệm
            ]);

            $leadTime = json_decode($leadTime);
            //   $feeship = $getFeeship->data;
            // print_r($leadTime->data);
            //nếu tồn tại ngày
            if($leadTime->data){
                //leadTime người ta gửi kiểu int nên mình format lại kiểu data
               /* $leadTime = date("Y-m-d", $leadTime->data->leadtime);
                $fromDate =  Carbon::create($leadTime)->format('d/m/Y');
                $toDate = Carbon::create($fromDate)->addDays(2)->format('d/m/Y'); // thêm ngày*/

                $fromDate = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
                $toDate = Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('d-m-Y'); // thêm ngày

            }else{ //không thì lấy ngày hiện tại
                $fromDate = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
                $toDate = Carbon::now('Asia/Ho_Chi_Minh')->addDays(3)->format('d/m/Y'); // thêm ngày
            }

            $shippingCarrier[] = array(
                'code' => 'GHN', //code để phân biệt giữa những phần tử giao hàng
                'name'=> 'Giao hàng nhanh',
                'feeship'=> $feeship->total,
                'leadtime' => $fromDate .' - '.$toDate , //là thời gian cần để giao một sản phẩm ngay khi nó ở trạng thái sẵn sàng để vận chuyển
            );


            ////// =========END GHN ===============\\\\
/// // Giao hàng tiết kiệm
            $data = Http::withHeaders([
                'Content-type' => 'application/json',
                'Token' => '69016Db27CDD40d246449B944486b70869Bdf1Ef'
            ])->get('https://services.giaohangtietkiem.vn/services/shipment/fee?',[
                "pick_province" => "Thành Phố Hồ Chí Minh", // chỗ lấy hàng
                "pick_district" => "Quận 2",// chỗ lấy hàng
                "province" => $shippingInfo['province'],
                "district" => $shippingInfo['district'],
                "address" => $shippingInfo['addressDetails'],
                "weight" => 50, // cân nặng tính bằng gam
                "value" => 300000, //giá trị của đơn hàng để bên vận chuyển tính phí
                "transport" => "road", // phương thức vận chuyển, mình truyền đại vào ghtk sẽ kiểm tra không đúng thì tự đổi thành mặc định, không sao hết
                "deliver_option" => "none", // vận chuyển thường
                "tags"  => [1]
            ]);


            //vì trả về kiểu chuỗi nên convert sang mảng
            $feeshipGHTK = json_decode($data);

            //bên vận chuyển không trả cho mình ngày dự kiến nhận nên mình tự tạo
            $now =  Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
            $leadTime = Carbon::create($now)->addDays(3)->format('d-m-Y');


            //Giao hàng tiết kiệm
            $shippingCarrier[] = array(
                'code'=> 'GHTK', //code để phân biệt giữa những phần tử giao hàng
                'name'=> 'Giao Hàng Tiết kiệm',
                'feeship'=>  $feeshipGHTK->fee->fee,
                'leadtime' => $leadTime, //là thời gian cần để giao một sản phẩm ngay khi nó ở trạng thái sẵn sàng để vận chuyển
            );



            //lưu shippingCarrier vào session
            Session::put('shippingCarrier',$shippingCarrier);
          
        }




    }




    public function chooseShippingCarrier(Request $req){
            //lưu vào session
        Session::put('chooseShippingCarrier', $req->shippingCode);
//echo  $req->shippingCode;
           return redirect()->back()->with('message','Update Shipping Carrier successfully.');
    }





    public function delFeeship()
    {
        if (Session::get('feeship')) {
            Session::forget('feeship');
        }
        return \redirect()->back()->with('message', 'Delete feeship successfully');
    }

    public function confirmOrder(Request $req)
    {
        $data = $req->all();

        //update Coupon and coupon_uesed
        $customer = Customer::find(Session::get('customerId'));
        $coupon = Coupon::where('coupon_code', $data['orderCoupon'])->first(); // orderCoupi là coupon_code
        if ($coupon) {
            $coupon->coupon_quantity -= 1; // trừ đi một mã
            $coupon->save();

            $customer->coupon_used = $customer->coupon_used . ',' . $data['orderCoupon'];
            $customer->save(); //lưu mã đã sử dụng vào customer để lần sau k cho nhập lại mã này nữa

            $couponCode = $coupon->coupon_code; //để gửi mail
        }else{
            $couponCode = 'Không có'; // để gửi mail
        }


        // đầu tiên lưu dữ liệu vào bảng shipping trước
        $shipping = new Shipping;
        $shipping->shipping_name = $data['shippingName'];
        $shipping->shipping_address = $data['shippingAddress'];
        $shipping->shipping_phone = $data['shippingPhone'];
        $shipping->shipping_email = $data['shippingEmail'];
        $shipping->shipping_notes = $data['shippingNotes'];
        $shipping->shipping_method_code = $data['shippingMethodCode'];
        $shipping->save();
        //lấy ra shipping_id để lát insert vào bảng order
        $shipping_id = $shipping->shipping_id;


        // sau khi thêm vào bảng tbl_shipping rồi thì ta thêm vào bảng tbl_order, thêm tbl_order vào trước vì ta phải lấy được hóa đơn thì ta mới xem được chi tiết đơn hàng
        $order = new Order;
        //random để trả ra chữ và số bất kì ,microtime là trả về thời gian tại thời điểm hiện tại bao gòm microseconds
        $orderCode = substr(md5(microtime()), rand(0, 26), 5);

        $order->customer_id = Session::get('customerId');
        $order->shipping_id = $shipping_id;
        if($data['paymentMethodCode'] == 'momo'){
            $orderStatus = 1; // chờ người dùng thanh toán
            $requestId = Str::uuid()->toString();  // requestId để gửi cho momo tạo đơn thanh toán

        }else if($data['paymentMethodCode'] == 'handcash'){
                $orderStatus = 2; //chờ admin xác nhận đơn
            $requestId =''; // requestId để gửi cho bên thanh toán, không có thì để trống
            }
        //pending: chờ giải quyết
        //pending payment : chờ thanh toán , áp dụng cho đơn hàng thanh toán online, khi thanh toán xong thì cập nhật lại thành processing
        //processing : đang xử lý, trả tiền rồi
        //done processing : đã xử lý xong, chờ vận chuyển
        // khi đơn hàng được khách hàng nhận  completed: hoàn thành

                /*1: pending payment
                  2: wait for confirmation
                  3:processing
                  4: done proessing*/
        $order->order_status = $orderStatus;
        $order->order_code = $orderCode;

        $order->payment_method_code = $data['paymentMethodCode'];
        $order->request_id = $requestId;
        $order->shipping_method_code = $data['shippingMethodCode'];
        $order->order_amount = $data['orderAmount']; // tổng tiền trong hóa đơn
        $order->created_at = Carbon::now('Asia/Ho_Chi_Minh');// ngày tạo đơn hàng bao gồm cả giờ
        $order->order_date = Carbon::now('Asia/Ho_Chi_Minh')->toDateString(); // ngày đặt hàng
        $order->save();

        // cuối cùng là thêm vào bảng tbl_order_details
        if (Session::get('cart')) {
            foreach (Session::get('cart') as $key => $cart) {
                $orderDetails = new OrderDetails(); // phải bỏ trong foreach không bỏ là nó chỉ thêm sản phẩm cuối cùng thui
                $orderDetails->order_code = $orderCode;
                $orderDetails->product_id = $cart['product_id'];
                $orderDetails->product_price = $cart['product_price'];
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
        //nếu thanh toán online thì chuyển đến trang của thanh toán, còn không thì chuyển qua trang historyOrder
        if($data['paymentMethodCode'] == 'momo'){
            //return \redirect('/orderHistory');
            //gửi thông tin để chuyển trang thanh toán
            $dataPayment = array(
                'paymentMethodCode' => 'momo',
                'orderCode' => $order->order_code,
                'requestId' => $requestId
            );
            echo json_encode($dataPayment);
        }else if($data['paymentMethodCode'] == 'handcash'){
            $dataPayment = array(
              'paymentMethodCode'=>'handcash',
            );
            echo json_encode($dataPayment);
        }
    }

}











/*    public function saveCheckoutCustomer(Request $req){
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

    }*/
/*public function payment(Request $req){
    $metaDes = "Giỏ hàng của bạn";
    $metaKeywords = "Giỏ hàng của bạn";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
    $metaTitle = "Payment"; // tiêu đề
    $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập

    return view('pages.checkout.payment')
        ->with('metaDes',$metaDes)
        ->with('metaKeywords',$metaKeywords)
        ->with('metaTitle',$metaTitle)
        ->with('urlCanonical',$urlCanonical);
}*/
/*
// Send mail confirm
$now = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
$title = "Đơn hàng bạn đã xác nhận mua lúc ".$now;

//lấy ra các sản phẩm trong giỏ hàng
foreach (Session::get('cart') as $key => $cartMail){
    $cartArray[] = array(   // khi xài mảng muốn lưu nhiều phần tử theo vòng lặp thì $cartArray[] , nếu không có[] thì nó thỉ lưu một phần tử cuối thồi
        'product_name'=> $cartMail['product_name'],
        'product_qty'=> $cartMail['product_qty'],
        'product_price'=> $cartMail['product_price'],
    );
} //cái này gọi là mảng đa chiều cái [] sẽ chứa [0] [1] khi nó thêm phần tử mới key là số nguyên nó sẽ tự tăng

//lấy phí ship
if(Session::get('feeship')){
    $feeship = Session::get('feeship');
}else{
    $feeship= 20000;
}
//lấy shipping , không cần lưu nhiều phần tử nên không cần kí tự []
$shippingArray = array(
    'feeship'=>$feeship, //lưa tạm vào đây
    'shipping_name' => $shipping->shipping_name,
    'shipping_address'=> $shipping->shipping_address,
    'shipping_phone'=> $shipping->shipping_phone,
    'shipping_email'=> $shipping->shipping_email,
    'shipping_method'=> $shipping->shipping_method,
    'shipping_notes'=>$shipping->shipping_notes

);
$email = $shipping->shipping_email; //lưu để gửi mail

//lưu mã đơn hàng và mã giảm giá
$orderArray = array(
    'coupon_code'=>$couponCode,
    'order_code'=> $order->order_code,
);

Mail::send('pages.mail.mailOrder',['cartArray'=>$cartArray,'shippingArray'=>$shippingArray,'orderArray'=>$orderArray],function($message) use ($title,$email){
    $message->to($email)->subject($title);
    $message->from($email,$title);
});*/
