<?php

namespace App\Http\Controllers;

// sử dụng database
use DB;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    //kiểm tra login
    public function authLogin(){
        $adminId = Session::get('adminId');
        if($adminId){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function allProduct(){
        $this->authLogin();
        $allProduct = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->orderby('product_id','desc')->get();//laays tất cả brand
        //chuyển tất brand qua view
        $managerProduct = view('admin.product.allProduct')->with('allProduct',$allProduct);
        // chuyển view chứa brand  vào layout admin để hiển thị
        return view('admin_layout')->with('admin.product.allProduct',$managerProduct);
    }
    public function addProduct(){
        $this->authLogin();
        $categoryProduct = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->orderby('brand_id','desc')->get();

        return view('admin.product.addProduct')->with('categoryProduct',$categoryProduct)->with('brandProduct',$brandProduct);
    }
    public function saveProduct(Request $req){
        $this->authLogin();
        $data = array();
        $data['product_name'] = $req->productName;
        $data['product_quantity'] = $req->productQty;
        $data['product_price'] = $req->productPrice;
        $data['product_des'] = $req->productDes;
        $data['product_content'] = $req->productContent;
        $data['category_id'] = $req->categoryId;
        $data['brand_id'] = $req->brandId;
        $data['product_status'] = $req->productStatus;
        $get_image = $req->file('productImage');
        //nếu có ảnh
        if($get_image){
            //lấy ra full tên hình vd : alo.jpg
            $getNameImage =$get_image->getClientOriginalName();
            //tách tên hình alo , xài hàm explode để tách chuỗi thành mảng tại một lý tự nào đó
            // mọi mảng đều có một phần tử đầu là phần tử hiện tại của nó
            // xài hàm current là lấy phần tử đầu là phần tử hiện tại , cps nghĩa là lấy ra được tên hình
            $nameImage = current(explode('.',$getNameImage));
            //name image + radom số để khỏi bị lặp,    getClientOriginalExtension là lấy đuôi của hình ảnh vd:jpg,png
            $new_image = $nameImage.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            // di chuyển ảnh , nếu đường dẫn chưa có thì nó tự tạo cho mình

            $get_image->move('public/uploads/products',$new_image);

            //lưu vào database
            $data['product_image'] = $new_image;

            DB::table('tbl_product')->insert($data);
            Session::put('message','Add successful product');
            return Redirect::to('/allProduct');
        }else{
            $data['product_image'] = '';
            DB::table('tbl_product')->insert($data);
            Session::put('message','Add successful product');
            return Redirect::to('/allProduct');
        }

    }

    public function unactiveProduct($productId){
        $this->authLogin();
        // điều kiện là $categoryId = category_id trong datebase , nếu bằng thì ta update nó
        DB::table('tbl_product')->where('product_id',$productId)->update(['product_status'=>0]);
        Session::put('message',' Product unactivation successful');
        return Redirect('allProduct');
    }
    public function activeProduct($productId){
        $this->authLogin();
        // điều kiện là $categoryId
        DB::table('tbl_product')->where('product_id',$productId)->update(['product_status'=>1]);
        Session::put('message','Product actived successfully');
        return Redirect('allProduct');
    }

    //edit -- delete -- update
    public function editProduct($productId){
        $this->authLogin();
        $categoryProduct = DB::table('tbl_category_product')->get();
        $brandProduct = DB::table('tbl_brand')->get();
        $editProduct = DB::table('tbl_product')->where('product_id',$productId)->get(); //

        /*$categoryProduct = DB::table('tbl_product')->where('category_id',$editProduct->category_id);
        $brandProduct = DB::table('tbl_product')->where('category_id',$editProduct->brand_id);*/

        $managerProduct = view('admin.product.editProduct')->with('editProduct',$editProduct)->with('categoryProduct',$categoryProduct)->with('brandProduct',$brandProduct);

        return view('admin_layout')->with('admin.product.editProduct',$managerProduct);
    }
    public function updateProduct(Request $req,$productId){
        $this->authLogin();

        $data = array();
        $data['product_name'] = $req->productName;
        $data['product_quantity'] = $req->productQty;
        $data['product_price'] = $req->productPrice;
        $data['product_des'] = $req->productDes;
        $data['product_content'] = $req->productContent;
        $data['category_id'] = $req->categoryId;
        $data['brand_id'] = $req->brandId;

        $get_image = $req->file('productImage');

        if($get_image){
            $getNameImage = $get_image->getClientOriginalName();
            // mọi mảng đều có một phần tử đầu là phần tử hiện tại của nó
            //nên ta xài hàm current để lấy ra phần tử đầu là tên hình đó,
            $nameImage = current(explode('.',$getNameImage));
           // xài hàm rand(0,99) để randum  số mục đính để tránh trùng tên hình
            $new_image = $nameImage.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            // di chuyển file hình tới chỗ mong muốn ta xài hàm move()
            $get_image->move('public/uploads/products',$new_image);
            // lưu tên hình mới vào database
            $data['product_image'] = $new_image;

            DB::table('tbl_product')->where('product_id',$productId)->update($data);
            Session::put('message','Update the product successfully');
            return Redirect::to('allProduct');
        }else{
            DB::table('tbl_product')->where('product_id',$productId)->update($data);
            Session::put('message','Update the product successfully');
            return Redirect::to('allProduct');
        }

    }
    public function deleteProduct($productId){
        $this->authLogin();

        DB::table('tbl_product')->where('product_id',$productId)->delete();
        Session::put('message','Product deleted successfully');
        return Redirect::to('allProduct');
    }

    //end Admin Pages
    public function productDetail(Request $req,$productId){

        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();

        $productDetail = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('product_id',$productId)->get();
        //product
        // lấy ra categoryId của product trên
        foreach($productDetail as $key => $value){
                $categoryId = $value->category_id;
            //----seo để cho google biết là google biết mình miêu tả trang web như thế này
            $metaDes = $value->product_des;
            $metaKeywords = $value->product_slug;  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
            $metaTitle = $value->product_name; // tiêu đề
            $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
            // ----------- End Seo -----------\\
        }
        // lấy các sản phẩm liên quan d=bằng cách lấy sản phẩm thuộc với category của product trên
        // trừ ra sản phẩm đã lấy được ở trên bằng hàm whereNotIn
        $productRelated = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('tbl_category_product.category_id',$categoryId)
            ->whereNotIn('tbl_product.product_id',[$productId])->get();


        return view('pages.product.showDetail')
            ->with('categoryProduct',$categoryProduct)
            ->with('brandProduct',$brandProduct)
            ->with('productDetail',$productDetail)
            ->with('productRelated',$productRelated)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);
    }




}
