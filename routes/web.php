<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryPost;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CkeditorController; //đê upload ảnh cục bộ bằng ckeditor thì mình phải tự cài đặt
use App\Http\Controllers\StatisticalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\payment\PaypalController;
use App\Http\Controllers\payment\MomoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


                        //********************** =====  FRONT END ===== ***********************\\
//payment
//momo
Route::get('/test2',[MomoController::class,'test2']);
Route::get('/test3',[MomoController::class,'refund']);

Route::get('/addOrderMomo2',[MomoController::class,'addOrderMomo2']);
Route::post('/paymentByMomo',[MomoController::class,'paymentByMomo']);
Route::get('/addOrderMomo',[MomoController::class,'addOrderMomo']);

//paypaladd
Route::get('/paypal', [PaypalController::class, 'payment']);
Route::get('/paypal/capture', [PaypalController::class, 'capture'])->name('paypal.capture');



Route::get('/test',[DeliveryController::class,'createOrder']);
Route::post('/selectShippingCarrier',[DeliveryController::class,'selectShippingCarrier']);
Route::post('/chooseShippingCarrier',[CheckoutController::class,'chooseShippingCarrier']);

// Change Language
Route::get('lang/{locale}',function ($locale){
   if(!in_array($locale,['en','vi'])){
       abort(404); //không tồn tại en , vi thì trảng về trang 404
   }
   //lưu ngôn ngữ vào session
   session()->put('locale',$locale); //locale = địa phương
    return redirect()->back();
});

Route::get('/', [HomeController::class,'index']);
Route::get('/home',[HomeController::class,'index']);

//===========search============
Route::post('/search',[HomeController::class,'search']);
//tự động gợi ý
Route::post('/autocomplete',[HomeController::class,'autocomplete']);
// thêm đánh giá sao


//===================== Category ====================================

Route::get('/productsByCategory/{categorySlug}',[CategoryProduct::class,'productsByCategory']);
Route::post('/productsByTab',[CategoryProduct::class,'productsByTab']);
Route::post('/loadMoreProducts',[CategoryProduct::class,'loadMoreProducts']);
//===================== Brand ====================================

Route::get('/productsByBrand/{brandSlug}',[BrandProduct::class,'productsByBrand']);


//=======================Product =========================

Route::get('/productDetail/{productSlug}',[ProductController::class,'productDetail']);

//============================ Comment ==============================

Route::post('/loadComment',[CommentController::class,'loadComment']);
Route::post('/sendComment',[CommentController::class,'sendComment']);


// ========================== Rating ===================================
Route::post('/insertRating',[RatingController::class,'insertRating']);

// =========================== Contact =============================
Route::get('/showContact',[ContactController::class,'showContact']);


//=============================== Quick view ========================================
Route::post('/quickViewProduct',[ProductController::class,'quickViewProduct']);


//============================== Cart ===============================
Route::post('/saveCart',[CartController::class,'saveCart']);
Route::get('/showCartQty',[CartController::class,'showCartQty']); //show số lượng item cạnh giỏ hàn
Route::get('/showCartMenu',[CartController::class,'showCartMenu']); //show menu giỏ hàng khi hover
//Delete
Route::get('/deleteToCart/{rowId}',[CartController::class,'deleteToCart']);
Route::get('/delProduct/{sessionId}',[CartController::class,'delProduct']);
Route::get('/deleteAllProduct',[CartController::class,'deleteAllProduct']);
//update
Route::post('/updateQuantityCart',[CartController::class,'updateQuantityCart']);
Route::post('/updateCart',[CartController::class,'updateCart']);

Route::post('/addToCartAjax',[CartController::class,'addToCartAjax']);
Route::get('/showCart',[CartController::class,'showCart']);

//============================ Checkout ===============================
Route::get('/checkout',[CheckoutController::class,'checkout']);
Route::post('/saveCheckoutCustomer',[CheckoutController::class,'saveCheckoutCustomer']);
Route::get('/payment',[CheckoutController::class,'payment']);
Route::post('/orderPlace',[CheckoutController::class,'orderPlace']);

Route::post('/selectDeliveryHome',[CheckoutController::class,'selectDeliveryHome']);
Route::post('/calculateFeeship',[CheckoutController::class,'calculateFeeship']);

Route::post('/updateShippingInfo',[CheckoutController::class,'updateShippingInfo']);

Route::post('/confirmOrder',[CheckoutController::class,'confirmOrder']);
Route::get('/delFeeship',[CheckoutController::class,'delFeeship']);


//============================ Customer ==================================
Route::get('/loginPage',[CustomerController::class,'loginPage']);
Route::post('/customerLogin',[CustomerController::class,'customerLogin']);

Route::post('/customerRegister',[CustomerController::class,'customerRegister']);
Route::get('/logoutCustomer',[CustomerController::class,'logoutCustomer']);
Route::post('/forgetPassword',[CustomerController::class,'forgetPassword']);
Route::get('/resetPassword',[CustomerController::class,'resetPassword']);
Route::post('/updatePasswordReset',[CustomerController::class,'updatePasswordReset']);

Route::get('/loginCustomerGG',[CustomerController::class,'loginCustomerGG']);
Route::get('/customer/google/callback',[CustomerController::class,'callbackCustomerGoogle']);
Route::get('/loginCustomerFB',[CustomerController::class,'loginCustomerFB']);

Route::get('/orderHistory/{status}',[CustomerController::class,'orderHistory']);
Route::get('/orderByStatus/{status}',[CustomerController::class,'orderByStatus']);
Route::get('/viewOrderHistory/{orderCode}',[CustomerController::class,'viewOrderHistory']);
Route::post('/cancelOrder',[OrderController::class,'cancelOrder']);



Route::get('/profileCustomer',[CustomerController::class,'profileCustomer']);
Route::post('/editProfileCustomer',[CustomerController::class,'editProfileCustomer']);
Route::post('/ensureLoggedIn',[CustomerController::class,'ensureLoggedIn']);

Route::post('/changePassword',[CustomerController::class,'changePassword']);
//========================== Coupon ==========================================

Route::post('/checkCoupon',[CartController::class,'checkCoupon']);
Route::get('/deleteCouponCode',[CartController::class,'deleteCouponCode']);


//==================================== POSTS ==========================================

Route::get('/listPostByCate/{categoryPostSlug}',[PostController::class,'listPostByCate']);
Route::get('/postDetail/{postSlug}',[PostController::class,'postDetail']);

//============================ VIDEO ==================================================

Route::get('/listVideo',[VideoController::class,'listVideo']);
Route::post('/watchVideo',[VideoController::class,'watchVideo']);


//=========================== TAGS ====================================

Route::get('/tag/{productTag}',[ProductController::class,'tag']);


                    //********************** =====  BACK END ===== ************************\\



// ========================= Admin ====================================

Route::get('/admin',[AdminController::class,'index']);
// admin đăng nhập
Route::post('/adminDashboard',[AdminController::class,'dashboard']);
// đăng xuất
Route::get('/logout',[AdminController::class,'logout']);

// ======================== Category-product ==============================

Route::get('/addCategoryProduct',[CategoryProduct::class,'addCategoryProduct']);
Route::get('/allCategoryProduct',[CategoryProduct::class,'allCategoryProduct']);
Route::post('/saveCategoryProduct',[CategoryProduct::class,'saveCategoryProduct']);

Route::get('/unactiveCategoryProduct/{categoryId}',[CategoryProduct::class,'unactiveCategoryProduct']);
Route::get('/activeCategoryProduct/{categoryId}',[CategoryProduct::class,'activeCategoryProduct']);
// edit - delete category
Route::get('/editCategoryProduct/{categoryId}',[CategoryProduct::class,'editCategoryProduct']);
Route::get('/deleteCategoryProduct/{categoryId}',[CategoryProduct::class,'deleteCategoryProduct']);
Route::post('/updateCategoryProduct/{categoryId}',[CategoryProduct::class,'updateCategoryProduct']);
//import  - export file
Route::post('/export-csv',[CategoryProduct::class,'export_csv']);
Route::post('/import-csv',[CategoryProduct::class,'import_csv']);
//sắp xếp
Route::post('/arrangeCategory',[CategoryProduct::class,'arrangeCategory']);


//============================ Brand ==================================================

Route::get('/addBrandProduct',[BrandProduct::class,'addBrandProduct']);
Route::get('/allBrandProduct',[BrandProduct::class,'allBrandProduct']);
Route::post('/saveBrandProduct',[BrandProduct::class,'saveBrandProduct']);

Route::get('/unactiveBrandProduct/{BrandId}',[BrandProduct::class,'unactiveBrandProduct']);
Route::get('/activeBrandProduct/{BrandId}',[BrandProduct::class,'activeBrandProduct']);
// edit - delete category
Route::get('/editBrandProduct/{BrandId}',[BrandProduct::class,'editBrandProduct']);
Route::get('/deleteBrandProduct/{BrandId}',[BrandProduct::class,'deleteBrandProduct']);
Route::post('/updateBrandProduct/{BrandId}',[BrandProduct::class,'updateBrandProduct']);


//============================ Product ==============================

/*Route::get('/addProduct',[ProductController::class,'addProduct']);
Route::get('/allProduct',[ProductController::class,'allProduct']);*/
Route::post('/saveProduct',[ProductController::class,'saveProduct']);

Route::get('/unactiveProduct/{productId}',[ProductController::class,'unactiveProduct']);
Route::get('/activeProduct/{productId}',[ProductController::class,'activeProduct']);
// edit - delete category

Route::get('/deleteProduct/{productId}',[ProductController::class,'deleteProduct']);
Route::post('/updateProduct/{productId}',[ProductController::class,'updateProduct']);
//import -export
Route::post('/export-csv-product',[CategoryProduct::class,'export_csv_product']);
Route::post('/import-csv-product',[CategoryProduct::class,'import_csv_product']);


// =================================== Order =================================
Route::get('/manageOrder',[OrderController::class,'manageOrder']);
Route::get('/viewOrder/{orderCode}',[OrderController::class,'viewOrder']);
Route::get('/printOrder/{checkoutCode}',[OrderController::class,'printOrder']);
Route::get('/deleteOrder/{orderCode}',[OrderController::class,'deleteOrder']);

// ================================== Coupon ====================================

Route::get('/allCoupon',[CouponController::class,'allCoupon']);
Route::get('/addCoupon',[CouponController::class,'addCoupon']);
Route::post('/saveCoupon',[CouponController::class,'saveCoupon']);
Route::get('/deleteCoupon/{couponId}',[CouponController::class,'deleteCoupon']);
Route::get('/sendCouponVip/{couponId}',[CouponController::class,'sendCouponVip']);
Route::get('/sendCouponNormal/{couponId}',[CouponController::class,'sendCouponNormal']);




//--update order qty and qty product
// update theo cái select đã xử lý để trừ số lượng tồn trong kho
Route::post('/updateInventory',[OrderController::class,'updateInventory']);
//update trong đơn hàng
Route::post('/updateQtyProductOrder',[OrderController::class,'updateQtyProductOrder']);



//============================== Social ==============================

//send mail
Route::get('/sendMail',[HomeController::class,'sendMail']);

//login FACEBOOK
Route::get('loginFacebook',[AdminController::class,'loginFacebook']);
Route::get('/admin/callback',[AdminController::class,'callbackFacebook']);
//Login  google
Route::get('/loginGoogle',[AdminController::class,'loginGoogle']);
Route::get('/google/callback',[AdminController::class,'callback_google']);

//============================= Delivery ===============================
Route::get('/addDelivery',[DeliveryController::class,'addDelivery']);
Route::get('/showDelivery',[DeliveryController::class,'showDelivery']);
Route::post('/selectDelivery',[DeliveryController::class,'selectDelivery']);
Route::post('/saveDelivery',[DeliveryController::class,'saveDelivery']);
Route::post('/selectFeeship',[DeliveryController::class,'selectFeeship']);
Route::post('/updateFeeship',[DeliveryController::class,'updateFeeship']);

//=============================== Slider ==========================
Route::get('/allSlider',[SliderController::class,'allSlider']);
Route::get('/addSlider',[SliderController::class,'addSlider']);
Route::post('/saveSlider',[SliderController::class,'saveSlider']);
Route::get('/unactiveSlider/{sliderId}',[SliderController::class,'unactiveSlider']);
Route::get('/activeSlider/{sliderId}',[SliderController::class,'activeSlider']);
Route::get('/deleteSlider/{sliderId}',[SliderController::class,'deleteSlider']);
Route::get('/editSlider/{sliderId}',[SliderController::class,'editSlider']);
Route::post('/updateSlider',[SliderController::class,'updateSlider']);


//========================== Authentication(xác thực) roles============================
Route::get('/registerAuth',[AuthController::class,'registerAuth']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/loginAuth',[AuthController::class,'loginAuth']);
Route::post('/login',[AuthController::class,'login']);
Route::get('logoutAuth',[AuthController::class,'logoutAuth']);



//kiểm tra quyền
Route::group(['middleware' => 'auth.roles'],function(){
    // auth.roles là cái tên đặt cho đường dẫn đến file Http/Middeware/AcessPermission , đặt ở kernel
    //auth.roles mang cái file AccessPermission nó có nhiệm vụ kiểm tra quyền, nếu là admin thì có quyền truy cập vào đường dẫn phía dưới
    Route::get('/addProduct',[ProductController::class,'addProduct']);
    Route::get('/editProduct/{productId}',[ProductController::class,'editProduct']);
});
Route::get('/allProduct',[ProductController::class,'allProduct']);
Route::get('/users',[UserController::class,'index'])->middleware('auth.roles'); // cái này cũng vậy
Route::post('/assignRoles',[UserController::class,'assignRoles'])->middleware('auth.roles'); // auth.roles là cái tên mình khai báo trong Kernel !!

Route::get('/deleteUserRoles/{adminId}',[UserController::class,'deleteUserRoles']);

//thêm user
Route::get('/addUser',[UserController::class,'addUser']);
Route::post('/saveUser',[UserController::class,'saveUser']);
//mạo danh
Route::get('/impersonate/{adminId}',[UserController::class,'impersonate']);
Route::get('/destroyImpersonate',[UserController::class,'destroyImpersonate']);


//=============================== Category Post=====================================


Route::get('/addCategoryPost',[CategoryPost::class,'addCategoryPost']);
Route::post('/saveCategoryPost',[CategoryPost::class,'saveCategoryPost']);
Route::get('/allCategoryPost',[CategoryPost::class,'allCategoryPost']);
Route::get('/editCategoryPost/{categoryPostId}',[CategoryPost::class,'editCategoryPost']);
Route::post('/updateCategoryPost',[CategoryPost::class,'updateCategoryPost']);
Route::get('/unactiveCategoryPost/{categoryId}',[CategoryPost::class,'unactiveCategoryPost']);
Route::get('/activeCategoryPost/{categoryId}',[CategoryPost::class,'activeCategoryPost']);
Route::get('/deleteCategoryPost/{categoryId}',[CategoryPost::class,'deleteCategoryPost']);
Route::get('/categoryPost/{categoryPostId}',[CategoryPost::class,'categoryPost']);



// ================================= POSTS ============================================

Route::get('/addPost',[PostController::class,'addPost']);
Route::post('/savePost',[PostController::class,'savePost']);
Route::get('/allPost',[PostController::class,'allPost']);
Route::get('/editPost/{postId}',[PostController::class,'editPost']);
Route::post('/updatePost',[PostController::class,'updatePost']);
Route::get('/deletePost/{postId}',[PostController::class,'deletePost']);
Route::get('/activePost/{postId}',[PostController::class,'activePost']);
Route::get('/unactivePost/{postId}',[PostController::class,'unactivePost']);

//================================== Gallery ==============================================

Route::get('/addGallery/{productId}',[GalleryController::class,'addGallery']);
Route::post('/selectGallery',[GalleryController::class,'selectGallery']);
Route::post('/saveGallery',[GalleryController::class,'saveGallery']);
Route::post('/editNameGallery',[GalleryController::class,'editNameGallery']);
Route::post('/deleteGallery',[GalleryController::class,'deleteGallery']);
Route::post('/updateGallery',[GalleryController::class,'updateGallery']);

// =============================== Video ====================================

Route::get('/allVideo',[VideoController::class,'allVideo']);
Route::post('/selectVideo',[VideoController::class,'selectVideo']);
Route::post('/saveVideo',[VideoController::class,'saveVideo']);
Route::post('/deleteVideo',[VideoController::class,'deleteVideo']);
Route::post('/updateVideo',[VideoController::class,'updateVideo']);
Route::post('/updateVideoImage',[VideoController::class,'updateVideoImage']);


//==================================Comment =====================================

Route::get('/allComment',[CommentController::class,'allComment']);
Route::post('/approvalComment',[CommentController::class,'approvalComment']);
Route::post('/replyComment',[CommentController::class,'replyComment']);
Route::get('/deleteComment/{commentId}',[CommentController::class,'deleteComment']);

//=====================================Contact ====================================
Route::get('/infoManagement',[ContactController::class,'infoManagement']);
Route::post('/updateContact',[ContactController::class,'updateContact']);
Route::post('/loadIcon',[ContactController::class,'loadIcon']);
Route::post('/saveIcon',[ContactController::class,'saveIcon']);
Route::post('/deleteIcon',[ContactController::class,'deleteIcon']);
// ============================= Ckeditor ========================================
//đê upload ảnh cục bộ bằng ckeditor thì mình phải tự cài đặt
Route::post('/uploads-ckeditor',[CkeditorController::class,'ckeditor_image']);
Route::get('/file-browser',[CkeditorController::class,'file_browser']);


// ============================= Statistical ========================================
Route::get('/dashboard',[StatisticalController::class,'showDashboard']);

Route::post('/filterByDate',[StatisticalController::class,'filterByDate']);
Route::post('/filterByChoose',[StatisticalController::class,'filterByChoose']);

//auto lọc khi ở dashboard
Route::post('/chartDates',[StatisticalController::class,'chartDates']);



//================================= file manager ===========================

Route::group(['prefix' => 'laravel-filemanager', 'middleware' ], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
