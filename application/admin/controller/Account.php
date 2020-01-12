<?php
namespace app\admin\controller;

use think\Request;
use mod\admin\providers\Account as Provider;
use mod\admin\providers\Common;
class Account {
    protected $provider;
    protected $admin_id;
    public function __construct(Provider $account) {
        $this->provider = $account;
        $this->admin_id = Common::session('id');
    }
    /**
     * 其余帐号相关操作
     * @return \think\Response
     */
    public function index(Request $request, $actions) {
        $actions = strtolower($actions);
        if ( ! in_array($actions, ['username', 'nick', 'mobile']))
            return wrong('非法的修改操作');
        $data = [$actions => $request->put('context', '')];
        return $this->provider->updateInfo($this->admin_id, $data, $actions)
            ? complete('修改成功') : wrong('修改失败');
    }
    /**
     * 修改登陆密码
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function passwd(Request $request) {
        $put = $request->only(['passwd' => '', 'new_passwd' => '', 'repeat_passwd' => ''], 'put');
        return $this->provider->updatePasswd($this->admin_id, $put)
            ? complete('登陆密码修改成功') : wrong('登陆密码修改失败');
    }
    /**
     * 上传新的头像
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function avatar(Request $request) {
        $file   = $request->file('file');
        $avatar = $this->provider->updateAvatar($this->admin_id, $file);
        return complete('头像上传成功', 200, '', compact('avatar'));
    }
}
