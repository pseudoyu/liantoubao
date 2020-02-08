<?php

namespace mod\services\model;

use think\Model;
use mod\services\model\Quoted;
// use mod\common\traits\BaseModel;

class Services extends Model
{
    // 引入公共库
    //use BaseModel;

    /**
     * 默认字段
     * @var string|array
     */
    protected $_field = 'id,title,content,unit';

    /**
     * 默认排序规则
     * @var string
     */
    protected $_order = 'id asc';

    // 指定完整的表名
    protected $table = 'jxh_services';

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

    public function quoted()
    {
        return $this->hasMany(Quoted::class, 'service_id', 'id');
    }

}
