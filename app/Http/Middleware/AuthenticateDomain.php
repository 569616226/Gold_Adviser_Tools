<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Route;

class AuthenticateDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /*验证域名，根据不同域名进入不同路径*/

//        if(Route::current()->action['domain'] == 'admin.gold.com'){
//            return redirect(url('admin/'));
//        }elseif(Route::current()->action['domain'] == 'vip.gold.com'){
//            return redirect(url('/'));
//        }

        return $next($request);
    }
}
