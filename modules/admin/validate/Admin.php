<?php

namespace mod\admin\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 验证场景
     * @author Lazy 2018-09-27
     */
     protected $scene = [
         'login'         => ['username', 'passwd'],
         'passwd'        => ['mobile'],
         'update_passwd' => ['passwd', 'new_passwd', 'repeat_passwd'],
         'retrieve'      => ['mobile', 'code'],
         'username'      => ['username'],
         'nick'          => ['nick'],
         'mobile'        => ['mobile']
     ];
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'username'      => 'require|length:5,16|alphaDash',
        'passwd'        => 'require|length:5,16',
        'new_passwd'    => 'require|length:5,16',
        'repeat_passwd' => 'confirm:new_passwd',
        'mobile'        => 'require|mobile',
        'nick'          => 'require|length:1,50',
        'code'          => 'require|checkCode:think'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'username.require'      => '请填写用户名',
        'username.length'       => '用户名必须由5-16个字符组成',
        'username.alphaDash'    => '用户名只能由字母、数字和下划线组成',
        'passwd.require'        => '请填写密码',
        'passwd.length'         => '密码必须由5-16个字符组成',
        'new_passwd.require'    => '请填写新密码',
        'new_passwd.length'     => '新密码必须由5-16个字符组成',
        'repeat_passwd.confirm' => '两次新密码填写不一致',
        'mobile.require'        => '请填写手机号码',
        'mobile.mobile'         => '无效的手机号码',
        'nick.require'          => '请填写名称',
        'nick.length'           => '名称最多只能填写50个字',
        'code.require'          => '请填写短信验证码'
    ];
    /**
     * 验证短信验证码
     */
    protected function checkCode($val) {
        $result = session('ADMIN_PWD_CODE');
        if ( ! $result) {
            return '请先获取短信验证码';
        } elseif ($result['code'] != md5($val)) {
            return '短信验证码错误';
        } elseif ($_SERVER['REQUEST_TIME'] > $result['expire']) {
            return '短信验证码已过期';
        }
        session('ADMIN_PWD_CODE', null);
        return true;
    }
}
