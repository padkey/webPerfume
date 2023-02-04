<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Models\Province; // sử dụng model
use App\Models\District; // sử dụng model
use App\Models\Ward; // sử dụng model
use App\Models\Coupon;
use App\Models\Feeship;
//sử dung session
use Session;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
session_start();
class DeliveryController extends Controller
{ //selectShippingCarrier  selectFeeship2
    public function selectFeeship2(){


    }
    public function createOrder(){
        $sendOrder = Http::withHeaders([
            'Content-type'=> 'application/json',
            'Token'=>'69016Db27CDD40d246449B944486b70869Bdf1Ef'
        ])->post('https://services.giaohangtietkiem.vn/services/shipment/order/?ver=1.5 HTTP/1.1',[
            "products"=> [
            "name"=> "bút",
        "weight"=> 0.1,
        "quantity"=>1,
        "product_code"=> 1241
    ],

            'order' => [
            "id" => "a4",
        "pick_name"=>"HCM-nội thành",
        "pick_address"=> "590 CMT8 P.11",
        "pick_province"=> "TP. Hồ Chí Minh",
        "pick_district"=> "Quận 3",
        "pick_ward"=> "Phường 1",
        "pick_tel"=> "0911222334",
        "tel"=> "0911222333",
        "name"=>"GHTK - HCM - Noi Thanh",
        "address"=> "123 nguyễn chí thanh",
        "province"=> "TP. Hồ Chí Minh",
        "district"=> "Quận 1",
        "ward"=> "Phường Bến Nghé",
        "hamlet"=> "Khác",
        "is_freeship"=> "1",
        "pick_date"=> "2016-09-30",
        "pick_money"=> 47000,
        'weight_option'=>'gram', // tính khối lượng đơn hàng bằng đơn vị
        'total_weight'=>100, // tổng khối lượng đơn hang
        "note"=>"Khối lượng tính cước tối đa: 1.00 kg",
        "value"=> 3000000,
        "transport"=> "road",
        "pick_option"=>"cod" ,// Đơn hàng xfast yêu cầu bắt buộc pick_option là COD
        "deliver_option" => "none",
       // "pick_session" => 2, // Phiên lấy xfast
        "tags"=> [1]
        ]

        ]);
        print_r(json_decode($sendOrder));
    }
    public function selectShippingCarrier (){
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
               $leadTime = date("Y-m-d", $leadTime->data->leadtime);
               $fromDate =  Carbon::create($leadTime)->format('d/m/Y');
               $toDate = Carbon::create($fromDate)->addDays(2)->format('d/m/Y'); // thêm ngày
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
           $now =  Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
           $leadTime = Carbon::create($now)->addDays(3);
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




    //admin Page
    public function addDelivery(){
       $allCity = Province::orderBy('matp','DESC')->get();
        $allCoupon = Coupon::orderby('coupon_id','DESC')->get();
      return view('admin.delivery.addDelivery')->with(compact('allCity','allCoupon'));
    }
    public function selectDelivery(Request $req){
        $data = $req->all();
        if($data['action']){
            $output = '';
            if($data['action'] == 'city'){
                    $selectProvince = District::where('matp',$data['id'])->orderby('maqh','ASC')->get();
                       //lặp để nối chuỗi  xong gửi qua lại ajax hiển thị trong select province
                $output = '<option>----Choose province ----</option>';
                foreach ($selectProvince as $key => $province){
                    $output .= '<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                };
            }
            else{
                $selectWards = Ward::where('maqh',$data['id'])->orderby('xaid','ASC')->get();
                $output = '<option>----Choose wards ----</option>';
                foreach ($selectWards as $key => $wards){
                    $output .='<option value="'.$wards->xaid.'">'.$wards->name_xaphuong.'</option>';
                }
            }
            echo $output; // gửi dữ liêu qua ajax
        }

    }
    public function saveDelivery(Request $req){
        $data = $req->all();
        // lọc kí tự thừa chỉ lấy kí tự số
        $fee_feeship = filter_var($data['feeShip'],FILTER_SANITIZE_NUMBER_INT);

        $feeship = new Feeship();
            $feeship->fee_matp = $data['city'];
            $feeship->fee_maqh = $data['province'];
            $feeship->fee_xaid = $data['wards'];
            $feeship->fee_feeship = $fee_feeship; // phí vận chuyển
            $feeship->save();
    }
    public function selectFeeship(Request $req ){
        $allFeeship = Feeship::orderby('fee_id','DESC')->get();
        $output = '<div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>City</th>
                        <th>Province</th>
                        <th>Wards</th>
                        <th>Feeship</th>
                        </tr>
                    </thead>
                    <tbody>
            ';
        foreach($allFeeship as $key => $fee){
            $output .=' <tr>
                            <td>'.$fee->city->name_thanhpho.'</td>
                            <td>'.$fee->province->name_quanhuyen.'</td>
                            <td>'.$fee->wards->name_xaphuong.'</td>
                            <td contenteditable data-feeship_id="'.$fee->fee_id.'"class = "fee_feeship_edit">'. number_format($fee->fee_feeship,0,',','.') .'</td>
                    </tr>';
        };
        $output.= '</tbody> </table> </div>';
        echo $output;


    }
    public function updateFeeship(Request $req){
        $data = $req->all();
        $feeshipValue = implode('',explode('.',$data['feeshipValue']));   // cắt chuỗi tại dấu chấm thành mảng , xong xài implode để gộp lại
        $feeship = Feeship::find($data['feeshipId']); // hàm find là mặc định tình Id
        $feeship->fee_feeship = $feeshipValue;
        // lưu lại bằng save()
        $feeship->save();
       // echo $feeship;
    }
}
