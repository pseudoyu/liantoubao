<?php
/**
 * 货币数据提供方的相关配置
 * @author Lazy 2019-11-23
 */
return [
    'coin_market_cap' => [
        // 接口请求地址
        'url' => env('COIN_URL', 'https://sandbox-api.coinmarketcap.com'),
        // 接口授权密钥
        'key' => env('COIN_SECRET', 'bb01c6f8-49eb-47d0-8757-82c58e53f854')
    ],
    'money_rate' => [
        // 接口请求地址
        'url' => env('MONEY_URL', 'http://web.juhe.cn:8080'),
        // 接口授权密钥
        'key' => env('MONEY_RATE', '16bcb4e344aab1ab6a38159fe167635d')
    ]
];