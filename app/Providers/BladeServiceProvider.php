<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    //kiểm tra user có quyền để hiện ra chức năng tương ứng ngoài cái menu
    public function boot()
    {   //$expression là trường admin, author và user
        Blade::if('hasRole',function($expression){ //hasrole là tên mìnhđặt , đặt tên j cũng được , sang bênh view gọi hasrole ra để kiểm tra có phải admin đăng nhập không
            //nếu người dùng có đăng nhập
                if(Auth::user()) { // k sử dụng admin được nó fix cứng là user rồi , ta chỉ chuyển sử dụng model user thành model admin được thôi
                    //nếu có quyền admin thì return true ,$expression là cái biến mình truyền vào bên web, truyên admin , author j đấy . nếu Auth::user() hiện tại có một trong hai quyền đó thì được tiếp tục
                    if(Auth::user()->hasAnyRoles($expression)){ // kiểm tra nhiều quyền , vd: cái chức năng đấy admin và author sử dụng được
                            return true;
                    }
                }
                return false; // còn k đăng nhập bằng authentication thì trả false
        });

        //kiểm tra admin có truy cập tính năng impersonate không
        // nếu có impersonte thì trả về true
        Blade::if('hasImpersonate',function(){
           if(session()->get('impersonate')){
               return true;
           }
           return false;
        });
    }
}
