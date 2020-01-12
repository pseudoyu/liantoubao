<?php
/**
 * 平台管理后台路由
 * @author Lazy 2019-11-20
 */
Route::group('admin', function () {
    // 登陆操作
    Route::post('login', 'admin/index/login');
    // 密码找回操作
    Route::post('retrieve', 'admin/index/retrieve');
    // 发送手机验证码
    Route::post('sendCheck', 'admin/index/send_check');
    // 以下路由需要登陆权限
    Route::group('', function () {
        // 后台首页统计
        Route::get('dashboard', 'admin/common/dashboard');
        // 获取币种汇总列表
        Route::get('coins', 'admin/common/coins');
        // 用户管理
        Route::group('member', function () {
            // 首页统计
            Route::get('dashboard', 'admin/member/dashboard');
            // 用户详情
            Route::get('<id>', 'admin/member/read')->pattern(['id' => '\d+']);
            // 用户列表
            Route::get('', 'admin/member/index');
        });
        // 支付记录
        Route::get('payment', function () {
            // 指定用户支付记录
            Route::get('<id>', 'admin/payment/member')->pattern(['id' => '\d+']);
            // 总支付记录
            Route::get('', 'admin/payment/index');
        });
        // 会员规则配置
        Route::group('viper', function () {
            Route::post('create', 'admin/viper/save');
            Route::post('update', 'admin/viper/update');
            Route::post('delete', 'admin/viper/delete');
            Route::get('', 'admin/viper/index');
        });
        // 帐号设置
        Route::group('account', function () {
            // 注销登陆
            Route::get('out', 'admin/index/login_out');
            // 密码修改
            Route::post('passwd', 'admin/account/passwd');
            // 修改头像
            Route::post('avatar', 'admin/account/avatar');
            // 其余字段修改操作
            Route::post('<actions>', 'admin/account/index')->pattern(['actions' => '\w+']);
        });
        // 平台介绍管理
        Route::group('about', function () {
            // 获取
            Route::get('', 'admin/about/read');
            // 保存
            Route::post('', 'admin/about/update');
        });
    })->middleware('AdminAuth');
});