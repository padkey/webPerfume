<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS;

class Impersonate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //nếu tồn tại Impersonate thì
        if(session()->has('impersonate')){
            Auth::onceUsingId(session('impersonate')); // thì gán  Auth bằng cái id này , onceUsingId là hàm có sẵn trong Auth
    }
        return $next($request);
    }
}
