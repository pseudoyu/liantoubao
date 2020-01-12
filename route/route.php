<?php
/**
 * 用户端路由
 * @author Lazy 2019-11-20
 */
Route::group('wxapi', function () {
    Route::get('/', '');

    Route::group('ws', function () {
        // 币种列表
        Route::get('coins', 'index/common/coins');
        // 币种即时报价
        Route::get('quotes', 'index/common/quotes');
    });
    Route::group('system', function () {
        // 关于我们
        Route::get('about', 'index/about/read');
    });

    Route::group('login', function () {
        // 获取微信授权
        Route::get('auth', 'index/login/auth');
        // 授权成功之后回跳地址
        Route::get('oauth_callback', 'index/login/oauth_callback');
        // 过期登陆token刷新
        //Route::post('refresh', 'index/login/refresh');
    });

    // 排行榜列表
    Route::get('ranking', '');
    Route::group('', function () {
        Route::group('member',function() {
            // 更新用户信息
            Route::post('update', 'index/member/update');
        });
    })->middleware('MemberLogin');

});

