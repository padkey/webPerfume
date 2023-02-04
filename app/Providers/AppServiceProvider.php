<?php

namespace App\Providers;

use App\Models\CatePost;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Icon;
use App\Models\Contact;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       /* view()->composer('*',function($view){
            $products = Product::all()->count();
            $orders = Order::all()->count();
            $posts = Post::all()->count();
            $customers = Customer::all()->count();
            $view->with(compact('products','posts','orders','customers'));
        });*/
        //không lấy danh mục dịch vụ
        $allCategoryPost = CatePost::where('category_post_status',1)->orderby('category_post_id','ASC')->get();
        $categoryProduct = DB::table('tbl_category_product')->where('category_status',1)->orderby('category_id','desc')->get();
        $brandProduct = DB::table('tbl_brand')->where('brand_status',1)->orderby('brand_id','desc')->get();
        $shareImage ='';
        $contact = Contact::first();
        $allIcon = Icon::orderBy('icon_id','DESC')->get();
        //lấy service footer , bằng cate_post_id = 9
        $postFooter = Post::where('cate_post_id',9)->get();

             View::share(compact('postFooter','contact','allIcon','allCategoryPost','categoryProduct','brandProduct','shareImage'));
    }
}
