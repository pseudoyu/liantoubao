<?php
namespace app\index\validate;

use think\Validate;

class Account extends Validate
{
    protected $rule =   [
        'nick'  => 'require|max:25',
        'mobile' => 'require|mobile',
    ];

    protected $message  =   [
        'nick.require' => '名称必须',
        'nick.max'     => '名称最多不能超过25个字符',
        'mobile.require'   => '手机号必须',
        'mobile.mobile'  => '手机号格式错误',
    ];

}