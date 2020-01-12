<?php
namespace mod\coins\providers;
/**
 * 币种公共配置
 * @author Lazy 2019-11-23
 */
class Config {
    // 币种列表缓存键名
    const COINS = 'coins';
    // 缓存有效时间，单位：秒
    const EXPIRE = 300;
    // 币种最新报价
    const CoinQuote = 'coin_market_cap_quote';
}