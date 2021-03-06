<?php

namespace mod\coins\model;

use think\Model;
use mod\common\traits\BaseModel;

class Change extends Model
{
    // 引入公共库
    use BaseModel;

    /**
     * 默认字段
     * @var string|array
     */
    protected $_field = 'id,timer,unit_price';

    /**
     * 默认排序规则
     * @var string
     */
    // protected $_order = '';

    // 指定完整的表名
    protected $table = 'jxh_coins_change';

    // 自动时间维护
    // protected $autoWriteTimestamp = true;

    /**
     * 创建时间字段 false表示关闭
     * @var false|string
     */
    // protected $createTime = 'create_time';

    /**
     * 更新时间字段 false表示关闭
     * @var false|string
     */
    // protected $updateTime = 'update_time';
    public function searchTimerAttr($query, $val) {
        if( ! is_array($val)) {
            $query->where('timer','>', trim($val));
        } else {
            $query->where('timer','>', trim($val['start_time']))->where('timer','<', trim($val['end_time']));
        }

    }
    public function searchIdAttr($query, $val) {
        $query->where('id', trim($val));
    }
}
