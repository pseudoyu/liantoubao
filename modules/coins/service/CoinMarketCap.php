<?php
namespace mod\coins\service;
/**
 * Coinmarketcap 提供的接口服务
 * @author Lazy 2019-11-23
 */
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
                            // 初始化单币最新值
                            Cache::set('coin_new_'.$id, $unit_price);
                            $unit_price = $quote['quote']['USD']['price'];
                            array_push($data, compact('id', 'timer', 'unit_price'));
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
                return $e->getMessage();
            }
        } else {
            return '没有设置币种';
        }
    }
}