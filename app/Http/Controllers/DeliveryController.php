<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\City; // sử dụng model
use App\Models\Province; // sử dụng model
use App\Models\Wards; // sử dụng model
use App\Models\Coupon;
use App\Models\Feeship;
//sử dung session
use Session;

use Illuminate\Support\Facades\Redirect;
session_start();
class DeliveryController extends Controller
{
    //
    public function addDelivery(){
       $allCity = City::orderBy('matp','DESC')->get();
        $allCoupon = Coupon::orderby('coupon_id','DESC')->get();
      return view('admin.delivery.addDelivery')->with(compact('allCity','allCoupon'));
    }
    public function selectDelivery(Request $req){
        $data = $req->all();
        if($data['action']){
            $output = '';
            if($data['action'] == 'city'){
                    $selectProvince = Province::where('matp',$data['id'])->orderby('maqh','ASC')->get();
                       //lặp để nối chuỗi  xong gửi qua lại ajax hiển thị trong select province
                $output = '<option>----Choose province ----</option>';
                foreach ($selectProvince as $key => $province){
                    $output .= '<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                };
            }
            else{
                $selectWards = Wards::where('maqh',$data['id'])->orderby('xaid','ASC')->get();
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

        $feeship = new Feeship();
            $feeship->fee_matp = $data['city'];
            $feeship->fee_maqh = $data['province'];
            $feeship->fee_xaid = $data['wards'];
            $feeship->fee_feeship = $data['feeShip'];
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
