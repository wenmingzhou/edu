<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckRbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //RBAC鉴权
        if(Auth::guard('admin')->user()->role_id!=1) {
            $route =Route::currentRouteAction();
            $ac =Auth::guard('admin')->user()->role->auth_ac;
            $ac =strtolower($ac.',indexController@index,indexcontroller@welcome');
            //权限判断
            $routeArr =explode('\\',$route);
            $route =strtolower(end($routeArr));
            if(strpos($ac,$route)===false){
               // echo "<h2>没有权限</h2>";exit;  暂时屏蔽
            }
            //继续后续的请求
            return $next($request);
        }
    }
}
