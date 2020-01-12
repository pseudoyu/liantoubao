<?php
namespace app\http\middleware;
/**
 * 会员登陆验证
 * @package app\http\middleware
 */
use Firebase\JWT\JWT;

class MemberLogin {
    public function handle($request, \Closure $next) {
        $token = $request->header()['token'];
        if( ! $token) {
            throw new Error('你还未登陆或者登陆已超时', 1403);
        }
        $key = env('JWT_KEY');
        $token_info = JWT::decode($token, $key, ["HS256"]);
        if($token_info['exp'] < time() || ! $token_info['uid']) {
            throw new Error('你还未登陆或者登陆已超时', 1403);
        }
        $request->uid = $token_info['uid'];
        return $next($request);
    }
}