<?php

namespace App\Http\Middleware;

use Closure;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Route,URL,Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->guest() && $guard) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/admin/login');
            }
        }

        if(Auth::guard($guard)->user()->is_super == 1){
            return $next($request);
        }

        $previousUrl = URL::previous();
        
        if(!Auth::guard($guard)->user()->can(Route::currentRouteName())) {
            if($request->ajax() && ($request->getMethod() != 'GET')) {
//                return response()->json([
//                    'status' => -1,
//                    'code' => 403,
//                    'msg' => '您没有权限执行此操作'
//                ]);

                return view('admin.errors.503');
            } else {
                return view('admin.errors.403', compact('previousUrl'));
            }
        }



        return $next($request);
    }
}
