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
        // 格式化币种列表
        Route::get('format_coins', 'index/common/format_coins');
        // 币种即时报价
        Route::get('quotes', 'index/common/quotes');
        // 交易所列表
        Route::get('exchange', 'index/common/exchange');
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
            // 更新头像
            Route::post('avatar', 'index/member/avatar');
            // 关注用户
            Route::get('follow_member', 'index/member/follow_member');
            // 取消关注
            Route::get('cancel_follow', 'index/member/cancel_follow');
            // 用户持币列表
            
        });
        Route::group('trades',function() {
            // 新增交易
            Route::post('add', 'index/trade/add');
            // 交易详情
            Route::get('info', 'index/trade/info');
            // 交易列表
            Route::get('list', 'index/trade/lists');
            // 更新阈值
            Route::get('update_limit', 'index/trade/update_limit');
            // 单币详情
            Route::get('coin_count', 'index/trade/coin_count');
            // 收益率
            Route::get('xirr', 'index/trade/calc_xirr');
        });
    })->middleware('MemberLogin');

});

