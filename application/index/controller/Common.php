<?php

namespace app\index\controller;

use Cassandra\Date;
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
    public function k_line(Request $request) {
        $type_array = ['hour', 'day', 'week', 'month'];
        $type = $request->type;
        $coin_id = $request->coin_id;
        if ( ! $type || ! $coin_id || !in_array($type, $type_array)) {
            return wrong('参数错误');
        }
        switch ($type) {
            case 'hour':
                $data = self::hour_kline($coin_id);
                break;
            case 'day':
                $data = self::day_kline($coin_id);
                break;
            case 'week':
                $data = self::week_kline($coin_id);
                break;
            case 'month':
                $data = self::month_kline($coin_id);
                break;
        }
        return output($data);
    }
    private function hour_kline($coin_id) {
        $start_hour = intval(date('H') / 4) * 4; // 获取最新蜡烛块初始时间
        //   组装最新蜡烛块起止时间戳
        $start_time = strtotime(date('Y-m-d '.$start_hour. ':00:00'));
        $data = [];
        // 共需要组装18个蜡烛块
        for ($i = 0; $i < 18; $i++) {
            $cache = Cache::get('kline_hour_'.$coin_id.'_'.$start_time);
            if ( $cache ) {
                $data[] = $cache;
            } else {
                // 初始化缓存块 14400 = 4 * 60 * 60
                $end_time = $start_time + 14400;
                $future_info = app(Index::class)->getTimerCoinFuture($coin_id, $start_time, $end_time);
                Cache::set('kline_hour_'.$coin_id.'_'.$start_time, $future_info);
                $data[] = $future_info;
            }
            $start_time -= 14400;
        }
        return $data;
    }
    private function day_kline($coin_id) {
        //   组装最新蜡烛块起止时间戳
        $start_time = strtotime(date('Y-m-d 00:00:00'));
        $data = [];
        // 共需要组装18个蜡烛块
        for ($i = 0; $i < 18; $i++) {
            $cache = Cache::get('kline_day_'.$coin_id.'_'.$start_time);
            if ( $cache ) {
                $data[] = $cache;
            } else {
                // 初始化缓存块 86400 = 24 * 60 * 60
                $end_time = $start_time + 86400;
                $future_info = app(Index::class)->getTimerCoinFuture($coin_id, $start_time, $end_time);
                Cache::set('kline_day_'.$coin_id.'_'.$start_time, $future_info);
                $data[] = $future_info;
            }
            $start_time -= 86400;
        }
        return $data;
    }
    private function week_kline($coin_id) {
        $start_time = strtotime('Sunday -6 day');
        $data = [];
        // 共需要组装16个蜡烛块
        for ($i = 0; $i < 16; $i++) {
            $cache = Cache::get('kline_week_'.$coin_id.'_'.$start_time);
            if ( $cache ) {
                $data[] = $cache;
            } else {
                // 初始化缓存块 604800 = 7 * 24 * 60 * 60
                $end_time = $start_time + 604800;
                $future_info = app(Index::class)->getTimerCoinFuture($coin_id, $start_time, $end_time);
                Cache::set('kline_week_'.$coin_id.'_'.$start_time, $future_info);
                $data[] = $future_info;
            }
            $start_time -= 604800;
        }
        return $data;
    }
    private function month_kline($coin_id) {
        //   组装最新蜡烛块起止时间戳
        $start_time = strtotime(date('Y-m-1 00:00:00'));
        $data = [];
        // 共需要组装36个蜡烛块
        for ($i = 0; $i < 36; $i++) {
            $cache = Cache::get('kline_month_'.$coin_id.'_'.$start_time);
            if ( $cache ) {
                $data[] = $cache;
            } else {
                $end_time = strtotime(date('Y-m-d H:i:s', $start_time) .' +1 month');
                $future_info = app(Index::class)->getTimerCoinFuture($coin_id, $start_time, $end_time);
                Cache::set('kline_month_'.$coin_id.'_'.$start_time, $future_info);
                $data[] = $future_info;
            }
            $start_time = strtotime(date('Y-m-d H:i:s', $start_time) .' -1 month');
        }
        return $data;
    }
}
