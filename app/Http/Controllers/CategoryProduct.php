<?php

namespace App\Http\Controllers;
// sử dụng database
use App\Models\Gallery;
use App\Models\Product;
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
use Auth;
use Excel;
use App\Models\CatePost;
use Illuminate\Contracts\Support\Htmlable;

session_start();
class CategoryProduct extends Controller
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

    public function addCategoryProduct(){
        $this->authLogin();
        //lấy ra category parent
        $allCategoryParent = Category::where('category_parent',0)->get();
        return view('admin.category.addCategoryProduct')->with(compact('allCategoryParent'));
    }
    public function allCategoryProduct(){
        $this->authLogin();
        //cho danh mục cha hiện trước , sau đó sắp xếp lại danh mục con
        $allCategoryProduct = Category::orderby('category_parent','ASC')->orderby('category_order','ASC')->get();// lấy ra tất cả category product

        return view('admin.category.allCategoryProduct')->with(compact('allCategoryProduct'));
    }
    public function saveCategoryProduct(Request $req){
        $this->authLogin();
            $data = array();
            $data['category_name'] = $req->categoryName;
            $data['category_parent'] = $req->categoryParent;
            $data['category_des'] = $req->categoryDes;
           $data['category_slug'] = $req->categorySlug;
            $data['category_status'] = $req->categoryStatus;
             $data['meta_keywords'] = $req->metaKeywords;
        $data['category_order'] = 0; // sắp xếp thứu tự
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
             // lấy ra tất cả category Parent
            $allCategoryParent = Category::where('category_parent',0)->get();
            $editCategoryProduct = DB::table('tbl_category_product')->where('category_id',$categoryId)->get();
            return view('admin.category.editCategoryProduct')->with(compact('editCategoryProduct','allCategoryParent'));
    }
    public function updateCategoryProduct(Request $req,$categoryId){
        $this->authLogin();
        $data = array();
        $data['category_name'] = $req->categoryName;
        $data['category_slug'] = $req->categorySlug;
        $data['category_parent'] = $req->categoryParent;
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

    public function arrangeCategory(Request $req){
        $this->authLogin();

        //lấy cái mảng chứa id đã sắp xếp hồi nãy
        $arrayId = $req->page_id_array;
        foreach ($arrayId as $key => $categoryId){
            $category = Category::find($categoryId); // tìm từng id để update lại vị trí cho category
            $category->category_order = $key; // $key là vị trí mình sắp xếp
            $category->save();
        }
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

    //end function ADMIN PAGE


    // show list productByCategory
    public function productsByCategory(Request $req,$categorySlug){

        $categoryName = DB::table('tbl_category_product')->where('category_slug',$categorySlug)->get();
        $categoryProduct = DB::table('tbl_category_product')->where('category_parent','!=',0)
            ->orderBy('category_order','ASC')->get();

         //-----SEO-----\\

        // Lấy category bằng slug để cho vào seo và xử lý phía dưới
        $category = Category::where('category_slug',$categorySlug)->first();

        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = $category->category_des;
        //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaKeywords = $category->meta_keywords;
        // tiêu đề
        $metaTitle = $category->category_name;
        //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        $urlCanonical = $req->url();
        // ----------- End Seo -----------\\


        $productsByCategory = DB::table('tbl_product')
            ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
            ->where('tbl_category_product.category_slug',$categorySlug)
            ->get();
        if(isset($_GET['sortBy'])){ // nếu trên đưỡng dẫn tồn tại sortBy thì
            $sortBy = $_GET['sortBy']; //lấy giá thị của ?sortBy=value
                if($sortBy == 'tangDan'){
                        $productsByCategory = Product::with('category')
                            ->where('category_id',$category->category_id)
                            ->orderBy('product_price','ASC')
                        ->paginate(3)->appends($req->query());
                        //khi lọc có phân trang thì sang trang mình sẽ bị mất sortBy nên phải thêm appends($req->query()) phân trang với yêu cầu đường dẫn
                    }
                elseif($sortBy == 'giamDan'){
                   $productsByCategory = Product::with('category')
                       ->where('category_id',$category->category_id)
                       ->orderBy('product_price','DESC')->paginate(3)->appends($req->query());
                }
        }else{//khống có thì lấy sản phẩm mới thêm vào database
            $productsByCategory = Product::with('category')
                ->where('category_id',$category->category_id)
                ->orderBy('product_id','DESC')->paginate(4);
        }


    //gửi dữ liệu qua view
        return view('pages.category.productsByCategory')
            ->with(compact('categoryProduct',
                            'productsByCategory',
                            'categoryName',
                         'categorySlug',
                            'metaDes',
                            'metaKeywords',
                            'metaTitle',
                            'urlCanonical'));
    }




    public function productsByTab(Request $req){
        $productsByTab = Product::where('category_id',$req->categoryId)->orderby('product_id','ASC')->take(1)->get(); //sắp xếp tăng dần
        $output ='<div class="row isotope-grid" >';
        $count = $productsByTab->count();
        //nếu mà k có sản phẩn thì jquery trả cái bãng alert lỗi nên phải kiểm tra bước này
        if($count > 0){
            foreach ($productsByTab as $key => $product){
                $output .='
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
            <!-- Block2 -->
            <div class="block2">
                <div class="block2-pic hov-img0">
                    <img width="100%" height="300px" src="'.url('public/uploads/products/'.$product->product_image).'" alt="'.$product->product_name.'">

                    <a   href="'.url('/productDetail/'.$product->product_slug).'" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                         View detail
                    </a>
                </div>

                <div class="block2-txt flex-w flex-t p-t-14">
                    <div class="block2-txt-child1 flex-col-l ">
                        <a href="'.url('/productDetail/'.$product->product_slug).'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                            '.$product->product_name.'
                        </a>

                        <span class="stext-105 cl3">
									'.number_format($product->product_price,0,',','.').'đ
								</span>
                    </div>

                    <div class="block2-txt-child2 flex-r p-t-3">
                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                            <img class="icon-heart1 dis-block trans-04" src="'.url('/public/frontend2/images/icons/icon-heart-01.png').'" alt="ICON">
                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="'.url('/public/frontend2/images/icons/icon-heart-02.png').'" alt="ICON">
                        </a>
                    </div>
                </div>
            </div>
        </div>';
            // lastId chứa id cuối cùng của product trong vòng lặp để làm chức năng load more
                $lastProductId = $product->product_id;
            }
        }else{
            $output .= '
                <div class="col-sm-12">
                    <center><h4>There are currently no products in this category!</h4></center>
                </div>
            ';
        }


        $output .="</div>";

        if($count>0){
            $output .='<!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45 loadMore">
            <button class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="loadMoreButton" data-last_product_id="'.$lastProductId.'" data-category_id='.$req->categoryId.'>
                Load More
            </button>
        </div>';
        }

        echo $output;
    }
    public function loadMoreProducts(Request $req){
                // lấy sản phẩm có id < lastProductId bời vì khi lấy sản phẩm mình đã sắp xếp id từ lớn đến bé
        $products = Product::where('category_id',$req->categoryId)->where('product_id','>',$req->lastProductId)->take(1)->get();
        $count = $products->count();
        $output ='<div class="row isotope-grid" >';
        if($count > 0) {
            foreach ($products as $key => $product) {
                $output .= '
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
            <!-- Block2 -->
            <div class="block2">
                <div class="block2-pic hov-img0">
                    <img width="100%" height="300px" src="' . url('public/uploads/products/' . $product->product_image) . '" alt="' . $product->product_name . '">

                    <a   href="' . url('/productDetail/' . $product->product_slug) . '" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                         View detail
                    </a>
                </div>

                <div class="block2-txt flex-w flex-t p-t-14">
                    <div class="block2-txt-child1 flex-col-l ">
                        <a href="' . url('/productDetail/' . $product->product_slug) . '" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                            ' . $product->product_name . '
                        </a>

                        <span class="stext-105 cl3">
									' . number_format($product->product_price, 0, ',', '.') . 'đ
								</span>
                    </div>

                    <div class="block2-txt-child2 flex-r p-t-3">
                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                            <img class="icon-heart1 dis-block trans-04" src="' . url('/public/frontend2/images/icons/icon-heart-01.png') . '" alt="ICON">
                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="' . url('/public/frontend2/images/icons/icon-heart-02.png') . '" alt="ICON">
                        </a>
                    </div>
                </div>
            </div>
        </div>';
                // lastId chứa id cuối cùng của product trong vòng lặp để làm chức năng load more
                $lastProductId = $product->product_id;
            }
        }

        $output .= "</div>";


        // nếu không có dữ liệu thì không cho hiện nút load more
        if($count >0){
            $output .='<!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45 loadMore">
            <button class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="loadMoreButton" data-last_product_id="'.$lastProductId.'" data-category_id='.$req->categoryId.'>
                Load More
            </button>
        </div>';

        }else{
            $output .='<!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45 loadMore">
           No more product found
        </div>';
        }

        echo $output;
    }


}










/*public function productsByTab(Request $req){
    $productsByTab = Product::where('category_id',$req->categoryId)->orderby('product_id','DESC')->get();
    $output ='<div class="tab-content">
            <div class="tab-pane fade active in" id="tshirt" >';
    $count = $productsByTab->count();
    //nếu mà k có sản phẩn thì jquery trả cái bãng alert lỗi nên phải kiểm tra bước này
    if($count > 0){
        foreach ($productsByTab as $key => $product){
            $output .= '
                             <input type="hidden" id="wishlist" class="cartProductId-'.$product->product_id.'" value="'.$product->product_id.'">
                            <input type="hidden" id="wishlistProductName-'.$product->product_id.'" class="cartProductName-'.$product->product_id.'" value="'.$product->product_name.'">
                            <input type="hidden" class="cartProductImage-'.$product->product_id.'" value="'.$product->product_image.'">
                            <input type="hidden"  class="cartProductPrice-'.$product->product_id.'" value="'.$product->product_price.'">
                            <input type="hidden" class="cartProductQty-'.$product->product_id.'" value="1">
                            <input type="hidden" class="qtyProductInStock-'.$product->product_id.'" value="'.$product->product_quantity.'">


                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                             <a href="'.url('/productDetail/'.$product->product_slug).'">
                                <img src="'.url('public/uploads/products/'.$product->product_image).'" alt="" />
                                <h2>'.number_format($product->product_price,0,',','.').'đ</h2>
                                <p>'.$product->product_name.'</p>
                               </a>
                               <button class="btn btn-default add-to-cart" onclick="addToCart(this.data)" data-id="'.$product->product_id.'"><i class="fa fa-shopping-cart"></i>Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    }else{
        $output .= '
                <div class="col-sm-12">
                    <center><h4>There are currently no products in this category!</h4></center>
                </div>
            ';
    }

    $output .= '</div></div>';

    echo $output;
}*/
