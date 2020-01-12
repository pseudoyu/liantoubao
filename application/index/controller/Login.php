<?php

namespace app\index\controller;

use app\http\exception\Error;
use think\Request;
use Firebase\JWT\JWT;
use EasyWeChat\Foundation\Application;
use mod\member\providers\Index as Members;

class Login{
    // 生成登陆授权连接
    public function auth() {
        $config = config('wechat.');
        if( ! is_array($config)) {
            return wrong('微信配置异常');
        }
        $app = new Application($config);
        $oauth = $app->oauth;
        return $oauth->redirect();
    }
    // 根据用户授权code生成登陆凭证
    public function oauth_callback($code) {
        $config = config('wechat');
        $app = new Application($config);
        $oauth = $app->oauth;
        $wechat_user = $oauth->user();
        if ( ! $user) {
            return wrong('微信用户信息读取失败');
        }
        $wechat_user = $wechat_user->toArray();
        $user_info = app(Members::class)->user_info();
        if( ! $user_info) {
            return wrong('获取用户信息失败');
        }
        $token = $this->create_jwt_token($user_info['id']);
        if( ! $token) {
            return wrong('创建Token失败');
        }
        $user_info['token'] = $token;
        return output($user_info);
    }
    private function create_jwt_token($uid)
    {
        $key = env('JWT_KEY');  //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
        $token = [
            "iss" => "",  //签发者 可以为空
            "aud" => "", //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time(), //JWT生效时间
            "exp" => time() + 31536000, //token 过期时间
            "uid" => $uid //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        ];
        $jwt = JWT::encode($token, $key, "HS256"); //根据参数生成了 token
        return $jwt;
    }
}
