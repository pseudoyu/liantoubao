<?php

namespace mod\member\model;

use think\Model;
use mod\common\traits\BaseModel;

class Coins extends Model
{
    // 引入公共库
    use BaseModel;

    /**
     * 默认字段
     * @var string|array
     */
    // protected $_field = '';

    /**
     * 默认排序规则
     * @var string
     */
    // protected $_order = '';

    // 指定完整的表名
    protected $table = 'jxh_member_coins';

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
    // 会员ID筛选
    public function searchMemberIdAttr($query, $val) {
        $query->where('member_id', trim($val));
    }
    public function searchCoinIdAttr($query, $val) {
        $query->where('coin_id', trim($val));
    }
    public function searchIdAttr($query, $val) {
        if( is_array($val) ) {
            $query->whereIn('id', $val);
        } else {
            $query->where('id', trim($val));
        }
    }
}
