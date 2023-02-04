<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
class Language
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
        //kiểm tra xem có session locale không, có thì lưu vào setlocale
        if(session()->has('locale')){
            App::setlocale(session()->get('locale'));
        }
        return $next($request);
    }
}
