<?php

namespace App\Http\Controllers;
// sử dụng database
use DB;
use App\Models\Category;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Imports\ExcelImports;
use App\Exports\ExcelExports;
use App\Imports\ImportProduct;
use App\Exports\ExportProduct;
use Excel;

session_start();
class CategoryProduct extends Controller
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

    public function addCategoryProduct(){
        $this->authLogin();
        return view('admin.category.addCategoryProduct');
    }
    public function allCategoryProduct(){
        $this->authLogin();
        $allCategoryProduct = DB::table('tbl_category_product')->get(); // lấy ra tất cả category product
        $managerCategoryProduct = view('admin.category.allCategoryProduct')->with('allCategoryProduct',$allCategoryProduct);//hiện thỉ file allcategoryproduct, gán allCategoryProduc hồi nãy lấy bằng with

        return view('admin_layout')->with('admin.category.allCategoryProduct',$managerCategoryProduct); // trang admin layout sẽ chứa allcategoryProduc luôn
    }
    public function saveCategoryProduct(Request $req){
        $this->authLogin();
            $data = array();
            $data['category_name'] = $req->categoryName;
            $data['category_des'] = $req->categoryDes;
           $data['category_slug'] = $req->categorySlug;
            $data['category_status'] = $req->categoryStatus;
             $data['meta_keywords'] = $req->metaKeywords;
            DB::table('tbl_category_product')->insert($data);
            Session::put('message','Add successful category');
           return Redirect::to('/addCategoryProduct');
    }
    public function unactiveCategoryProduct($categoryId){
        $this->authLogin();
        // điều kiện là $categoryId = category_id trong datebase , nếu bằng thì ta update nó
        DB::table('tbl_category_product')->where('category_id',$categoryId)->update(['category_status'=>0]);
        Session::put('message',' Category unactivation successful');
        return Redirect('allCategoryProduct');
    }
    public function activeCategoryProduct($categoryId){
        $this->authLogin();
        // điều kiện là $categoryId
        DB::table('tbl_category_product')->where('category_id',$categoryId)->update(['category_status'=>1]);
        Session::put('message','Category actived successfully');
        return Redirect('allCategoryProduct');
    }

    //edit -- delete -- update
    public function editCategoryProduct($categoryId){
        $this->authLogin();
            $editCategoryProduct = DB::table('tbl_category_product')->where('category_id',$categoryId)->get(); // limit 1
            $managerCategoryProduct = view('admin.editCategoryProduct')->with('editCategoryProduct',$editCategoryProduct);

            return view('admin_layout')->with('admin.category.editCategoryProduct',$managerCategoryProduct);
    }
    public function updateCategoryProduct(Request $req,$categoryId){
        $this->authLogin();
        $data = array();
        $data['category_name'] = $req->categoryName;
        $data['category_slug'] = $req->categorySlug;

        $data['category_des'] = $req->categoryDes;
        $data['meta_keywords'] = $req->metaKeywords;
        DB::table('tbl_category_product')->where('category_id',$categoryId)->update($data);

        Session::put('message','Category updated successfully');
        return Redirect::to('/allCategoryProduct');
    }
    public function deleteCategoryProduct($categoryId){
        $this->authLogin();
        DB::table('tbl_category_product')->where('category_id',$categoryId)->delete();
        Session::put('message','Category deleted successfully');
        return Redirect::to('allCategoryProduct');
    }
    //end function ADMIN PAGE

    public function showCategoryHome(Request $req,$categoryId){


        $categoryName = DB::table('tbl_category_product')->where('category_id',$categoryId)->get();
        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $productsByCategory = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->where('tbl_product.category_id',$categoryId)
            ->get();
            foreach ($categoryProduct as $key => $value){
                //----seo để cho google biết là google biết mình miêu tả trang web như thế này
                $metaDes = $value->category_des;
                //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
                $metaKeywords = $value->meta_keywords;
                // tiêu đề
                $metaTitle = $value->category_name;
                //lấy ra đường dẫn hiện tại của trang mình đang truy cập
                $urlCanonical = $req->url();
                // ----------- End Seo -----------\\
            };
        return view('pages.category.showCategory')
            ->with(compact('categoryProduct',
                            'brandProduct',
                            'productsByCategory',
                            'categoryName',
                            'metaDes',
                            'metaKeywords',
                            'metaTitle',
                            'urlCanonical'));

    }
    //import - export
    public function export_csv(){
        return Excel::download(new ExcelExports , 'CategoryProduct.xlsx');
    }

    public function import_csv(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ExcelImports, $path);
        return back();
    }
    public function export_csv_product(){
        return Excel::download(new ExportProduct , 'Product.xlsx');
    }

    public function import_csv_product(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportProduct, $path);
        return back();
    }


}
