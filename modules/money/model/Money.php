<?php

namespace mod\money\model;

use think\Model;

class Money extends Model
{
    /**
     * 默认字段
     * @var string|array
     */
    protected $_field = 'code,price';

    /**
     * 默认排序规则
     * @var string
     */
    protected $_order = 'timer desc';

    // 指定完整的表名
    protected $table = 'jxh_money_rate';

    // 自动时间维护
     protected $autoWriteTimestamp = true;

    /**
     * 创建时间字段 false表示关闭
     * @var false|string
     */
     protected $createTime = 'timer';

}
