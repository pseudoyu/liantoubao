<?php

namespace app\index\controller;

use mod\coins\providers\Index;
use think\Controller;
use mod\coins\providers\Index as Coins;
use mod\exchange\providers\Index as Exchange;
use mod\money\providers\Money;
use think\facade\Cache;
use think\Request;

class Common extends Controller
{
    // 前端公共整合数据
    public function common() {
        $provider = app(Coins::class);
        $coins = $provider->getLists();
        $format_coins = $provider->formatLists();
        $exchange = app(Exchange::class)->getLists();
        $rate = app(Money::class)->quotes();
        return output(compact('coins', 'format_coins', 'exchange', 'rate'));
    }
    // 读取币种列表
    /*public function coins() {
        return output(app(Coins::class)->getLists());
    }*/
    // 读取单币报价列表
    public function single_coin(Request $request) {
        if( ! $request->coin_id) {
            return wrong('参数错误');
        }
        $data = app(Coins::class)->getCoinPriceList($request->coin_id);
        return output($data ? $data : []);
    }
    // 读取币种格式化列表
    /*public function format_coins() {
        return output(app(Coins::class)->formatLists());
    }*/
    // 读取币种即时报价
    public function quotes() {
        return output(app(Coins::class)->getPrice());
    }
    // 读取交易所列表
    /*public function exchange() {
        return output(app(Exchange::class)->getLists());
    }*/
    // 读取单币特征值
    public function coin_info(Request $request) {
        $id = $request->coin_id;
        if( ! $id) {
            return wrong('参数异常');
        }
        // 24H最大值
        if (Cache::get('coin_24h_max_'.$id) ) {
            $max = Cache::get('coin_24h_max_'.$id);
        } else {
            // 初始化最大值
            $max_price = app(Index::class)->getOneCoinMaxPrice($id);
            if($max_price) {
                $max = $max_price['unit_price'];
                Cache::set('coin_24h_max_'.$id, $max_price['unit_price'], 24 * 60 * 60 );
            } else {
                $max = 0;
            }
        }
        // 24H最小值
        if (Cache::get('coin_24h_min_'.$id) ) {
            $min = Cache::get('coin_24h_min_'.$id);
        } else {
            // 初始化最小值
            $min_price = app(Index::class)->getOneCoinMinPrice($id);
            if($min_price) {
                $min = $min_price['unit_price'];
                Cache::set('coin_24h_min_'.$id, $min_price['unit_price'], 24 * 60 * 60 );
            } else {
                $min = 0;
            }
        }
        // 缓存单币每日初始值
        if (Cache::get('coin_'.date('Y-m-d').'_'.$id) ) {
            $first = Cache::get('coin_'.date('Y-m-d').'_'.$id);
        } else {
            // 初始化每日初始值
            $first_price = app(Index::class)->getOneCoinFirstPrice($id);
            if($first_price) {
                $first = $first_price['unit_price'];
                Cache::set('coin_'.date('Y-m-d').'_'.$id, $first_price['unit_price'], 24 * 60 * 60 );
            } else {
                $first = 0;
            }
        }
        // 获取单币最新值
        $new = app(Index::class)->getCoinPrice($id);
        // 计算涨跌幅
        $rate = $first ? ( $new - $first ) / $first : 0;
        // 组装数据
        $data = [
            'coin_id' => $id,
            'min' => $min,
            'max' => $max,
            'new' => $new,
            'first' => $first,
            'rate' => $rate,
        ];
        return output($data);
    }
    public function heat_map() {
        $coins = app(Coins::class)->getPrice();
        $map = [];
        foreach ($coins as $id => $new) {
            // 缓存单币每日初始值
            if (Cache::get('coin_'.date('Y-m-d').'_'.$id) ) {
                $first = Cache::get('coin_'.date('Y-m-d').'_'.$id);
            } else {
                // 初始化每日初始值
                $first_price = app(Index::class)->getOneCoinFirstPrice($id);
                if($first_price) {
                    $first = $first_price['unit_price'];
                    Cache::set('coin_'.date('Y-m-d').'_'.$id, $first_price['unit_price'], 24 * 60 * 60 );
                } else {
                    $first = 0;
                }
            }
            $rate = $first ? ( $new - $first ) / $first : 0;
            $map[] = [
                'coin_id' => $id,
                'rate' => $rate,
            ];
        }
        return output($map);
    }
}
