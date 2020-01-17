<?php

namespace app\index\controller;

use think\Controller;
use mod\coins\providers\Index as Coins;
use mod\exchange\providers\Index as Exchange;
use think\Request;

class Common extends Controller
{
    // 读取币种列表
    public function coins() {
        return output(app(Coins::class)->getLists());
    }
    // 读取单币报价列表
    public function single_coin(Request $request) {
        if( ! $request->coin_id) {
            return wrong('参数错误');
        }
        $data = app(Coins::class)->getCoinPriceList($request->coin_id);
        return output($data ? $data : []);
    }
    // 读取币种格式化列表
    public function format_coins() {
        return output(app(Coins::class)->formatLists());
    }
    // 读取币种即时报价
    public function quotes() {
        return output(app(Coins::class)->getPrice());
    }
    // 读取交易所列表
    public function exchange() {
        return output(app(Exchange::class)->getLists());
    }
}
