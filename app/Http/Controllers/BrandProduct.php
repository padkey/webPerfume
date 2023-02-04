<?php

namespace App\Http\Controllers;

// sử dụng database
use App\Models\CatePost;
use Auth;
use App\Models\Brand; // sử dụng model
//sử dung session
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();
class BrandProduct extends Controller
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
    public function allBrandProduct(){
        $this->authLogin();
     //  $allBrandProduct = DB::table('tbl_brand')->get();//laays tất cả brand,static trong hướng đối được
        //$allBrandProduct = Brand::all(); //lất ra tất cả brand
        $allBrandProduct = Brand::orderBy('brand_id','DESC')->get(); //  lấy tất cả brand sắp xếp theo chiều id giảm dần
        //chuyển tất brand qua view
        $managerBrandProduct = view('admin.brand.allBrandProduct')->with('allBrandProduct',$allBrandProduct);
        // chuyển view chứa brand  vào layout admin để hiển thị
        return view('admin_layout')->with('admin.brand.allBrandProduct',$managerBrandProduct);
    }
    public function addBrandProduct(){
        $this->authLogin();
        return view('admin.brand.addBrandProduct');
    }
    public function saveBrandProduct(Request $req){
        $this->authLogin();
        $data = $req->all(); // lấy tất cả dữ liệu từ form
        $brand = new Brand();
        $brand->brand_name = $data['brandName'];
        $brand->brand_slug = $data['brandSlug'];
        $brand->meta_keywords = $data['metaKeywords'];
        $brand->brand_des = $data['brandDes'];
        $brand->brand_status = $data['brandStatus'];
        $brand->save(); // lưu dữ liệu

        /*$data['brand_name'] = $req->brandName;
        $data['brand_des'] = $req->brandDes;
        $data['brand_status'] = $req->brandStatus;
        DB::table('tbl_brand')->insert($data);*/

        Session::put('message','Add successful brand ');
        return Redirect::to('/allBrandProduct');
    }

    public function unactiveBrandProduct($brandId){
        $this->authLogin();

        // điều kiện là $categoryId = category_id trong datebase , nếu bằng thì ta update nó
        DB::table('tbl_brand')->where('brand_id',$brandId)->update(['brand_status'=>0]);
        Session::put('message',' Brand unactivation successful');
        return Redirect('allBrandProduct');
    }
    public function activeBrandProduct($brandId){
        $this->authLogin();
        // điều kiện là $categoryId
        DB::table('tbl_brand')->where('brand_id',$brandId)->update(['brand_status'=>1]);
        Session::put('message','Brand actived successfully');
        return Redirect('allBrandProduct');
    }

    //edit -- delete -- update
    public function editBrandProduct($brandId){
        $this->authLogin();
     //   $editBrandProduct = DB::table('tbl_brand')->where('brand_id',$brandId)->get();
        $editBrandProduct = Brand::find($brandId); // khi sử dụng find thì không cần vòng lặp foreach để truy xuất giá trị
        $managerBrandProduct = view('admin.brand.editBrandProduct')->with('editBrandProduct',$editBrandProduct);

        return view('admin_layout')->with('admin.brand.editBrandProduct',$managerBrandProduct);
    }
    public function updateBrandProduct(Request $req,$brandId){
        $this->authLogin();
        $data = array();
        $data['brand_name'] = $req->brandName;
        $data['brand_des'] = $req->brandDes;
        $data['brand_slug'] =  $req->brandSlug;
        $data['meta_keywords'] =  $req->metaKeywords;

        DB::table('tbl_brand')->where('brand_id',$brandId)->update($data);

        Session::put('message','Brand updated successfully');
        return Redirect::to('/allBrandProduct');
    }
    public function deleteBrandProduct($brandId){
        $this->authLogin();
        DB::table('tbl_brand')->where('brand_id',$brandId)->delete();
        Session::put('message','Brand deleted successfully');
        return Redirect::to('allBrandProduct');
    }
    //end ADMIN pages


    public function productsByBrand($brandSlug,Request $req){
        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $allCategoryPost = CatePost::where('category_post_status',1)->orderby('category_post_id','DESC')->get();

        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $brandName = DB::table('tbl_brand')->where('brand_slug',$brandSlug)->get();
        $getProductsByBrandId = DB::table('tbl_product')
            ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
            ->where('tbl_brand.brand_slug',$brandSlug)
            ->get();
        foreach ($brandProduct as $key => $value){
            //----seo để cho google biết là google biết mình miêu tả trang web như thế này
            $metaDes = $value->brand_des;
            //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
            $metaKeywords = $value->meta_keywords;
            // tiêu đề
            $metaTitle = $value->brand_name;
            //lấy ra đường dẫn hiện tại của trang mình đang truy cập
            $urlCanonical = $req->url();
            // ----------- End Seo -----------\\
        };
        return view('pages.brand.showBrand')
            ->with('categoryProduct',$categoryProduct)
            ->with('allCategoryPost',$allCategoryPost)
            ->with('brandProduct',$brandProduct)
            ->with('productsByBrand',$getProductsByBrandId)
            ->with('brandName',$brandName)
            ->with('metaDes',$metaDes)
            ->with('metaKeywords',$metaKeywords)
            ->with('metaTitle',$metaTitle)
            ->with('urlCanonical',$urlCanonical);
    }
}
