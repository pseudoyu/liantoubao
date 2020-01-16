<?php

namespace mod\member\providers;

use app\http\exception\Error;
use mod\member\model\Follows as Model;
//use mod\common\traits\BaseProviders;

class Follow
{
    // 引入公共库
    // use BaseProviders;

    /**
     * @var Model
     */
    protected $model;

    // 指定验证器
    // protected $validate = null;

    // 验证不过能跳出异常
    // protected $failException = true;

    /**
     * 配置模块别名映射表
     * @var array
     */
    // protected static $app_map = [];

    /**
     * Follow constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    public function follow($uid, $object_id) {
        // 检查关注人数
        $fllow_number = $this->model->getCount(['member_id' => $uid]);
        if( $fllow_number > env('VIP_MAX_FOLLOW', 8)) {
            throw new Error('已达关注上限');
        }
        // 检查是否已经关注
        $is_follow = $this->model->getCount(['member_id' => $uid, 'object_id' => $object_id]);
        if($is_follow > 0) {
            throw new Error('已关注过，请勿重复关注');
        }
        // 插入数据
        $data = [
            'member_id' => $uid,
            'object_id' => $object_id,
            'create_time' => time(),
        ];
        return $this->model->add($data);
    }
    public function cancel_follow($uid, $object_id) {
        return $this->model->del(['member_id' => $uid, 'object_id' => $object_id]);
    }
}
