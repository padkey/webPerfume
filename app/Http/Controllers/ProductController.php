<?php

namespace App\Http\Controllers;

// sử dụng database
use App\Models\CatePost;
use DB;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\Gallery;
use File;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Rating;
session_start();

class ProductController extends Controller
{
    //kiểm tra login
    public function authLogin(){
        $adminId = Auth::id();
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
            ->orderby('tbl_product.category_id','desc')->get();//laays tất cả brand
        //chuyển tất brand qua view
        $managerProduct = view('admin.product.allProduct')->with('allProduct',$allProduct);
        // chuyển view chứa brand  vào layout admin để hiển thị
        return view('admin_layout')->with('admin.product.allProduct',$managerProduct);
    }
    public function addProduct(){
        $this->authLogin();
        $categoryProduct = DB::table('tbl_category_product')->where('category_parent','!=',0)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->orderby('brand_id','desc')->get();

        return view('admin.product.addProduct')->with('categoryProduct',$categoryProduct)->with('brandProduct',$brandProduct);
    }
    public function saveProduct(Request $req){
        $this->authLogin();
        //xóa dấu phẩu trong giá tiền
        $productPrice = filter_var($req->productPrice,FILTER_SANITIZE_NUMBER_INT); // hàm này chỉ lấy kí tự là số, lọc các kí tự thừa
        $productCost = filter_var($req->productCost,FILTER_SANITIZE_NUMBER_INT); // hàm lọc để lấy các kí tự là số

        echo $productCost;

        $data = array();
        $data['product_name'] = $req->productName;
        $data['product_tags'] = $req->productTags;

        $data['product_quantity'] = $req->productQty;
        $data['product_slug'] = $req->productSlug;
        $data['product_sold'] = 0;
        $data['product_price'] = $productPrice;
        $data['product_cost'] = $productCost; //giá vốn
        $data['product_des'] = $req->productDes;
        $data['product_content'] = $req->productContent;
        $data['category_id'] = $req->categoryId;
        $data['brand_id'] = $req->brandId;
        $data['product_status'] = $req->productStatus;
        $get_image = $req->file('productImage');

        $pathProduct = 'public/uploads/products/';
        $pathGallery = 'public/uploads/gallery/';
        //nếu có ảnh
        if($get_image){
            //lấy ra full tên hình vd : alo.jpg
            $getNameImage =$get_image->getClientOriginalName();
            //tách tên hình alo , xài hàm explode để tách chuỗi thành mảng tại một lý tự nào đó
            // mọi mảng đều có một phần tử đầu là phần tử hiện tại của nó
            // xài hàm current là lấy phần tử đầu là phần tử hiện tại , cps nghĩa là lấy ra được tên hình
            $nameImage = current(explode('.',$getNameImage));
            //name image + radom số để khỏi bị lặp,    getClientOriginalExtension là lấy đuôi của hình ảnh vd:jpg,png
            $newName = $nameImage.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            // di chuyển ảnh , nếu đường dẫn chưa có thì nó tự tạo cho mình
            $get_image->move($pathProduct,$newName);

            //lưu vào database
            $data['product_image'] = $newName;


        }
       $productId = DB::table('tbl_product')->insertGetId($data);

        //lưu hình vào gallery
        $gallery = new Gallery();
        $gallery->product_id = $productId;
        $gallery->gallery_image = $newName;
        $gallery->gallery_name = $newName;
        $gallery->save();
        //phải coppy file trong thư mục product, move 2 lần sẽ bị lỗi
        File::copy($pathProduct.$newName,$pathGallery.$newName);

        Session::put('message','Add successful product');
        return Redirect::to('/allProduct');
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
        $categoryProduct = DB::table('tbl_category_product')->where('category_parent','!=',0)->get();
        $brandProduct = DB::table('tbl_brand')->get();
        $editProduct = DB::table('tbl_product')->where('product_id',$productId)->get(); //


        $managerProduct = view('admin.product.editProduct')->with('editProduct',$editProduct)->with('categoryProduct',$categoryProduct)->with('brandProduct',$brandProduct);

        return view('admin_layout')->with('admin.product.editProduct',$managerProduct);
    }
    public function updateProduct(Request $req,$productId){
        $this->authLogin();
        $data = array();
        // lọc kí tự thừa chỉ lấy kí tự số
        $productPrice = filter_var($req->productPrice,FILTER_SANITIZE_NUMBER_INT);
        $productCost = filter_var($req->productCost,FILTER_SANITIZE_NUMBER_INT);
        $data['product_name'] = $req->productName;
        $data['product_tags'] = $req->productTags;
        $data['product_quantity'] = $req->productQty;
        $data['product_slug'] = $req->productSlug;
        $data['product_price'] = $productPrice;
        $data['product_cost'] = $productCost; // giá vốn
        $data['product_des'] = $req->productDes;
        $data['product_content'] = $req->productContent;
        $data['category_id'] = $req->categoryId;
        $data['brand_id'] = $req->brandId;

        $get_image = $req->file('productImage');
    $get_image = $req->file('productImage');

        if($get_image){
            $getNameImage = $get_image->getClientOriginalName();
            // mọi mảng đều có một phần tử đầu là phần tử hiện tại của nó
            //nên ta xài hàm current để lấy ra phần tử đầu là tên hình đó,
            $nameImage = current(explode('.',$getNameImage));
           // xài hàm rand(0,99) để randum  số mục đính để tránh trùng tên hình
            $newName = $nameImage.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            // di chuyển file hình tới chỗ mong muốn ta xài hàm move()
            $get_image->move('public/uploads/products',$newName);
            // lưu tên hình mới vào database
            $data['product_image'] = $newName;

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
    public function productDetail(Request $req,$productSlug){
        $productDetail = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('product_slug',$productSlug)->get();
        //product
        // lấy ra categoryId của product trên
        foreach($productDetail as $key => $value){
            $categorySlug = $value->category_slug;
            $categoryName = $value->category_name;
            //----seo để cho google biết là google biết mình miêu tả trang web như thế này
            $metaDes = $value->product_des;
            $metaKeywords = $value->product_slug;  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
            $metaTitle = $value->product_name; // tiêu đề
            $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
            // ----------- End Seo -----------\\

            //lấy gallery
            $gallery = Gallery::where('product_id',$value->product_id)->get();
            //lấy Rating
            $rating = Rating::where('product_id',$value->product_id)->avg('rating'); //avg('rating') là hàm tính trung bình cộng của cột rating
            $rating = round($rating); //hàm round là hàm làm tròn


        }
        //cập nhật lượt xem cho product
        $product =  Product::where('product_slug',$productSlug)->first();
        $product->product_views = $product->product_views +1;
        $product->save();


        // lấy các sản phẩm liên quan bằng cách lấy những sản phẩm thuộc với category của product trên
        // trừ ra sản phẩm đã lấy được ở trên bằng hàm whereNotIn
        $productRelated = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('tbl_category_product.category_slug',$categorySlug)
            ->whereNotIn('tbl_product.product_slug',[$productSlug])->get();


        return view('pages.product.productDetail')
            ->with(compact('rating','urlCanonical','metaTitle',
                'metaKeywords','metaDes','productRelated','productDetail',
                'gallery','categoryName','categorySlug'));

    }

    public function tag(Request $req,$productTag){

        $tag = str_replace('-',' ',$productTag);

        $productByTag = Product::where('product_status',1)
            ->where('product_name','LIKE','%'.$tag.'%')
            ->orwhere('product_slug','LIKE','%'.$tag.'%')
            ->orwhere('product_tags','LIKE','%'.$tag.'%')
            ->get();
        //product


            //----seo để cho google biết là google biết mình miêu tả trang web như thế này
            $metaDes = 'Tags : '.$tag;
            $metaKeywords = $tag;  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
            $metaTitle = $tag; // tiêu đề
            $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
            // ----------- End Seo -----------\\


        return view('pages.product.tag')
            ->with(compact('urlCanonical','metaTitle',
                'metaKeywords','metaDes','productByTag'
            ));
    }

   /* //quickView
    public function quickViewProduct(Request $req){
        $productDetail = Product::find($req->productId);
        $output['product_name'] = $productDetail->product_name;
        $output['product_price'] = number_format($productDetail->product_price,0,',','.').'đ';
        $output['product_des'] =$productDetail->product_des;
        $output['product_image'] = '<p><img style="width: 100%" src="'.url('public/uploads/products/'.$productDetail->product_image).'"></p>';

        //lấy gallery
     //   $output['gallery'] = '<ul id="imageGallery" >';   data-src="'.url('public/uploads/gallery/'.$gal->gallery_image).'"
        $output['gallery'] = ' <div class="wrap-slick3 flex-sb flex-w" >
                                <div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
								<div class="slick3 gallery-lb">';
        $gallery = Gallery::where('product_id',$req->productId)->get();

        foreach ($gallery as $key => $gal){

            $output['gallery'] .='
                                     <div class="item-slick3" data-thumb="'.url('public/uploads/gallery/'.$gal->gallery_image).'">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="'.url('public/uploads/gallery/'.$gal->gallery_image).'" alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="'.url('public/uploads/gallery/'.$gal->gallery_image).'">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>';
        }
        $output['gallery'] .= '</div></div>';

        //gửi luôn cả giá trị cần thiết để add vào cart
        $output['quickViewProductValue'] = '<input type="hidden" class="cartProductId-'.$productDetail->product_id.'" value="'.$productDetail->product_id.'">
                            <input type="hidden" class="cartProductName-'.$productDetail->product_id.'" value="'.$productDetail->product_name.'">
                            <input type="hidden" class="cartProductImage-'.$productDetail->product_id.'" value="'.$productDetail->product_image.'">
                            <input type="hidden" class="cartProductPrice-'.$productDetail->product_id.'" value="'.$productDetail->product_price.'">
                             <input type="hidden" class="qtyProductInStock-'.$productDetail->product_id.'" value="'.$productDetail->product_quantity.'"> ';

        //gửi thêm cái input product quantity
        //Vì khi chạy vòng lặp duyệt sản phẩm ra trang home  đã có một cái class cartProductQty-id set giá trị mặc định mặc định là 1 rồi nên không thể tăng số lượng lên được nữa
        $output['inputProductQty'] = '<input type="number"  class="cartProductQty-'.$productDetail->product_id.'" value="1" min="1">';
        //gửi cái button Addtocart với dataid qua luôn
        $output['btnAddToCart']= '<button type="button" class="btn btn-default cart add-to-cart" name="addToCart" data-id="'.$productDetail->product_id.'">Add To Cart</button>';
        //phải json_decode chuyển thành kiểu json mới gửi qua ajax cho dễ xài
        echo json_encode($output);
    }*/


}
