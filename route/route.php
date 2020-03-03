<?php
/**
 * 用户端路由
 * @author Lazy 2019-11-20
 */
Route::group('wxapi', function () {
    Route::get('/', 'index/index/index');

    Route::group('ws', function () {
        // √ 公用数据
        Route::get('common', 'index/common/common');
        // √ 币种列表
        // Route::get('coins', 'index/common/coins');
        // √ 单币曲线
        Route::get('single_coin', 'index/common/single_coin');
        // √ 单币涨跌信息
        Route::get('coin_info', 'index/common/coin_info');
        // √ 热力图
        Route::get('heat_map', 'index/common/heat_map');
        Route::get('k_line', 'index/common/k_line');
        // √ 格式化币种列表
        // Route::get('format_coins', 'index/common/format_coins');
        // √ 币种即时报价
        Route::get('quotes', 'index/common/quotes');
        // √ 交易所列表
        // Route::get('exchange', 'index/common/exchange');
        // √ 排行榜
        Route::get('top_rank', 'index/trade/top_rank');
    });

    Route::group('system', function () {
        // √ 关于我们
        Route::get('about', 'index/about/read');
    });
    Route::group('login', function () {
        // √ 获取微信授权
        Route::get('auth', 'index/login/auth');
        // √ 授权成功之后回跳地址
        Route::get('oauth_callback', 'index/login/oauth_callback');
        // 过期登陆token刷新
        //Route::post('refresh', 'index/login/refresh');
    });
    // 排行榜列表
    Route::get('ranking', '');
    Route::group('', function () {
        Route::group('payment', function () {
            // 会员报价数据
            Route::get('viper', 'index/payment/services?id=1');
            // 短信包报价
            Route::get('sms', 'index/payment/services?id=2');
        });
        Route::group('member',function() {
            // √ 更新用户信息
            Route::post('update', 'index/member/update');
            // 设置货币类型
            Route::post('update_coin', 'index/member/update_coin');
            // 设置用户信息访问权限
            Route::post('update_permission', 'index/member/update_permission');
            // √ 更新头像
            Route::post('avatar', 'index/member/avatar');
            // √ 关注用户
            Route::get('follow_member', 'index/member/follow_member');
            // √ 取消关注
            Route::get('cancel_follow', 'index/member/cancel_follow');
            // √ 关注列表
            Route::get('follow_list', 'index/member/follow_list');
        });
        Route::group('trades',function() {
            // √ 新增交易
            Route::post('add', 'index/trade/add');
            // √ 交易详情
            Route::get('info', 'index/trade/info');
            // √ 交易列表
            Route::get('list', 'index/trade/lists');
            // √ 单币交易列表
            Route::get('coin_trade_list', 'index/trade/coin_trade_list');
            // √ 更新阈值
            Route::post('update_limit', 'index/trade/update_limit');
            // √ 单币详情
            Route::get('single_coin_info', 'index/trade/single_coin_info');
            // 持币比例
            Route::get('has_coin_percent', 'index/trade/has_coin_percent');
            // √ 我的货币
            Route::get('my_coin', 'index/trade/my_coin');
            // 我的钱包（收入）
            Route::get('my_income', 'index/trade/my_income');
            // 我的钱包（时间筛选）
            Route::get('my_income_time', 'index/trade/my_income_time');
            // 排名缓存
            Route::get('rank_cache', 'index/trade/rank_cache');
            // 关注用户信息
            Route::get('follow_user_info', 'index/trade/follow_user_info');

        });
    })->middleware('MemberLogin');
});
