<?php

namespace App\Http\Controllers;

use App\Models\OrderDetails;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use App\Models\Customer;
use Mail;
use Illuminate\Support\Str; // để xài hàm random
use Socialite; // trang xã hội
use App\Models\SocialCustomers;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderStatus;
session_start();
class CustomerController extends Controller
{
    public function ensureLoggedIn(){
        if(Session::get('customerId')){
            echo 1;
        }else{
            echo -1;
        }
    }
    //customer
    public function  changePassword(Request $req){
        $customer = Customer::find(Session::get('customerId'));

        if($customer->customer_password === md5($req->oldPassword)){
            //thay đổi là lưu lại
                $customer->customer_password = md5($req->newPassword);
                $customer->save();
        }else{
            echo -1;
        }
    }
    public function profileCustomer(Request $req){
        $metaDes = "profile";
        $metaKeywords = "profile";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "profile"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        $customer = Customer::find(Session::get('customerId'));

        return view('pages.customer.profile')
            ->with(compact('customer','metaDes','metaKeywords','metaTitle','urlCanonical'));
    }
    public function editProfileCustomer(Request $req){
        $customerId= Session::get('customerId');
            Customer::where('customer_id',$customerId)
                ->update(['customer_name'=>$req->name,'customer_phone'=>$req->phone,'customer_address'=>$req->address]);

    }
    public function loginPage(Request $req)
    {
        $metaDes = "Đăng nhập";
        $metaKeywords = "Đăng nhập";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Đăng nhập"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập


        return view('pages.customer.login')
            ->with('metaDes', $metaDes)
            ->with('metaKeywords', $metaKeywords)
            ->with('metaTitle', $metaTitle)
            ->with('urlCanonical', $urlCanonical);
    }

    public function customerLogin(Request $req){
        //xóa session counpon phòng khi người dùng nhập mã xong mới đăng nhập, như vây mã đã được lưu trong session
        //khi người dùng đăng nhập phải xóa mã để kiểm tra xem mã đó người dùng đã sử dụng chưa
        Session::forget('coupon');


        $email = $req->emailAccount;
        $password = md5($req->passwordAccount);
        // first để lấy ra dữ liệu gọi được, không dùng get() bởi thì lấy dữ liệu bằng get() phải foreach() mới gọi được
        $customer = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($customer){
            Session::put('customerId',$customer->customer_id);
            Session::put('customerName',$customer->customer_name);
            echo '1';
        }else{
                echo '-1';
        }

    }
    public function logoutCustomer(){
        // sử dụng Session::flush() để xóa tất cả session
        Session::flush();
        return Redirect::to('/');

    }

    public function customerRegister(Request $req)
    {

        //kiểm tra email đã được đk trước đó chưa
        $checkEmail = Customer::where('customer_email',$req->email)->get();
       $count = $checkEmail->count();
       //nếu email tồn tại thì
        if($count > 0){
            echo -1;

        }else{ //thêm customer mới
            $customer = new Customer();
            $customer->customer_name = $req->name;
            $customer->customer_phone = $req->phone;
            $customer->customer_email = $req->email;
            $customer->customer_password = md5($req->password);
            $customer->save();

            // lúc này customer vừa được thêm nên ta có thể lấy id của customer
            Session::put('customerId',$customer->customer_id);
            Session::put('customerName',$customer->customer_name);
            echo 1;
        }


    }

    //Quên mật khẩu
    public function forgetPassword(Request $req){
        $customer = Customer::where('customer_email',$req->emailForget)->first();
        if($customer){
                $token = Str::random();
                $customer->customer_token = $token;
                $customer->save();

               $linkResetPassword = url('/resetPassword?token='.$token);

                //gửi mail
            $title = "Shop perfume Reset your password";

            // lưu các giữ liệu vào mảng $data
            $data = array("email"=>$customer->customer_email,"linkResetPassword"=>$linkResetPassword);

            Mail::send('pages.mail.forgetPassword',['data'=>$data],function ($message) use ($title,$data){
                $message->to($data['email'])->subject($title); // gửi đến mail với chủ về là $title
                $message->from($data['email'],$title);
            });
        }else{
            echo '-1';
        }

    }
    public function resetPassword(Request $req){
        $metaDes = "Reset password";
        $metaKeywords = "Reset password";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Reset password"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập

        $token = $_GET['token']; // lấy token trên đường dẫn
        $customer = Customer::where('customer_token',$token)->first();
        $customerEmail = $customer->customer_email;
        return view('pages.customer.resetPassword')
            ->with(compact('customerEmail','metaDes','metaKeywords','metaTitle','urlCanonical'));
    }
    public function updatePasswordReset(Request $req){
        $customer = Customer::where('customer_email',$req->email)->first();
        $customer->customer_password = md5($req->password);
        $customer->customer_token = '';
        $customer->save();
        //lưu tên id vào session
        Session::put('customerId',$customer->customer_id);
        Session::put('customerName',$customer->customer_name);

    }

    // ---------- login google ------------

    public function loginCustomerGG(){
        //phải xài đường dẫn callback mới vì dùng chung với admin thì lỗi
        config(['services.google.redirect'=>env('GOOGLE_CLIENT_URL')]); // lấy cái đường dẫn định nghĩa trong .env để google gửi về

        return Socialite::driver('google')->redirect();// chuyển sang trang đăng nhập google
    }

    //sau khi chuyển sang trang đăng nhập và đăng nhập đúng thì qua hàm này
    public function callbackCustomerGoogle(){
        config(['services.google.redirect'=>env('GOOGLE_CLIENT_URL')]); // lấy cái đường dẫn định nghĩa trong .env để google gửi về
        $user = Socialite::driver('google')->stateless()->user(); // lấy ra user mà google trả về


       $authUser = $this->findOrCreateNewCustomer($user,'GOOGLE');

//tại vì đã lưu email vào customer rùi thì lấy ra thui
        if($authUser){
            $account = Customer::where('customer_id',$authUser->user)->first(); // $authUser chứa dữ liệu của bảng tbl_social_customers nên không lấy cột customer_id so sánh mà lấy cột user
            Session::put('customerId',$account->customer_id);
            Session::put('customerPicture',$account->customer_picture);
            Session::put('customerName',$account->customer_name);
        }elseif ($newCustomer){
            $account = Customer::where('customer_id',$authUser->user)->first(); // $authUser chứa dữ liệu của bảng tbl_social_customers nên không lấy cột customer_id so sánh mà lấy cột user
            Session::put('customerId',$account->customer_id);
            Session::put('customerPicture',$account->customer_picture);
            Session::put('customerName',$account->customer_name);
        }


      return Redirect::to('/home');

    }
    //tìm kiếm hoặc tạo mới user
    public function findOrCreateNewCustomer($user,$provider){
        //kiểm tra xem tài khoản gg này tồn tại trong tbl_social_customers chưa
        $authUser = SocialCustomers::where('provider_user_id',$user->id)->first();
        if($authUser){ //nếu tồn tại thì trả về cái user vừa tìm được
                return $authUser;
        }else{ //không thì tạo mới
            //kiểm tra xem cái email user google đã tồn tại trong tbl_customers chưa
            $customer = Customer::where('customer_email',$user->email)->first();
            if(!$customer){ //nếu không có customer tạo mới
                $customer =  new Customer();
                $customer->customer_name = $user->name;
                $customer->customer_email=$user->email;
                $customer->customer_picture=$user->avatar;
                $customer->customer_password='';
                $customer->customer_phone='';
                $customer->save();
            }
            //tạo mới user trong tbl_social_custoer
            $newCustomer = new SocialCustomers([
               'provider_user_id'=> $user->id,
               'provider_user_email'=> $user->email,
               'provider'=> $provider,//nãy mình đưa vào hàm này chuỗi GOOGLE
            ]);// câu lệnh làm gọn thui , kiểu new xong cho giá trị bằng từng cái vd: $newCustomer->provider = $provider

            //tbl_social_customers nối với bảng tbl_customers rồi lấy khóa chính của tbl_customers gắn vào cột user của tbl_socical_customers
            $newCustomer->customer()->associate($customer);//kiểu lấy khóa chính của bảng customers gắn vào cột user của bảng tbl_social_customers

            $newCustomer->save();//lưu lại
            return $newCustomer;
        }
    }

    public function orderHistory(Request $req,$status){
        if(!Session::get('customerId')){
            return Redirect::to('/loginPage')->with('message','Vui lòng đăng nhập để xem lịch sử mua hàng');
        }

        $metaDes = "Lịch sử đơn hàng";
        $metaKeywords = "Lịch sử đơn hàng";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Lịch sử đơn hàng"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập

        $allOrderStatus = OrderStatus::all();
        //bằng 0 thì ta lấy tất cả
        if ($status == 0){
            $allOrder = Order::with('orderStatus')
            ->where('customer_id',Session::get('customerId'))
                ->orderBy('order_id','DESC')
                ->paginate(8);
            $orderStatus = $status; // gán để lát kiểm tra active

        }else{
            $allOrder = Order::with('orderStatus')->where('customer_id',Session::get('customerId'))
                ->where('order_status',$status)
                ->orderBy('order_id','DESC')
                ->paginate(8);
            $orderStatus = $status; // gán để lát kiểm tra active
        }

        return view('pages.customer.orderHistory')
            ->with(compact('allOrderStatus','orderStatus','allOrder','metaDes','metaKeywords','metaTitle','urlCanonical'));
    }

    public function viewOrderHistory(Request $req,$orderCode){
        if(!Session::get('customerId')){
            return Redirect::to('/loginPage')->with('message','Vui lòng đăng nhập để xem lịch sử mua hàng');
        }
        $metaDes = "Lịch sử đơn hàng";
        $metaKeywords = "Lịch sử đơn hàng";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Lịch sử đơn hàng"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập

        $orderDetails = OrderDetails::with('product')->where('order_code',$orderCode)->get();
        $order = Order::where('order_code',$orderCode)->first();
        //lấy shipping id
        $shipping =Shipping::find($order->shipping_id);
        //lấy customer
        $customer = Customer::find($order->customer_id);
        //lấy status order
        $orderStatus = $order->order_status;

        //lấy ra mã giảm giá
        foreach ($orderDetails as $key => $val){
            $couponCode = $val->product_coupon;
        }
        //nếu coupon là no  nghĩa là người dùng k nhập mã giảm giá ,thì cho couponCondition = 2 , couponNumber =0
        if($couponCode == 'no'){
            $couponCondition = 2;
            $couponNumber = 0;
        }else{
            //lấy ra coupon
            $coupon = Coupon::where('coupon_code',$couponCode)->first();
            $couponCondition = $coupon->coupon_condition;
            $couponNumber = $coupon->coupon_number;
        }


        return view('pages.customer.viewOrderHistory')
            ->with(compact('order','orderStatus','orderDetails','shipping','customer','couponNumber','couponCondition',
                'metaDes','metaKeywords','metaTitle','urlCanonical'));
    }
}
