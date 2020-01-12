<?php

namespace mod\payment\model;

use think\Model;
use mod\common\traits\BaseModel;

class Payment extends Model
{
    // 引入公共库
    use BaseModel;

    /**
     * 默认字段
     * @var string|array
     */
    protected $_field = 'id,title,spec,nums,unit,total_fee,status,end_time';

    /**
     * 默认排序规则
     * @var string
     */
    protected $_order = 'end_time desc';

    // 指定完整的表名
    protected $table = 'jxh_payment';

    // 自动时间维护
    protected $autoWriteTimestamp = true;

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
    public function searchMemberIdAttr($query, $val) {
        if ( ! empty($val)) {
            $query->where('member', $val);
        }
    }
}
