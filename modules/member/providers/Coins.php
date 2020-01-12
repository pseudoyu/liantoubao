<?php
namespace mod\member\providers;

/**
 * 会员持有币种相关业务逻辑
 */
use mod\member\model\Coins as Model;
// use mod\common\traits\BaseProviders;

class Coins
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
     * Coins constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    /**
     * 统计所有用户持有资产统计
     */
    public function property() {
        return $this->model->field('coin_id,sum(nums) as sum_nums')
                           ->group('coin_id')
                           ->select();
    }
}
