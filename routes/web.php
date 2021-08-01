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



Route::get('/', [HomeController::class,'index']);
Route::get('/home',[HomeController::class,'index']);
Route::post('/search',[HomeController::class,'search']);


Route::get('/categoryProduct/{categoryId}',[CategoryProduct::class,'showCategoryHome']);
Route::get('/brandProduct/{brandId}',[BrandProduct::class,'showBrandHome']);
Route::get('/productDetail/{productId}',[ProductController::class,'productDetail']);

//+++++ Cart +++++
Route::post('/saveCart',[CartController::class,'saveCart']);
Route::get('/showCart',[CartController::class,'showCart']);
//delete
Route::get('/deleteToCart/{rowId}',[CartController::class,'deleteToCart']);
Route::get('/delProduct/{sessionId}',[CartController::class,'delProduct']);
Route::get('/deleteAllProduct',[CartController::class,'deleteAllProduct']);
//update
Route::post('/updateQuantityCart',[CartController::class,'updateQuantityCart']);
Route::post('/updateCart',[CartController::class,'updateCart']);


Route::post('/addToCartAjax',[CartController::class,'addToCartAjax']);
Route::get('/showCartAjax',[CartController::class,'showCartAjax']);

//+++++ Checkout+++++
Route::get('/loginCheckout',[CheckoutController::class,'loginCheckout']);
Route::get('/logoutCheckout',[CheckoutController::class,'logoutCheckout']);

Route::post('/loginCustomer',[CheckoutController::class,'loginCustomer']);

Route::post('/addCustomer',[CheckoutController::class,'addCustomer']);
Route::get('/checkout',[CheckoutController::class,'checkout']);
Route::post('/saveCheckoutCustomer',[CheckoutController::class,'saveCheckoutCustomer']);
Route::get('/payment',[CheckoutController::class,'payment']);
Route::post('/orderPlace',[CheckoutController::class,'orderPlace']);

Route::post('/selectDeliveryHome',[CheckoutController::class,'selectDeliveryHome']);
Route::post('/calculateFeeship',[CheckoutController::class,'calculateFeeship']);

Route::post('/confirmOrder',[CheckoutController::class,'confirmOrder']);
Route::get('/delFeeship',[CheckoutController::class,'delFeeship']);
//+++++ Coupon+++++
Route::post('/checkCoupon',[CartController::class,'checkCoupon']);
Route::get('/deleteCouponCode',[CartController::class,'deleteCouponCode']);





                    //********************** =====  BACK END ===== ************************\\



// ========================= Admin ====================================

Route::get('/admin',[AdminController::class,'index']);
Route::get('/dashboard',[AdminController::class,'showDashboard']);
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

Route::get('/addProduct',[ProductController::class,'addProduct']);
Route::get('/allProduct',[ProductController::class,'allProduct']);
Route::post('/saveProduct',[ProductController::class,'saveProduct']);

Route::get('/unactiveProduct/{productId}',[ProductController::class,'unactiveProduct']);
Route::get('/activeProduct/{productId}',[ProductController::class,'activeProduct']);
// edit - delete category
Route::get('/editProduct/{productId}',[ProductController::class,'editProduct']);
Route::get('/deleteProduct/{productId}',[ProductController::class,'deleteProduct']);
Route::post('/updateProduct/{productId}',[ProductController::class,'updateProduct']);
//import -export
Route::post('/export-csv-product',[CategoryProduct::class,'export_csv_product']);
Route::post('/import-csv-product',[CategoryProduct::class,'import_csv_product']);


// =================================== Order =================================
Route::get('/manageOrder',[OrderController::class,'manageOrder']);
Route::get('/viewOrder/{orderCode}',[OrderController::class,'viewOrder']);
Route::get('/printOrder/{checkoutCode}',[OrderController::class,'printOrder']);
// ============ Coupon ================
Route::get('/allCoupon',[CouponController::class,'allCoupon']);
Route::get('/addCoupon',[CouponController::class,'addCoupon']);
Route::post('/saveCoupon',[CouponController::class,'saveCoupon']);
Route::get('/deleteCoupon/{couponId}',[CouponController::class,'deleteCoupon']);
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
