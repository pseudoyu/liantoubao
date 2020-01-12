<?php

namespace mod\payment\providers;

use mod\payment\model\Payment as Model;
// use mod\common\traits\BaseProviders;

class Stats
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
     * Stats constructor.
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }
    // 获取指定日期收入
    public function income($date = null) {
        $model = $this->model->where('status', 2);
        if ($date) {
            $between = [strtotime($date), strtotime($date . ' 23:59:59')];
            $model = $model->where('create_time', 'between', $between);
        }
        return $model->sum('total_fee');
    }
}
