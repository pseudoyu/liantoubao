<?php

namespace app\http\middleware;

use app\http\exception\Error;
class AdminAuth
{
    public function handle($request, \Closure $next) {
        //session('?uid') || session('uid', 1);
        //验证登陆状态
        if ( ! session('?admin_login_id'))
            throw new Error('你还未登陆或者登陆已超时', 1403);
        return $next($request);
    }
}
