<?php
/**
 * 阿里云云通信接口配置
 * @author Lazy 2018-09-20
 */
return [
    // 短信接口验证ID
    'access_id'  => '',
    // 短信接口验证密钥
    'secret_key' => '',
    // 短信发送签名
    'sign_name'  => '',
    // 调试模块，true:为调试模式，并不会真正执行短信发送
    'debug' => config('app.app_debug'),
    // 短信模板映射列表
    'sms_tpls' => [
        // 格式：模板名称 => 模板ID
        // 平台后台密码重置短信验证码
        'ADMIN_PWD_CODE' => '',
        // 重置之后新的密码通知
        'ADMIN_PWD_NOTICE' => '',
    ]
];