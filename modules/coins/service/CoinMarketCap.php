<?php
namespace mod\coins\service;
/**
 * Coinmarketcap 提供的接口服务
 * @author Lazy 2019-11-23
 */
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use think\exception\ErrorException;
use think\facade\Cache;
use mod\coins\providers\Index;
use mod\coins\model\Change;
use mod\coins\providers\Config;

class CoinMarketCap {
    /**
     * Http 客户端
     * @var Client
     */
    protected static $client;
    // 总映射表缓存
    const MapCache = 'coin_market_cap_map';
    // 过滤之后的IDS集合
    const FilterMapIDs = 'coin_market_cap_map_symbols';
    // 加载配置
    public function __construct() {
        if ( ! self::$client) {
            $conf      = config('coin.coin_market_cap');
            // 初始化http客户端
            self::$client = new Client([
                'base_uri' => $conf['url'],
                'headers'  => [
                    'Content-Type'      => 'application/json',
                    'X-CMC_PRO_API_KEY' => $conf['key']
                ]
            ]);
        }
    }
    // 读取币种编号映射关系
    public function coinMap() {
        $data = [];
        try {
            $http = self::$client->get('/v1/cryptocurrency/map');
            if ($http->getStatusCode() == 200) {
                $context = json_decode($http->getBody()->getContents(), true);
                if ( ! $context['status']['error_code']) {
                    $data = array_column($context['data'], 'id', 'symbol');
                }
            }
        } catch (RequestException $e) {
            return $e->getMessage();
        }
        Cache::set(self::MapCache, $data);
        return count($data);
    }
    /**
     * 根据平台的币种列表获取最新的报价，并写入缓存与数据库中
     */
    public function quotes() {
        $coins = app(Index::class)->getLists();
        $symbols = Cache::remember(self::FilterMapIDs, function () use ($coins) {
            if ( ! empty($coins)) {
                $coins = array_flip(array_column($coins, 'code'));
                return array_intersect_key(Cache::get(self::MapCache), $coins);
            }
            return [];
        }, 300);
        if ( ! empty($symbols)) {
            $query = ['id' => implode(',', array_values($symbols))];
            try {
                $http = self::$client->get('/v1/cryptocurrency/quotes/latest', ['query'=>$query]);
                if ($http->getStatusCode() == 200) {
                    $context = json_decode($http->getBody()->getContents(), true);
                    if ( ! $context['status']['error_code']) {
                        $coin_ids = array_column($coins, 'id', 'code');
                        $timer = time();
                        $data = [];
                        foreach ($context['data'] as $key=>$quote) {
                            $id = $coin_ids[array_search($key, $symbols)];
                            // 初始化单币最新值
                            $unit_price = $quote['quote']['USD']['price'];
                            Cache::set('coin_new_'.$id, $unit_price);
                            array_push($data, compact('id', 'timer', 'unit_price'));
                            // 24H最大值
                            if (Cache::get('coin_24h_max_'.$id) ) {
                                if($unit_price > Cache::get('coin_24h_max_'.$id)) {
                                    Cache::set('coin_24h_max_'.$id, $unit_price, 24 * 60 * 60 );
                                }
                            } else {
                                // 初始化最大值
                                $max_price = app(Index::class)->getOneCoinMaxPrice($id);
                                if($max_price) {
                                    Cache::set('coin_24h_max_'.$id, $max_price['unit_price'], 24 * 60 * 60 );
                                }
                            }
                            // 24H最小值
                            if (Cache::get('coin_24h_min_'.$id) ) {
                                if($unit_price > Cache::get('coin_24h_min_'.$id)) {
                                    Cache::set('coin_24h_min_'.$id, $unit_price, 24 * 60 * 60 );
                                }
                            } else {
                                // 初始化最小值
                                $min_price = app(Index::class)->getOneCoinMinPrice($id);
                                if($min_price) {
                                    Cache::set('coin_24h_min_'.$id, $min_price['unit_price'], 24 * 60 * 60 );
                                }
                            }
                            // 更新K线缓存数据
                            $kline_type = ['hour', 'day', 'week', 'month'];
                            foreach ($kline_type as $k_type) {
                                switch ($k_type) {
                                    case 'hour':
                                        $kline_start_time = strtotime(date('Y-m-d '. intval(date('H') / 4) * 4 .':00:00'));
                                        break;
                                    case 'day':
                                        $kline_start_time = strtotime(date('Y-m-d 00:00:00'));
                                        break;
                                    case 'week':
                                        $kline_start_time = strtotime('Sunday -6 day');
                                        break;
                                    case 'month':
                                        $kline_start_time = strtotime(date('Y-m-1 00:00:00'));
                                        break;
                                }
                                $kline_cache = Cache::get('kline_'. $k_type .'_'.$id.'_'.$kline_start_time);
                                if ( $kline_cache ) {
                                    $kline_cache_update = [
                                        'start_time' => $kline_cache['start_time'],
                                        'end_time' => $kline_cache['end_time'],
                                        'start_price' => $kline_cache['start_price'],
                                        'end_price' => $unit_price,
                                        'max_price' => $kline_cache['max_price'] > $unit_price ? $kline_cache['max_price'] : $unit_price,
                                        'min_price' => $kline_cache['min_price'] < $unit_price ? $kline_cache['min_price'] : $unit_price,
                                    ];
                                } else {
                                    switch ($k_type) {
                                        case 'hour':
                                            $kline_end_time = $kline_start_time + 14400;
                                            break;
                                        case 'day':
                                            $kline_end_time = $kline_start_time + 86400;
                                            break;
                                        case 'week':
                                            $kline_end_time = $kline_start_time + 604800;
                                            break;
                                        case 'month':
                                            $kline_end_time = strtotime(date('Y-m-d H:i:s', $kline_start_time) .' +1 month');
                                            break;
                                    }
                                    $kline_cache_update = [
                                        'start_time' => $kline_start_time,
                                        'end_time' => $kline_end_time,
                                        'start_price' => $unit_price,
                                        'end_price' => $unit_price,
                                        'max_price' => $unit_price,
                                        'min_price' => $unit_price,
                                    ];
                                }
                                Cache::set('kline_'. $k_type .'_'.$id.'_'.$kline_start_time, $kline_cache_update);
                            }

                        }
                        // 写入数据库
                        (new Change)->saveAll($data, false);
                        // 写入缓存
                        Cache::set(Config::CoinQuote, array_column($data, 'unit_price', 'id'));
                        return true;
                    } else {
                        return sprintf('【%d】%s', $context['status']['error_code'], $context['status']['error_message']);
                    }
                }
            } catch (RequestException $e) {
                return $this->formatError($e);
            } catch (ErrorException $e) {
                return $this->formatError($e);
            }
        } else {
            return '没有设置币种';
        }
    }
    /**
     * 格式化错误输出
     */
    protected function formatError($e) {
        return sprintf(
            "\n\n  Error: %s\n  Line: %d\n  File: %s\n",
            $e->getMessage(),
            $e->getLine(),
            $e->getFile()
        );
    }
}