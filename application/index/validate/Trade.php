<?php
namespace app\index\validate;

use think\Validate;

class Trade extends Validate
{
    protected $rule =   [
        'coin_id'  => 'require|number',
        'nums' => 'require|float',
        'unit_price' => 'require|float',
        'act'  => 'require|number|in:1,2',
        'exchange_id'  => 'require|number',
        'create_time' => 'require|date'
    ];

    protected $message  =   [
        'coin_id.require' => '币种信息不能为空',
        'nums.require' => '交易数量不能为空',
        'unit_price.require' => '交易单价不能为空',
        'act.require' => '交易类别不能为空',
        'exchange_id.require' => '持币交易所不能为空',
        'create_time.require' => '交易时间不能为空',
        'nick.number'     => '币种信息格式错误',
        'nums.float'   => '交易数量格式错误',
        'unit_price.float'  => '交易单价格式错误',
        'act.number' => '交易类别格式错误',
        'act.in' => '交易类别格式错误',
        'exchange_id.number' => '持币交易所格式错误',
        'create_time.date' => '交易时间格式错误',
    ];

}