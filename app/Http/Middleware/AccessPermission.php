<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illiminate\Support\Facades\Route; // route ngoaif web á
class AccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //middleware này là để phòng tránh người dùng không có quyền mà tìm cách điền vào đường dẫn để truy cập
    public function handle(Request $request, Closure $next)
    {
        //nếu có quyền admin hoặc author thì được tiếp tục
        if(Auth::user()->hasAnyRoles(['admin','author'])){ //khi đăng nhập auth thì thông tin đã lưu vào Auth::user()
        return $next($request);
    }
        //còn không thì quay về trang dashboard
        return redirect('/dashboard');
    }
}
