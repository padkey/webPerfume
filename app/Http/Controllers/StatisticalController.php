<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Statistical;
use Carbon\Carbon;
use App\Models\Visitors; //nguời ghé thăm
use App\Models\Post;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Auth;
class StatisticalController extends Controller
{
    public function authLogin(){
        $adminId = Auth::id();
        if(!$adminId){
            return Redirect::to('admin')->send(); // phải thêm hàm send() ,không thêm là không được, không có thì cho về trang đăng nhập
        }
    }

    public function showDashboard(Request  $req){
        $this->authLogin();

        $userIpAddress = $req->ip(); // lấy địa chỉ ip hiện tại của mấy người đang vào trang web kể cả mình
        //current online
        $visitorsCurrent = Visitors::where('ip_address',$userIpAddress)->get();//select theo ipAddress, ipAddress của mỗi người mặc định là duy nhất
        $countCurrent = $visitorsCurrent->count(); // đếm xem coi có dữ liệu không
        if($countCurrent<1){ // nếu không có dữ liệu  của người truy cập thì thêm mới
                $newVisitor = new Visitors();
                $newVisitor->ip_address = $userIpAddress;
                $newVisitor->date_visitor = Carbon::now('Asia/Ho_Chi_Minh')->toDateString(); // ngày user truy cập vào trang web
                $newVisitor->save();
        }
        //lấy ra ngày hiện tại
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        //lấy ra đầu tháng này
        $earlyThisMonth = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString(); // toDateString() là hàm chuyển về định dạnh yyyy/mm/dd cho mình
        //lấy ra đầu tháng trước và cuối tháng trước  startOfMonth() là hàm lấy ngày đầu tháng
        $earlyLastMonth = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->subMonth()->toDateString(); //subMonth() là hàm trừ đi 1 tháng
        $endOfLastMonth = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth()->subMonth()->toDateString(); //endOfMonth() là hàm lấy ngày cuối tháng
        //lấy ra một năm
        $oneYear = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString(); //subDays trừ ngày

        //tổng truy cập tháng trước, lấy đầu tháng trước tới cuối tháng trước
        $visitorsLastMonth = Visitors::whereBetween('date_visitor',[$earlyLastMonth,$endOfLastMonth])->get()->count();
        //tổng truy cập tháng này, lấy đầu tháng tới ngày hiện tại
        $visitorsThisMonth = Visitors::whereBetween('date_visitor',[$earlyThisMonth,$now])->get()->count();
        //tổng truy cập 365 ngày tới ngày hiện tại
        $visitorsOneYear = Visitors::whereBetween('date_visitor',[$oneYear,$now])->get()->count(); //xài count đếm số lượng truy cập luôn
        //tổng lượng khách truy cập
        $visitorsTotal = Visitors::all()->count(); // all() là hàm lấy tất cả trong table_visitor , và xài count để đếm tất cả dữ liệu đó, lấy ra tổng


        //lấy tổng sản phẩm, bài viết, khách hàng,đơn hàng
        $products = Product::all()->count();
        $orders = Order::all()->count();
        $posts = Post::all()->count();
        $customers = Customer::all()->count();

        //lấy top 20 bài viết và sản phẩm được xem nhiều
        $postViews = Post::orderBy('post_views','DESC')->take(20)->get();
        $productViews = Product::orderBy('product_views','DESC')->take(20)->get();
        return view('admin.dashboard')
            ->with(compact('productViews','postViews','visitorsCurrent','visitorsThisMonth','visitorsLastMonth'
                ,'visitorsOneYear','visitorsTotal','products','posts','orders','customers'));
    }

    public function filterByDate(Request $req){
        $statistical = Statistical::whereBetween('order_date',[$req->fromDate,$req->toDate])
            ->orderBy('order_date','ASC')->get();

        foreach ($statistical as $key => $value){
            $chartData[] = array(
                'period' =>$value->order_date, // khoảng thời gian
                'total_order' => $value->total_order, // tổng đơn trong ngày
                'sales' => $value->sales, // doang số
                'profit'=> $value->profit, // lợi nhuận
                'quantity'=> $value->quantity,//số lượng đã bán trong ngày

            );

        }
        $data = json_encode($chartData);
        echo $data;
    }

    public function filterByChoose(Request $req){
        $choose = $req->choose;

        //lấy ngày hiện tại
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        //subDays là trừ cho bao nhiêu ngày
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString(); // toDateString dùng để format lại này giwof theo yyyy/mm/dd
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        //tháng này là lấy từ đầu tháng hiện tại đến hiện tại
        $earlyThisMonth = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->todateString(); // startOfmonth() là hàm lấy ngày 1 của tháng hiện tại

        //tháng trước là lấy khoảng thời gian từ đầu tháng trước đến cuối tháng trước
        $earlyLastMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString(); // subMonth() không có s là trừ cho một tháng
        $endOfLastMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString(); // endOfMonth() là hàm lấy ngày cuối thags
        if($choose == '7Days'){
            //từ 7 ngày trước đến ngày hiện tại, và sắp xếp order_date tăng dần
            $statistical = Statistical::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        }elseif($choose =='lastMonth'){
            //lấy khoảng thời gian từ đầu tháng trước đến cuối tháng trước
            $statistical = Statistical::whereBetween('order_date',[$earlyLastMonth,$endOfLastMonth])->orderBy('order_date')->get();
        }elseif ($choose == 'thisMonth'){
            $statistical = Statistical::whereBetween('order_date',[$earlyThisMonth,$now])->orderBy('order_date','ASC')->get();
        }elseif ($choose == '365Days'){
           $statistical = Statistical::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }

        foreach ($statistical as $key => $value){
            $chartData[] = array(
                'sales' => $value->sales, //doanh số
                'profit' => $value->profit, // lợi nhuận
                'period'=> $value->order_date, //khoảng thời gian
                'quantity' => $value->quantity, // số lượng bán trong ngày
                'total_order' => $value->total_order, //tổng số lượng đơn hàng
            );
        }
        $data = json_encode($chartData);
        echo $data;
    }


    public function chartDates(){
        //lấy ngày hiện tại và 3 này trước
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $sub3days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(3)->toDateString();

        $statistical = Statistical::whereBetween('order_date',[$sub3days,$now])->orderBy('order_date','ASC')->get();
        foreach($statistical as $key => $value){
            $chartData[] =  array(
              'sales' => $value->sales, //doanh số trong ngày
                'profit'=> $value->profit, // lợi nhuận trong ngày
                'quantity'=> $value->quantity,//sô lượng bán trong ngày
                'total_order'=>$value->total_order, // tổng số đơn hàng trong ngày
                'period'=> $value->order_date,
            );
        }
        $data = json_encode($chartData);
        echo $data;
    }
}
