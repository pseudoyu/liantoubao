<?php

namespace mod\wechat\providers;
use app\http\exception\Error;
use mod\common\traits\BaseProviders;
use think\facade\Cache;

class Account
{

    protected $config;
    /**
     * 初始化配置文件
     * @author Lazy 2019-02-13
     */
    protected function initialize() {
        $conf = $this->isWeChat() ? 'wechat' : 'web';
        $this->config = config('wechat.wechat_config');
    }
    /**
     * 判断当前是否处在微信客户下
     * @author Lazy 2019-02-13
     */
    public function isWeChat() {
        static $state;
        if (is_null($state)) {
            $agent = request()->header('USER_AGENT');
            $state = (false !== strpos($agent, 'MicroMessenger/')
                && false === strpos($agent, 'wxwork/'));
        }
        return $state;
    }
    /**
     * 获取公众号的基础 access_token
     * @author Lazy 2019-01-28
     * @return string
     */
    public function getAccessToken() {
        $cache_key    = $this->config['appid'] . '_access_token';
        $access_token = Cache::store('wechat')->get($cache_key);
        return $access_token ?: $this->requestAccessToken($cache_key);
    }
    /**
     * 请求新的access_token
     * @author Lazy 2019-01-28
     * @param sting $key 缓存名称
     * @return mixed
     * @throws AbzException
     */
    protected function requestAccessToken($key) {
        $uri = 'https://api.weixin.qq.com/cgi-bin/token';
        // 请求参数
        $params = [
            'appid'      => $this->config['appid'],
            'secret'     => $this->config['secret'],
            'grant_type' => 'client_credential'
        ];
        // 发起请求
        $response = Http::get($uri, $params);
        if (isset($response->errcode) && $response->errcode)
            throw new Error($response->errmsg, $response->errcode);
        // 将 access_token 存至缓存
        Cache::store('wechat')->set($key, $response->access_token, $response->expires_in - 50);
        return $response->access_token;
    }
    /**
     * 生成code获取跳转地址，web页面
     * @author Lazy 2019-02-12
     */
    public function makeCodeUrl($state = '') {
        //https://open.weixin.qq.com/connect/qrconnect?
        $url = 'https://open.weixin.qq.com/connect/qrconnect';
        $params = $this->buildParams($state);
        return url_get($url, $params, 'wechat_redirect');
    }
    /**
     * 生成code获取跳转地址，微信内浏览
     * @author Lazy 2019-02-12
     */
    public function makeCodeUrlByWeChat($state = '') {
        //https://open.weixin.qq.com/connect/oauth2/authorize
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $params = $this->buildParams($state);
        return url_get($url, $params, 'wechat_redirect');
    }
    /**
     * 生成请求参数
     * @author Lazy 2019-02-12
     */
    protected function buildParams($state) {
        $param = [
            'appid'         => $this->config['appid'],
            'redirect_uri'  => url($this->config['redirect']),
            'response_type' => 'code',
            'scope'         => $this->config['scope']
        ];
        if (is_string($state) && ! empty($state)) {
            $param['state'] = $state;
        } elseif (is_array($state) && ! empty($state)) {
            $param = array_merge($param, $state);
        } else {
            $param['state'] = request()->id;
        }
        return $param;
    }
    /**
     * 根据code获取指定用户的access_token
     * @author Lazy 2019-01-27
     * @param $code string
     * @throws AbzException
     */
    public function getUserAccess($code, $appid = null, $secret = null) {
        $params = [
            'appid'      => $appid ?: $this->config['appid'],
            'secret'     => $secret ?: $this->config['secret'],
            'code'       => $code,
            'grant_type' => 'authorization_code'
        ];
        $info = Http::get('https://api.weixin.qq.com/sns/oauth2/access_token', $params);
        if (isset($info->errcode) && $info->errcode)
            throw new AbzException($info->errmsg, $info->errcode);
        /*$info = new \extend\http\Response(200, [], json_encode([
            'access_token'  => '18_CR6ZopiAhHfKYlQncCVRmf66TiI-uWy3t1qqE2piBoIYrbT4Wl-ZeEb4LC4qNRmCfNOr-An6fCtlELnsp_9C1A',
            'expires_in'    => 7200,
            'refresh_token' => '18_-5ctQ4mMns3DJ-CofFi0SB2w4AmhTJNk3m_HOaHG0dyBUvXoYfuIpJkJCQhBW_7w6mgJq0QgJeJCN2uTEqqcXw',
            'openid'        => 'oBigX5-vh9bB6M-y4OZNg7ByWmgY',
            'scope'         => 'snsapi_userinfo',
            'unionid'       => 'os1M50heKVlZkgk7T_H1d67TqLas'
        ]), 'json');*/
        /**
        [access_token] => 18_ZnRHwu4D8D0yNCU28GuumkMZtAYxhEx5zqMGjzz63EAUF6bKq4vYmISFzsSliMigwen0PBfQNYu8xTK3sh77ZQ
        [expires_in] => 7200
        [refresh_token] => 18_lYqQINCRmuMLRvGsBQ5UNS-psaZ2PVYaOcy6vzuOL_aiSduj7wgSm93Wws6m11T59iiWkIHwv0MsHcvl1mSl1g
        [openid] => o6Ymd5ly4QuMAjTvmvxXiYpzpIFA
        [scope] => snsapi_login
        [unionid] => os1M50heKVlZkgk7T_H1d67TqLas
         */
        return $info;
    }
    /**
     * 检测指定用户的access_token是否有效
     * @author Lazy 2019-01-27
     * @param string $access_token 用户的access_token
     * @param string $openid       用户的openid
     * @throws AbzException
     */
    public function checkUserAccess($access_token, $openid) {
        //https://api.weixin.qq.com/sns/auth?access_token=ACCESS_TOKEN&openid=OPENID
        $info = Http::get('https://api.weixin.qq.com/sns/oauth2/access_token', compact('access_token', 'openid'));
        if (isset($info->errcode) && $info->errcode)
            return false;
        return true;
    }
    /**
     * 刷新指定用户的access_token
     * @author Lazy 2019-01-27
     * @param string $refresh_token 用户刷新access_token
     * @throws AbzException
     */
    public function refreUserAccess($refresh_token) {
        //https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
        $params = [
            'appid'         => $this->config['appid'],
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refresh_token,
        ];
        $info = Http::get('https://api.weixin.qq.com/sns/oauth2/access_token', $params);
        if (isset($info->errcode) && $info->errcode)
            throw new Error($info->errmsg, $info->errcode);
        return $info;
    }
    /**
     * 获取指定用户的基本信息与UnionID
     * @author Lazy 2019-01-27
     * @param string $open_id 用户对应的微信号
     * @return mixed
     * @throws AbzException
     */
    public function getUserInfo($open_id, $access_token) {
        $params = [
            'access_token' => $access_token,
            'openid'       => $open_id,
            'lang'         => 'zh_CN'
        ];
        //$info   = Http::get('https://api.weixin.qq.com/cgi-bin/user/info', $params);
        //                   https://api.weixin.qq.com/sns/userinfo
        $info   = Http::get('https://api.weixin.qq.com/sns/userinfo', $params);
        if (isset($info->errcode) && $info->errcode)
            throw new Error($info->errmsg, $info->errcode);
        /*$info = new \extend\http\Response(200, [], json_encode([
            'subscribe'       => 1,
            'openid'          => 'oBigX5-vh9bB6M-y4OZNg7ByWmgY',
            'nickname'        => 'Lazy',
            'sex'             => 1,
            'language'        => 'zh_CN',
            'city'            => '台州',
            'province'        => '浙江',
            'country'         => '中国',
            'headimgurl'      => 'http://thirdwx.qlogo.cn/mmopen/1n48NlziaHaBCoWVEjzMf18m0SPceNx6ls4xH8HvmG3qVMHhI3DgztO3NU85RpgaiaoLd3YqM5ibNRkkOVSm30A8RG9qakg3ibtm/132',
            'subscribe_time'  => '1548352137',
            'unionid'         => 'os1M50heKVlZkgk7T_H1d67TqLas',
            'remark'          => '',
            'groupid'         => '0',
            'subscribe_scene' => 'ADD_SCENE_QR_CODE',
            'qr_scene'        => '0',
            'qr_scene_str'    => ''
        ]), 'json');*/
        return $info;
    }

}
