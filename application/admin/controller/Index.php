<?php
namespace app\admin\controller;

use extend\facade\Sms;
use think\Request;
use mod\admin\providers\Index as Provider;
class Index {
    protected $provider;
    public function __construct(Provider $index) {
        $this->provider = $index;
    }
    // 5f6b6c13bb9ce04883c9687b7dfed20b
    /**
     * 管理员登陆验证
     * @return \think\Response
     */
    public function login(Request $request) {
        $put = $request->only(['username' => '', 'password' => ''], 'put');
        return output($this->provider->login($put['username'], $put['password']));
    }
    /**
     * 发送手机号码验证短信（全局一个小时内只能试15次）
     */
    public function send_check(Request $request) {
        $mobile = $request->put('mobile', '');
        return $this->provider->send_check($mobile) ? complete('success') : wrong('fail');
    }
    /**
     * 发送密码重置成功短信
     * @return \think\Response
     */
    public function retrieve(Request $request) {
        $put = $request->only(['mobile' => '', 'code' => ''], 'put');
        return $this->provider->retrieve($put['mobile'], $put['code'])
            ? complete('success') : wrong('fail');
    }
    // 注销登陆
    public function login_out() {
        return $this->provider->login_out() ? complete('success') : wrong('fail');
    }
}
