<?php
namespace app\index\validate;

use think\Validate;

class Member extends Validate
{
    protected $rule =   [
        'nick'  => 'require|max:25',
        'mobile' => 'require|mobile',
    ];

    protected $message  =   [
        'nick.require' => '昵称不能为空',
        'nick.max'     => '昵称最多不能超过25个字符',
        'mobile.require'   => '手机号不能为空',
        'mobile.mobile'  => '手机号格式错误',
    ];

}