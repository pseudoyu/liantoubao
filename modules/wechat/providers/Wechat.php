<?php
namespace mod\wechat\providers;
/**
 * 微信一键登陆逻辑处理
 * @author Lazy 2019-01-26
 */

use app\common\facade\Captcha;
use app\http\exception\JumpException;
use app\member\facade\Register;
use app\member\providers\Token;

use app\common\traits\BaseProviders;
use app\http\exception\Error;
use mod\wechat\providers\Account;

class WeChat
{

    /**
     * 根据当前环境生成对应的code获取地址
     * @author Lazy 2019-01-26
     * @param string $redirect 登陆成功时的回调地址
     * @param string $notex 用户不存时的回调地址
     * @return string
     * @throws Error
     */
    public function makeLoginUri($redirect, $notex){
        if ( ! $redirect || ! $notex)
            throw new Error('未知的回调地址');
        // 保存appid配置
        $account = app(Account::class);
        $appid = $account->config['appid'];
        session('redirect', compact('redirect', 'notex', 'appid'));

        $state   = $this->cacheKey();
        // 判断是否在微信客户端环境
        return $account->isWeChat() ? $account->makeCodeUrlByWeChat($state) : $account->makeCodeUrl($state);
    }
    /**
     * 生成微信内部授权获取连接
     * @author Lazy 2019-03-23
     */
    public function makeWeChatAuthUri($redirect, $params = '', $appid = '') {
        if ( ! $redirect)
            throw new Error('未知的回调地址');
        // 缓存请求信息
        session('auth_uri', compact('redirect', 'params'));
        // 组装请求参数
        $param = [
            'redirect_uri' => url('wechat/auth/redirect_code'),
            'state'        => $this->cacheKey(),
            'scope'        => 'snsapi_base'
        ];
        empty($appid) || $param['appid'] = $appid;
        // 生成授权请求连接
        return app('account')->makeCodeUrlByWeChat($param);
    }
    /**
     * redirectCode
     * @author Lazy 2019-03-23
     * @param string $code 微信的code
     * @return string
     */
    public function redirectCode($code) {
        if ( ! $code || ! session('auth_uri'))
            throw new Error('invalid request.');
        $sess = session('auth_uri');
        $param = array_merge($sess['params'], ['code'=>$code]);
        return url_get(urldecode($sess['redirect']), $param);

    }
    /**
     * 基于微信的code获取对应的用户信息
     * @author Lazy 2019-03-23
     * @param string $code   微信的code
     * @param string $appid  对应的公从号应用ID
     * @param string $secret 对应的公众号密钥
     */
    public function getUserAccess($code, $appid, $secret) {
        return app(WeChat::class)->getUserAccess($code, $appid, $secret);
    }
    /**
     * 基于微信的code获取对应的用户信息并返回登陆凭证
     * @author Lazy 2019-01-27
     * @param string $code 微信的code
     * @return string
     */
    public function login($code) {
        if ( ! $code || ! session('redirect'))
            throw new Error('invalid request.');
        // 获取用户基本信息与token
        $info = app(WeChat::class)->getUserAccess($code);
        // 读取绑定的对应的用户信息
        $openid = isset($info->unionid) ? $info->unionid : $info->openid;
        // 读取用户信息
        $bind = $this->app('user_bind')->find('wechat', $openid);
        // 保存用户信息
        $appid = session('redirect.appid');
        $this->cacheUserInfo(($bind ? $bind->uid : ''), $info, $appid);
        // 判断是否是否有绑定帐号
        if ( ! $bind || ! $bind->uid)
            throw new JumpException(
                url_get(
                    session('redirect.notex'),
                    ['state' => $this->cacheKey()]
                )
            );
        // 补全openid
        $bind->saveAppids($appid, $info->openid);
        // 组装登陆成功信息
        $auth = Token::make($bind->user, ['cache' => $this->cacheKey()]);
        return url_get(session('redirect.redirect'), $auth);
    }
    /**
     * 绑定手机
     * @author Lazy 2019-01-29
     * @param string $mobile 手机号码
     * @param string $code 手机短信验证码
     */
    public function bindMoible($mobile, $code) {
        // 读取缓存信息
        $access = cache($this->cacheKey());
        if ( ! $access)
            throw new Error('invalid request.');
        // 读取用户信息
        $_info = app(WeChat::class)->getUserInfo($access['openid'], $access['access']);
        // 验证手机验证码
        Captcha::checkMobileCode($code, $mobile, 'wechat_captcha');
        // 保存手机号
        $openid = empty($access['unionid']) ? $access['openid'] : $access['unionid'];
        $user_data = ['nick'   => $_info->nickname ?: '', 'avatar' => $_info->headimgurl ?: ''];
        $bind_data = ['app_ids' => [$access['appid'] => $access['openid']]];
        $user = Register::userData($user_data)
            ->bindData($bind_data)
            ->bindMobile($openid, $mobile, 'wechat');
        // 删除缓存
        cache($this->cacheKey(), null);

        return Token::make($user, ['cache' => $this->cacheKey()]);
    }
    /**
     * 将获取到的用户信息缓存到本地
     * @author Lazy 2019-01-28
     * @param string $key 缓存名称
     * @return bool
     */
    protected function cacheUserInfo($id = '',$info, $appid = '') {
        // 组装用户信息
        $data = [
            // 用户主键
            'id'         => $id,
            // 用户唯一标识信息
            'openid'     => $info->openid,
            'unionid'    => isset($info->unionid) ? $info->unionid : '',
            // 获取用户信息的凭证
            'access'     => $info->access_token,
            'access_in'  => $_SERVER['REQUEST_TIME'] + ($info->expires_in - 50),
            // 刷新access_token的凭证，以及过期时间
            'refresh'    => $info->refresh_token,
            'refresh_in' => $_SERVER['REQUEST_TIME'] + 2505600,
            'appid'      => $appid
        ];
        cache($this->cacheKey(), $data, 2505600);
    }
    protected function cacheKey() {
        static $key;
        is_null($key) && $key = request()->id;
        return $key;
    }
}
